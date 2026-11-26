<?php
// controller/reports/ContractFinancialController.php
if (!class_exists('ClassDatabaseConnection')) {
    require_once ROOT_PATH . '/model/db_connection/pdo_db_connection.php';
}
if (!class_exists('CommonPDOModel')) {
    require_once ROOT_PATH . '/model/common/pdoCommonFunctions.php';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $raw = file_get_contents('php://input');
    $req = json_decode($raw, true);
    if (!is_array($req)) {
        $req = $_POST;
    }

    $action = $req['action'] ?? '';
    if ($action !== 'getReportData') {
        echo json_encode(['status' => false, 'message' => 'Invalid action']);
        exit;
    }

    try {
        $db = new ClassDatabaseConnection();
        $pdo = $db->pdo;

        $companyFilter = trim((string)($req['company_id'] ?? 'all'));
        $fromDate = trim((string)($req['from_date'] ?? ''));
        $toDate = trim((string)($req['to_date'] ?? ''));
        $todayStr = date('Y-m-d');
        $asOfDate = trim((string)($req['as_of_date'] ?? $todayStr));
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $asOfDate)) {
            $asOfDate = $todayStr;
        }
        $isToday = ($asOfDate === $todayStr);
        $nowTs = $isToday ? time() : strtotime($asOfDate . ' 23:59:59');
        $asOfDisplay = $isToday ? date('d M Y, H:i') : date('d M Y', $nowTs) . ' (23:59)';

        $where = [
            "LOWER(COALESCE(ct.agreement_status, '')) NOT IN ('cancelled', 'canceled', 'void')",
            "DATE(COALESCE(NULLIF(ct.agreement_date, '0000-00-00'), ct.service_start_date_time)) <= :as_of_date"
        ];
        $params = [':as_of_date' => $asOfDate];

        if ($companyFilter !== '' && strtolower($companyFilter) !== 'all') {
            $where[] = "ct.company_id = :comp_id";
            $params[':comp_id'] = (int)$companyFilter;
        }
        if ($fromDate !== '' && $toDate !== '') {
            $where[] = "DATE(ct.agreement_date) BETWEEN :from_dt AND :to_dt";
            $params[':from_dt'] = $fromDate;
            $params[':to_dt'] = $toDate;
        }

        $sql = "
            SELECT
                ct.ids,
                ct.company_id,
                ct.booking_ids,
                ct.agreement_group_ref_no,
                ct.agreement_no,
                ct.agreement_date,
                ct.agreement_status,
                ct.customer_code,
                ct.customer_name,
                ct.vehicle_id,
                ct.vehicle_no,
                ct.vehicle_category_id,
                ct.vehicle_model_id,
                ct.service_type,
                ct.service_start_date_time,
                ct.service_end_date_time,
                ct.return_date,
                ct.contract_details_json,
                ct.vechile_details,
                DATE_FORMAT(ct.service_start_date_time, '%d-%b-%Y %H:%i') AS from_date_format,
                DATE_FORMAT(ct.service_end_date_time, '%d-%b-%Y %H:%i') AS to_date_format,
                cust.customer_name AS cust_db_name,
                cust.customer_mobile,
                cust.customer_cr_cpr,
                cust.customer_email,
                cust.nationality AS customer_nationality,
                tv.vehicle_year,
                tv.vehicle_color,
                tv.vehicle_status,
                tv.other_details_json AS veh_other_json,
                cat.category_name,
                mdl.modal_name AS model_name,
                mdl.price_json AS model_price_json,
                tb.brand_name,
                comp.company_name
            FROM tbl_vehicle_rentout_contracts ct
            LEFT JOIN customer_details cust ON (cust.customer_id = ct.customer_code OR cust.ids = ct.customer_code)
            LEFT JOIN tbl_vehicles tv ON tv.ids = ct.vehicle_id
            LEFT JOIN tbl_vehicle_category cat ON cat.ids = COALESCE(tv.category_id, ct.vehicle_category_id)
            LEFT JOIN tbl_vehicle_model mdl ON mdl.ids = COALESCE(tv.model_id, ct.vehicle_model_id)
            LEFT JOIN tbl_vehicle_brand tb ON tb.ids = tv.brand_id
            LEFT JOIN tbl_company comp ON comp.ids = ct.company_id
            WHERE " . implode(' AND ', $where) . "
            ORDER BY ct.ids DESC
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $contracts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Batch load extensions up to as_of_date
        $extByContract = [];
        try {
            $stExt = $pdo->prepare("SELECT agreement_ids, extend_end_date, extend_details FROM tbl_vehicle_contract_extensions WHERE DATE(COALESCE(NULLIF(extend_start_date, '0000-00-00'), created_at)) <= :as_of_date ORDER BY extend_end_date ASC, ids ASC");
            $stExt->execute([':as_of_date' => $asOfDate]);
            foreach ($stExt->fetchAll(PDO::FETCH_ASSOC) as $er) {
                $extByContract[(int)$er['agreement_ids']][] = $er;
            }
        } catch (\Throwable $e) {}

        // Batch load ledger totals up to as_of_date
        $ledByContractId = [];
        $ledByAgrNo = [];
        try {
            $stLed = $pdo->prepare("
                SELECT contract_ids, agreement_no, debit, credit, cheque_status
                FROM tbl_customer_ledger
                WHERE DATE(COALESCE(NULLIF(trans_date, '0000-00-00'), created_at)) <= :as_of_date
            ");
            $stLed->execute([':as_of_date' => $asOfDate]);
            foreach ($stLed->fetchAll(PDO::FETCH_ASSOC) as $l) {
                $deb = (float)($l['debit'] ?? 0);
                $isBounced = (strcasecmp(trim((string)($l['cheque_status'] ?? '')), 'Bounced') === 0);
                $cred = $isBounced ? 0.0 : (float)($l['credit'] ?? 0);
                $bounced = ($isBounced && (float)($l['credit'] ?? 0) > 0) ? 1 : 0;

                if (!empty($l['contract_ids'])) {
                    $k = (string)$l['contract_ids'];
                    if (!isset($ledByContractId[$k])) $ledByContractId[$k] = ['d' => 0.0, 'c' => 0.0, 'b' => 0];
                    $ledByContractId[$k]['d'] += $deb;
                    $ledByContractId[$k]['c'] += $cred;
                    $ledByContractId[$k]['b'] += $bounced;
                } elseif (!empty($l['agreement_no'])) {
                    $k = (string)$l['agreement_no'];
                    if (!isset($ledByAgrNo[$k])) $ledByAgrNo[$k] = ['d' => 0.0, 'c' => 0.0, 'b' => 0];
                    $ledByAgrNo[$k]['d'] += $deb;
                    $ledByAgrNo[$k]['c'] += $cred;
                    $ledByAgrNo[$k]['b'] += $bounced;
                }
            }
        } catch (\Throwable $e) {}

        // Batch load invoices up to as_of_date
        $invByAgr = [];
        try {
            $stInv = $pdo->prepare("SELECT reference_number, COUNT(*) AS cnt, COALESCE(SUM(grand_total), 0) AS tot FROM invoices WHERE COALESCE(draft, 0) = 0 AND reference_number IS NOT NULL AND reference_number != '' AND DATE(invoice_date) <= :as_of_date GROUP BY reference_number");
            $stInv->execute([':as_of_date' => $asOfDate]);
            foreach ($stInv->fetchAll(PDO::FETCH_ASSOC) as $ir) {
                $invByAgr[(string)$ir['reference_number']] = ['cnt' => (int)$ir['cnt'], 'tot' => (float)$ir['tot']];
            }
        } catch (\Throwable $e) {}

        $rows = [];
        $kpiTotalContracts = 0;
        $kpiActiveContracts = 0;
        $kpiClosedReturned = 0;
        $kpiOverdueContracts = 0;
        $kpiTotalAgreed = 0.0;
        $kpiTotalBilled = 0.0;
        $kpiTotalCollected = 0.0;
        $kpiTotalOverdue = 0.0;
        $kpiTotalOutstanding = 0.0;
        $kpiTotalInvoiced = 0.0;

        foreach ($contracts as $ct) {
            $cid = (int)$ct['ids'];
            $agrNo = (string)($ct['agreement_no'] ?? '');
            $agrStatus = trim((string)($ct['agreement_status'] ?? 'Rentout'));
            $stLower = strtolower($agrStatus);

            $cdj = !empty($ct['contract_details_json']) ? (json_decode($ct['contract_details_json'], true) ?: []) : [];
            $vdj = !empty($ct['vechile_details']) ? (json_decode($ct['vechile_details'], true) ?: []) : [];
            $vehOther = !empty($ct['veh_other_json']) ? (json_decode($ct['veh_other_json'], true) ?: []) : [];

            $baseAmount = (float)($cdj['total_amount'] ?? ($cdj['total_amt'] ?? ($cdj['grand_total'] ?? 0)));
            $rateType = strtolower($cdj['rate_type'] ?? ($ct['service_type'] ?? 'daily'));
            $unitPrice = (float)($cdj['unit_price'] ?? 0);
            $duration = (int)($cdj['duration'] ?? 0);
            $expStr = $cdj['period_to'] ?? ($ct['service_end_date_time'] ?? '');

            $exts = $extByContract[$cid] ?? [];
            $extAmount = 0.0;
            $extCount = count($exts);
            if ($extCount > 0) {
                foreach ($exts as $ex) {
                    $ed = !empty($ex['extend_details']) ? (json_decode($ex['extend_details'], true) ?: []) : [];
                    $extAmount += (float)($ed['total_amt'] ?? ($ed['total_amount'] ?? 0));
                }
                $lastExt = end($exts);
                if (!empty($lastExt['extend_end_date'])) {
                    $expStr = $lastExt['extend_end_date'];
                }
                $led = !empty($lastExt['extend_details']) ? (json_decode($lastExt['extend_details'], true) ?: []) : [];
                if (!empty($led['rate_type'])) $rateType = strtolower($led['rate_type']);
                if (!empty($led['unit_price'])) $unitPrice = (float)$led['unit_price'];
            }

            $agreedTotal = round($baseAmount + $extAmount, 3);

            $ledInfo = $ledByContractId[(string)$cid] ?? ($ledByAgrNo[$agrNo] ?? ['d' => 0.0, 'c' => 0.0, 'b' => 0]);
            $ledgerDebit = round($ledInfo['d'], 3);
            $collected = round($ledInfo['c'], 3);
            $bouncedCount = (int)$ledInfo['b'];

            // Overdue calculation ONLY if contract was active (not yet returned) as of as_of_date
            $overdueDays = 0;
            $overdueAmt = 0.0;
            $retStr = trim((string)($ct['return_date'] ?? ''));
            $retTs = (!empty($retStr) && strpos($retStr, '0000-00-00') === false) ? strtotime($retStr) : false;
            $isActive = in_array($stLower, ['rentout', 'rented', 'extended'], true)
                || ($retTs && $retTs > $nowTs);
            if ($isActive) {
                $kpiActiveContracts++;
                $expTs = (!empty($expStr) && strpos($expStr, '0000-00-00') === false) ? strtotime($expStr) : false;
                if ($expTs && $expTs > 946684800) {
                    $graceAnchorTs = (date('H:i:s', $expTs) === '00:00:00')
                        ? strtotime(date('Y-m-d 23:59:59', $expTs))
                        : $expTs;
                    if ($nowTs > ($graceAnchorTs + 3600)) {
                        $diffSec = $nowTs - $graceAnchorTs;
                        $isDueToday = (date('Y-m-d', $expTs) === $asOfDate);
                        $overdueDays = $isDueToday ? 1 : max(1, (int)ceil($diffSec / 86400));

                        $modelRates = ['hourly' => 0.0, 'daily' => 0.0, 'weekly' => 0.0, 'monthly' => 0.0];
                        $pArr = !empty($ct['model_price_json']) ? (json_decode($ct['model_price_json'], true) ?: []) : [];
                        if (is_array($pArr)) {
                            foreach ($pArr as $pi) {
                                $item = strtolower($pi['item'] ?? '');
                                $amt = (float)($pi['amount'] ?? 0);
                                if ($amt <= 0) continue;
                                $bucket = strpos($item, 'hour') !== false ? 'hourly' : (strpos($item, 'week') !== false ? 'weekly' : (strpos($item, 'month') !== false ? 'monthly' : 'daily'));
                                if (strpos($item, 'without driver') !== false) {
                                    $modelRates[$bucket] = $amt;
                                }
                            }
                        }
                        $formulaDaily = 0.0;
                        if ($unitPrice > 0) {
                            $formulaDaily = strpos($rateType, 'hour') !== false ? $unitPrice * 24
                                : (strpos($rateType, 'month') !== false ? $unitPrice / 30
                                : (strpos($rateType, 'week') !== false ? $unitPrice / 7 : $unitPrice));
                        } elseif ($baseAmount > 0 && $duration > 0) {
                            $formulaDaily = $baseAmount / $duration;
                        }
                        $effHourly  = $modelRates['hourly']  > 0 ? $modelRates['hourly']  : (strpos($rateType, 'hour') !== false && $unitPrice > 0 ? $unitPrice : $formulaDaily / 24);
                        $effDaily   = $modelRates['daily']   > 0 ? $modelRates['daily']   : $formulaDaily;
                        $effWeekly  = $modelRates['weekly']  > 0 ? $modelRates['weekly']  : (strpos($rateType, 'week') !== false && $unitPrice > 0 ? $unitPrice : $formulaDaily * 7);
                        $effMonthly = $modelRates['monthly'] > 0 ? $modelRates['monthly'] : (strpos($rateType, 'month') !== false && $unitPrice > 0 ? $unitPrice : $formulaDaily * 30);

                        if (strpos($rateType, 'hour') !== false) {
                            $overdueAmt = round(max(1, (int)ceil($diffSec / 3600)) * $effHourly, 3);
                        } elseif (strpos($rateType, 'month') !== false) {
                            $dStart = new DateTime('@' . $expTs);
                            $dNow   = new DateTime('@' . $nowTs);
                            $diffObj = $dStart->diff($dNow);
                            $months = ($diffObj->y * 12) + $diffObj->m;
                            $extraDays = $diffObj->d + (($diffObj->h > 0 || $diffObj->i > 0 || $diffObj->s > 0) ? 1 : 0);
                            if ($months === 0 && $extraDays === 0) $extraDays = 1;
                            $overdueAmt = round(($months * $effMonthly) + ($extraDays * $effDaily), 3);
                        } elseif (strpos($rateType, 'week') !== false) {
                            $overdueAmt = round((intdiv($overdueDays, 7) * $effWeekly) + (($overdueDays % 7) * $effDaily), 3);
                        } else {
                            $overdueAmt = round($overdueDays * $effDaily, 3);
                        }
                        if ($overdueAmt > 0) {
                            $kpiOverdueContracts++;
                        }
                    }
                }
            } else {
                $kpiClosedReturned++;
            }

            $effectiveTotal = max($ledgerDebit, $agreedTotal);
            $ledgerBalance = round($effectiveTotal - $collected, 3);
            $balance = round(($effectiveTotal + $overdueAmt) - $collected, 3);

            if ($ledgerBalance <= 0 && $overdueAmt > 0) {
                $paymentStatus = 'Ledger Paid + Overdue';
            } elseif ($balance <= 0 && $collected > 0 && $balance < 0) {
                $paymentStatus = 'Overpaid';
            } elseif ($balance <= 0) {
                $paymentStatus = 'Paid';
            } elseif ($collected > 0) {
                $paymentStatus = 'Partial';
            } else {
                $paymentStatus = 'Unpaid';
            }

            $invInfo = $invByAgr[$agrNo] ?? ['cnt' => 0, 'tot' => 0.0];
            $invoicedTotal = round($invInfo['tot'], 3);

            $kpiTotalContracts++;
            $kpiTotalAgreed += $agreedTotal;
            $kpiTotalBilled += $ledgerDebit;
            $kpiTotalCollected += $collected;
            $kpiTotalOverdue += $overdueAmt;
            if ($balance > 0) $kpiTotalOutstanding += $balance;
            $kpiTotalInvoiced += $invoicedTotal;

            $rows[] = [
                'ids'                  => $cid,
                'agreement_no'         => $agrNo,
                'agreement_date'       => $ct['agreement_date'] ?? '',
                'agreement_status'     => $agrStatus,
                'booking_no'           => $ct['agreement_group_ref_no'] ?? '',
                'company_name'         => $ct['company_name'] ?? 'Fast Link',
                'from_date_format'     => $ct['from_date_format'] ?? '',
                'to_date_format'       => $expStr ? date('d-M-Y H:i', strtotime($expStr)) : ($ct['to_date_format'] ?? ''),
                'customer_code'        => $ct['customer_code'] ?? '',
                'customer_name'        => $ct['cust_db_name'] ?? ($ct['customer_name'] ?? ''),
                'customer_mobile'      => $ct['customer_mobile'] ?? '',
                'customer_cpr'         => $ct['customer_cr_cpr'] ?? '',
                'customer_email'       => $ct['customer_email'] ?? '',
                'customer_nationality' => $ct['customer_nationality'] ?? '',
                'vehicle_id'           => $ct['vehicle_id'] ?? '',
                'model_id'             => $ct['vehicle_model_id'] ?? '',
                'vehicle_no'           => $ct['vehicle_no'] ?? '',
                'brand_name'           => $ct['brand_name'] ?? '',
                'model_name'           => $ct['model_name'] ?? ($vdj['model_name'] ?? ''),
                'category_name'        => $ct['category_name'] ?? ($vdj['category_name'] ?? ''),
                'vehicle_year'         => $ct['vehicle_year'] ?? ($vdj['vehicle_year'] ?? ''),
                'vehicle_color'        => $ct['vehicle_color'] ?? ($vdj['vehicle_color'] ?? ''),
                'vehicle_status'       => $ct['vehicle_status'] ?? '',
                'fuel_type'            => $vehOther['vehicleFuelType'] ?? ($vehOther['fuel_type'] ?? ''),
                'gear_type'            => $vehOther['gear_type'] ?? ($vehOther['transmission'] ?? ''),
                'chassis_number'       => $vehOther['chassis_number'] ?? ($vehOther['chassis_no'] ?? ''),
                'rate_type'            => ucfirst($rateType),
                'unit_price'           => round($unitPrice, 3),
                'base_amount'          => round($baseAmount, 3),
                'extension_count'      => $extCount,
                'extension_amount'     => round($extAmount, 3),
                'agreed_total'         => $agreedTotal,
                'ledger_debit'         => $ledgerDebit,
                'collected'            => $collected,
                'bounced_count'        => $bouncedCount,
                'overdue_days'         => $overdueDays,
                'overdue_amount'       => $overdueAmt,
                'invoiced_count'       => $invInfo['cnt'],
                'invoiced_total'       => $invoicedTotal,
                'ledger_balance'       => $ledgerBalance,
                'balance'              => $balance,
                'payment_status'       => $paymentStatus,
                'is_active'            => $isActive,
            ];
        }

        echo json_encode([
            'status' => true,
            'data'   => $rows,
            'kpis'   => [
                'as_of_date'               => $asOfDisplay,
                'as_of_date_iso'           => $asOfDate,
                'total_contracts'          => $kpiTotalContracts,
                'active_contracts'         => $kpiActiveContracts,
                'closed_returned_contracts'=> $kpiClosedReturned,
                'overdue_contracts'        => $kpiOverdueContracts,
                'total_agreed'             => round($kpiTotalAgreed, 3),
                'total_billed'             => round($kpiTotalBilled, 3),
                'total_collected'          => round($kpiTotalCollected, 3),
                'total_overdue'            => round($kpiTotalOverdue, 3),
                'total_outstanding'        => round($kpiTotalOutstanding, 3),
                'total_invoiced'           => round($kpiTotalInvoiced, 3),
            ]
        ]);
        exit;
    } catch (\Throwable $e) {
        echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        exit;
    }
}

include 'view/contract_financial_report.php';
