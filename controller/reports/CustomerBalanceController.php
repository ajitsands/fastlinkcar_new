<?php
// controller/reports/CustomerBalanceController.php
require_once ROOT_PATH . '/__db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'get_balances') {
    $pdo = getPDO();

    $todayStr = date('Y-m-d');
    $asOfDate = trim((string)($_POST['as_of_date'] ?? $todayStr));
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $asOfDate)) {
        $asOfDate = $todayStr;
    }
    $isToday = ($asOfDate === $todayStr);
    $nowTs = $isToday ? time() : strtotime($asOfDate . ' 23:59:59');
    $asOfDisplay = $isToday ? date('d M Y, H:i') : date('d M Y', $nowTs) . ' (23:59)';

    try {
        // 1. Load all customers keyed by customer_id and ids
        $stmtCust = $pdo->query("
            SELECT ids, customer_id, customer_name, customer_mobile, customer_cr_cpr, customer_email, nationality AS customer_nationality, status, is_blacklisted
            FROM customer_details
            ORDER BY customer_name ASC
        ");
        $customersByKey = [];
        $custAlias = [];
        $totalCustomers = 0;
        $blacklistedCustomers = 0;
        $activeCustomers = 0;
        foreach ($stmtCust->fetchAll(PDO::FETCH_ASSOC) as $c) {
            $cid = (string)($c['customer_id'] ?? '');
            if ($cid === '') {
                continue;
            }
            $totalCustomers++;
            $blVal = strtolower(trim((string)($c['is_blacklisted'] ?? '')));
            $stVal = strtolower(trim((string)($c['status'] ?? '')));
            $isBlacklisted = ($blVal === '1' || $blVal === 'yes' || $blVal === 'true' || $stVal === 'blacklisted');
            if ($isBlacklisted) {
                $blacklistedCustomers++;
            } elseif ($stVal === '' || $stVal === 'active') {
                $activeCustomers++;
            }

            $customersByKey[$cid] = [
                'customer_id'             => $cid,
                'customer_name'           => $c['customer_name'] ?? '',
                'customer_mobile'         => $c['customer_mobile'] ?? '',
                'customer_cr_cpr'         => $c['customer_cr_cpr'] ?? '',
                'customer_email'          => $c['customer_email'] ?? '',
                'customer_nationality'    => $c['customer_nationality'] ?? '',
                'is_blacklisted'          => $isBlacklisted,
                'active_contracts_count'  => 0,
                'overdue_contracts_count' => 0,
                'bounced_cheques_count'   => 0,
                'bounced_cheques_amount'  => 0.0,
                'ledger_debit'            => 0.0,
                'unposted_debit'          => 0.0,
                'total_debit'             => 0.0,
                'total_credit'            => 0.0,
                'overdue_amount'          => 0.0,
                'ledger_balance'          => 0.0,
                'balance'                 => 0.0,
                'unposted_or_overdue'     => [],
            ];
            $custAlias[$cid] = $cid;
            if (!empty($c['ids'])) {
                $custAlias[(string)$c['ids']] = $cid;
            }
        }

        // 2. Aggregate ledger debits & valid credits per customer up to as_of_date
        $stmtLed = $pdo->prepare("
            SELECT
                customer_code,
                contract_ids,
                agreement_no,
                payment_method,
                cheque_status,
                debit,
                credit,
                CASE WHEN COALESCE(cheque_status, '') = 'Bounced' THEN 0 ELSE credit END AS valid_credit
            FROM tbl_customer_ledger
            WHERE DATE(COALESCE(NULLIF(trans_date, '0000-00-00'), created_at)) <= :as_of_date
        ");
        $stmtLed->execute([':as_of_date' => $asOfDate]);
        $contractsWithDebit = [];
        $paymentMethodTotals = [];
        $totalCollected = 0.0;
        foreach ($stmtLed->fetchAll(PDO::FETCH_ASSOC) as $l) {
            $rawCode = (string)($l['customer_code'] ?? '');
            $custKey = $custAlias[$rawCode] ?? '';
            $deb = (float)($l['debit'] ?? 0);
            $cred = (float)($l['valid_credit'] ?? 0);
            $rawCred = (float)($l['credit'] ?? 0);
            $isBounced = (strcasecmp(trim((string)($l['cheque_status'] ?? '')), 'Bounced') === 0);

            if ($cred > 0) {
                $totalCollected += $cred;
                $pm = trim((string)($l['payment_method'] ?? ''));
                if ($pm === '' || strtoupper($pm) === 'N/A') {
                    $pm = 'Other / Unspecified';
                }
                if (!isset($paymentMethodTotals[$pm])) {
                    $paymentMethodTotals[$pm] = 0.0;
                }
                $paymentMethodTotals[$pm] += $cred;
            }

            if ($custKey === '' || !isset($customersByKey[$custKey])) {
                continue;
            }
            if ($isBounced && $rawCred > 0) {
                $customersByKey[$custKey]['bounced_cheques_count']++;
                $customersByKey[$custKey]['bounced_cheques_amount'] += $rawCred;
            }
            $customersByKey[$custKey]['ledger_debit'] += $deb;
            $customersByKey[$custKey]['total_debit'] += $deb;
            $customersByKey[$custKey]['total_credit'] += $cred;

            if ($deb > 0) {
                if (!empty($l['contract_ids'])) {
                    $contractsWithDebit['id_' . $l['contract_ids']] = true;
                }
                if (!empty($l['agreement_no'])) {
                    $contractsWithDebit['agr_' . $l['agreement_no']] = true;
                }
            }
        }

        // 3. Batch load latest extensions up to as_of_date
        $extByContract = [];
        try {
            $stmtExt = $pdo->prepare("SELECT agreement_ids, extend_end_date, extend_details FROM tbl_vehicle_contract_extensions WHERE DATE(COALESCE(NULLIF(extend_start_date, '0000-00-00'), created_at)) <= :as_of_date ORDER BY extend_end_date ASC, ids ASC");
            $stmtExt->execute([':as_of_date' => $asOfDate]);
            foreach ($stmtExt->fetchAll(PDO::FETCH_ASSOC) as $er) {
                $extByContract[(int)$er['agreement_ids']][] = $er;
            }
        } catch (\Throwable $e) {}

        // 4. Include unposted contracts and calculate Overdue Return Amount as of as_of_date
        $stmtCon = $pdo->prepare("
            SELECT ct.ids, ct.agreement_no, ct.vehicle_no, ct.customer_code, ct.agreement_status, ct.service_type,
                   ct.service_start_date_time, ct.service_end_date_time, ct.return_date, ct.contract_details_json,
                   m.price_json AS model_price_json
            FROM tbl_vehicle_rentout_contracts ct
            LEFT JOIN tbl_vehicle_model m ON m.ids = ct.vehicle_model_id
            WHERE LOWER(COALESCE(ct.agreement_status, '')) NOT IN ('cancelled', 'canceled', 'void')
              AND DATE(COALESCE(NULLIF(ct.agreement_date, '0000-00-00'), ct.service_start_date_time)) <= :as_of_date
        ");
        $stmtCon->execute([':as_of_date' => $asOfDate]);
        foreach ($stmtCon->fetchAll(PDO::FETCH_ASSOC) as $ct) {
            $rawCode = (string)($ct['customer_code'] ?? '');
            $custKey = $custAlias[$rawCode] ?? '';
            if ($custKey === '' || !isset($customersByKey[$custKey])) {
                continue;
            }

            $cdj = !empty($ct['contract_details_json']) ? (json_decode($ct['contract_details_json'], true) ?: []) : [];
            $contractAmt = (float)($cdj['total_amount'] ?? ($cdj['total_amt'] ?? ($cdj['grand_total'] ?? 0)));

            $hasDebit = !empty($contractsWithDebit['id_' . $ct['ids']])
                || (!empty($ct['agreement_no']) && !empty($contractsWithDebit['agr_' . $ct['agreement_no']]));
            $unpostedAmt = 0.0;
            if (!$hasDebit && $contractAmt > 0) {
                $unpostedAmt = $contractAmt;
                $customersByKey[$custKey]['unposted_debit'] += $contractAmt;
                $customersByKey[$custKey]['total_debit'] += $contractAmt;
            }

            // Overdue Return Amount ONLY if contract was active (not yet returned) as of as_of_date
            $stLower = strtolower(trim($ct['agreement_status'] ?? ''));
            $retStr = trim((string)($ct['return_date'] ?? ''));
            $retTs = (!empty($retStr) && strpos($retStr, '0000-00-00') === false) ? strtotime($retStr) : false;
            $wasActiveAsOf = in_array($stLower, ['rentout', 'rented', 'extended'], true)
                || ($retTs && $retTs > $nowTs);
            if (!$wasActiveAsOf) {
                if ($unpostedAmt > 0) {
                    $customersByKey[$custKey]['unposted_or_overdue'][] = [
                        'agreement_no'   => $ct['agreement_no'] ?? '',
                        'vehicle_no'     => $ct['vehicle_no'] ?? '',
                        'status'         => $ct['agreement_status'] ?? '',
                        'unposted_debit' => round($unpostedAmt, 3),
                        'overdue_days'   => 0,
                        'overdue_amount' => 0.0,
                    ];
                }
                continue;
            }
            $customersByKey[$custKey]['active_contracts_count']++;

            $rateType = strtolower($cdj['rate_type'] ?? ($ct['service_type'] ?? 'daily'));
            $unitPrice = (float)($cdj['unit_price'] ?? 0);
            $duration = (int)($cdj['duration'] ?? 0);
            $expStr = $cdj['period_to'] ?? ($ct['service_end_date_time'] ?? '');

            $exts = $extByContract[(int)$ct['ids']] ?? [];
            if (!empty($exts)) {
                $lastExt = end($exts);
                if (!empty($lastExt['extend_end_date'])) {
                    $expStr = $lastExt['extend_end_date'];
                }
                $ed = !empty($lastExt['extend_details']) ? (json_decode($lastExt['extend_details'], true) ?: []) : [];
                if (!empty($ed['rate_type'])) {
                    $rateType = strtolower($ed['rate_type']);
                }
                if (!empty($ed['unit_price'])) {
                    $unitPrice = (float)$ed['unit_price'];
                }
            }

            $expTs = (!empty($expStr) && strpos($expStr, '0000-00-00') === false) ? strtotime($expStr) : false;
            if (!$expTs || $expTs <= 946684800) {
                if ($unpostedAmt > 0) {
                    $customersByKey[$custKey]['unposted_or_overdue'][] = [
                        'agreement_no'   => $ct['agreement_no'] ?? '',
                        'vehicle_no'     => $ct['vehicle_no'] ?? '',
                        'status'         => $ct['agreement_status'] ?? '',
                        'unposted_debit' => round($unpostedAmt, 3),
                        'overdue_days'   => 0,
                        'overdue_amount' => 0.0,
                    ];
                }
                continue;
            }

            $graceAnchorTs = (date('H:i:s', $expTs) === '00:00:00')
                ? strtotime(date('Y-m-d 23:59:59', $expTs))
                : $expTs;

            if ($nowTs <= ($graceAnchorTs + 3600)) {
                if ($unpostedAmt > 0) {
                    $customersByKey[$custKey]['unposted_or_overdue'][] = [
                        'agreement_no'   => $ct['agreement_no'] ?? '',
                        'vehicle_no'     => $ct['vehicle_no'] ?? '',
                        'status'         => $ct['agreement_status'] ?? '',
                        'unposted_debit' => round($unpostedAmt, 3),
                        'overdue_days'   => 0,
                        'overdue_amount' => 0.0,
                    ];
                }
                continue; // Within 1-hour grace period
            }

            $diffSec = $nowTs - $graceAnchorTs;
            $isDueToday = (date('Y-m-d', $expTs) === $asOfDate);
            $overdueDays = $isDueToday ? 1 : max(1, (int)ceil($diffSec / 86400));

            // Effective rates from model price_json or contract fallback
            $modelRates = ['hourly' => 0.0, 'daily' => 0.0, 'weekly' => 0.0, 'monthly' => 0.0];
            $modelWoRates = ['hourly' => 0.0, 'daily' => 0.0, 'weekly' => 0.0, 'monthly' => 0.0];
            $pArr = !empty($ct['model_price_json']) ? (json_decode($ct['model_price_json'], true) ?: []) : [];
            if (is_array($pArr)) {
                foreach ($pArr as $pi) {
                    $item = strtolower($pi['item'] ?? '');
                    $amt = (float)($pi['amount'] ?? 0);
                    if ($amt <= 0) continue;
                    $bucket = strpos($item, 'hour') !== false ? 'hourly' : (strpos($item, 'week') !== false ? 'weekly' : (strpos($item, 'month') !== false ? 'monthly' : 'daily'));
                    if (strpos($item, 'without driver') !== false) {
                        $modelWoRates[$bucket] = $amt;
                        $modelRates[$bucket] = $amt;
                    }
                }
            }
            $formulaDaily = 0.0;
            if ($unitPrice > 0) {
                $formulaDaily = strpos($rateType, 'hour') !== false ? $unitPrice * 24
                    : (strpos($rateType, 'month') !== false ? $unitPrice / 30
                    : (strpos($rateType, 'week') !== false ? $unitPrice / 7 : $unitPrice));
            } elseif ($contractAmt > 0 && $duration > 0) {
                $formulaDaily = $contractAmt / $duration;
            }
            $effHourly  = $modelRates['hourly']  > 0 ? $modelRates['hourly']  : (strpos($rateType, 'hour') !== false && $unitPrice > 0 ? $unitPrice : $formulaDaily / 24);
            $effDaily   = $modelRates['daily']   > 0 ? $modelRates['daily']   : $formulaDaily;
            $effWeekly  = $modelRates['weekly']  > 0 ? $modelRates['weekly']  : (strpos($rateType, 'week') !== false && $unitPrice > 0 ? $unitPrice : $formulaDaily * 7);
            $effMonthly = $modelRates['monthly'] > 0 ? $modelRates['monthly'] : (strpos($rateType, 'month') !== false && $unitPrice > 0 ? $unitPrice : $formulaDaily * 30);

            $ovAmt = 0.0;
            if (strpos($rateType, 'hour') !== false) {
                $ovAmt = round(max(1, (int)ceil($diffSec / 3600)) * $effHourly, 3);
            } elseif (strpos($rateType, 'month') !== false) {
                $dStart = new DateTime('@' . $expTs);
                $dNow   = new DateTime('@' . $nowTs);
                $diffObj = $dStart->diff($dNow);
                $months = ($diffObj->y * 12) + $diffObj->m;
                $extraDays = $diffObj->d + (($diffObj->h > 0 || $diffObj->i > 0 || $diffObj->s > 0) ? 1 : 0);
                if ($months === 0 && $extraDays === 0) $extraDays = 1;
                $ovAmt = round(($months * $effMonthly) + ($extraDays * $effDaily), 3);
            } elseif (strpos($rateType, 'week') !== false) {
                $ovAmt = round((intdiv($overdueDays, 7) * $effWeekly) + (($overdueDays % 7) * $effDaily), 3);
            } else {
                $ovAmt = round($overdueDays * $effDaily, 3);
            }
            $customersByKey[$custKey]['overdue_contracts_count']++;
            $customersByKey[$custKey]['overdue_amount'] += $ovAmt;
            $customersByKey[$custKey]['unposted_or_overdue'][] = [
                'agreement_no'   => $ct['agreement_no'] ?? '',
                'vehicle_no'     => $ct['vehicle_no'] ?? '',
                'status'         => $ct['agreement_status'] ?? '',
                'unposted_debit' => round($unpostedAmt, 3),
                'overdue_days'   => $overdueDays,
                'overdue_amount' => round($ovAmt, 3),
            ];
        }

        // 5. Filter & format
        $results = [];
        $ledgerOutstanding = 0.0;
        $overdueOutstanding = 0.0;
        $totalOutstanding = 0.0;
        $totalOverpaid = 0.0;
        foreach ($customersByKey as $row) {
            $row['ledger_debit'] = round($row['ledger_debit'], 3);
            $row['unposted_debit'] = round($row['unposted_debit'], 3);
            $row['total_debit'] = round($row['total_debit'], 3);
            $row['total_credit'] = round($row['total_credit'], 3);
            $row['overdue_amount'] = round($row['overdue_amount'], 3);
            $row['bounced_cheques_amount'] = round($row['bounced_cheques_amount'], 3);
            $row['ledger_balance'] = round($row['total_debit'] - $row['total_credit'], 3);
            $row['balance'] = round(($row['total_debit'] + $row['overdue_amount']) - $row['total_credit'], 3);

            $ledgerBal = $row['ledger_balance'];
            if ($ledgerBal > 0) {
                $ledgerOutstanding += $ledgerBal;
            }
            $overdueOutstanding += $row['overdue_amount'];
            if ($row['balance'] > 0) {
                $totalOutstanding += $row['balance'];
            } elseif ($row['balance'] < 0) {
                $totalOverpaid += abs($row['balance']);
            }

            if (abs($row['balance']) > 0.0001 || $row['total_debit'] > 0 || $row['total_credit'] > 0 || $row['overdue_amount'] > 0 || $row['active_contracts_count'] > 0) {
                $results[] = $row;
            }
        }

        arsort($paymentMethodTotals);
        $pmList = [];
        foreach ($paymentMethodTotals as $m => $amt) {
            $pmList[] = ['method' => $m, 'amount' => round($amt, 3)];
        }

        echo json_encode([
            'status' => 'success',
            'data'   => $results,
            'kpis'   => [
                'as_of_date'            => $asOfDisplay,
                'as_of_date_iso'        => $asOfDate,
                'total_customers'       => $totalCustomers,
                'blacklisted_customers' => $blacklistedCustomers,
                'active_customers'      => $activeCustomers,
                'total_collected'       => round($totalCollected, 3),
                'ledger_outstanding'    => round($ledgerOutstanding, 3),
                'overdue_outstanding'   => round($overdueOutstanding, 3),
                'total_outstanding'     => round($totalOutstanding, 3),
                'total_overpaid'        => round($totalOverpaid, 3),
                'payment_methods'       => $pmList,
            ]
        ]);
        exit;
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => "Database Error: " . $e->getMessage()]);
        exit;
    }
}

// Initial page load
include 'view/customer_balance_report.php';
?>
