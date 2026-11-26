<?php
// controller/reports/CustomerBalanceController.php
require_once ROOT_PATH . '/__db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'get_balances') {
    $pdo = getPDO();

    try {
        // 1. Load all customers keyed by customer_id and ids
        $stmtCust = $pdo->query("
            SELECT ids, customer_id, customer_name, customer_mobile, customer_cr_cpr, customer_email, nationality AS customer_nationality
            FROM customer_details
            ORDER BY customer_name ASC
        ");
        $customersByKey = [];
        $custAlias = [];
        foreach ($stmtCust->fetchAll(PDO::FETCH_ASSOC) as $c) {
            $cid = (string)($c['customer_id'] ?? '');
            if ($cid === '') {
                continue;
            }
            $customersByKey[$cid] = [
                'customer_id'          => $cid,
                'customer_name'        => $c['customer_name'] ?? '',
                'customer_mobile'      => $c['customer_mobile'] ?? '',
                'customer_cr_cpr'      => $c['customer_cr_cpr'] ?? '',
                'customer_email'       => $c['customer_email'] ?? '',
                'customer_nationality' => $c['customer_nationality'] ?? '',
                'total_debit'          => 0.0,
                'total_credit'         => 0.0,
                'overdue_amount'       => 0.0,
                'balance'              => 0.0,
            ];
            $custAlias[$cid] = $cid;
            if (!empty($c['ids'])) {
                $custAlias[(string)$c['ids']] = $cid;
            }
        }

        // 2. Aggregate ledger debits & valid credits per customer and track contracts with debits
        $stmtLed = $pdo->query("
            SELECT
                customer_code,
                contract_ids,
                agreement_no,
                debit,
                CASE WHEN COALESCE(cheque_status, '') = 'Bounced' THEN 0 ELSE credit END AS valid_credit
            FROM tbl_customer_ledger
        ");
        $contractsWithDebit = [];
        foreach ($stmtLed->fetchAll(PDO::FETCH_ASSOC) as $l) {
            $rawCode = (string)($l['customer_code'] ?? '');
            $custKey = $custAlias[$rawCode] ?? '';
            if ($custKey === '' || !isset($customersByKey[$custKey])) {
                continue;
            }
            $deb = (float)($l['debit'] ?? 0);
            $cred = (float)($l['valid_credit'] ?? 0);
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

        // 3. Batch load latest extensions for active overdue calculation
        $extByContract = [];
        try {
            $stmtExt = $pdo->query("SELECT agreement_ids, extend_end_date, extend_details FROM tbl_vehicle_contract_extensions ORDER BY extend_end_date ASC, ids ASC");
            foreach ($stmtExt->fetchAll(PDO::FETCH_ASSOC) as $er) {
                $extByContract[(int)$er['agreement_ids']][] = $er;
            }
        } catch (\Throwable $e) {}

        // 4. Include unposted contracts and calculate Overdue Return Amount for active contracts
        $nowTs = time();
        $todayStr = date('Y-m-d', $nowTs);
        $stmtCon = $pdo->query("
            SELECT ct.ids, ct.agreement_no, ct.customer_code, ct.agreement_status, ct.service_type,
                   ct.service_start_date_time, ct.service_end_date_time, ct.contract_details_json,
                   m.price_json AS model_price_json
            FROM tbl_vehicle_rentout_contracts ct
            LEFT JOIN tbl_vehicle_model m ON m.ids = ct.vehicle_model_id
            WHERE LOWER(COALESCE(ct.agreement_status, '')) NOT IN ('cancelled', 'canceled', 'void')
        ");
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
            if (!$hasDebit && $contractAmt > 0) {
                $customersByKey[$custKey]['total_debit'] += $contractAmt;
            }

            // Overdue Return Amount ONLY for active Rentout / Rented / Extended contracts
            $stLower = strtolower(trim($ct['agreement_status'] ?? ''));
            if (!in_array($stLower, ['rentout', 'rented', 'extended'], true)) {
                continue;
            }

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
                continue;
            }

            $graceAnchorTs = (date('H:i:s', $expTs) === '00:00:00')
                ? strtotime(date('Y-m-d 23:59:59', $expTs))
                : $expTs;

            if ($nowTs <= ($graceAnchorTs + 3600)) {
                continue; // Within 1-hour grace period
            }

            $diffSec = $nowTs - $graceAnchorTs;
            $isDueToday = (date('Y-m-d', $expTs) === $todayStr);
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
            $customersByKey[$custKey]['overdue_amount'] += $ovAmt;
        }

        // 5. Filter & format
        $results = [];
        foreach ($customersByKey as $row) {
            $row['total_debit'] = round($row['total_debit'], 3);
            $row['total_credit'] = round($row['total_credit'], 3);
            $row['overdue_amount'] = round($row['overdue_amount'], 3);
            $row['balance'] = round(($row['total_debit'] + $row['overdue_amount']) - $row['total_credit'], 3);
            if (abs($row['balance']) > 0.0001 || $row['total_debit'] > 0 || $row['total_credit'] > 0 || $row['overdue_amount'] > 0) {
                $results[] = $row;
            }
        }

        echo json_encode(['status' => 'success', 'data' => $results]);
        exit;
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => "Database Error: " . $e->getMessage()]);
        exit;
    }
}

// Initial page load
include 'view/customer_balance_report.php';
?>
