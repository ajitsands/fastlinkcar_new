<?php

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action == 'save_refund') {
    $company_code = $_POST['company_code'] ?? 'AA';
    $date = $_POST['refund_date'] ?? date('Y-m-d');
    $customer_code = $_POST['customer_code'] ?? '';
    $agreement_no = $_POST['agreement_no'] ?? '';
    $amount = $_POST['amount'] ?? 0;
    $refund_mode = $_POST['refund_mode'] ?? 'Cash';
    $reason = $_POST['reason'] ?? '';
    $user_id = $_SESSION['user_id'] ?? 1; // Fallback to 1 if no session
    
    // Ensure table exists
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;
    $sqlCreate = "CREATE TABLE IF NOT EXISTS `tbl_refund_requests` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `refund_no` varchar(100) NOT NULL,
      `date` date NOT NULL,
      `customer_code` varchar(100) NOT NULL,
      `agreement_no` varchar(100) NOT NULL,
      `amount` decimal(18,5) NOT NULL,
      `refund_mode` varchar(50) DEFAULT 'Cash',
      `reason` text,
      `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
      `created_by` int(11) NOT NULL,
      `created_at` datetime NOT NULL,
      `approved_by` int(11) DEFAULT NULL,
      `approved_at` datetime DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    $pdo->exec($sqlCreate);

    // Make sure column exists in case table was created earlier
    try {
        $pdo->exec("ALTER TABLE `tbl_refund_requests` ADD COLUMN `refund_mode` VARCHAR(50) DEFAULT 'Cash' AFTER `amount`");
    } catch(Exception $e) {
        // Column probably already exists
    }

    // Generate refund no for the specific company
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tbl_refund_requests WHERE YEAR(`date`) = YEAR(CURRENT_DATE) AND refund_no LIKE ?");
    $stmt->execute([$company_code . '/%']);
    $count = $stmt->fetchColumn() + 1;
    $refund_no = $company_code . '/' . date('Y') . '/REF/' . str_pad($count, 4, '0', STR_PAD_LEFT);

    $sqlInsert = "INSERT INTO tbl_refund_requests (refund_no, date, customer_code, agreement_no, amount, refund_mode, reason, status, created_by, created_at)
                  VALUES (:refund_no, :date, :customer_code, :agreement_no, :amount, :refund_mode, :reason, 'Pending', :created_by, NOW())";
    $stmt = $pdo->prepare($sqlInsert);
    $stmt->execute([
        ':refund_no' => $refund_no,
        ':date' => $date,
        ':customer_code' => $customer_code,
        ':agreement_no' => $agreement_no,
        ':amount' => $amount,
        ':refund_mode' => $refund_mode,
        ':reason' => $reason,
        ':created_by' => $user_id
    ]);

    // Handle additional charges
    $charges_json = $_POST['charges'] ?? '[]';
    $charges = json_decode($charges_json, true);
    if (is_array($charges) && count($charges) > 0) {
        $sqlLedger = "INSERT INTO tbl_customer_ledger (customer_code, booking_no, agreement_no, trans_date, trans_type, payment_method, debit, credit, ref_no, description, created_at)
                      VALUES (:customer_code, :booking_no, :agreement_no, :trans_date, :trans_type, 'Cash', :debit, 0, :ref_no, :description, NOW())";
        $stmtLedger = $pdo->prepare($sqlLedger);

        foreach ($charges as $charge) {
            $type = $charge['type'] ?? 'Other Fee';
            $desc = $charge['desc'] ?? '';
            $amt = floatval($charge['amt'] ?? 0);

            if ($amt > 0) {
                $stmtLedger->execute([
                    ':customer_code' => $customer_code,
                    ':booking_no' => $agreement_no,
                    ':agreement_no' => $agreement_no,
                    ':trans_date' => $date,
                    ':trans_type' => $type,
                    ':debit' => $amt,
                    ':ref_no' => $refund_no,
                    ':description' => $desc
                ]);
            }
        }
    }

    echo json_encode(['status' => true, 'message' => 'Refund Request Created Successfully', 'refund_no' => $refund_no]);
    exit;
}

if ($action == 'approve_refund') {
    $id = $_POST['id'] ?? 0;
    $user_id = $_SESSION['user_id'] ?? 1;

    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;
    $stmt = $pdo->prepare("SELECT * FROM tbl_refund_requests WHERE id = ?");
    $stmt->execute([$id]);
    $refund = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($refund && $refund['status'] == 'Pending') {
        // Approve it
        $stmtUpdate = $pdo->prepare("UPDATE tbl_refund_requests SET status = 'Approved', approved_by = ?, approved_at = NOW() WHERE id = ?");
        $stmtUpdate->execute([$user_id, $id]);

        $company_id = $_SESSION['company_id'] ?? 1;

        // Fetch contract_ids and booking_ids
        $stmtContract = $pdo->prepare("SELECT ids as contract_ids, booking_ids FROM tbl_vehicle_rentout_contracts WHERE agreement_no = ?");
        $stmtContract->execute([$refund['agreement_no']]);
        $contract = $stmtContract->fetch(PDO::FETCH_ASSOC);
        
        $contract_ids = $contract ? $contract['contract_ids'] : null;
        $booking_ids = $contract ? $contract['booking_ids'] : null;

        // Insert into customer ledger
        $sqlLedger = "INSERT INTO tbl_customer_ledger (customer_code, booking_no, agreement_no, trans_date, trans_type, payment_method, debit, credit, ref_no, description, user_id, company_id, booking_ids, contract_ids)
                      VALUES (:customer_code, :booking_no, :agreement_no, :trans_date, 'Refund', :payment_method, :debit, 0, :ref_no, :description, :user_id, :company_id, :booking_ids, :contract_ids)";
        $stmtLedger = $pdo->prepare($sqlLedger);
        $stmtLedger->execute([
            ':customer_code' => $refund['customer_code'],
            ':booking_no' => $refund['agreement_no'], // using agreement_no as booking_no too
            ':agreement_no' => $refund['agreement_no'],
            ':trans_date' => date('Y-m-d'),
            ':payment_method' => $refund['refund_mode'] ?: 'Cash',
            ':debit' => $refund['amount'],
            ':ref_no' => $refund['refund_no'],
            ':description' => $refund['reason'] ?: 'Refund Approved',
            ':user_id' => $user_id,
            ':company_id' => $company_id,
            ':booking_ids' => $booking_ids,
            ':contract_ids' => $contract_ids
        ]);

        echo json_encode(['status' => true, 'message' => 'Refund Approved and Ledger Updated']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Invalid or already processed refund']);
    }
    exit;
}

if ($action == 'delete_refund') {
    $id = $_POST['id'] ?? 0;
    
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;
    $stmt = $pdo->prepare("SELECT * FROM tbl_refund_requests WHERE id = ?");
    $stmt->execute([$id]);
    $refund = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($refund) {
        if ($refund['status'] == 'Approved') {
            echo json_encode(['status' => false, 'message' => 'Cannot delete an approved refund']);
        } else {
            // Also delete associated unapproved charges in ledger
            $stmtDelLedger = $pdo->prepare("DELETE FROM tbl_customer_ledger WHERE ref_no = ?");
            $stmtDelLedger->execute([$refund['refund_no']]);

            $stmtDel = $pdo->prepare("DELETE FROM tbl_refund_requests WHERE id = ?");
            if ($stmtDel->execute([$id])) {
                echo json_encode(['status' => true, 'message' => 'Refund request deleted successfully']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Error deleting refund request']);
            }
        }
    } else {
        echo json_encode(['status' => false, 'message' => 'Refund request not found']);
    }
    exit;
}

if ($action == 'get_refund_details') {
    $id = $_POST['id'] ?? 0;
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;

    $stmt = $pdo->prepare("
        SELECT r.*, c.customer_name, c.customer_mobile, c.customer_cr_cpr, comp.company_name 
        FROM tbl_refund_requests r
        LEFT JOIN customer_details c ON r.customer_code = c.customer_id
        LEFT JOIN tbl_company comp ON SUBSTRING_INDEX(r.refund_no, '/', 1) = comp.company_code
        WHERE r.id = ?
    ");
    $stmt->execute([$id]);
    $refund = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($refund) {
        $stmtLedger = $pdo->prepare("SELECT trans_type, debit as amount, description as `desc` FROM tbl_customer_ledger WHERE ref_no = ? AND trans_type != 'Refund' AND debit > 0");
        $stmtLedger->execute([$refund['refund_no']]);
        $charges = $stmtLedger->fetchAll(PDO::FETCH_ASSOC);

        $agreement_no = $refund['agreement_no'];
        $stmtContract = $pdo->prepare("SELECT service_start_date_time, return_date, km_used, vechile_details, vehicle_no FROM tbl_vehicle_rentout_contracts WHERE agreement_no = ?");
        $stmtContract->execute([$agreement_no]);
        $contract = $stmtContract->fetch(PDO::FETCH_ASSOC);
        if ($contract) {
            $contract['vechile_details'] = json_decode($contract['vechile_details'], true);
        }

        $stmtLedgerSum = $pdo->prepare("SELECT SUM(debit) as total_debit, SUM(credit) as total_credit FROM tbl_customer_ledger WHERE booking_no = ? OR agreement_no = ? OR ref_no = ?");
        $stmtLedgerSum->execute([$agreement_no, $agreement_no, $agreement_no]);
        $ledger_sum = $stmtLedgerSum->fetch(PDO::FETCH_ASSOC);

        $stmtRows = $pdo->prepare("SELECT trans_date, trans_type, payment_method, debit, credit, ref_no, description FROM tbl_customer_ledger WHERE booking_no = ? OR agreement_no = ? OR ref_no = ? ORDER BY trans_date ASC, ids ASC");
        $stmtRows->execute([$agreement_no, $agreement_no, $agreement_no]);
        $ledger_rows = $stmtRows->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['status' => true, 'data' => ['refund' => $refund, 'charges' => $charges, 'contract' => $contract, 'ledger_sum' => $ledger_sum, 'ledger_rows' => $ledger_rows]]);
    } else {
        echo json_encode(['status' => false, 'message' => 'Refund not found']);
    }
    exit;
}

if ($action == 'get_refunds') {
    $filter_company_code = $_POST['filter_company_code'] ?? 'All';
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;
    
    $where = "";
    $params = [];
    if ($filter_company_code !== 'All' && !empty($filter_company_code)) {
        $where = "WHERE r.refund_no LIKE ?";
        $params[] = $filter_company_code . '/%';
    }

    $stmt = $pdo->prepare("
        SELECT r.*, c.customer_name, c.customer_mobile, c.customer_cr_cpr, comp.company_name 
        FROM tbl_refund_requests r
        LEFT JOIN customer_details c ON r.customer_code = c.customer_id
        LEFT JOIN tbl_company comp ON SUBSTRING_INDEX(r.refund_no, '/', 1) = comp.company_code
        $where
        ORDER BY r.id DESC
    ");
    $stmt->execute($params);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['data' => $data]);
    exit;
}

if ($action == 'search_ledger_heads') {
    $q = $_GET['q'] ?? '';
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;
    $stmt = $pdo->prepare("SELECT head_name as id, head_name as text FROM tbl_ledger_heads WHERE head_type = 'Debit' AND head_name LIKE ? ORDER BY head_name ASC LIMIT 20");
    $stmt->execute(['%' . $q . '%']);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
    exit;
}

if ($action == 'save_additional_charges') {
    $agreement_no = $_POST['agreement_no'] ?? '';
    $charges = $_POST['charges'] ?? [];
    
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;

    if (empty($agreement_no)) {
        echo json_encode(['status' => false, 'message' => 'Agreement number is required']);
        exit;
    }

    // Retrieve existing violations_json if any
    $stmt = $pdo->prepare("SELECT * FROM tbl_vehicle_rentout_contracts WHERE agreement_no = ?");
    $stmt->execute([$agreement_no]);
    $contract = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$contract) {
        echo json_encode(['status' => false, 'message' => 'Contract not found']);
        exit;
    }

    $existingViolations = [];
    if (!empty($contract['violations_json'])) {
        $decoded = json_decode($contract['violations_json'], true);
        if (is_array($decoded)) {
            $existingViolations = $decoded;
        }
    }

    $user_id = $_SESSION['user_id'] ?? 1;
    $company_id = $contract['company_id'] ?? 1;
    $customer_code = $contract['customer_code'] ?? '';
    $quotation_no = $contract['quotation_number'] ?? '';
    $booking_no = $contract['agreement_group_ref_no'] ?? '';
    $booking_ids = $contract['booking_ids'] ?? 0;
    $contract_ids = $contract['ids'] ?? 0;

    // Append new charges
    foreach ($charges as $charge) {
        $type = $charge['type'] ?? '';
        $fee = (float)($charge['amount'] ?? 0);
        $desc = $charge['desc'] ?? '';
        $date = date('Y-m-d H:i:s');

        $existingViolations[] = [
            'title'   => $type,
            'fee'     => $fee,
            'remarks' => $desc,
            'date'    => $date
        ];

        // Insert into ledger
        $ledgerDesc = "Vehicle Violation: $type" . ($desc ? " (Remarks: $desc)" : "") . " (Agreement No: $agreement_no)";
        $ledgerSql = "
            INSERT INTO tbl_customer_ledger (
                customer_code, quotation_no, booking_no, trans_date, trans_type, 
                payment_method, debit, credit, ref_no, description, 
                user_id, company_id, created_at, booking_ids, contract_ids, agreement_no
            ) VALUES (
                ?, ?, ?, ?, ?, 
                'N/A', ?, 0, ?, ?, 
                ?, ?, ?, ?, ?, ?
            )";
        $ledgerStmt = $pdo->prepare($ledgerSql);
        $ledgerStmt->execute([
            $customer_code, $quotation_no, $booking_no, date('Y-m-d'), $type,
            $fee, $agreement_no, $ledgerDesc,
            $user_id, $company_id, $date, $booking_ids, $contract_ids, $agreement_no
        ]);
    }

    $violations_json = json_encode($existingViolations);
    
    $updateStmt = $pdo->prepare("UPDATE tbl_vehicle_rentout_contracts SET violations_json = ? WHERE agreement_no = ?");
    $updateStmt->execute([$violations_json, $agreement_no]);

    echo json_encode(['status' => true, 'message' => 'Additional charges saved to contract']);
    exit;
}

if ($action == 'get_agreement_summary') {
    $agreement_no = $_POST['agreement_no'] ?? '';
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;

    $stmt = $pdo->prepare("SELECT service_start_date_time, return_date, km_used, vechile_details, vehicle_no FROM tbl_vehicle_rentout_contracts WHERE agreement_no = ?");
    $stmt->execute([$agreement_no]);
    $contract = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($contract) {
        $contract['vechile_details'] = json_decode($contract['vechile_details'], true);
    }

    $stmt2 = $pdo->prepare("
        SELECT 
            SUM(debit) as total_debit,
            SUM(credit) as total_credit,
            SUM(CASE WHEN trans_type LIKE '%Damage%' THEN debit ELSE 0 END) as damage_cost,
            SUM(CASE WHEN trans_type LIKE '%Violation%' THEN debit ELSE 0 END) as traffic_fine,
            SUM(CASE WHEN trans_type NOT LIKE '%Damage%' AND trans_type NOT LIKE '%Violation%' AND trans_type NOT LIKE 'Rental%' AND trans_type NOT LIKE 'VAT%' THEN debit ELSE 0 END) as other_charges
        FROM tbl_customer_ledger
        WHERE booking_no = ? OR agreement_no = ? OR ref_no = ?
    ");
    $stmt2->execute([$agreement_no, $agreement_no, $agreement_no]);
    $ledger = $stmt2->fetch(PDO::FETCH_ASSOC);

    $stmtRows = $pdo->prepare("
        SELECT trans_date, trans_type, payment_method, debit, credit, ref_no, description
        FROM tbl_customer_ledger
        WHERE booking_no = ? OR agreement_no = ? OR ref_no = ?
        ORDER BY trans_date ASC, ids ASC
    ");
    $stmtRows->execute([$agreement_no, $agreement_no, $agreement_no]);
    $ledger_rows = $stmtRows->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => true, 'data' => ['contract' => $contract, 'ledger' => $ledger, 'ledger_rows' => $ledger_rows]]);
    exit;
}
