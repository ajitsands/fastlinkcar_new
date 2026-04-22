<?php
header('Content-Type: application/json');
session_start();
define('ROOT_PATH', dirname(dirname(__DIR__)));
include(ROOT_PATH . '/model/db_connection/pdo_db_connection.php');

class FundFlowController {
    private $varPDOModelObj;

    public function __construct() {
        $this->varPDOModelObj = new ClassPDOModel();
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
            default:
                echo json_encode(['status' => false, 'message' => 'Invalid Action']);
                break;
        }
    }

    private function getMonthlySummary() {
        $company_id = $_SESSION['company_id'] ?? 1;
        $start = $_GET['start_date'] ?? date('Y-m-01', strtotime('-5 months'));
        $end = $_GET['end_date'] ?? date('Y-m-t');

        // 1. Get Monthly Invoices (Debits) and Payments (Credits)
        $sql = "SELECT 
                    DATE_FORMAT(trans_date, '%Y-%m') as month_key,
                    DATE_FORMAT(trans_date, '%b %Y') as month_name,
                    SUM(debit) as total_debit,
                    SUM(credit) as total_credit,
                    SUM(CASE WHEN payment_method = 'Cheque' AND cheque_status = 'Pending' THEN debit ELSE 0 END) as pending_cheques
                FROM tbl_customer_ledger 
                WHERE company_id = ? AND trans_date BETWEEN ? AND ?
                GROUP BY month_key
                ORDER BY month_key ASC";
        
        $res = json_decode($this->varPDOModelObj->ListFromTable($sql, [$company_id, $start, $end]), true);

        // 2. Get Overdue (Everything before the start date that is still outstanding)
        $sqlOverdue = "SELECT 
                        SUM(debit - credit) as total_outstanding
                       FROM tbl_customer_ledger 
                       WHERE company_id = ? AND trans_date < ?";
        $resOverdue = json_decode($this->varPDOModelObj->ListFromTable($sqlOverdue, [$company_id, $start]), true);

        echo json_encode([
            'status' => true,
            'data' => $res['data'] ?? [],
            'overdue' => $resOverdue['data'][0]['total_outstanding'] ?? 0
        ]);
    }

    private function getMonthlyDetails() {
        $company_id = $_SESSION['company_id'] ?? 1;
        $month = $_GET['month']; // YYYY-MM
        
        $sql = "SELECT 
                    c.customer_name,
                    c.customer_mobile,
                    SUM(l.debit - l.credit) as balance,
                    SUM(CASE WHEN l.payment_method = 'Cheque' AND l.cheque_status = 'Pending' THEN l.debit ELSE 0 END) as pending_cheque_amount
                FROM tbl_customer_ledger l
                JOIN tbl_customers c ON l.customer_code = c.customer_code
                WHERE l.company_id = ? AND DATE_FORMAT(l.trans_date, '%Y-%m') = ?
                GROUP BY c.customer_code
                HAVING balance != 0 OR pending_cheque_amount != 0
                ORDER BY balance DESC";
        
        echo $this->varPDOModelObj->ListFromTable($sql, [$company_id, $month]);
    }
}

$controller = new FundFlowController();
$controller->handleRequest();
