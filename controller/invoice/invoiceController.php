<?php
session_start();
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class InvocieController
{
    var $varPDOModelObj;
    public $json, $actionevents;
    public $params = array();

    public $userId, $name, $role_id, $role_name, $username, $password, $id;
    public $email, $phoneNumber, $companies, $image, $createdDate, $ReturnData, $userStatus, $t_c_name, $terms_condition;
    public $invoice_id, $original_draft, $action_type, $save_type, $draft_flag,$customer_code, $customer_name, $customer_phone, $customer_email, $customer_address, $invoice_date, $invoice_due_date;
    public $items, $subtotal, $vat_total, $grand_total, $total_discount, $total_discount_amount, $after_discount_amount, $storage_company_id, $storage_company_name, $storage_username, $storage_userid;
    public $allItemSubtotal, $reference_number,$attentionValue, $doc_type, $draft, $invoice_number, $startDate, $endDate, $lpo_no, $qtn_ref_no, $transaction_no,$company_code,$customer_cpr_cr;
    public $company_id, $user_id, $company_name;
    function __construct()
    {
        $this->varPDOModelObj = new CommonPDOModel();

        
        // User fields
    
        $this->id = $_POST['id'] ?? null;
        
        $this->company_id = $_POST['company_id'] ?? $_SESSION['company_id'] ?? 1;
        $this->user_id = $_SESSION['user_id'] ?? 1;
        $this->actionevents = $_POST['action'] ?? null;
        date_default_timezone_set('Asia/Bahrain');
        $this->createdDate = date('Y-m-d H:i:s');
        
        $this->invoice_id = $_POST['invoice_id'] ?? null;
        $this->invoice_number = $_POST['invoice_number'] ?? null;
        
        $this->original_draft = $_POST['original_draft'] ?? null;
        $this->action_type = $_POST['action_type'] ?? null;
        $this->save_type = $_POST['save_type'] ?? null;
        if($this->save_type == "draft"){
            $this->doc_type = "QD";
            $this->draft_flag = "Yes";
        } else {
           $this->doc_type = "QT";
            $this->draft_flag = "No";
        }
        $this->customer_code = $_POST['customer_code'] ?? null;
        $this->customer_name = $_POST['customer_name'] ?? null;
        $this->customer_phone = $_POST['customer_phone'] ?? null;
        $this->customer_email = $_POST['customer_email'] ?? null;
         $this->customer_cpr_cr = $_POST['customer_cpr_cr'] ?? null;
        
        $this->customer_address = $_POST['customer_address'] ?? null;
        $this->invoice_date = $_POST['invoice_date'] ?? null;
        $this->invoice_due_date = $_POST['invoice_due_date'] ?? null;
        
        $this->items = $_POST['items'] ?? [];
        $this->subtotal = $_POST['subtotal'] ?? 0;
        $this->vat_total = $_POST['vat_total'] ?? 0;
        $this->grand_total = $_POST['grand_total'] ?? 0; 
        
        $this->total_discount = $_POST['total_discount'] ?? null;
        $this->total_discount_amount = $_POST['total_discount_amount'] ?? null;
        $this->after_discount_amount = $_POST['after_discount_amount'] ?? null;
        $this->storage_company_id = $_POST['company_id'] ?? $_SESSION['company_id'] ?? 1;
        $this->storage_company_name = $_POST['company_name'] ?? $_SESSION['company_name'] ?? '';
        $this->storage_username = $_SESSION['user_name'] ?? '';
        $this->storage_userid = $_SESSION['user_id'] ?? 1;
        $this->company_code = $_POST['company_code'] ?? $_SESSION['company_code'] ?? 'AA';
        $this->allItemSubtotal = $_POST['allItemSubtotal'] ?? null;
        
        $this->reference_number  = $_POST['reference_number'] ?? null;
       // $this->itemNamesThroughPost = $_POST['items'];
        
      
        $this->attentionValue = $_POST['attentionValue'] ?? null;
        
        $this->lpo_no = $_POST['lpo_no'] ?? null;
        $this->qtn_ref_no = $_POST['qtn_ref_no'] ?? null;
        $this->transaction_no = $_POST['transaction_no'] ?? null;
        
        $this->draft = $_POST['draft'] ?? null;
        
        $this->startDate = !empty($_POST['startDate']) 
            ? date('Y-m-d', strtotime($_POST['startDate'])) 
            : date('Y-01-01');
        
        $this->endDate = !empty($_POST['endDate']) 
            ? date('Y-m-d', strtotime($_POST['endDate'])) 
            : date('Y-12-31');
        
        
        
       
    }

    function SQLArray()
    {
        $array = array();

       
        $array[8] = "SELECT * FROM invoices WHERE company_id = :company_ids and draft =:draft AND invoice_date BETWEEN :start_date AND :end_date order by id desc ";
        
        $this->params[8] = [
             ':company_ids' => $this->company_id,
             ':draft' => $this->draft,
             ':start_date'  => $this->startDate,
             ':end_date'    => $this->endDate
             
        ];
        
        $array[9] = "SELECT * FROM invoices WHERE id = :invoiceId ";
        
        $this->params[9] = [
             ':invoiceId' => $this->invoice_id
             
        ];
       
        return $array;
    }

    function DataRequest($action)
    {
        $var = $this->SQLArray();

        switch ($action) {

            
            case 'SaveInvocie':
                    try {
                        
                        $isUpdate = ($this->action_type === 'update' && !empty($this->invoice_id));
                
                        if ($isUpdate) {
                            
                              
                                
                            $sqlUpdate = "UPDATE invoices SET
                                        customer_code = :customer_code,
                                        customer_name = :customer_name,
                                        invoice_date = :invoice_date,
                                        invoice_due_date = :invoice_due_date,
                                        customer_phone = :customer_phone,
                                        customer_email = :customer_email,
                                        customer_cpr_cr = :customer_cpr_cr,
                                        customer_address = :customer_address,
                                        items = :items,
                                        subtotal = :subtotal,
                                        vat_total = :vat_total,
                                        grand_total = :grand_total,
                                        draft = :draft,
                                        reference_number = :reference_number,
                                        total_discount = :total_discount,
                                        total_discount_amount = :total_discount_amount,
                                        after_discount_amount = :after_discount_amount,
                                        user_id = :user_id,
                                        user_name = :user_name,
                                        company_id = :company_id,
                                        company_name = :company_name,
                                        allItemSubtotal = :allItemSubtotal,
                                        attention = :attention,
                                        lpo_number = :lpo_number, 
                                        trn_no = :trn_no,
                                        quotation_ref_no = :quotation_ref_no
                                    WHERE id = :invoice_id";
                            $updateParams = [
                                ':customer_code' => $this->customer_code,
                                ':customer_name' => $this->customer_name,
                                ':invoice_date' => $this->invoice_date,
                                ':invoice_due_date' => $this->invoice_due_date,
                                ':customer_phone' => $this->customer_phone,
                                ':customer_email' => $this->customer_email,
                                ':customer_cpr_cr' => $this->customer_cpr_cr,
                                ':customer_address' => $this->customer_address,
                                ':items' => json_encode($this->items),
                                ':subtotal' => $this->subtotal,
                                ':vat_total' => $this->vat_total,
                                ':grand_total' => $this->grand_total,
                                ':draft' => $this->draft_flag,
                                ':reference_number' => $this->reference_number,
                                ':total_discount' => $this->total_discount,
                                ':total_discount_amount' => $this->total_discount_amount,
                                ':after_discount_amount' => $this->after_discount_amount,
                                ':user_id' => $this->storage_userid,
                                ':user_name' => $this->storage_username,
                                ':company_id' => $this->storage_company_id,
                                ':company_name' => $this->storage_company_name,
                                ':allItemSubtotal' => $this->allItemSubtotal,
                                ':attention' => $this->attentionValue,
                                ':lpo_number' => $this->lpo_no,
                                ':trn_no' => $this->transaction_no,
                                ':quotation_ref_no' => $this->qtn_ref_no,
                                ':invoice_id' => $this->invoice_id
                             ];
                             
                             $result =$this->varPDOModelObj->UpdateTable($sqlUpdate,$updateParams);
                             
                              echo json_encode([
                                "status"  => 'Success',
                                "msg_text"  => 'Updated successfully',
                                "message" =>  $this->invoice_number
                            ]);
                            
                           // echo "Quotation updated successfully.";
                        } else {
                            
                            $this->varPDOModelObj->Begin();
                           
                         
                            $invoiceNo=$this->generateInvoiceNo($this->varPDOModelObj,$this->invoice_date,$this->company_code);
                            $sqlInsert = "INSERT INTO invoices
                                    (invoice_no, invoice_date,invoice_due_date, customer_code,
                                     customer_name, customer_phone, customer_email,customer_cpr_cr, customer_address,
                                     items, subtotal, vat_total, grand_total, draft, reference_number,
                                     total_discount, total_discount_amount, after_discount_amount,
                                     user_id, user_name, company_id, company_name,
                                     allItemSubtotal, attention, lpo_number, trn_no, quotation_ref_no)
                                    VALUES
                                    (:invoice_no, :invoice_date, :invoice_due_date, :customer_code,
                                     :customer_name, :customer_phone, :customer_email, :customer_cpr_cr, :customer_address,
                                     :items, :subtotal, :vat_total, :grand_total, :draft, :reference_number,
                                     :total_discount, :total_discount_amount, :after_discount_amount,
                                     :user_id, :user_name, :company_id, :company_name,
                                     :allItemSubtotal, :attention, :lpo_number, :trn_no, :quotation_ref_no)";
                            $insertParams = [
                                
                                ':invoice_no' => $invoiceNo,
                                ':invoice_date' => $this->invoice_date,
                                ':invoice_due_date' => $this->invoice_due_date,
                                ':customer_code' => $this->customer_code,
                                ':customer_name' => $this->customer_name,
                                ':customer_phone' => $this->customer_phone,
                                ':customer_email' => $this->customer_email,
                                 ':customer_cpr_cr' => $this->customer_cpr_cr,
                                ':customer_address' => $this->customer_address,
                                ':items' => json_encode($this->items),
                                ':subtotal' => $this->subtotal,
                                ':vat_total' => $this->vat_total,
                                ':grand_total' => $this->grand_total,
                                ':draft' => $this->draft_flag,
                                ':reference_number' => $this->reference_number,
                                ':total_discount' => $this->total_discount,
                                ':total_discount_amount' => $this->total_discount_amount,
                                ':after_discount_amount' => $this->after_discount_amount,
                                ':user_id' => $this->storage_userid,
                                ':user_name' => $this->storage_username,
                                ':company_id' => $this->storage_company_id,
                                ':company_name' => $this->storage_company_name,
                                ':allItemSubtotal' => $this->allItemSubtotal,
                                ':attention' => $this->attentionValue,
                                ':lpo_number' => $this->lpo_no,
                                ':trn_no' => $this->transaction_no,
                                ':quotation_ref_no' => $this->qtn_ref_no
                                ];
                                
                            $this->ReturnData =  $this->varPDOModelObj->AddToTable($sqlInsert,$insertParams);
                            
                            $this->varPDOModelObj->Commit();
                            echo json_encode([
                                "status"  => 'Success',
                                "msg_text"  => 'Created successfully',
                                "message" => $invoiceNo
                            ]);
                            //echo "New quotation created: " . $quotation_no;
                        }
                    } catch (Exception $e) {
                        if (!$isUpdate) {
                             $this->varPDOModelObj->RollBack();

                        }
                        die("Error: " . $e->getMessage());
                    }
                break;
           case 'GetInvoices':

           $sql = "SELECT i.*, c.company_name AS c_company_name FROM invoices i LEFT JOIN tbl_company c ON i.company_id = c.ids WHERE i.draft = :draft AND i.invoice_date BETWEEN :start_date AND :end_date";
           $params = [
             ':draft' => $this->draft,
             ':start_date'  => $this->startDate,
             ':end_date'    => $this->endDate
           ];

           if ($this->company_id !== 'all' && !empty($this->company_id)) {
               $sql .= " AND i.company_id = :company_ids";
               $params[':company_ids'] = $this->company_id;
           } else {
               $userCompanyJson = isset($_SESSION['company_json']) ? json_decode($_SESSION['company_json'], true) : [];
               $userCompanyIds = [];
               if (is_array($userCompanyJson)) {
                   foreach ($userCompanyJson as $c) {
                       if (isset($c['ids'])) {
                           $userCompanyIds[] = (int)$c['ids'];
                       }
                   }
               }
               if (!empty($userCompanyIds)) {
                   $placeholders = implode(',', $userCompanyIds);
                   $sql .= " AND i.company_id IN ($placeholders)";
               }
           }
           
            if (!empty($this->customer_code) && $this->customer_code != 'All') {
                    $sql .= " AND i.customer_code = :customer_code";
                    $params[':customer_code'] = trim($this->customer_code);
                }
            
            $sql .= " ORDER BY i.id DESC";
 
            $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql, $params);
           
        
            $result = json_decode($this->ReturnData, true);
        
            $decimals = 3; // adjust if needed
            $data = [];
        
            if (!empty($result['data'])) {
                foreach ($result['data'] as $row) {
        
                    $date = date("d-m-Y", strtotime($row['invoice_date']));
                    $subtotal = number_format((float)$row['subtotal'], $decimals);
                    $vat      = number_format((float)$row['vat_total'], $decimals);
                    $grand    = number_format((float)$row['grand_total'], $decimals);
        
                    $id = (int)$row['id'];
                    $raw_invoice_no = htmlspecialchars($row['invoice_no']);
                    $comp_name = !empty($row['c_company_name']) ? htmlspecialchars($row['c_company_name']) : '';
                    $invoice_no = $raw_invoice_no . "<br><span class='badge' style='background-color:#ED1C24; font-size:10px;'>" . $comp_name . "</span>";
                    $customer_name = htmlspecialchars($row['customer_name']);
                    $customer_phone = htmlspecialchars($row['customer_phone']);
                    $customer_cpr_cr = htmlspecialchars($row['customer_cpr_cr']);
                    $customer_val=$customer_name.' | '.$customer_phone.' | '.$customer_cpr_cr;
                    $data[] = [
                        $invoice_no,
                        $date,
                        $customer_val,
                        "<div style='text-align:right'>{$subtotal}</div>",
                        "<div style='text-align:right'>{$vat}</div>",
                        "<div style='text-align:right'>{$grand}</div>",
                        "<button class='btn btn-sm btn-primary viewInvoice' data-id='{$id}'>
                            <span class='ri ri-list-view icon-18px'></span>
                        </button>",
                        "<div class='d-flex gap-1 '>
                            
                            <button class='btn btn-sm btn-warning invoiceprint' data-bs-toggle='tooltip' title='Print Format 2' data-id={$id} data-ref=\"{$raw_invoice_no}\" >
                                <span class='ri ri-printer-line icon-18px'></span>
                            </button>
                        </div>"
                       
                    ];
                }
            }
        
            echo json_encode([
                "data" => $data
            ]);
        
            break;
            case 'GetInvoicesDetails':

                $this->ReturnData = $this->varPDOModelObj->ListFromTable(
                    $var[9],
                    $this->params[9]
                );
            
                $result = json_decode($this->ReturnData, true);
            
                echo json_encode([
                    "data" => $result['data'] ?? []
                ]);
            
            break;
            default:
                $noAction = json_encode([
                    'status' => false,
                    'message' => "No Action Found"
                ]);

                echo $noAction;

                Logger::ActivityLog(
                    'InvoiceController',
                    "default",
                    [json_decode($noAction)]
                );

           break;
        }
    }
    
   function generateInvoiceNo($pdo, $invoice_date, $company_code)
{
    $year = date('Y', strtotime($invoice_date));

    $prefix = $company_code . '/' . $year . '/PO/';

    $sql = "SELECT MAX(CAST(RIGHT(invoice_no, 4) AS UNSIGNED)) AS last_no
            FROM invoices
            WHERE invoice_no LIKE :prefix";

    $stmt = $pdo->selectexecuteQuery(
        $sql,
        [':prefix' => $prefix . '%']
    );

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $nextNo = ((int)($row['last_no'] ?? 0)) + 1;

    return $prefix . str_pad($nextNo, 4, '0', STR_PAD_LEFT);
}
}

$obj = new InvocieController();
$obj->DataRequest($obj->actionevents);
