<?php
// controller/reports/CustomerBalanceController.php
require_once ROOT_PATH . '/__db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'get_balances') {
    $pdo = getPDO();
    
    try {
        $sql = "
            SELECT 
                c.customer_id,
                c.customer_name,
                c.customer_mobile,
                SUM(l.debit) as total_debit,
                SUM(l.credit) as total_credit,
                (SUM(l.debit) - SUM(l.credit)) as balance
            FROM tbl_customer_ledger l
            JOIN customer_details c ON l.customer_code = c.customer_id
            GROUP BY c.customer_id, c.customer_name, c.customer_mobile
            HAVING balance != 0 OR total_debit > 0 OR total_credit > 0
            ORDER BY c.customer_name ASC
        ";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
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
