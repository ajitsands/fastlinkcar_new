<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once ROOT_PATH . '/__db.php';

try {
    $pdo = getPDO();
    $companyId = $_GET['company_id'] ?? ($_SESSION['company_id'] ?? 'all');

    $sql = "
        SELECT
            c.ids,
            c.agreement_no,
            c.agreement_date,
            c.agreement_status,
            c.quotation_number,
            c.customer_code,
            c.customer_name,
            c.customer_details,
            c.vechile_details,
            c.contract_details_json,
            c.vehicle_id,
            c.vehicle_no,
            c.vehicle_model_id,
            c.booking_ids,
            c.service_start_date_time,
            c.service_end_date_time,
            c.extend_date,
            c.company_id,
            tc.company_name,
            cust.customer_name AS cust_db_name,
            cust.customer_mobile AS cust_db_mobile,
            cust.customer_email AS cust_db_email,
            cust.customer_cr_cpr AS cust_db_cpr,
            v.vehicle_number AS v_number,
            v.chassis_number AS v_chassis,
            v.vehicle_year AS v_year,
            v.vehicle_color AS v_color,
            v.model_names AS v_model_names,
            cat.category_name AS v_category,
            modl.modal_name AS v_model_name
        FROM tbl_vehicle_rentout_contracts c
        LEFT JOIN tbl_company tc ON tc.ids = c.company_id
        LEFT JOIN customer_details cust ON (cust.customer_id = c.customer_code OR cust.ids = c.customer_code)
        LEFT JOIN tbl_vehicles v ON v.ids = c.vehicle_id
        LEFT JOIN tbl_vehicle_category cat ON cat.ids = COALESCE(v.category_id, c.vehicle_category_id)
        LEFT JOIN tbl_vehicle_model modl ON modl.ids = COALESCE(v.model_id, c.vehicle_model_id)
        WHERE c.agreement_status IN ('Rentout', 'Extended')
    ";

    $params = [];
    if (!empty($companyId) && $companyId !== 'all') {
        $sql .= " AND c.company_id = ? ";
        $params[] = (int)$companyId;
    }

    $sql .= " ORDER BY c.ids DESC ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $contractIds = array_map('intval', array_column($rows, 'ids'));
    $extensionsByContract = [];
    $receivedByContract = [];

    if (!empty($contractIds)) {
        $inClause = implode(',', $contractIds);

        // Batch fetch extensions
        $extStmt = $pdo->query("SELECT * FROM tbl_vehicle_contract_extensions WHERE agreement_ids IN ({$inClause}) ORDER BY extend_end_date ASC, ids ASC");
        if ($extStmt) {
            while ($extRow = $extStmt->fetch(PDO::FETCH_ASSOC)) {
                $extensionsByContract[(int)$extRow['agreement_ids']][] = $extRow;
            }
        }

        // Batch fetch received amounts from customer ledger
        $ledStmt = $pdo->query("
            SELECT contract_ids, COALESCE(SUM(credit), 0) AS received_amount
            FROM tbl_customer_ledger
            WHERE contract_ids IN ({$inClause})
              AND (cheque_status IS NULL OR cheque_status != 'Bounced')
            GROUP BY contract_ids
        ");
        if ($ledStmt) {
            while ($ledRow = $ledStmt->fetch(PDO::FETCH_ASSOC)) {
                $receivedByContract[(int)$ledRow['contract_ids']] = (float)$ledRow['received_amount'];
            }
        }
    }

    $todayStr = date('Y-m-d');
    $nowTs = time();

    $validDateTs = function ($dt) {
        if (empty($dt) || strpos((string)$dt, '0000-00-00') !== false || strpos((string)$dt, '1970-01-01') !== false) {
            return false;
        }
        $ts = strtotime((string)$dt);
        return ($ts !== false && $ts > 946684800) ? $ts : false;
    };

    $summary = [
        'total_active'            => 0,
        'due_today'               => 0,
        'overdue'                 => 0,
        'extended'                => 0,
        'to_collect_excl_overdue' => 0.0,
        'overdue_total'           => 0.0,
        'total_incl_overdue'      => 0.0,
    ];

    $contracts = [];
    foreach ($rows as $row) {
        $cId = (int)$row['ids'];
        $cust = json_decode($row['customer_details'] ?? '{}', true) ?: [];
        $veh  = json_decode($row['vechile_details'] ?? '{}', true) ?: [];
        $cd   = json_decode($row['contract_details_json'] ?? '{}', true) ?: [];

        // Initial period & base contract total
        $initialStart = $cd['period_from'] ?? $row['service_start_date_time'] ?? '';
        $initialEnd   = $cd['period_to'] ?? $row['service_end_date_time'] ?? '';
        $initialDuration = (int)($cd['duration'] ?? 0);
        $initialStartTs = $validDateTs($initialStart);
        $initialEndTs   = $validDateTs($initialEnd);

        if ($initialDuration <= 0 && $initialStartTs && $initialEndTs && $initialEndTs > $initialStartTs) {
            $initialDuration = max(1, (int)round(($initialEndTs - $initialStartTs) / 86400));
        }

        $baseAmount = (float)($cd['total_amt'] ?? ($cd['grand_total'] ?? 0));
        $unitPrice  = (float)($cd['unit_price'] ?? 0);
        $rateType   = strtolower($cd['rate_type'] ?? 'daily');

        $dailyRate = 0.0;
        if ($unitPrice > 0) {
            if (strpos($rateType, 'hour') !== false) {
                $dailyRate = $unitPrice * 24;
            } elseif (strpos($rateType, 'month') !== false) {
                $dailyRate = $unitPrice / 30;
            } elseif (strpos($rateType, 'week') !== false) {
                $dailyRate = $unitPrice / 7;
            } else {
                $dailyRate = $unitPrice;
            }
        } elseif ($baseAmount > 0 && $initialDuration > 0) {
            $dailyRate = $baseAmount / $initialDuration;
        }

        // Extensions analysis
        $extList = $extensionsByContract[$cId] ?? [];
        $extensionAmt = 0.0;
        $latestExtEndTs = null;
        $latestExtEndStr = '';

        foreach ($extList as $ext) {
            $extDet = json_decode($ext['extend_details'] ?? '{}', true) ?: [];
            $extensionAmt += (float)($extDet['total_amt'] ?? 0);
            $extEnd = $ext['extend_end_date'] ?? ($extDet['period_to'] ?? '');
            $extEndTs = $validDateTs($extEnd);
            if ($extEndTs && ($latestExtEndTs === null || $extEndTs > $latestExtEndTs)) {
                $latestExtEndTs = $extEndTs;
                $latestExtEndStr = $extEnd;
                $extUnit = (float)($extDet['unit_price'] ?? 0);
                $extRType = strtolower($extDet['rate_type'] ?? 'daily');
                if ($extUnit > 0) {
                    if (strpos($extRType, 'hour') !== false) {
                        $dailyRate = $extUnit * 24;
                    } elseif (strpos($extRType, 'month') !== false) {
                        $dailyRate = $extUnit / 30;
                    } elseif (strpos($extRType, 'week') !== false) {
                        $dailyRate = $extUnit / 7;
                    } else {
                        $dailyRate = $extUnit;
                    }
                }
            }
        }

        $effectiveEndTs = $latestExtEndTs ?: $initialEndTs;
        $effectiveEndStr = $latestExtEndTs ? $latestExtEndStr : $initialEnd;
        $endDateOnly = $effectiveEndTs ? date('Y-m-d', $effectiveEndTs) : '';

        // Overdue status & amount as per today (with 1hr grace period)
        $isOverdue = false;
        $isDueToday = ($endDateOnly === $todayStr);
        $overdueDays = 0;
        $overdueAmount = 0.0;

        if ($effectiveEndTs && $nowTs > ($effectiveEndTs + 3600) && !$isDueToday) {
            $isOverdue = true;
            $overdueDays = max(1, (int)ceil(($nowTs - $effectiveEndTs) / 86400));
            $overdueAmount = round($overdueDays * $dailyRate, 3);
        } elseif ($effectiveEndTs && $isDueToday && $nowTs > ($effectiveEndTs + 3600)) {
            $isOverdue = true;
            $overdueDays = 1;
            $overdueAmount = round($dailyRate, 3);
        }

        $contractTotalAmount   = round($baseAmount + $extensionAmt, 3);
        $receivedAmount        = round($receivedByContract[$cId] ?? 0.0, 3);
        $totalContractValue    = round($contractTotalAmount + $overdueAmount, 3);
        $toCollectExclOverdue  = round(max(0, $contractTotalAmount - $receivedAmount), 3);
        $toCollectInclOverdue  = round(max(0, $totalContractValue - $receivedAmount), 3);

        $summary['total_active']++;
        $summary['to_collect_excl_overdue'] = round($summary['to_collect_excl_overdue'] + $toCollectExclOverdue, 3);
        $summary['overdue_total']           = round($summary['overdue_total'] + $overdueAmount, 3);
        $summary['total_incl_overdue']      = round($summary['total_incl_overdue'] + $toCollectInclOverdue, 3);
        if ($isOverdue) {
            $summary['overdue']++;
        }
        if ($isDueToday) {
            $summary['due_today']++;
        }
        if (strcasecmp($row['agreement_status'], 'Extended') === 0) {
            $summary['extended']++;
        }

        $contracts[] = [
            'id'                    => $cId,
            'agreement_no'          => $row['agreement_no'] ?? '',
            'agreement_date'        => $row['agreement_date'] ?? '',
            'status'                => $row['agreement_status'] ?? '',
            'booking_no'            => $row['quotation_number'] ?? '',
            'booking_ids'           => (int)($row['booking_ids'] ?? 0),
            'vehicle_id'            => (int)($row['vehicle_id'] ?? 0),
            'model_id'              => (int)($row['vehicle_model_id'] ?? 0),
            'company_name'          => $row['company_name'] ?? 'Fast Link',
            'customer_code'         => $row['customer_code'] ?? '',
            'customer_name'         => $row['cust_db_name'] ?: ($cust['customer_name'] ?? ($row['customer_name'] ?? 'N/A')),
            'customer_cpr'          => $row['cust_db_cpr'] ?: ($cust['customer_cr_cpr'] ?? ($cust['cpr'] ?? '-')),
            'customer_phone'        => $row['cust_db_mobile'] ?: ($cust['customer_mobile'] ?? ($cust['customer_phone'] ?? '-')),
            'customer_email'        => $row['cust_db_email'] ?: ($cust['customer_email'] ?? ''),
            'vehicle_category'      => $row['v_category'] ?: ($veh['category_name'] ?? '-'),
            'vehicle_model'         => $row['v_model_name'] ?: ($row['v_model_names'] ?: ($veh['model_name'] ?? '-')),
            'vehicle_year'          => $row['v_year'] ?: ($veh['vehicle_year'] ?? '-'),
            'vehicle_color'         => $row['v_color'] ?: ($veh['vehicle_color'] ?? '-'),
            'vehicle_no'            => $row['v_number'] ?: ($veh['veh_no'] ?? ($veh['vehicle_number'] ?? ($row['vehicle_no'] ?? 'N/A'))),
            'chassis_number'        => $row['v_chassis'] ?: ($veh['chassis_number'] ?? '-'),
            'start_date'            => $initialStart,
            'end_date'              => $effectiveEndStr,
            'is_overdue'            => $isOverdue,
            'is_due_today'          => $isDueToday,
            'overdue_days'          => $overdueDays,
            'received_amount'          => $receivedAmount,
            'contract_total_amount'    => $contractTotalAmount,
            'overdue_amount'           => $overdueAmount,
            'total_contract_value'     => $totalContractValue,
            'to_collect_excl_overdue'  => $toCollectExclOverdue,
            'to_collect_incl_overdue'  => $toCollectInclOverdue,
            'rate_type'             => $cd['rate_type'] ?? '',
            'notes'                 => $cd['booking_notes'] ?? '',
        ];
    }

    echo json_encode([
        'status'  => 'success',
        'summary' => $summary,
        'data'    => $contracts,
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status'  => 'error',
        'message' => $e->getMessage(),
    ]);
}
