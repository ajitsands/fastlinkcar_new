<?php
session_start();
header('Content-Type: application/json');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
class QuoationController
{
    var $varPDOModelObj;
    public $json, $actionevents;
    public $params = array();

    public $userId, $name, $role_id, $role_name, $username, $password;
    public $email, $phoneNumber, $companies, $image, $createdDate, $ReturnData, $userStatus, $t_c_name, $terms_condition;
    public $quotation_id, $original_draft, $action_type, $save_type, $draft_flag,$customer_code, $customer_name, $customer_phone, $customer_email, $customer_address, $quotation_date, $quotation_prefix;
    public $items, $subtotal, $vat_total, $grand_total, $total_discount, $total_discount_amount, $after_discount_amount, $storage_company_id, $storage_company_name, $storage_username, $storage_userid;
    public $allItemSubtotal, $reference_number,  $termsContentValue, $introContentValue, $attentionValue, $doc_type, $draft, $quotation_number, $startDate, $endDate,$is_approved,$customer_cpr_cr;
    function __construct()
    {
        $this->varPDOModelObj = new CommonPDOModel();

        
        // User fields
        $this->intrn_title = $_POST['intrn_title'] ?? null;
        $this->intrn_content = $_POST['intrn_content'] ?? null;
        $this->terms_condition = $_POST['terms_condition'] ?? null;
        $this->t_c_name = $_POST['t_c_name'] ?? null;
        $this->id = $_POST['id'] ?? null;
        
        $this->company_id = $_SESSION['company_id'] ?? 1;
        $this->user_id = $_SESSION['user_id'] ?? 1;
        $this->actionevents = $_POST['action'] ?? null;
        date_default_timezone_set('Asia/Bahrain');
        $this->createdDate = date('Y-m-d H:i:s');
        
        $this->quotation_id = $_POST['quotation_id'] ?? null;
        $this->quotation_number = $_POST['quotation_number'] ?? null;
        $this->is_approved = $_POST['is_approved'] ?? null;
        
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
        $this->quotation_date = $_POST['quotation_date'] ?? null;
        $this->quotation_prefix = $_POST['quotation_prefix'] ?? null;
       
        $this->items = $_POST['items'] ?? [];
        $this->subtotal = $_POST['subtotal'] ?? 0;
        $this->vat_total = $_POST['vat_total'] ?? 0;
        $this->grand_total = $_POST['grand_total'] ?? 0; 
        
        $this->total_discount = $_POST['total_discount'] ?? null;
        $this->total_discount_amount = $_POST['total_discount_amount'] ?? null;
        $this->after_discount_amount = $_POST['after_discount_amount'] ?? null;
        $this->storage_company_id = $_SESSION['company_id'] ?? 1;
        $this->storage_company_name =$_SESSION['company_name'] ?? null;
        $this->storage_username = $_SESSION['user_name'] ?? null;
        $this->storage_userid = $_SESSION['user_id'] ?? 1;
        $this->allItemSubtotal = $_POST['allItemSubtotal'] ?? null;
        
        $this->reference_number  = $_POST['reference_number'] ?? null;
       
        $this->termsContentValue = $_POST['termsContentValue'] ?? null;
        $this->introContentValue = $_POST['introContentValue'] ?? null;
        $this->attentionValue = $_POST['attentionValue'] ?? null;
        
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

        $array[0] = "INSERT INTO tbl_quotation_introduction
                    (
                        intrn_title,
                        intrn_content,
                        company_id,
                        user_id
                    )
                    VALUES
                    (?, ?, ?, ?)";

        $this->params[0] = [
            $this->intrn_title,
            $this->intrn_content,
            $this->company_id,
            $this->user_id
        ];

        $array[1] = "SELECT * FROM tbl_quotation_introduction WHERE company_id = ? ORDER BY ids DESC";
        
        $this->params[1] = [
            $this->company_id
        ];

        $array[2] = "DELETE from tbl_quotation_introduction WHERE ids = :intr_ids";
         $this->params[2] = [
             ':intr_ids' => $this->id
        ];
        
        $array[3] = "SELECT intrn_content FROM tbl_quotation_introduction WHERE ids = :intr_ids";
        
        $this->params[3] = [
             ':intr_ids' => $this->id
        ];

        //TermsCondition
         $array[4] = "INSERT INTO tbl_terms_and_condition
                    (
                        terms_condition,
                        t_c_name,
                        company_id,
                        user_id
                    )
                    VALUES
                    (?, ?, ?, ?)";

        $this->params[4] = [
            $this->terms_condition,
            $this->t_c_name,
            $this->company_id,
            $this->user_id
        ];

        $array[5] = "SELECT * FROM tbl_terms_and_condition WHERE company_id = ? ORDER BY ids DESC";
        
        $this->params[5] = [
            $this->company_id
        ];

        $array[6] = "DELETE from tbl_terms_and_condition WHERE ids = :tc_ids";
         $this->params[6] = [
             ':tc_ids' => $this->id
        ];
        
        $array[7] = "SELECT terms_condition FROM tbl_terms_and_condition WHERE ids = :tc_ids";
        
        $this->params[7] = [
             ':tc_ids' => $this->id
        ];
        
        $array[8] = "SELECT * FROM quotations WHERE company_id = :company_ids and draft =:draft AND quotation_date BETWEEN :start_date AND :end_date order by id desc ";
        
        $this->params[8] = [
             ':company_ids' => $this->company_id,
             ':draft' => $this->draft,
             ':start_date'  => $this->startDate,
             ':end_date'    => $this->endDate
             
        ];
        
        $array[9] = "SELECT * FROM quotations WHERE id = :quotationId ";
        
        $this->params[9] = [
             ':quotationId' => $this->quotation_id
             
        ];
       
        return $array;
    }

    function DataRequest($action)
    {
        $var = $this->SQLArray();

        switch ($action) {

            case 'SaveIntroduction':

                $this->ReturnData = $this->varPDOModelObj
                    ->AddToTable(
                        $var[0],
                        $this->params[0]
                    );

                echo $this->ReturnData;

                break;

           case 'LoadIntroduction':

                $this->ReturnData = $this->varPDOModelObj->ListFromTable(
                    $var[1],
                    $this->params[1]
                );
            
                $result = json_decode($this->ReturnData, true);
            
                echo json_encode([
                    "data" => $result['data'] ?? []
                ]);
            
            break;
            
            case 'deleteIntroduction':
                $this->ReturnData = $this->varPDOModelObj->DeleteFromTable(
                    $var[2],
                    $this->params[2]
                );
            
             
                $result = json_decode($this->ReturnData, true);
            
                echo json_encode([
                    "status"  => $result['status'],
                    "message" => $result['message'],
                    "rows_affected" => $result['data']['rows_affected'] ?? 0
                ]);

            break;
            
            case 'LoadIntroductionToEditor':

                 $this->ReturnData = $this->varPDOModelObj->ListFromTable(
                    $var[3],
                    $this->params[3]
                );
            
                $result = json_decode($this->ReturnData, true);
            
                $htmlContent = $result['data'][0]['intrn_content'] ?? '';
            
                echo json_encode([
                    'status' => true,
                    'html'   => $htmlContent
                ]);
            
            break;


            case 'SaveTermsCondition':

                $this->ReturnData = $this->varPDOModelObj
                    ->AddToTable(
                        $var[4],
                        $this->params[4]
                    );

                echo $this->ReturnData;

            break;
            case 'LoadTermsCondition':

                $this->ReturnData = $this->varPDOModelObj->ListFromTable(
                    $var[5],
                    $this->params[5]
                );
            
                $result = json_decode($this->ReturnData, true);
            
                echo json_encode([
                    "data" => $result['data'] ?? []
                ]);
            
            break;
            
            case 'deleteTermsCondition':
                $this->ReturnData = $this->varPDOModelObj->DeleteFromTable(
                    $var[6],
                    $this->params[6]
                );
            
             
                $result = json_decode($this->ReturnData, true);
            
                echo json_encode([
                    "status"  => $result['status'],
                    "message" => $result['message'],
                    "rows_affected" => $result['data']['rows_affected'] ?? 0
                ]);

            break;
            
            case 'LoadTermsConditionToEditor':

                 $this->ReturnData = $this->varPDOModelObj->ListFromTable(
                    $var[7],
                    $this->params[7]
                );
            
                $result = json_decode($this->ReturnData, true);
            
                $htmlContent = $result['data'][0]['terms_condition'] ?? '';
            
                echo json_encode([
                    'status' => true,
                    'html'   => $htmlContent
                ]);
            
            break;
            case 'SaveQuotation':
                    try {
                        
                        $isUpdate = ($this->action_type === 'update' && !empty($this->quotation_id));
                
                        if ($isUpdate) {
                            
                                $parts = explode('/', $this->quotation_number);

                                if (count($parts) == 4) {
                                    $parts[2] = $this->quotation_prefix; 
                                }
                                else 
                                {
                                    $parts[3] = $this->quotation_prefix;
                                }
                                
                                $newQuotation = implode('/', $parts);
                                
                            $sqlUpdate = "UPDATE quotations SET
                                        customer_code = :customer_code,
                                        customer_name = :customer_name,
                                        quotation_date = :quotation_date,
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
                                        terms = :terms,
                                        introduction= :introduction,
                                        attention = :attention,
                                        quotation_no = :quotation_no,
                                        user_prefix = :user_prefix
                                    WHERE id = :quotation_id";
                            $updateParams = [
                                ':customer_code' => $this->customer_code,
                                ':customer_name' => $this->customer_name,
                                ':quotation_date' => $this->quotation_date,
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
                                ':terms' => $this->termsContentValue,
                                ':introduction' => $this->introContentValue,
                                ':attention' => $this->attentionValue,
                                ':quotation_no' => $newQuotation,
                                ':user_prefix' => $this->quotation_prefix,
                                ':quotation_id' => $this->quotation_id
                             ];
                             
                             $this->varPDOModelObj->UpdateTable($sqlUpdate,$updateParams);
                              echo json_encode([
                                "status"  => 'Success',
                                "msg_text"  => 'Updated successfully',
                                "message" => $newQuotation
                            ]);
                            
                           // echo "Quotation updated successfully.";
                        } else {
                            
                            $this->varPDOModelObj->Begin();
                           
                           $result = $this->varPDOModelObj->callProcedure(
                                "generate_quotation_no",
                                [
                                    $this->doc_type,
                                    $this->storage_company_id,
                                    $this->quotation_prefix,
                                    $this->storage_userid
                                ],
                                ["quotation_no", "draft_flag"]
                            );
                           
                            $quotation_no = $result['quotation_no'] ?? null;
                            $draft_flag   = $result['p_draft_flag'] ?? $this->draft_flag;
                           
               
                            if (!$quotation_no) {
                                throw new Exception("Error generating quotation number.");
                            }
                
                            $sqlInsert = "INSERT INTO quotations
                                    (user_prefix, quotation_no, quotation_date, customer_code,
                                     customer_name, customer_phone, customer_email,customer_cpr_cr, customer_address,
                                     items, subtotal, vat_total, grand_total, draft, reference_number,
                                     total_discount, total_discount_amount, after_discount_amount,
                                     user_id, user_name, company_id, company_name,
                                     allItemSubtotal, attention, terms, introduction)
                                    VALUES
                                    (:user_prefix, :quotation_no, :quotation_date, :customer_code,
                                     :customer_name, :customer_phone, :customer_email, :customer_cpr_cr, :customer_address,
                                     :items, :subtotal, :vat_total, :grand_total, :draft, :reference_number,
                                     :total_discount, :total_discount_amount, :after_discount_amount,
                                     :user_id, :user_name, :company_id, :company_name,
                                     :allItemSubtotal, :attention, :terms, :introduction)";
                            $insertParams = [
                                ':user_prefix' => $this->quotation_prefix,
                                ':quotation_no' => $quotation_no,
                                ':quotation_date' => $this->quotation_date,
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
                                ':draft' => $draft_flag,
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
                                ':terms' => $this->termsContentValue,
                                ':introduction' => $this->introContentValue
                                ];
                               
                            $this->ReturnData =  $this->varPDOModelObj->AddToTable($sqlInsert,$insertParams);
                
                            $this->varPDOModelObj->Commit();
                            echo json_encode([
                                "status"  => 'Success',
                                "msg_text"  => 'Created successfully',
                                "message" => $quotation_no
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
           case 'GetQuotations':

         
          $sql = "SELECT * FROM quotations WHERE company_id = :company_ids and draft =:draft AND quotation_date BETWEEN :start_date AND :end_date ";
            
            $params = [
               ':company_ids' => $this->company_id,
             ':draft' => $this->draft,
             ':start_date'  => $this->startDate,
             ':end_date'    => $this->endDate
            ];
            
           
            if (!empty($this->customer_code) && $this->customer_code != 'All') {
                    $sql .= " AND customer_code = :customer_code";
                    $params[':customer_code'] = trim($this->customer_code);
                }
            
            $sql .= " ORDER BY id DESC";
 
            $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql, $params);
            
            
            $result = json_decode($this->ReturnData, true);
        
            $decimals = 3; // adjust if needed
            $data = [];
        
            if (!empty($result['data'])) {
                foreach ($result['data'] as $row) {
        
                    $date = date("d-m-Y", strtotime($row['quotation_date']));
                    $subtotal = number_format((float)$row['subtotal'], $decimals);
                    $vat      = number_format((float)$row['vat_total'], $decimals);
                    $grand    = number_format((float)$row['grand_total'], $decimals);
        
                    $id = (int)$row['id'];
                    $quotation_no = htmlspecialchars($row['quotation_no']);
                    $customer_name = htmlspecialchars($row['customer_name']);
                    $customer_phone = htmlspecialchars($row['customer_phone']);
                    $customer_cpr_cr = htmlspecialchars($row['customer_cpr_cr']);
                    $customer_val=$customer_name.' | '.$customer_phone.' | '.$customer_cpr_cr;
                    $checked = ($row['quotation_status']== 'Approved') ? 'checked' : '';
                    $data[] = [
                        $quotation_no,
                        $date,
                        $customer_val,
                        "<div style='text-align:right'>{$subtotal}</div>",
                        "<div style='text-align:right'>{$vat}</div>",
                        "<div style='text-align:right'>{$grand}</div>",
                         
                        ($this->draft == 'No')
                            ? "<span class='me-2 text-danger'>Disapproved</span>
                               <label class='switch'>
                                   <input type='checkbox'
                                          class='quotation-status'
                                          data-id='{$id}'
                                          {$checked}>
                                   <span class='slider'></span>
                               </label>
                               <span class='ms-2 text-success'>Approved</span>"
                            : '',
                        "<button class='btn btn-sm btn-primary viewQuotation' data-id='{$id}'>
                            <span class='ri ri-list-view icon-18px'></span>
                        </button>",
                        // "<div class='d-flex gap-1 '>
                            
                        //     <button class='btn btn-sm btn-warning .qtnprint' data-bs-toggle='tooltip' title='Print Format 2' data-id={$id} data-ref={$quotation_no} >
                        //         <span class='ri ri-printer-line icon-18px'></span>
                        //     </button>
                        // </div>"
                       
                    ];
                }
            }
        
            echo json_encode([
                "data" => $data
            ]);
        
            break;
            case 'GetQuotationsDetails':

                $this->ReturnData = $this->varPDOModelObj->ListFromTable(
                    $var[9],
                    $this->params[9]
                );
            
                $result = json_decode($this->ReturnData, true);
            
                echo json_encode([
                    "data" => $result['data'] ?? []
                ]);
            
            break;
             case 'UpdateQuotationApproval':
                 if($this->is_approved=='1')
                 {
                        $sqlUpdate = "UPDATE quotations SET
                                        quotation_status = 'Approved'
                                    WHERE id = :quotation_id";
                            $updateParams = [
                                ':quotation_id' => $this->quotation_id,
                                
                             ];
                             
                             
                 }
                 else
                 {
                     $sqlUpdate = "UPDATE quotations SET
                                        quotation_status = 'Not Approved'
                                    WHERE id = :quotation_id";
                            $updateParams = [
                                ':quotation_id' => $this->quotation_id,
                                
                             ];
                 }
                 $this->varPDOModelObj->UpdateTable($sqlUpdate,$updateParams);
                              echo json_encode([
                                "status"  => 'Success',
                                "msg_text"  => 'Updated successfully',
                                "message" => $newQuotation
                            ]);
                 
            break;
            default:
                $noAction = json_encode([
                    'status' => false,
                    'message' => "No Action Found"
                ]);

                echo $noAction;

                Logger::ActivityLog(
                    'QuotationController',
                    "default",
                    [json_decode($noAction)]
                );

           break;
        }
    }
}

$obj = new QuoationController();
$obj->DataRequest($obj->actionevents);
