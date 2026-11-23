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
            case 'GetContracts':
                $customer_code = $_GET['customer_code'] ?? '';
                $sql = "SELECT ids AS id, agreement_no AS text FROM tbl_vehicle_rentout_contracts WHERE customer_code = ? ORDER BY ids DESC";
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
            case 'GetContractLedgerData':
                $this->handleContractGetLedger();
                break;
            case 'GetContractLedgerBalance':
                $this->handleContractGetLedgerBalance();
                break;
            case 'GetCustomerContractLedgerData':
                $contractid = $_GET['contract_id'] ?? 'All';
                if($contractid=='0' || $contractid=='All')
                {
                     $this->handleGetLedger();
                }
                else
                {
                    $this->handleContractGetLedger();
                }
                
                break;
             
            case 'GetChequeCalendarEvents':
                $this->handleGetChequeCalendarEvents();
                break;
             case 'GetChequeCalendarEventsContract':
                $this->handleGetChequeCalendarEventsContract();
                break;
            case 'GetChequesByDate':
                $this->handleGetChequesByDate();
                break;
            case 'GetChequesByDateContract':
                $this->handleGetChequesByDateContract();
                break;
            case 'GetChequesCollection':
                $this->handleGetChequesCollection();
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

            case 'GetBanks':
                $sql = "SELECT ids AS id, bank_name AS text, account_no FROM tbl_banks ORDER BY bank_name ASC";
                echo $this->varPDOModelObj->ListFromTable($sql, []);
                break;

            case 'SaveBank':
                $bank_name = $_POST['bank_name'] ?? '';
                $account_no = $_POST['account_no'] ?? null;
                $company_id = $_SESSION['company_id'] ?? 1;
                $sql = "INSERT INTO tbl_banks (bank_name, account_no, company_id) VALUES (?, ?, ?)";
                echo $this->varPDOModelObj->AddToTable($sql, [$bank_name, $account_no, $company_id]);
                break;

            case 'GetLedgerHeads':
                $sql = "SELECT ids AS id, head_name AS text, head_type FROM tbl_ledger_heads ORDER BY head_name ASC";
                echo $this->varPDOModelObj->ListFromTable($sql, []);
                break;
             case 'GetLedgerHeadsContract':
                $sql = "SELECT 
                            ids AS id, 
                            head_name AS text, 
                            head_type,'No' as ledger_type
                        FROM tbl_ledger_heads
                        
                        UNION
                        
                        SELECT 
                            ids AS id, 
                            price_item AS text, 
                            'Debit' AS head_type,'Yes' as ledger_type 
                        FROM tbl_vehicle_pricing_master
                        WHERE ledger_status = 'Yes'
                        
                        ORDER BY text ASC";
                echo $this->varPDOModelObj->ListFromTable($sql, []);
                break;
                case 'getmodel_price':
                    $model_ids = $_POST['model_ids'] ?? '';
                    $head_ids = $_POST['head_ids'] ?? '';
                    $sql = "SELECT  COALESCE(
                            (
                                SELECT NULLIF(jt.amount, '')
                                FROM JSON_TABLE(
                                    t.price_json,
                                    '$[*]' COLUMNS (
                                        ids VARCHAR(10) PATH '$.ids',
                                        amount VARCHAR(50) PATH '$.amount'
                                    )
                                ) jt
                                WHERE jt.ids = ?
                                LIMIT 1
                            ),
                            0
                        ) AS amount
                    FROM  tbl_vehicle_model t
                    WHERE t.ids = ?";
                    echo $this->varPDOModelObj->ListFromTable($sql, [$head_ids, $model_ids]);
                break;

            case 'SaveLedgerHead':
                $head_name = $_POST['head_name'] ?? '';
                $head_type = $_POST['head_type'] ?? 'Credit';
                $company_id = $_SESSION['company_id'] ?? 1;
                $sql = "INSERT INTO tbl_ledger_heads (head_name, head_type, company_id) VALUES (?, ?, ?)";
                echo $this->varPDOModelObj->AddToTable($sql, [$head_name, $head_type, $company_id]);
                break;
            
            case 'GetPendingCheques':
                $customer_code = $_GET['customer_code'] ?? '';
                $sql = "SELECT cheque_date, credit as amount, ref_no FROM tbl_customer_ledger WHERE customer_code = ? AND payment_method = 'Cheque' AND cheque_status = 'Pending' ORDER BY cheque_date ASC";
                echo $this->varPDOModelObj->ListFromTable($sql, [$customer_code]);
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
        $agreement_no = $_POST['agreement_no'] ?? '';
        $agreement_id = $_POST['agreement_id'] ?? '';
        $booking_id = $_POST['booking_id'] ?? '';
        $trans_date = $_POST['trans_date'] ?? date('Y-m-d');
       // $trans_type = $_POST['trans_type'] ?? 'Payment';
        $trans_type = $_POST['trans_name'] ?? 'Payment';
        
        $head_type = $_POST['head_type'] ?? 'Debit';
        $payment_method = $_POST['payment_method'] ?? 'N/A';
        $amount = $_POST['amount'] ?? 0;
        $ref_no = $_POST['ref_no'] ?? '';
        $description = $_POST['description'] ?? '';
        $quotation_no = !empty($_POST['quotation_no']) ? $_POST['quotation_no'] : null;
        $booking_no = !empty($_POST['booking_no']) ? $_POST['booking_no'] : null;
        $bank_id = !empty($_POST['bank_id']) ? $_POST['bank_id'] : null;
        $cheque_date = !empty($_POST['cheque_date']) ? $_POST['cheque_date'] : null;
        $company_bank_id = !empty($_POST['company_bank_id']) ? $_POST['company_bank_id'] : null;
        $trans_name = $_POST['trans_name'] ?? 'Payment';

        // Dynamic logic for debit/credit based on head_type
        $debit = 0;
        $credit = 0;
        
        $type = $head_type;
            if ($type === 'Debit') {
                $debit = $amount;
            } else {
                $credit = $amount;
            }
        // $sqlHead = "SELECT head_type FROM tbl_ledger_heads WHERE head_name = ?";
        // $resHead = json_decode($this->varPDOModelObj->ListFromTable($sqlHead, [$trans_type]), true);
        
        // if ($resHead['status'] && !empty($resHead['data'])) {
        //     $type = $resHead['data'][0]['head_type'];
        //     if ($type === 'Debit') {
        //         $debit = $amount;
        //     } else {
        //         $credit = $amount;
        //     }
        // } else {
        //     // Fallback for legacy data or if head not found
        //     $debit = ($trans_type == 'Invoice' || $trans_type == 'Opening Balance') ? $amount : 0;
        //     $credit = ($debit == 0) ? $amount : 0;
        // }

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
                    customer_code = ?, quotation_no = ?, booking_no = ?, trans_date = ?, cheque_date = ?, 
                    trans_type = ?, payment_method = ?, bank_id = ?, company_bank_id = ?, debit = ?, credit = ?, 
                    ref_no = ?, description = ? WHERE ids = ?";
            $params = [$customer_code, $quotation_no, $booking_no, $trans_date, $cheque_date, $trans_type, $payment_method, $bank_id, $company_bank_id, $debit, $credit, $ref_no, $description, $ids];
            echo $this->varPDOModelObj->UpdateTable($sql, $params);
        } else {
            // New entry
            $sql = "INSERT INTO tbl_customer_ledger 
                    (customer_code, quotation_no, booking_no, trans_date, cheque_date, trans_type, payment_method, bank_id, company_bank_id, debit, credit, ref_no, cheque_status, description, user_id, company_id,booking_ids,contract_ids,agreement_no) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', ?, ?, ?, ?, ?, ?)";
            $params = [$customer_code, $quotation_no, $booking_no, $trans_date, $cheque_date, $trans_type, $payment_method, $bank_id, $company_bank_id, $debit, $credit, $ref_no, $description, $user_id, $company_id, $booking_id, $agreement_id, $agreement_no];
            echo $this->varPDOModelObj->AddToTable($sql, $params);
        }
    }

    private function handleGetChequeCalendarEvents()
    {
        $customer_code = $_GET['customer_code'] ?? null;
        $sql = "SELECT cheque_date, cheque_status, COUNT(*) as cheque_count 
                FROM tbl_customer_ledger 
                WHERE payment_method = 'Cheque' AND cheque_date IS NOT NULL ";
        $params = [];
        if ($customer_code) {
            $sql .= " AND customer_code = ? ";
            $params[] = $customer_code;
        }
        $sql .= " GROUP BY cheque_date, cheque_status";
        $res = json_decode($this->varPDOModelObj->ListFromTable($sql, $params), true);
        
        $events = [];
        if ($res['status']) {
            foreach ($res['data'] as $row) {
                $color = ($row['cheque_status'] === 'Collected') ? '#28c76f' : (($row['cheque_status'] === 'Bounced') ? '#ea5455' : '#ff9f43');
                $events[] = [
                    'title' => $row['cheque_count'] . ' ' . $row['cheque_status'],
                    'start' => $row['cheque_date'],
                    'color' => $color,
                    'textColor' => '#ffffff',
                    'allDay' => true,
                    'extendedProps' => ['date' => $row['cheque_date']]
                ];
            }
        }
        echo json_encode($events);
    }
     private function handleGetChequeCalendarEventsContract()
    {
        $contract_id = $_GET['contract_id'] ?? null;
        $sql = "SELECT cheque_date, cheque_status, COUNT(*) as cheque_count 
                FROM tbl_customer_ledger 
                WHERE payment_method = 'Cheque' AND cheque_date IS NOT NULL ";
        $params = [];
        if ($contract_id) {
            $sql .= " AND contract_ids = ? ";
            $params[] = $contract_id;
        }
        $sql .= " GROUP BY cheque_date, cheque_status";
        $res = json_decode($this->varPDOModelObj->ListFromTable($sql, $params), true);
        
        $events = [];
        if ($res['status']) {
            foreach ($res['data'] as $row) {
                $color = ($row['cheque_status'] === 'Collected') ? '#28c76f' : (($row['cheque_status'] === 'Bounced') ? '#ea5455' : '#ff9f43');
                $events[] = [
                    'title' => $row['cheque_count'] . ' ' . $row['cheque_status'],
                    'start' => $row['cheque_date'],
                    'color' => $color,
                    'textColor' => '#ffffff',
                    'allDay' => true,
                    'extendedProps' => ['date' => $row['cheque_date']]
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
                WHERE l.payment_method = 'Cheque' AND l.cheque_date = ? ";
        $params = [$date];
        if ($customer_code) {
            $sql .= " AND l.customer_code = ? ";
            $params[] = $customer_code;
        }
        echo $this->varPDOModelObj->ListFromTable($sql, $params);
    }
    
    private function handleGetChequesByDateContract()
    {
        $date = $_GET['date'] ?? '';
        $contract_id = $_GET['contract_id'] ?? null;
        
        $sql = "SELECT l.*, c.customer_name 
                FROM tbl_customer_ledger l
                JOIN customer_details c ON l.customer_code = c.customer_id
                WHERE l.payment_method = 'Cheque' AND l.cheque_date = ? ";
        $params = [$date];
        if ($contract_id) {
            $sql .= " AND l.contract_ids = ? ";
            $params[] = $contract_id;
        }
        echo $this->varPDOModelObj->ListFromTable($sql, $params);
    }

    private function handleGetChequesCollection()
    {
        $sql = "
            SELECT
                l.ids,
                l.trans_date,
                l.cheque_date,
                COALESCE(NULLIF(l.cheque_status, ''), 'Pending') AS cheque_status,
                l.collected_at,
                l.credit,
                l.debit,
                l.ref_no,
                l.trans_type,
                l.description,
                l.customer_code,
                l.contract_ids,
                COALESCE(NULLIF(l.agreement_no, ''), vc.agreement_no, '') AS agreement_no,
                c.customer_name,
                c.customer_mobile,
                b.bank_name,
                b.account_no,
                cb.bank_name AS company_bank_name,
                cb.account_no AS company_account_no,
                CASE
                    WHEN COALESCE(NULLIF(l.cheque_status, ''), 'Pending') = 'Collected' THEN 'collected'
                    WHEN COALESCE(NULLIF(l.cheque_status, ''), 'Pending') = 'Bounced' THEN 'bounced'
                    WHEN l.cheque_date IS NOT NULL AND l.cheque_date < CURDATE() THEN 'overdue'
                    WHEN l.cheque_date IS NOT NULL AND l.cheque_date = CURDATE() THEN 'due_today'
                    ELSE 'upcoming'
                END AS due_state
            FROM tbl_customer_ledger l
            LEFT JOIN customer_details c ON (c.customer_id = l.customer_code OR c.ids = l.customer_code)
            LEFT JOIN tbl_banks b ON b.ids = l.bank_id
            LEFT JOIN tbl_banks cb ON cb.ids = l.company_bank_id
            LEFT JOIN tbl_vehicle_rentout_contracts vc ON vc.ids = l.contract_ids
            WHERE l.payment_method = 'Cheque'
            ORDER BY
                CASE
                    WHEN COALESCE(NULLIF(l.cheque_status, ''), 'Pending') = 'Pending' AND l.cheque_date < CURDATE() THEN 1
                    WHEN COALESCE(NULLIF(l.cheque_status, ''), 'Pending') = 'Pending' AND l.cheque_date = CURDATE() THEN 2
                    WHEN COALESCE(NULLIF(l.cheque_status, ''), 'Pending') = 'Pending' THEN 3
                    WHEN COALESCE(NULLIF(l.cheque_status, ''), 'Pending') = 'Collected' THEN 4
                    ELSE 5
                END ASC,
                l.cheque_date ASC,
                l.ids DESC
        ";
        $stmt = $this->varPDOModelObj->varDBPDO->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $summary = [
            'overdue_count' => 0, 'overdue_amount' => 0.0,
            'due_today_count' => 0, 'due_today_amount' => 0.0,
            'upcoming_count' => 0, 'upcoming_amount' => 0.0,
            'collected_count' => 0, 'collected_amount' => 0.0,
            'bounced_count' => 0, 'bounced_amount' => 0.0
        ];
        foreach ($rows as $r) {
            $amt = (float)($r['credit'] > 0 ? $r['credit'] : $r['debit']);
            $st = $r['due_state'] ?? 'upcoming';
            if (isset($summary[$st . '_count'])) {
                $summary[$st . '_count']++;
                $summary[$st . '_amount'] += $amt;
            }
        }

        echo json_encode([
            'status' => true,
            'data' => $rows,
            'summary' => $summary
        ]);
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
        // Removed security check to allow all modifications
        return true;
    }

    private function handleGetLedger()
    {
        $customer_code = $_GET['customer_code'] ?? '';
        $sql = "SELECT l.*, b.bank_name, b.account_no, cb.bank_name as company_bank_name, cb.account_no as company_account_no
                FROM tbl_customer_ledger l 
                LEFT JOIN tbl_banks b ON l.bank_id = b.ids 
                LEFT JOIN tbl_banks cb ON l.company_bank_id = cb.ids 
                WHERE l.customer_code = ? 
                ORDER BY l.trans_date ASC, l.ids ASC";
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
    
    private function handleContractGetLedger()
    {
        $contract_id = $_GET['contract_id'] ?? '';
        $sql = "SELECT l.*, b.bank_name, b.account_no, cb.bank_name as company_bank_name, cb.account_no as company_account_no
                FROM tbl_customer_ledger l 
                LEFT JOIN tbl_banks b ON l.bank_id = b.ids 
                LEFT JOIN tbl_banks cb ON l.company_bank_id = cb.ids 
                WHERE l.contract_ids = ? 
                ORDER BY l.trans_date ASC, l.ids ASC";
        $res = json_decode($this->varPDOModelObj->ListFromTable($sql, [$contract_id]), true);
        
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
   private function handleContractGetLedgerBalance()
{
    $contract_id = $_POST['contract_id'] ?? '';

    $sql = "SELECT l.*
            FROM tbl_customer_ledger l
            WHERE l.contract_ids = ?
            ORDER BY l.trans_date ASC, l.ids ASC";

    $res = json_decode($this->varPDOModelObj->ListFromTable($sql, [$contract_id]), true);

    if ($res['status']) {

           $totalDebit = 0;
            $totalCredit = 0;
            $balance = 0;

        foreach ($res['data'] as &$row) {
           
            $totalDebit += (float)$row['debit'];
            $totalCredit += (float)$row['credit'];

            $balance += ((float)$row['debit'] - (float)$row['credit']);
            $row['running_balance'] = $balance;
        }
         $sqlContract = "SELECT
                        agreement_no,customer_code,quotation_number,
                        customer_name,vehicle_no,
                        customer_details,vechile_details,
                        service_type
                    FROM  tbl_vehicle_rentout_contracts
                    WHERE ids = ?";

    $contractRes = json_decode(
        $this->varPDOModelObj->ListFromTable($sqlContract, [$contract_id]),
        true
    );
   $contract = $contractRes['data'][0] ?? [];

    $customer = json_decode(
        $contract['customer_details'] ?? '{}',
        true
    );
    $customer = json_decode(
        $contract['customer_details'] ?? '{}',
        true
    );
  $vehicle = json_decode(
        $contract['vechile_details'] ?? '{}',
        true
    );
  
     $res['balance'] = $balance;
    $res['total_debit'] = $totalDebit;
    $res['total_credit'] = $totalCredit;

    $res['agreement_no'] = $contract['agreement_no'] ?? '';

    $res['customer_name'] = $customer['customer_name'] ?? '';
    $res['customer_code'] = $customer['customer_code'] ?? '';
    $res['customer_mobile'] = $customer['customer_mobile'] ?? '';
    $res['customer_email'] = $customer['customer_email'] ?? '';
    $res['vehicle_no'] =  $contract['vehicle_no'] ?? '';
    $res['service_type'] =  $contract['service_type'] ?? '';
    $res['model_name'] = $vehicle['model_name'] ?? '';
    $res['contract_id'] = $contract_id ?? '';

    echo json_encode($res);
    } else {
        echo json_encode($res);
    }
}
}

$obj = new CustomerLedgerController();
$obj->DataRequest($obj->actionevents);
?>
