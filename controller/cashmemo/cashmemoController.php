<?php
session_start();
header('Content-Type: application/json');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
class cashmemoController
{
    var $varPDOModelObj;
    public $json, $actionevents;
    public $params = array();

    public $userId, $name, $role_id, $role_name, $username, $password;
    public $email, $phoneNumber, $companies, $image, $createdDate, $ReturnData, $userStatus, $t_c_name, $terms_condition;
    public $cashmemo_id, $original_draft, $action_type, $save_type, $draft_flag,$customer_code, $customer_name, $customer_phone, $customer_email, $customer_address, $cashmemo_date;
    public $items, $subtotal, $vat_total, $grand_total, $total_discount, $total_discount_amount, $after_discount_amount, $storage_company_id, $storage_company_name, $storage_username, $storage_userid;
    public $allItemSubtotal, $reference_number,$attentionValue, $doc_type, $draft, $cashmemo_number, $startDate, $endDate, $lpo_no, $qtn_ref_no, $transaction_no,$company_code,$cashmemo_notes, $contract_id, $agreement_no, $vehicle_id, $booking_ids, $vehicle_model_id,$model_name,  $vehicleno, $vehiclecolor,$hirer_name,$delivery_name,$hirer_signature,$delivery_signature,$customer_cpr_cr,$cashmemo_payment_type,$cashmemo_cheque_date,$cashmemo_cheque_ref_no;
    function __construct()
    {
        $this->varPDOModelObj = new CommonPDOModel();

        
        // User fields
    
        $this->id = $_POST['id'] ?? null;
        
        $this->company_id = $_SESSION['company_id'] ?? 1;
        $this->user_id = $_SESSION['user_id'] ?? 1;
        $this->actionevents = $_POST['action'] ?? null;
        date_default_timezone_set('Asia/Bahrain');
        $this->createdDate = date('Y-m-d H:i:s');
        
        $this->cashmemo_id = $_POST['cashmemo_id'] ?? null;
        $this->cashmemo_number = $_POST['cashmemo_number'] ?? null;
        
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
        $this->cashmemo_date = !empty($_POST['cashmemo_date']) ? $_POST['cashmemo_date'] : null;
       
        $this->items = $_POST['items'] ?? [];
        $this->subtotal = isset($_POST['subtotal']) && $_POST['subtotal'] !== '' ? floatval($_POST['subtotal']) : 0;
        $this->vat_total = isset($_POST['vat_total']) && $_POST['vat_total'] !== '' ? floatval($_POST['vat_total']) : 0;
        $this->grand_total = isset($_POST['grand_total']) && $_POST['grand_total'] !== '' ? floatval($_POST['grand_total']) : 0; 
        
        $this->total_discount = isset($_POST['total_discount']) && $_POST['total_discount'] !== '' ? floatval($_POST['total_discount']) : 0;
        $this->total_discount_amount = isset($_POST['total_discount_amount']) && $_POST['total_discount_amount'] !== '' ? floatval($_POST['total_discount_amount']) : 0;
        $this->after_discount_amount = isset($_POST['after_discount_amount']) && $_POST['after_discount_amount'] !== '' ? floatval($_POST['after_discount_amount']) : 0;
        $this->storage_company_id = $_SESSION['company_id'] ?? 1;
        $this->storage_company_name = $_SESSION['company_name'] ?? 1;
        $this->storage_username = $_SESSION['user_name'] ?? '';
        $this->storage_userid = $_SESSION['user_id'] ?? 1;
        $this->company_code = $_SESSION['company_code'] ?? 'AA';
        $this->allItemSubtotal = $_POST['allItemSubtotal'] ?? null;
        
        if (isset($_POST['company_id']) && !empty($_POST['company_id'])) {
            $this->company_id = $_POST['company_id'];
            $this->storage_company_id = $this->company_id;
            try {
                $stmtCompany = $this->varPDOModelObj->varDBPDO->prepare("SELECT company_code, company_name FROM tbl_company WHERE ids = ?");
                $stmtCompany->execute([$this->company_id]);
                if ($comp = $stmtCompany->fetch(\PDO::FETCH_ASSOC)) {
                    $this->company_code = $comp['company_code'];
                    $this->storage_company_name = $comp['company_name'];
                }
            } catch (\Exception $e) { }
        }
        
        $this->reference_number  = $_POST['reference_number'] ?? null;
      
        $this->contract_id  = $_POST['contract_id'] ?? null;
        $this->agreement_no  = $_POST['agreement_no'] ?? null;
        $this->vehicle_id  = $_POST['vehicle_id'] ?? null;
        $this->booking_ids  = $_POST['booking_ids'] ?? null;
        $this->vehicle_model_id  = $_POST['vehicle_model_id'] ?? null;
        $this->model_name  = $_POST['model_name'] ?? null;
        $this->vehicleno  = $_POST['vehicleno'] ?? null;
        $this->vehiclecolor  = $_POST['vehiclecolor'] ?? null;
        $this->cashmemo_notes  = $_POST['cashmemo_notes'] ?? null;
        $this->cashmemo_payment_type  = $_POST['cashmemo_payment_type'] ?? null;
        $this->cashmemo_cheque_date = !empty($_POST['cashmemo_cheque_date'])
    ? $_POST['cashmemo_cheque_date']
    : null;
       // $this->cashmemo_cheque_date  = $_POST['cashmemo_cheque_date'] ?? null;
        $this->cashmemo_cheque_ref_no  = $_POST['cashmemo_cheque_ref_no'] ?? null;
        
       // $this->itemNamesThroughPost = $_POST['items'];
        $this->hirer_name         = $_POST['hirer_name'] ?? '';
        $this->delivery_name      = $_POST['delivery_name'] ?? '';
        $this->hirer_signature    = $_POST['hirer_signature'] ?? '';
        $this->delivery_signature = $_POST['delivery_signature'] ?? '';
      
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

       
        $array[8] = "SELECT * FROM  cashmemo WHERE company_id = :company_ids and draft =:draft AND  cashmemo_date BETWEEN :start_date AND :end_date order by id desc ";
        
        $this->params[8] = [
             ':company_ids' => $this->company_id,
             ':draft' => $this->draft,
             ':start_date'  => $this->startDate,
             ':end_date'    => $this->endDate
             
        ];
        
        $array[9] = "SELECT * FROM  cashmemo WHERE id = :cashmemoId ";
        
        $this->params[9] = [
             ':cashmemoId' => $this->cashmemo_id
             
        ];
       
        return $array;
    }

    function DataRequest($action)
    {
        $var = $this->SQLArray();

        switch ($action) {

            case 'GetSignDetails':
                    $result_sign = $this->varPDOModelObj->selectexecuteQuery(
                            "SELECT company_signature,company_sign_date_time, DATE_FORMAT(company_sign_date_time, '%d-%m-%Y %h:%i %p') AS company_sign_date_time_format,customer_signature,customer_sign_datetime,company_sign_name,customer_sign_name,DATE_FORMAT(customer_sign_datetime, '%d-%m-%Y %h:%i %p') AS customer_sign_datetime_format FROM   cashmemo WHERE id = :cashmemo_id",
                            [':cashmemo_id' => $this->cashmemo_id]
                        );
                
                $sign_details = $result_sign->fetchAll(PDO::FETCH_ASSOC);
                 $response = [
                        'data' => $sign_details ?: []
                    ];
                
                    echo json_encode($response);
            break;
            case 'SaveCashMemo':
                    try {
                        
                        $isUpdate = ($this->action_type === 'update' && !empty($this->cashmemo_id));
                
                        if ($isUpdate) {
                            
                                       
                                
                            $sqlUpdate = "UPDATE cashmemo SET
                                        customer_code = :customer_code,
                                        customer_name = :customer_name,
                                        cashmemo_date = :cashmemo_date,
                                        customer_phone = :customer_phone,
                                        customer_email = :customer_email,
                                        customer_cpr_cr = :customer_cpr_cr,
                                        customer_address = :customer_address,
                                        contract_ids = :contract_ids,
                                        booking_ids = :booking_ids,
                                        agreement_no = :agreement_no,
                                        vehicle_ids = :vehicle_ids,
                                        vehicle_no = :vehicle_no,
                                        model_ids = :model_ids,
                                        model_names = :model_names,
                                        vehicle_color = :vehicle_color,
                                        cashmemo_notes = :cashmemo_notes,
                                        cashmemo_payment_type = :cashmemo_payment_type,
                                        cashmemo_cheque_date = :cashmemo_cheque_date,
                                        cashmemo_cheque_ref_no = :cashmemo_cheque_ref_no,
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
                                        allItemSubtotal = :allItemSubtotal
                                    WHERE id = :cashmemo_id";
                            $updateParams = [
                                ':customer_code' => $this->customer_code,
                                ':customer_name' => $this->customer_name,
                                ':cashmemo_date' => $this->cashmemo_date,
                                ':customer_phone' => $this->customer_phone,
                                ':customer_email' => $this->customer_email,
                                ':customer_cpr_cr' => $this->customer_cpr_cr,
                                ':customer_address' => $this->customer_address,
                                ':contract_ids' => $this->contract_id,
                                ':booking_ids' => $this->booking_ids,
                                ':agreement_no' => $this->agreement_no,
                                ':vehicle_ids' => $this->vehicle_id,
                                ':vehicle_no' => $this->vehicleno,
                                ':model_ids' => $this->vehicle_model_id,
                                ':model_names' => $this->model_name,
                                ':vehicle_color' => $this->vehiclecolor,
                                ':cashmemo_notes' => $this->cashmemo_notes,
                                ':cashmemo_payment_type' => $this->cashmemo_payment_type,
                                ':cashmemo_cheque_date' => $this->cashmemo_cheque_date,
                                ':cashmemo_cheque_ref_no' => $this->cashmemo_cheque_ref_no,
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
                                ':cashmemo_id' => $this->cashmemo_id
                             ];
                             
                             $result =$this->varPDOModelObj->UpdateTable($sqlUpdate,$updateParams);
                             
                              echo json_encode([
                                "status"  => 'Success',
                                "msg_text"  => 'Updated successfully',
                                "message" =>  $this->cashmemo_number
                            ]);
                            
                           // echo "Quotation updated successfully.";
                        } else {
                            
                            $this->varPDOModelObj->Begin();
                          
                         
                            $cashmemoNo=$this->generateCashMemoNo($this->varPDOModelObj,$this->cashmemo_date,$this->company_code);
                            $sqlInsert = "INSERT INTO cashmemo
                                    (cashmemo_no, cashmemo_date, customer_code,
                                     customer_name, customer_phone, customer_email,customer_cpr_cr, customer_address, contract_ids, booking_ids, agreement_no, vehicle_ids, vehicle_no, model_ids, model_names, vehicle_color, cashmemo_notes,cashmemo_payment_type,cashmemo_cheque_date,cashmemo_cheque_ref_no,
                                     items, subtotal, vat_total, grand_total, draft, reference_number,
                                     total_discount, total_discount_amount, after_discount_amount,
                                     user_id, user_name, company_id, company_name,
                                     allItemSubtotal)
                                    VALUES
                                    (:cashmemo_no, :cashmemo_date, :customer_code,
                                     :customer_name, :customer_phone, :customer_email, :customer_cpr_cr, :customer_address, :contract_ids, :booking_ids, :agreement_no, :vehicle_ids, :vehicle_no, :model_ids, :model_names, :vehicle_color, :cashmemo_notes, :cashmemo_payment_type, :cashmemo_cheque_date, :cashmemo_cheque_ref_no,
                                     :items, :subtotal, :vat_total, :grand_total, :draft, :reference_number,
                                     :total_discount, :total_discount_amount, :after_discount_amount,
                                     :user_id, :user_name, :company_id, :company_name,
                                     :allItemSubtotal)";
                                     
                            $insertParams = [
                                
                                ':cashmemo_no' => $cashmemoNo,
                                ':cashmemo_date' => $this->cashmemo_date,
                                ':customer_code' => $this->customer_code,
                                ':customer_name' => $this->customer_name,
                                ':customer_phone' => $this->customer_phone,
                                ':customer_email' => $this->customer_email,
                                ':customer_cpr_cr' => $this->customer_cpr_cr,
                                ':customer_address' => $this->customer_address,
                                ':contract_ids' => $this->contract_id,
                                ':booking_ids' => $this->booking_ids,
                                ':agreement_no' => $this->agreement_no,
                                ':vehicle_ids' => $this->vehicle_id,
                                ':vehicle_no' => $this->vehicleno,
                                ':model_ids' => $this->vehicle_model_id,
                                ':model_names' => $this->model_name,
                                ':vehicle_color' => $this->vehiclecolor,
                                ':cashmemo_notes' => $this->cashmemo_notes,
                                ':cashmemo_payment_type' => $this->cashmemo_payment_type,
                                ':cashmemo_cheque_date' => $this->cashmemo_cheque_date,
                                ':cashmemo_cheque_ref_no' => $this->cashmemo_cheque_ref_no,
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
                                ':allItemSubtotal' => $this->allItemSubtotal
                               
                                ];
                                
                            $this->ReturnData =  $this->varPDOModelObj->AddToTable($sqlInsert,$insertParams);
                            
                            $this->varPDOModelObj->Commit();
                            echo json_encode([
                                "status"  => 'Success',
                                "msg_text"  => 'Created successfully',
                                "message" => $cashmemoNo
                            ]);
                            $sql_contract = "SELECT 
                                    ids,
                                    booking_ids,
                                    agreement_group_ref_no,
                                    quotation_number
                                FROM tbl_vehicle_rentout_contracts
                                WHERE agreement_no = :agr_no";

                                $stmt = $this->varPDOModelObj->selectexecuteQuery(
                                    $sql_contract,
                                    [':agr_no' => $this->agreement_no]
                                );
                            
                            $contractData = $stmt->fetch(PDO::FETCH_ASSOC);
                            $agreement_group_ref_no = $contractData['agreement_group_ref_no'];
                            $quotation_number  = $contractData['quotation_number'];
                        $itemSummary = !empty($this->cashmemo_notes) ? trim((string)$this->cashmemo_notes) : (!empty($this->items[0]['item_name']) ? trim((string)$this->items[0]['item_name']) : '');
                        $ledger_des = 'Auto Post From Receipt ' . $cashmemoNo . ($itemSummary !== '' ? ' (' . $itemSummary . ')' : '');
                             $sql_ledger = "INSERT INTO tbl_customer_ledger 
                                (customer_code, quotation_no, booking_no, trans_date, cheque_date, trans_type, payment_method, debit, credit, ref_no, cheque_status, description, user_id, company_id,booking_ids,contract_ids,agreement_no) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', ?, ?, ?, ?, ?, ?)";
                        $params_ledger = [$this->customer_code, $quotation_number, $agreement_group_ref_no, $this->cashmemo_date, $this->cashmemo_cheque_date, $cashmemoNo, $this->cashmemo_payment_type, '0.000',  $this->after_discount_amount, $this->cashmemo_cheque_ref_no, $ledger_des, $this->storage_userid, $this->storage_company_id, $this->booking_ids, $this->contract_id, $this->agreement_no];
                         $this->varPDOModelObj->AddToTable($sql_ledger, $params_ledger);
                         if((float)$this->vat_total > 0)
                         
                         {
                             $vat_ledger_des='VAT Auto Post From Receipt '.$cashmemoNo;
                             $sql_vat_ledger = "INSERT INTO tbl_customer_ledger 
                                (customer_code, quotation_no, booking_no, trans_date, trans_type, payment_method, debit, credit, ref_no, cheque_status, description, user_id, company_id,booking_ids,contract_ids,agreement_no) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', ?, ?, ?, ?, ?, ?)";
                        $vat_params_ledger = [$this->customer_code, $quotation_number, $agreement_group_ref_no, $this->cashmemo_date,  $cashmemoNo, $this->cashmemo_payment_type, '0.000',  $this->vat_total, $this->cashmemo_cheque_ref_no, $vat_ledger_des, $this->storage_userid, $this->storage_company_id, $this->booking_ids, $this->contract_id, $this->agreement_no];
                         $this->varPDOModelObj->AddToTable($sql_vat_ledger, $vat_params_ledger);
                         }
                         if((float)$this->total_discount_amount > 0)
                         
                         {
                             $dis_ledger_des='Discount Auto Post From Receipt '.$cashmemoNo;
                             $sql_dis_ledger = "INSERT INTO tbl_customer_ledger 
                                (customer_code, quotation_no, booking_no, trans_date,  trans_type,  debit, credit,  cheque_status, description, user_id, company_id,booking_ids,contract_ids,agreement_no) 
                                VALUES (?, ?,  ?, ?, ?, ?, ?, 'Pending', ?, ?, ?, ?, ?, ?)";
                        $dis_params_ledger = [$this->customer_code, $quotation_number, $agreement_group_ref_no, $this->cashmemo_date,  $cashmemoNo,'0.000',$this->total_discount_amount, $dis_ledger_des, $this->storage_userid, $this->storage_company_id, $this->booking_ids, $this->contract_id, $this->agreement_no];
                         $this->varPDOModelObj->AddToTable($sql_dis_ledger, $dis_params_ledger);
                         }
                          
                        }
                    } catch (Exception $e) {
                        if (!$isUpdate) {
                             $this->varPDOModelObj->RollBack();

                        }
                        die("Error: " . $e->getMessage());
                    }
                break;
           case 'GetCashmemo':
            $sql = "SELECT cm.*, c.company_name AS c_company_name
                    FROM cashmemo cm
                    LEFT JOIN tbl_company c ON cm.company_id = c.ids
                    WHERE cm.draft = :draft
                      AND cm.cashmemo_date BETWEEN :start_date AND :end_date";
            
            $params = [
             ':draft' => $this->draft,
             ':start_date'  => $this->startDate,
             ':end_date'    => $this->endDate
            ];
            
            if ($this->company_id !== 'All' && !empty($this->company_id)) {
                $sql .= " AND cm.company_id = :company_ids";
                $params[':company_ids'] = $this->company_id;
            } else {
                $userCompanyJson = isset($_SESSION['company_json']) ? json_decode($_SESSION['company_json'], true) : [];
                $userCompanyIds = [];
                if (is_array($userCompanyJson)) {
                    foreach ($userCompanyJson as $uc) {
                        if (isset($uc['ids'])) $userCompanyIds[] = (int)$uc['ids'];
                    }
                }
                if (!empty($userCompanyIds)) {
                    $placeholders = implode(',', $userCompanyIds);
                    $sql .= " AND cm.company_id IN ($placeholders)";
                }
            }
           
            if (!empty($this->customer_code) && $this->customer_code != 'All') {
                    $sql .= " AND cm.customer_code = :customer_code";
                    $params[':customer_code'] = trim($this->customer_code);
                }
            
            $sql .= " ORDER BY cm.id DESC";
 
            $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql, $params);
           
        
            $result = json_decode($this->ReturnData, true);
        
            $decimals = 3; // adjust if needed
            $data = [];
        
            if (!empty($result['data'])) {
                foreach ($result['data'] as $row) {
        
                    $date = date("d-m-Y", strtotime($row['cashmemo_date']));
                    $subtotal = number_format((float)$row['subtotal'], $decimals);
                    $vat      = number_format((float)$row['vat_total'], $decimals);
                    $grand    = number_format((float)$row['grand_total'], $decimals);
        
                    $id = (int)$row['id'];
                    $cashmemo_no = htmlspecialchars($row['cashmemo_no']);
                    
                    $cmpName = !empty($row['c_company_name']) ? htmlspecialchars($row['c_company_name']) : htmlspecialchars($row['company_name']);
                    if (!empty($cmpName)) {
                        $cashmemo_no .= "<br><span class='badge' style='background-color:#ED1C24; color:#fff;'>{$cmpName}</span>";
                    }
                    
                    $customer_name = htmlspecialchars($row['customer_name']);
                    $customer_phone = htmlspecialchars($row['customer_phone']);
                    $customer_cpr_cr = htmlspecialchars($row['customer_cpr_cr']);
                    $agreement_no = htmlspecialchars($row['agreement_no']);
                    $vehicle_no = htmlspecialchars($row['vehicle_no']);
                    $model_names = htmlspecialchars($row['model_names']);
                    $custom_val=$agreement_no.' | '.$model_names.' | '.$vehicle_no;
                    $customer_val=$customer_name.' | '.$customer_phone.' | '.$customer_cpr_cr;
                    $display = "
                            <div>
                                <div>{$custom_val}</div>
                                <div style='font-size:11px; color:#6c757d;'>{$customer_val}</div>
                            </div>
                        ";
                    $data[] = [
                        $cashmemo_no,
                        $date,
                        $display,
                        "<div style='text-align:right'>{$subtotal}</div>",
                        "<div style='text-align:right'>{$vat}</div>",
                        "<div style='text-align:right'>{$grand}</div>",
                        "<button class='btn btn-sm btn-primary viewCashmemo' data-id='{$id}'>
                            <span class='ri ri-list-view icon-18px'></span>
                        </button>",
                        "<div class='d-flex gap-1 '>
                            <button class='btn btn-sm btn-info btnOpenSignature' data-bs-toggle='tooltip' title='Apply Signature' data-id={$id} data-ref={$cashmemo_no} >
                                <span class='ri ri-quill-pen-line icon-18px'></span>
                            </button>
                            <button class='btn btn-sm btn-warning cashmemoprint' data-bs-toggle='tooltip' title='Print' data-id={$id} data-ref={$cashmemo_no} >
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
            case 'GetCashmemoDetails':

                $this->ReturnData = $this->varPDOModelObj->ListFromTable(
                    $var[9],
                    $this->params[9]
                );
            
                $result = json_decode($this->ReturnData, true);
            
                echo json_encode([
                    "data" => $result['data'] ?? []
                ]);
            
            break;
                  case 'SaveSignature':
                
                 
                        $updateFields = [];
                        $params = [];
                    
                        $now = date('Y-m-d H:i:s');
                    
                        // ====================================
                        // HIRER SIGNATURE
                        // ====================================
                    
                        if (!empty($this->hirer_signature)) {
                    
                            $hirer_signature_path =
                                'uploads/signatures/cashmemocomp_' .
                                $this->cashmemo_id. '_' . time() . '.png';
                    
                            $hirer_signature = str_replace(
                                'data:image/png;base64,',
                                '',
                                $this->hirer_signature
                            );
                    
                            $hirer_signature = str_replace(
                                ' ',
                                '+',
                                $hirer_signature
                            );
                    
                            file_put_contents(
                                $hirer_signature_path,
                                base64_decode($hirer_signature)
                            );
                    
                            $updateFields[] =
                                "company_signature = :hirer_signature";
                    
                            $updateFields[] =
                                "company_sign_name = :hirer_name";
                    
                            $updateFields[] =
                                "company_sign_date_time = :hirer_signature_date";
                    
                            
                    
                            $params[':hirer_signature'] =
                                $hirer_signature_path;
                    
                            $params[':hirer_name'] =
                                $this->hirer_name;
                    
                            $params[':hirer_signature_date'] =
                                $now;
                    
                            
                        }
                    
                        // ====================================
                        // DELIVERY SIGNATURE
                        // ====================================
                    
                        if (!empty($this->delivery_signature)) {
                    
                            $delivery_signature_path =
                                'uploads/signatures/cashmemocust_' .
                                $this->cashmemo_id. '_' . time() . '.png';
                    
                            $delivery_signature = str_replace(
                                'data:image/png;base64,',
                                '',
                                $this->delivery_signature
                            );
                    
                            $delivery_signature = str_replace(
                                ' ',
                                '+',
                                $delivery_signature
                            );
                    
                            file_put_contents(
                                $delivery_signature_path,
                                base64_decode($delivery_signature)
                            );
                    
                            $updateFields[] =
                                "customer_signature = :delivery_signature";
                    
                            $updateFields[] =
                                "customer_sign_name = :delivery_name";
                    
                            $updateFields[] =
                                "customer_sign_datetime = :delivery_signature_date";
                    
                           
                    
                            $params[':delivery_signature'] =
                                $delivery_signature_path;
                    
                            $params[':delivery_name'] =
                                $this->delivery_name;
                    
                            $params[':delivery_signature_date'] =
                                $now;
                    
                            
                        }
                    
                        // ====================================
                        // NOTHING TO UPDATE
                        // ====================================
                    
                        if (empty($updateFields)) {
                            continue;
                        }
                    
                        // ====================================
                        // FINAL QUERY
                        // ====================================
                    
                    
                      
                        $query = "
                            UPDATE  cashmemo
                            SET " . implode(', ', $updateFields) . "
                            WHERE id = :cashmemo_id
                        ";
                    
                        $params[':cashmemo_id'] = $this->cashmemo_id;
                    
                        $this->ReturnData =
                            $this->varPDOModelObj
                                 ->executeQuery($query, $params);
                      
                  
                    echo json_encode([
                        "status" => true,
                        "message" => "Signature saved successfully"
                    ]);
                
                break;
            default:
                $noAction = json_encode([
                    'status' => false,
                    'message' => "No Action Found"
                ]);

                echo $noAction;

                Logger::ActivityLog(
                    'CashMemoController',
                    "default",
                    [json_decode($noAction)]
                );

           break;
        }
    }
    
   function generateCashMemoNo($pdo, $cashmemo_date, $company_code)
{
    $year = date('Y', strtotime($cashmemo_date));

    $prefix = $company_code . '/' . $year . '/CM/';

    $sql = "SELECT MAX(CAST(RIGHT(cashmemo_no, 4) AS UNSIGNED)) AS last_no
            FROM cashmemo
            WHERE cashmemo_no LIKE :prefix";

    $stmt = $pdo->selectexecuteQuery(
        $sql,
        [':prefix' => $prefix . '%']
    );

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $nextNo = ((int)($row['last_no'] ?? 0)) + 1;

    return $prefix . str_pad($nextNo, 4, '0', STR_PAD_LEFT);
}
}

$obj = new cashmemoController();
$obj->DataRequest($obj->actionevents);
