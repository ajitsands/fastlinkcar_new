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
        $this->storage_company_id = $_POST['company_id'] ?? $_SESSION['company_id'] ?? 1;
        $this->storage_company_name = $_SESSION['company_name'] ?? null;
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
        
        $array[3] = "SELECT * FROM tbl_quotation_introduction WHERE ids = :intr_ids";
        
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
                if (!empty($this->id)) {
                    $sqlUpdate = "UPDATE tbl_quotation_introduction SET intrn_title = ?, intrn_content = ? WHERE ids = ?";
                    $this->ReturnData = $this->varPDOModelObj->UpdateTable(
                        $sqlUpdate,
                        [$this->intrn_title, $this->intrn_content, $this->id]
                    );
                    echo json_encode([
                        "status"  => 'Success',
                        "msg_text"  => 'Updated successfully'
                    ]);
                } else {
                    $this->ReturnData = $this->varPDOModelObj
                        ->AddToTable(
                            $var[0],
                            $this->params[0]
                        );

                    echo $this->ReturnData;
                }
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
                $title = $result['data'][0]['intrn_title'] ?? '';
                $id = $result['data'][0]['ids'] ?? '';
            
                echo json_encode([
                    'status' => true,
                    'html'   => $htmlContent,
                    'title'  => $title,
                    'id'     => $id
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
                    $userPermissions = isset($_SESSION['permissions']) ? (is_array($_SESSION['permissions']) ? $_SESSION['permissions'] : explode(',', $_SESSION['permissions'])) : [];
                    $loggedInRoleIds = array_map('intval', explode(',', $_SESSION['user_role_id'] ?? ''));
                    $isSuperAdmin = (!empty($_SESSION['is_super_admin'])) || in_array($_SESSION['user_role_name'] ?? '', ['Super Admin', 'Admin']) || in_array(3, $loggedInRoleIds) || in_array(1, $loggedInRoleIds);
                    $canManage = $isSuperAdmin || in_array('*', $userPermissions) || in_array('quotation_manage', $userPermissions);
                    
                    if (!$canManage) {
                        echo json_encode(["status" => false, "msg_text" => "Permission denied to manage quotations."]);
                        break;
                    }
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

         
            $filterCompanyId = $_POST['company_id'] ?? 'All';
            $companyIds = [];
            
            if ($filterCompanyId !== 'All' && !empty($filterCompanyId)) {
                $companyIds[] = $filterCompanyId;
            } else {
                if (!empty($_SESSION['company_json'])) {
                    $companyData = json_decode($_SESSION['company_json'], true);
                    if (is_array($companyData)) {
                        foreach ($companyData as $comp) {
                            $companyIds[] = $comp['ids'];
                        }
                    }
                }
                if (empty($companyIds) && !empty($_SESSION['company_id'])) {
                    $companyIds[] = $_SESSION['company_id'];
                }
            }
            
            if (empty($companyIds)) {
                $companyIds = [-1]; // Fallback if no companies
            }
            
            $placeholders = implode(',', array_fill(0, count($companyIds), '?'));
            
            $sql = "SELECT quotations.*, tbl_company.company_name 
                    FROM quotations 
                    LEFT JOIN tbl_company ON quotations.company_id = tbl_company.ids 
                    WHERE quotations.company_id IN ($placeholders) AND quotations.draft = ? AND quotations.quotation_date BETWEEN ? AND ? ";
            
            $params = $companyIds;
            $params[] = $this->draft;
            $params[] = $this->startDate;
            $params[] = $this->endDate;
           
            if (!empty($this->customer_code) && $this->customer_code != 'All') {
                    $sql .= " AND quotations.customer_code = ?";
                    $params[] = trim($this->customer_code);
                }
            
            $sql .= " ORDER BY quotations.id DESC";
 
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
                    $company_name = htmlspecialchars($row['company_name'] ?? '');
                    $quotation_no_html = "{$quotation_no}<br><span class='badge bg-primary mt-1'>{$company_name}</span>";
                    $customer_name = htmlspecialchars($row['customer_name']);
                    $customer_phone = htmlspecialchars($row['customer_phone']);
                    $customer_cpr_cr = htmlspecialchars($row['customer_cpr_cr']);
                    $customer_val=$customer_name.' | '.$customer_phone.' | '.$customer_cpr_cr;
                    $checked = ($row['quotation_status']== 'Approved') ? 'checked' : '';
                    $userPermissions = isset($_SESSION['permissions']) ? (is_array($_SESSION['permissions']) ? $_SESSION['permissions'] : explode(',', $_SESSION['permissions'])) : [];
                    $loggedInRoleIds = array_map('intval', explode(',', $_SESSION['user_role_id'] ?? ''));
                    $isSuperAdmin = (!empty($_SESSION['is_super_admin'])) || in_array($_SESSION['user_role_name'] ?? '', ['Super Admin', 'Admin']) || in_array(3, $loggedInRoleIds) || in_array(1, $loggedInRoleIds);
                    $canApprove = $isSuperAdmin || in_array('*', $userPermissions) || in_array('quotation_approve', $userPermissions);
                    
                    if ($this->draft == 'No') {
                        if ($canApprove) {
                            $statusHtml = "<span class='me-2 text-danger'>Not Approved</span>
                                           <label class='switch'>
                                               <input type='checkbox'
                                                      class='quotation-status'
                                                      data-id='{$id}'
                                                      {$checked}>
                                               <span class='slider'></span>
                                           </label>
                                           <span class='ms-2 text-success'>Approved</span>";
                        } else {
                            $statusText = ($row['quotation_status'] == 'Approved') ? 'Approved' : 'Disapproved';
                            $badgeClass = ($row['quotation_status'] == 'Approved') ? 'bg-success' : 'bg-danger';
                            $statusHtml = "<span class='badge {$badgeClass}'>{$statusText}</span>";
                        }
                    } else {
                        $statusHtml = '';
                    }

                    $data[] = [
                        $quotation_no_html,
                        $date,
                        $customer_val,
                        "<div style='text-align:right'>{$subtotal}</div>",
                        "<div style='text-align:right'>{$vat}</div>",
                        "<div style='text-align:right'>{$grand}</div>",
                         
                        $statusHtml,
                        "<button class='btn btn-sm btn-primary viewQuotation' data-id='{$id}'>
                            <span class='ri ri-edit-box-line icon-18px'></span>
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
                 $userPermissions = isset($_SESSION['permissions']) ? (is_array($_SESSION['permissions']) ? $_SESSION['permissions'] : explode(',', $_SESSION['permissions'])) : [];
                 $loggedInRoleIds = array_map('intval', explode(',', $_SESSION['user_role_id'] ?? ''));
                 $isSuperAdmin = (!empty($_SESSION['is_super_admin'])) || in_array($_SESSION['user_role_name'] ?? '', ['Super Admin', 'Admin']) || in_array(3, $loggedInRoleIds) || in_array(1, $loggedInRoleIds);
                 $canApprove = $isSuperAdmin || in_array('*', $userPermissions) || in_array('quotation_approve', $userPermissions);
                 
                 if (!$canApprove) {
                     echo json_encode(["status" => false, "msg_text" => "Permission denied to approve quotations."]);
                     break;
                 }
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
