<?php
header('Content-Type: application/json');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(dirname(__DIR__)));
}

include_once(ROOT_PATH . '/model/db_connection/pdo_db_connection.php');
include_once(ROOT_PATH . '/model/common/pdoCommonFunctions.php');

class FundFlowController {
    private $varPDOModelObj;

    public function __construct() {
        $this->varPDOModelObj = new CommonPDOModel();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? $_POST['action'] ?? '';
        switch ($action) {
            case 'GetMonthlySummary':
                $this->getMonthlySummary();
                break;
            case 'GetMonthlyDetails':
                $this->getMonthlyDetails();
                break;
            case 'GetOverdueDetails':
                $this->getOverdueDetails();
                break;
            default:
                echo json_encode(['status' => false, 'message' => 'Invalid Action']);
                break;
        }
    }

    private function getMonthlySummary() {
        $company_id = $_SESSION['company_id'] ?? 1;
        $start = $_GET['start_date'] ?? date('Y-m-01', strtotime('-5 months'));
        $end = $_GET['end_date'] ?? date('Y-m-t');

        $targetDateSql = "CASE WHEN payment_method = 'Cheque' THEN COALESCE(cheque_date, trans_date) ELSE trans_date END";

        // 1. Get Monthly Invoices and Detailed Credits
        $sql = "SELECT 
                    DATE_FORMAT($targetDateSql, '%Y-%m') as month_key,
                    DATE_FORMAT($targetDateSql, '%b %Y') as month_name,
                    SUM(debit) as total_debit,
                    SUM(CASE WHEN payment_method = 'Cash' THEN credit ELSE 0 END) as cash_credit,
                    SUM(CASE WHEN payment_method = 'BankTransfer' THEN credit ELSE 0 END) as bank_transfer_credit,
                    SUM(CASE WHEN payment_method NOT IN ('Cash', 'BankTransfer', 'Cheque') AND payment_method != 'N/A' THEN credit ELSE 0 END) as other_payment_credit,
                    SUM(CASE WHEN payment_method = 'Cheque' AND cheque_status = 'Collected' THEN credit ELSE 0 END) as collected_cheques,
                    SUM(CASE WHEN payment_method = 'Cheque' AND cheque_status = 'Pending' THEN credit ELSE 0 END) as pending_cheques
                FROM tbl_customer_ledger 
                WHERE company_id = ? AND $targetDateSql BETWEEN ? AND ?
                GROUP BY month_key
                ORDER BY month_key ASC";
        
        $res = json_decode($this->varPDOModelObj->ListFromTable($sql, [$company_id, $start, $end]), true);

        // 2. Get Overdue (Total Pending Cheques from before the start date)
        $sqlOverdue = "SELECT 
                        SUM(credit) as total_pending
                       FROM tbl_customer_ledger 
                       WHERE company_id = ? 
                       AND payment_method = 'Cheque' 
                       AND cheque_status = 'Pending'
                       AND $targetDateSql < ?";
        $resOverdue = json_decode($this->varPDOModelObj->ListFromTable($sqlOverdue, [$company_id, $start]), true);

        echo json_encode([
            'status' => true,
            'data' => $res['data'] ?? [],
            'overdue' => $resOverdue['data'][0]['total_pending'] ?? 0
        ]);
    }

    private function getMonthlyDetails() {
        $company_id = $_SESSION['company_id'] ?? 1;
        $month = $_GET['month']; // YYYY-MM
        
        $targetDateSql = "CASE WHEN payment_method = 'Cheque' THEN COALESCE(cheque_date, trans_date) ELSE trans_date END";

        $sql = "SELECT 
                    c.customer_name,
                    c.customer_mobile,
                    SUM(l.debit - (CASE WHEN l.payment_method != 'Cheque' OR l.cheque_status = 'Collected' THEN l.credit ELSE 0 END)) as balance,
                    SUM(CASE WHEN l.payment_method = 'Cheque' AND l.cheque_status = 'Pending' THEN l.credit ELSE 0 END) as pending_cheque_amount
                FROM tbl_customer_ledger l
                JOIN customer_details c ON l.customer_code = c.customer_id
                WHERE l.company_id = ? AND DATE_FORMAT($targetDateSql, '%Y-%m') = ?
                GROUP BY c.customer_id
                HAVING balance != 0 OR pending_cheque_amount != 0
                ORDER BY balance DESC";
        
        echo $this->varPDOModelObj->ListFromTable($sql, [$company_id, $month]);
    }

    private function getOverdueDetails() {
        $company_id = $_SESSION['company_id'] ?? 1;
        $start = $_GET['start_date'] ?? date('Y-m-d');
        
        $targetDateSql = "CASE WHEN payment_method = 'Cheque' THEN COALESCE(cheque_date, trans_date) ELSE trans_date END";

        // Fetch all cheques from the past period to allow Revoke/Management
        $sql = "SELECT 
                    l.ids,
                    l.cheque_status,
                    c.customer_name,
                    c.customer_mobile,
                    l.credit as amount,
                    l.cheque_date,
                    l.ref_no,
                    b1.bank_name as from_bank,
                    b2.bank_name as to_bank
                FROM tbl_customer_ledger l
                JOIN customer_details c ON l.customer_code = c.customer_id
                LEFT JOIN tbl_banks b1 ON l.bank_id = b1.ids
                LEFT JOIN tbl_banks b2 ON l.company_bank_id = b2.ids
                WHERE l.company_id = ? 
                AND l.payment_method = 'Cheque' 
                AND l.cheque_status = 'Pending'
                AND $targetDateSql < ?
                ORDER BY l.cheque_date DESC";
        
        echo $this->varPDOModelObj->ListFromTable($sql, [$company_id, $start]);
    }
}

$controller = new FundFlowController();
$controller->handleRequest();
