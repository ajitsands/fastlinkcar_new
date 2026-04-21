<?php
header('Content-Type: application/json');

class CustomerLedgerController
{
    private $varPDOModelObj;
    public $actionevents, $params = [];

    public function __construct()
    {
        $this->varPDOModelObj = new CommonPDOModel();
        $this->actionevents = $_GET['action'] ?? $_POST['action'] ?? null;
    }

    public function DataRequest($action)
    {
        switch ($action) {
            case 'SearchCustomer':
                $search = $_GET['q'] ?? '';
                $sql = "SELECT ids AS id, customer_id AS customer_code, customer_name, customer_mobile 
                        FROM customer_details 
                        WHERE customer_name LIKE ? OR customer_mobile LIKE ? 
                        LIMIT 20";
                $res = $this->varPDOModelObj->ListFromTable($sql, ["%$search%", "%$search%"]);
                $data = json_decode($res, true);
                echo json_encode($data['data'] ?? []);
                break;

            case 'GetQuotations':
                $customer_code = $_GET['customer_code'] ?? '';
                $sql = "SELECT quotation_no AS id, quotation_no AS text FROM quotations WHERE customer_code = ? ORDER BY id DESC";
                $res = $this->varPDOModelObj->ListFromTable($sql, [$customer_code]);
                $data = json_decode($res, true);
                echo json_encode($data['data'] ?? []);
                break;

            case 'GetBookings':
                $customer_code = $_GET['customer_code'] ?? '';
                $sql = "SELECT booking_no AS id, booking_no AS text FROM tbl_vehicle_bookings WHERE customer_code = ? ORDER BY ids DESC";
                $res = $this->varPDOModelObj->ListFromTable($sql, [$customer_code]);
                $data = json_decode($res, true);
                echo json_encode($data['data'] ?? []);
                break;

            case 'SaveTransaction':
                $this->handleSave();
                break;

            case 'GetLedgerData':
                $this->handleGetLedger();
                break;
            
            case 'GetChequeCalendarEvents':
                $this->handleGetChequeCalendarEvents();
                break;

            case 'GetChequesByDate':
                $this->handleGetChequesByDate();
                break;

            case 'UpdateChequeStatus':
                $this->handleUpdateChequeStatus();
                break;
            
            case 'DeleteTransaction':
                $this->handleDeleteTransaction();
                break;
            
            case 'GetTransaction':
                $id = $_GET['ids'] ?? 0;
                $sql = "SELECT * FROM tbl_customer_ledger WHERE ids = ?";
                echo $this->varPDOModelObj->ListFromTable($sql, [$id]);
                break;

            default:
                echo json_encode(['status' => false, 'message' => 'Invalid Action']);
                break;
        }
    }

    private function handleSave()
    {
        $ids = $_POST['ids'] ?? null;
        $customer_code = $_POST['customer_code'] ?? '';
        $trans_date = $_POST['trans_date'] ?? date('Y-m-d');
        $trans_type = $_POST['trans_type'] ?? 'Payment';
        $payment_method = $_POST['payment_method'] ?? 'N/A';
        $amount = $_POST['amount'] ?? 0;
        $ref_no = $_POST['ref_no'] ?? '';
        $description = $_POST['description'] ?? '';
        $quotation_no = $_POST['quotation_no'] ?? null;
        $booking_no = $_POST['booking_no'] ?? null;

        // Logic for debit/credit
        // Invoices are Debits (Customer owes)
        // Payments, Advances, Discounts are Credits (Customer paid)
        $debit = ($trans_type == 'Invoice') ? $amount : 0;
        $credit = ($trans_type != 'Invoice') ? $amount : 0;

        $user_id = $_SESSION['user_id'] ?? 1;
        $company_id = $_SESSION['company_id'] ?? 1;
        $user_role = $_SESSION['user_role_name'] ?? 'User';

        if ($ids) {
            // Edit mode - Check permissions (Admin or Creator on same day)
            if (!$this->canModify($ids)) {
                echo json_encode(['status' => false, 'message' => 'You only have permission to edit your own entries on the same day they were created. Otherwise, only Administrators can edit.']);
                return;
            }
            $sql = "UPDATE tbl_customer_ledger SET 
                    customer_code = ?, quotation_no = ?, booking_no = ?, trans_date = ?, 
                    trans_type = ?, payment_method = ?, debit = ?, credit = ?, 
                    ref_no = ?, description = ? WHERE ids = ?";
            $params = [$customer_code, $quotation_no, $booking_no, $trans_date, $trans_type, $payment_method, $debit, $credit, $ref_no, $description, $ids];
            echo $this->varPDOModelObj->UpdateTable($sql, $params);
        } else {
            // New entry
            $sql = "INSERT INTO tbl_customer_ledger 
                    (customer_code, quotation_no, booking_no, trans_date, trans_type, payment_method, debit, credit, ref_no, cheque_status, description, user_id, company_id) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', ?, ?, ?)";
            $params = [$customer_code, $quotation_no, $booking_no, $trans_date, $trans_type, $payment_method, $debit, $credit, $ref_no, $description, $user_id, $company_id];
            echo $this->varPDOModelObj->AddToTable($sql, $params);
        }
    }

    private function handleGetChequeCalendarEvents()
    {
        $customer_code = $_GET['customer_code'] ?? null;
        $sql = "SELECT trans_date, cheque_status, COUNT(*) as cheque_count 
                FROM tbl_customer_ledger 
                WHERE payment_method = 'Cheque' ";
        $params = [];
        if ($customer_code) {
            $sql .= " AND customer_code = ? ";
            $params[] = $customer_code;
        }
        $sql .= " GROUP BY trans_date, cheque_status";
        $res = json_decode($this->varPDOModelObj->ListFromTable($sql, $params), true);
        
        $events = [];
        if ($res['status']) {
            foreach ($res['data'] as $row) {
                $color = ($row['cheque_status'] === 'Collected') ? '#28c76f' : (($row['cheque_status'] === 'Bounced') ? '#ea5455' : '#ff9f43');
                $events[] = [
                    'title' => $row['cheque_count'] . ' ' . $row['cheque_status'],
                    'start' => $row['trans_date'],
                    'color' => $color,
                    'allDay' => true,
                    'extendedProps' => ['date' => $row['trans_date']]
                ];
            }
        }
        echo json_encode($events);
    }

    private function handleGetChequesByDate()
    {
        $date = $_GET['date'] ?? '';
        $customer_code = $_GET['customer_code'] ?? null;
        
        $sql = "SELECT l.*, c.customer_name 
                FROM tbl_customer_ledger l
                JOIN customer_details c ON l.customer_code = c.customer_id
                WHERE l.payment_method = 'Cheque' AND l.trans_date = ? ";
        $params = [$date];
        if ($customer_code) {
            $sql .= " AND l.customer_code = ? ";
            $params[] = $customer_code;
        }
        echo $this->varPDOModelObj->ListFromTable($sql, $params);
    }

    private function handleUpdateChequeStatus()
    {
        $ids = $_POST['ids'] ?? 0;
        $status = $_POST['status'] ?? 'Collected';
        $collected_at = ($status == 'Collected') ? date('Y-m-d H:i:s') : null;
        
        if (!$this->canModify($ids)) {
            echo json_encode(['status' => false, 'message' => 'You only have permission to update status for your own entries on the same day. Otherwise, only Administrators can.']);
            return;
        }

        $sql = "UPDATE tbl_customer_ledger SET cheque_status = ?, collected_at = ? WHERE ids = ?";
        echo $this->varPDOModelObj->UpdateTable($sql, [$status, $collected_at, $ids]);
    }

    private function handleDeleteTransaction()
    {
        $ids = $_POST['ids'] ?? 0;
        if (!$this->canModify($ids)) {
            echo json_encode(['status' => false, 'message' => 'You only have permission to delete your own entries on the same day. Otherwise, only Administrators can.']);
            return;
        }
        $sql = "DELETE FROM tbl_customer_ledger WHERE ids = ?";
        echo $this->varPDOModelObj->DeleteFromTable($sql, [$ids]);
    }

    private function canModify($ids)
    {
        $user_role = $_SESSION['user_role_name'] ?? 'User';
        $user_id = $_SESSION['user_id'] ?? 0;

        if ($user_role === 'Administrator') return true;

        $sql = "SELECT created_at, user_id FROM tbl_customer_ledger WHERE ids = ?";
        $res = json_decode($this->varPDOModelObj->ListFromTable($sql, [$ids]), true);

        if ($res['status'] && !empty($res['data'])) {
            $row = $res['data'][0];
            $isToday = date('Y-m-d', strtotime($row['created_at'])) === date('Y-m-d');
            if ($isToday && $row['user_id'] == $user_id) {
                return true;
            }
        }
        return false;
    }

    private function handleGetLedger()
    {
        $customer_code = $_GET['customer_code'] ?? '';
        $sql = "SELECT * FROM tbl_customer_ledger WHERE customer_code = ? ORDER BY trans_date ASC, ids ASC";
        $res = json_decode($this->varPDOModelObj->ListFromTable($sql, [$customer_code]), true);
        
        if ($res['status']) {
            $balance = 0;
            foreach ($res['data'] as &$row) {
                $balance += ($row['debit'] - $row['credit']);
                $row['running_balance'] = $balance;
            }
            echo json_encode($res);
        } else {
            echo json_encode($res);
        }
    }
}

$obj = new CustomerLedgerController();
$obj->DataRequest($obj->actionevents);
?>
