<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once ROOT_PATH . '/__db.php';

try {
    $pdo = getPDO();

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `tbl_contract_feedback` (
          `ids` int(11) NOT NULL AUTO_INCREMENT,
          `contract_id` int(11) NOT NULL,
          `agreement_no` varchar(100) DEFAULT NULL,
          `feedback_date` date NOT NULL,
          `feedback_notes` text NOT NULL,
          `taken_by` varchar(150) NOT NULL,
          `created_by` int(11) DEFAULT NULL,
          `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`ids`),
          KEY `idx_contract_feedback_cid` (`contract_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rawBody = file_get_contents('php://input');
        $postInput = json_decode($rawBody, true);
        if (!is_array($postInput) || empty($postInput)) {
            $postInput = $_POST;
        }
        $postAction = $postInput['action'] ?? '';

        if ($postAction === 'get_feedback') {
            $cid = (int)($postInput['contract_id'] ?? 0);
            if ($cid <= 0) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid contract ID']);
                exit;
            }
            $stFb = $pdo->prepare("SELECT ids, contract_id, agreement_no, feedback_date, feedback_notes, taken_by, created_at FROM tbl_contract_feedback WHERE contract_id = ? ORDER BY feedback_date DESC, ids DESC");
            $stFb->execute([$cid]);
            echo json_encode([
                'status' => 'success',
                'data' => $stFb->fetchAll(PDO::FETCH_ASSOC),
                'default_taken_by' => $_SESSION['profile_name'] ?? ($_SESSION['user_name'] ?? '')
            ]);
            exit;
        }

        if ($postAction === 'save_feedback') {
            $cid = (int)($postInput['contract_id'] ?? 0);
            $agrNo = trim((string)($postInput['agreement_no'] ?? ''));
            $fbDate = trim((string)($postInput['feedback_date'] ?? date('Y-m-d')));
            $fbNotes = trim((string)($postInput['feedback_notes'] ?? ''));
            $takenBy = trim((string)($postInput['taken_by'] ?? ($_SESSION['profile_name'] ?? ($_SESSION['user_name'] ?? ''))));

            if ($cid <= 0 || $fbNotes === '' || $fbDate === '' || $takenBy === '') {
                echo json_encode(['status' => 'error', 'message' => 'Feedback date, taken by, and notes are required.']);
                exit;
            }

            $stIns = $pdo->prepare("INSERT INTO tbl_contract_feedback (contract_id, agreement_no, feedback_date, feedback_notes, taken_by, created_by) VALUES (?, ?, ?, ?, ?, ?)");
            $stIns->execute([$cid, $agrNo, $fbDate, $fbNotes, $takenBy, $_SESSION['user_id'] ?? null]);

            $stFb = $pdo->prepare("SELECT ids, contract_id, agreement_no, feedback_date, feedback_notes, taken_by, created_at FROM tbl_contract_feedback WHERE contract_id = ? ORDER BY feedback_date DESC, ids DESC");
            $stFb->execute([$cid]);
            echo json_encode([
                'status' => 'success',
                'message' => 'Feedback saved successfully.',
                'data' => $stFb->fetchAll(PDO::FETCH_ASSOC)
            ]);
            exit;
        }

        if ($postAction === 'post_ledger_charges') {
            $cid = (int)($postInput['contract_id'] ?? 0);
            $violations = is_array($postInput['violations'] ?? null) ? $postInput['violations'] : [];
            $otherFees = is_array($postInput['other_fees'] ?? null) ? $postInput['other_fees'] : [];

            if ($cid <= 0) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid contract ID.']);
                exit;
            }
            if (empty($violations) && empty($otherFees)) {
                echo json_encode(['status' => 'error', 'message' => 'Please add at least one violation or other fee entry.']);
                exit;
            }

            $stC = $pdo->prepare("
                SELECT c.ids, c.agreement_no, c.quotation_number, c.booking_ids, c.customer_code, c.company_id,
                       b.booking_no AS booking_no_str, b.quotation_number AS booking_qtn_str
                FROM tbl_vehicle_rentout_contracts c
                LEFT JOIN tbl_vehicle_bookings b ON b.ids = c.booking_ids
                WHERE c.ids = ?
                LIMIT 1
            ");
            $stC->execute([$cid]);
            $cRow = $stC->fetch(PDO::FETCH_ASSOC);
            if (!$cRow) {
                echo json_encode(['status' => 'error', 'message' => 'Contract not found.']);
                exit;
            }

            $agreeNo  = $cRow['agreement_no'] ?? '';
            $qtnNo    = !empty($cRow['quotation_number']) ? $cRow['quotation_number'] : (!empty($cRow['booking_qtn_str']) ? $cRow['booking_qtn_str'] : $agreeNo);
            $bookNo   = !empty($cRow['booking_no_str']) ? $cRow['booking_no_str'] : (string)($cRow['booking_ids'] ?? '');
            $custCode = $cRow['customer_code'] ?? '';
            $compId   = (int)($cRow['company_id'] ?? ($_SESSION['company_id'] ?? 1));
            $userId   = (int)($_SESSION['user_id'] ?? 1);
            $bookIds  = (int)($cRow['booking_ids'] ?? 0);
            $nowStr   = date('Y-m-d H:i:s');

            $insSql = "
                INSERT INTO tbl_customer_ledger
                (customer_code, quotation_no, booking_no, trans_date, trans_type, payment_method, debit, credit, ref_no, description, user_id, company_id, created_at, booking_ids, contract_ids, agreement_no)
                VALUES
                (?, ?, ?, ?, ?, 'N/A', ?, 0, ?, ?, ?, ?, ?, ?, ?, ?)
            ";
            $stIns = $pdo->prepare($insSql);
            $inserted = 0;

            foreach ($violations as $v) {
                $vTitle = trim((string)($v['title'] ?? ''));
                $vFee   = (float)($v['fee'] ?? 0);
                $vDate  = !empty($v['violation_date']) ? trim((string)$v['violation_date']) : date('Y-m-d');
                $vRem   = trim((string)($v['remarks'] ?? ''));
                if ($vFee > 0 || $vTitle !== '') {
                    $transType = $vTitle !== '' ? ('Traffic Violation: ' . $vTitle) : 'Traffic Violation';
                    $desc = $transType . ($vRem !== '' ? " (Remarks: {$vRem})" : '') . " (Agreement No: {$agreeNo})";
                    $stIns->execute([$custCode, $qtnNo, $bookNo, $vDate, $transType, $vFee, $agreeNo, $desc, $userId, $compId, $nowStr, $bookIds, $cid, $agreeNo]);
                    $inserted++;
                }
            }

            foreach ($otherFees as $f) {
                $fItem = trim((string)($f['item'] ?? ''));
                $fAmt  = (float)($f['actual_amount'] ?? ($f['price'] ?? 0));
                $fRem  = trim((string)($f['remarks'] ?? ''));
                if ($fAmt > 0 || $fItem !== '') {
                    $transType = $fItem !== '' ? ('Other Fee: ' . $fItem) : 'Other Fee';
                    $desc = $transType . ($fRem !== '' ? " (Remarks: {$fRem})" : '') . " (Agreement No: {$agreeNo})";
                    $stIns->execute([$custCode, $qtnNo, $bookNo, date('Y-m-d'), $transType, $fAmt, $agreeNo, $desc, $userId, $compId, $nowStr, $bookIds, $cid, $agreeNo]);
                    $inserted++;
                }
            }

            echo json_encode([
                'status' => 'success',
                'message' => $inserted . ' entry(s) posted to Contract Ledger.',
                'inserted' => $inserted
            ]);
            exit;
        }

        if ($postAction === 'get_other_fee_heads' || $postAction === 'save_other_fee_head' || $postAction === 'delete_other_fee_head') {
            $colCheck = $pdo->query("SHOW COLUMNS FROM tbl_ledger_heads LIKE 'standard_price'");
            if (!$colCheck || $colCheck->rowCount() === 0) {
                $pdo->exec("ALTER TABLE tbl_ledger_heads ADD COLUMN standard_price DECIMAL(10,3) NOT NULL DEFAULT 0.000");
            }
        }

        if ($postAction === 'get_other_fee_heads') {
            $modelId = (int)($postInput['model_id'] ?? 0);
            $heads = [];

            $stHeads = $pdo->query("
                SELECT h.ids, h.head_name, COALESCE(h.standard_price, 0.000) AS standard_price, COALESCE(h.is_locked, 0) AS is_locked,
                       (SELECT COUNT(*) FROM tbl_customer_ledger l WHERE l.trans_type = h.head_name OR l.trans_type = CONCAT('Other Fee: ', h.head_name)) AS tx_count
                FROM tbl_ledger_heads h
                WHERE h.head_type = 'Debit' AND COALESCE(h.violation_fine_type, 'No') <> 'Yes'
                ORDER BY h.head_name ASC
            ");
            if ($stHeads) {
                while ($r = $stHeads->fetch(PDO::FETCH_ASSOC)) {
                    $heads[] = [
                        'ids' => (int)$r['ids'],
                        'head_name' => $r['head_name'],
                        'standard_price' => number_format((float)$r['standard_price'], 3, '.', ''),
                        'is_locked' => (int)$r['is_locked'],
                        'tx_count' => (int)$r['tx_count'],
                        'source' => 'Ledger Master'
                    ];
                }
            }

            $modelPrices = [];
            if ($modelId > 0) {
                $stMod = $pdo->prepare("SELECT price_json FROM tbl_vehicle_model WHERE ids = ? LIMIT 1");
                $stMod->execute([$modelId]);
                $mRow = $stMod->fetch(PDO::FETCH_ASSOC);
                if ($mRow && !empty($mRow['price_json'])) {
                    $pArr = json_decode($mRow['price_json'], true);
                    if (is_array($pArr)) {
                        foreach ($pArr as $p) {
                            if (isset($p['ids'])) {
                                $modelPrices[(string)$p['ids']] = (float)($p['amount'] ?? 0);
                            }
                        }
                    }
                }
            }

            $existingNames = array_map(function($h) { return strtolower(trim($h['head_name'])); }, $heads);
            $stPm = $pdo->query("SELECT ids, price_item FROM tbl_vehicle_pricing_master WHERE ledger_status = 'Yes' ORDER BY price_item ASC");
            if ($stPm) {
                while ($pm = $stPm->fetch(PDO::FETCH_ASSOC)) {
                    $pmName = trim((string)$pm['price_item']);
                    if ($pmName !== '' && !in_array(strtolower($pmName), $existingNames, true)) {
                        $stdAmt = $modelPrices[(string)$pm['ids']] ?? 0;
                        $heads[] = [
                            'ids' => 0,
                            'pm_id' => (int)$pm['ids'],
                            'head_name' => $pmName,
                            'standard_price' => number_format((float)$stdAmt, 3, '.', ''),
                            'is_locked' => 1,
                            'source' => 'Pricing Master'
                        ];
                    }
                }
            }

            echo json_encode(['status' => 'success', 'data' => $heads]);
            exit;
        }

        if ($postAction === 'save_other_fee_head') {
            $headId = (int)($postInput['ids'] ?? 0);
            $headName = trim((string)($postInput['head_name'] ?? ''));
            $stdPrice = round((float)($postInput['standard_price'] ?? 0), 3);
            $companyId = (int)($_SESSION['company_id'] ?? 1);

            if ($headName === '') {
                echo json_encode(['status' => 'error', 'message' => 'Fee head name is required.']);
                exit;
            }

            if ($headId > 0) {
                $stUpd = $pdo->prepare("UPDATE tbl_ledger_heads SET head_name = ?, standard_price = ? WHERE ids = ?");
                $stUpd->execute([$headName, $stdPrice, $headId]);
            } else {
                $stIns = $pdo->prepare("
                    INSERT INTO tbl_ledger_heads (head_name, head_type, violation_fine_type, is_locked, company_id, standard_price)
                    VALUES (?, 'Debit', 'No', 0, ?, ?)
                    ON DUPLICATE KEY UPDATE standard_price = VALUES(standard_price)
                ");
                $stIns->execute([$headName, $companyId, $stdPrice]);
            }

            echo json_encode(['status' => 'success', 'message' => 'Other fee head saved successfully.']);
            exit;
        }

        if ($postAction === 'delete_other_fee_head') {
            $headId = (int)($postInput['ids'] ?? 0);
            if ($headId <= 0) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid fee head ID.']);
                exit;
            }
            $stChk = $pdo->prepare("
                SELECT h.head_name, COALESCE(h.is_locked, 0) AS is_locked,
                       (SELECT COUNT(*) FROM tbl_customer_ledger l WHERE l.trans_type = h.head_name OR l.trans_type = CONCAT('Other Fee: ', h.head_name)) AS tx_count
                FROM tbl_ledger_heads h WHERE h.ids = ? LIMIT 1
            ");
            $stChk->execute([$headId]);
            $hRow = $stChk->fetch(PDO::FETCH_ASSOC);
            if (!$hRow) {
                echo json_encode(['status' => 'error', 'message' => 'Fee head not found.']);
                exit;
            }
            if ((int)$hRow['is_locked'] === 1 || (int)$hRow['tx_count'] > 0) {
                echo json_encode(['status' => 'error', 'message' => 'Cannot delete: transactions exist for this fee head.']);
                exit;
            }
            $stDel = $pdo->prepare("DELETE FROM tbl_ledger_heads WHERE ids = ? AND COALESCE(is_locked, 0) = 0");
            $stDel->execute([$headId]);
            echo json_encode(['status' => 'success', 'message' => 'Fee head deleted.']);
            exit;
        }

        if ($postAction === 'get_violation_heads') {
            $stVh = $pdo->query("
                SELECT h.ids, h.head_name, COALESCE(h.is_locked, 0) AS is_locked,
                       (SELECT COUNT(*) FROM tbl_customer_ledger l WHERE l.trans_type = h.head_name OR l.trans_type = CONCAT('Traffic Violation: ', h.head_name)) AS ledger_cnt,
                       (SELECT COUNT(*) FROM tbl_vehicle_rentout_contracts c WHERE c.violations_json IS NOT NULL AND c.violations_json LIKE CONCAT('%', h.head_name, '%')) AS contract_cnt
                FROM tbl_ledger_heads h
                WHERE h.violation_fine_type = 'Yes'
                ORDER BY h.head_name ASC
            ");
            $rows = [];
            if ($stVh) {
                while ($r = $stVh->fetch(PDO::FETCH_ASSOC)) {
                    $txCount = (int)$r['ledger_cnt'] + (int)$r['contract_cnt'];
                    $rows[] = [
                        'ids' => (int)$r['ids'],
                        'head_name' => $r['head_name'],
                        'is_locked' => (int)$r['is_locked'],
                        'tx_count' => $txCount
                    ];
                }
            }
            echo json_encode(['status' => 'success', 'data' => $rows]);
            exit;
        }

        if ($postAction === 'save_violation_head') {
            $headId = (int)($postInput['ids'] ?? 0);
            $headName = trim((string)($postInput['head_name'] ?? ''));
            $companyId = (int)($_SESSION['company_id'] ?? 1);
            if ($headName === '') {
                echo json_encode(['status' => 'error', 'message' => 'Violation head name is required.']);
                exit;
            }
            if ($headId > 0) {
                $stUpd = $pdo->prepare("UPDATE tbl_ledger_heads SET head_name = ? WHERE ids = ? AND violation_fine_type = 'Yes'");
                $stUpd->execute([$headName, $headId]);
            } else {
                $stIns = $pdo->prepare("
                    INSERT INTO tbl_ledger_heads (head_name, head_type, violation_fine_type, is_locked, company_id)
                    VALUES (?, 'Debit', 'Yes', 0, ?)
                    ON DUPLICATE KEY UPDATE violation_fine_type = 'Yes'
                ");
                $stIns->execute([$headName, $companyId]);
            }
            echo json_encode(['status' => 'success', 'message' => 'Violation head saved successfully.']);
            exit;
        }

        if ($postAction === 'delete_violation_head') {
            $headId = (int)($postInput['ids'] ?? 0);
            if ($headId <= 0) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid violation head ID.']);
                exit;
            }
            $stChk = $pdo->prepare("
                SELECT h.head_name, COALESCE(h.is_locked, 0) AS is_locked,
                       (SELECT COUNT(*) FROM tbl_customer_ledger l WHERE l.trans_type = h.head_name OR l.trans_type = CONCAT('Traffic Violation: ', h.head_name)) AS ledger_cnt,
                       (SELECT COUNT(*) FROM tbl_vehicle_rentout_contracts c WHERE c.violations_json IS NOT NULL AND c.violations_json LIKE CONCAT('%', h.head_name, '%')) AS contract_cnt
                FROM tbl_ledger_heads h
                WHERE h.ids = ? AND h.violation_fine_type = 'Yes'
                LIMIT 1
            ");
            $stChk->execute([$headId]);
            $hRow = $stChk->fetch(PDO::FETCH_ASSOC);
            if (!$hRow) {
                echo json_encode(['status' => 'error', 'message' => 'Violation head not found.']);
                exit;
            }
            if ((int)$hRow['is_locked'] === 1 || ((int)$hRow['ledger_cnt'] + (int)$hRow['contract_cnt']) > 0) {
                echo json_encode(['status' => 'error', 'message' => 'Cannot delete: transactions exist for this violation head.']);
                exit;
            }
            $stDel = $pdo->prepare("DELETE FROM tbl_ledger_heads WHERE ids = ? AND violation_fine_type = 'Yes' AND COALESCE(is_locked, 0) = 0");
            $stDel->execute([$headId]);
            echo json_encode(['status' => 'success', 'message' => 'Violation head deleted.']);
            exit;
        }
    }

    $companyId = $_GET['company_id'] ?? ($_SESSION['company_id'] ?? 'all');
    $scope = strtolower(trim((string)($_GET['scope'] ?? 'active')));
    $statusIn = "'Rentout', 'Extended'";
    if ($scope === 'closed') {
        $statusIn = "'Closed', 'Returned'";
    } elseif ($scope === 'generated') {
        $statusIn = "'Generated'";
    } elseif ($scope === 'all') {
        $statusIn = "";
    }

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
            c.service_type,
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
            modl.modal_name AS v_model_name,
            modl.price_json AS v_price_json
        FROM tbl_vehicle_rentout_contracts c
        LEFT JOIN tbl_company tc ON tc.ids = c.company_id
        LEFT JOIN customer_details cust ON (cust.customer_id = c.customer_code OR cust.ids = c.customer_code)
        LEFT JOIN tbl_vehicles v ON v.ids = c.vehicle_id
        LEFT JOIN tbl_vehicle_category cat ON cat.ids = COALESCE(v.category_id, c.vehicle_category_id)
        LEFT JOIN tbl_vehicle_model modl ON modl.ids = COALESCE(v.model_id, c.vehicle_model_id)
        WHERE 1=1
    ";

    if ($statusIn !== '') {
        $sql .= " AND c.agreement_status IN ({$statusIn}) ";
    }

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
    $feedbackCountByContract = [];

    if (!empty($contractIds)) {
        $inClause = implode(',', $contractIds);

        // Batch fetch feedback counts
        $fbStmt = $pdo->query("SELECT contract_id, COUNT(*) AS cnt FROM tbl_contract_feedback WHERE contract_id IN ({$inClause}) GROUP BY contract_id");
        if ($fbStmt) {
            while ($fbRow = $fbStmt->fetch(PDO::FETCH_ASSOC)) {
                $feedbackCountByContract[(int)$fbRow['contract_id']] = (int)$fbRow['cnt'];
            }
        }

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
        $activeRateType  = $rateType;
        $activeUnitPrice = $unitPrice;

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
                $extRType = strtolower($extDet['rate_type'] ?? '');
                if ($extUnit > 0) {
                    $activeUnitPrice = $extUnit;
                    if ($extRType !== '') {
                        $activeRateType = $extRType;
                    }
                }
            }
        }

        // Extract model pricing configuration (With Driver vs Without Driver)
        $svcStr = strtolower(trim((string)($row['service_type'] ?? ($cd['service'] ?? ($cd['service_type'] ?? '')))));
        $wantsWithDriver = (strpos($svcStr, 'with driver') !== false && strpos($svcStr, 'without') === false);
        $modelRates = ['hourly' => 0.0, 'daily' => 0.0, 'weekly' => 0.0, 'monthly' => 0.0];
        $modelFallbackWo = ['hourly' => 0.0, 'daily' => 0.0, 'weekly' => 0.0, 'monthly' => 0.0];

        $priceArr = json_decode($row['v_price_json'] ?? '[]', true);
        if (is_array($priceArr)) {
            foreach ($priceArr as $pItem) {
                $itemName = strtolower((string)($pItem['item'] ?? ''));
                $amt = (float)($pItem['amount'] ?? 0);
                if ($amt <= 0 || $itemName === '') continue;

                $isWith = (strpos($itemName, 'with driver') !== false && strpos($itemName, 'without') === false);
                $isWithout = (strpos($itemName, 'without driver') !== false);

                $bucket = null;
                if (strpos($itemName, 'hour') !== false) $bucket = 'hourly';
                elseif (strpos($itemName, 'day') !== false) $bucket = 'daily';
                elseif (strpos($itemName, 'week') !== false) $bucket = 'weekly';
                elseif (strpos($itemName, 'month') !== false) $bucket = 'monthly';
                if ($bucket === null) continue;

                if ($wantsWithDriver && $isWith) {
                    $modelRates[$bucket] = $amt;
                } elseif (!$wantsWithDriver && $isWithout) {
                    $modelRates[$bucket] = $amt;
                }
                if ($isWithout) {
                    $modelFallbackWo[$bucket] = $amt;
                }
            }
            foreach ($modelRates as $k => $v) {
                if ($v <= 0 && $modelFallbackWo[$k] > 0) {
                    $modelRates[$k] = $modelFallbackWo[$k];
                }
            }
        }

        // Formula fallback rates when model pricing is not configured
        $formulaDaily = 0.0;
        if ($activeUnitPrice > 0) {
            if (strpos($activeRateType, 'hour') !== false) {
                $formulaDaily = $activeUnitPrice * 24;
            } elseif (strpos($activeRateType, 'month') !== false) {
                $formulaDaily = $activeUnitPrice / 30;
            } elseif (strpos($activeRateType, 'week') !== false) {
                $formulaDaily = $activeUnitPrice / 7;
            } else {
                $formulaDaily = $activeUnitPrice;
            }
        } elseif ($baseAmount > 0 && $initialDuration > 0) {
            $formulaDaily = $baseAmount / $initialDuration;
        }

        $formulaHourly  = (strpos($activeRateType, 'hour') !== false && $activeUnitPrice > 0) ? $activeUnitPrice : ($formulaDaily / 24);
        $formulaWeekly  = (strpos($activeRateType, 'week') !== false && $activeUnitPrice > 0) ? $activeUnitPrice : ($formulaDaily * 7);
        $formulaMonthly = (strpos($activeRateType, 'month') !== false && $activeUnitPrice > 0) ? $activeUnitPrice : ($formulaDaily * 30);

        $effHourly  = ($modelRates['hourly']  > 0) ? $modelRates['hourly']  : $formulaHourly;
        $effDaily   = ($modelRates['daily']   > 0) ? $modelRates['daily']   : $formulaDaily;
        $effWeekly  = ($modelRates['weekly']  > 0) ? $modelRates['weekly']  : $formulaWeekly;
        $effMonthly = ($modelRates['monthly'] > 0) ? $modelRates['monthly'] : $formulaMonthly;

        $effectiveEndTs = $latestExtEndTs ?: $initialEndTs;
        $effectiveEndStr = $latestExtEndTs ? $latestExtEndStr : $initialEnd;
        $endDateOnly = $effectiveEndTs ? date('Y-m-d', $effectiveEndTs) : '';

        // Overdue status & amount as per today (with 1hr grace period, only for active contracts)
        $isActiveStatus = in_array(strtolower(trim((string)($row['agreement_status'] ?? ''))), ['rentout', 'extended'], true);
        $isOverdue = false;
        $isDueToday = ($isActiveStatus && $endDateOnly === $todayStr);
        $overdueDays = 0;
        $overdueAmount = 0.0;

        if ($isActiveStatus && $effectiveEndTs && $nowTs > ($effectiveEndTs + 3600)) {
            $isOverdue = true;
            $diffSec = $nowTs - $effectiveEndTs;
            $overdueDays = $isDueToday ? 1 : max(1, (int)ceil($diffSec / 86400));

            if (strpos($activeRateType, 'hour') !== false) {
                $overdueHours = max(1, (int)ceil($diffSec / 3600));
                $overdueAmount = round($overdueHours * $effHourly, 3);
            } elseif (strpos($activeRateType, 'month') !== false) {
                $dtStart = new DateTime('@' . $effectiveEndTs);
                $dtNow   = new DateTime('@' . $nowTs);
                $diffObj = $dtStart->diff($dtNow);
                $completedMonths = ($diffObj->y * 12) + $diffObj->m;
                $extraDays = $diffObj->d + (($diffObj->h > 0 || $diffObj->i > 0 || $diffObj->s > 0) ? 1 : 0);
                if ($completedMonths === 0 && $extraDays === 0) {
                    $extraDays = 1;
                }
                $overdueAmount = round(($completedMonths * $effMonthly) + ($extraDays * $effDaily), 3);
            } elseif (strpos($activeRateType, 'week') !== false) {
                $completedWeeks = intdiv($overdueDays, 7);
                $extraDays = $overdueDays % 7;
                $overdueAmount = round(($completedWeeks * $effWeekly) + ($extraDays * $effDaily), 3);
            } else {
                $overdueAmount = round($overdueDays * $effDaily, 3);
            }
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
            'feedback_count'        => $feedbackCountByContract[$cId] ?? 0,
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
