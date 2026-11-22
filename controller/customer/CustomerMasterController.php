<?PHP 
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class CustomerMasterController
{
	  var $varPDOModelObj;
      public $actionevents,$json;
      public $booking, $payments, $drivers, $vehicles, $clients, $params =  array();
	  public $customerName,$ContactNumber,$emailId,$cprno,$cprexpiryDate,$custAttn,$custType,$customerAddress,$customer_ids,$customerStatus,$user_id,$company_id,$filter_date,$insertedDate,$customerDocObj,$ReturnData;
	  public $nationality,$license_no,$license_issue_place,$license_expiry_date,$phone_1,$phone_2,$fax_no,$website,$vat_reg_no,$is_blacklisted,$blacklist_description,$customer_account_id;
	  public $page, $limit, $offset, $status;
	function __construct()
	{
	    $this->varPDOModelObj = new CommonPDOModel();
	    
	
        $this->json = file_get_contents("php://input");
        
        
        if (!$this->json) {
            echo json_encode([
                "status" => "error",
                "message" => "No input data received"
            ]);
            exit;
        }
        
        $data = json_decode($this->json, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid JSON"
            ]);
            exit;
        }
         
        // Access values
        $this->customerName = $data['customerName'] ?? null;
        $this->ContactNumber = $data['ContactNumber'] ?? null;
        $this->emailId = $data['emailId'] ?? null;
        $this->cprno = $data['cprno'] ?? null;
        $this->cprexpiryDate = $data['cprexpiryDate'] ?? null;
        $this->custAttn = $data['custAttn'] ?? null;
        $this->custType = $data['custType'] ?? null;
        $this->customerAddress = $data['customerAddress'] ?? null;
        $this->nationality = $data['nationality'] ?? null;
        $this->license_no = $data['license_no'] ?? null;
        $this->license_issue_place = $data['license_issue_place'] ?? null;
        $this->license_expiry_date = !empty($data['license_expiry_date']) ? $data['license_expiry_date'] : null;
        $this->phone_1 = $data['phone_1'] ?? null;
        $this->phone_2 = $data['phone_2'] ?? null;
        $this->fax_no = $data['fax_no'] ?? null;
        $this->website = $data['website'] ?? null;
        $this->vat_reg_no = $data['vat_reg_no'] ?? null;
        $this->is_blacklisted = !empty($data['is_blacklisted']) ? 1 : 0;
        $this->blacklist_description = $data['blacklist_description'] ?? null;
        $this->customer_account_id = !empty($data['customer_account_id']) ? (int)$data['customer_account_id'] : null;
       
        $this->customerDocObj = json_encode($data['customerDocObj'] ?? []);
        
        $this->customer_ids = $data['ids'] ?? null;
        
        $this->customerStatus = $data['customerStatus'] ?? null;
        
       
        date_default_timezone_set('Asia/Bahrain');
        
        
        $this->actionevents = $data['action'] ?? null;
        $this->filter_date = $data['filter_date '] ?? null;
        $this->company_id = $_SESSION['company_id'] ?? 1;
        $this->user_id = $_SESSION['user_id'] ?? 1;
        $this->insertedDate = date('Y-m-d');
        $this->page = isset($data['page']) ? (int)$data['page'] : 1;
        $this->limit = 8;
        $this->offset = ($this->page - 1) * $this->limit;
        
        

	}
	function onOff($val) {
        return ($val === 'on') ? 1 : 0;
    }

	function SQLArray()
    {
		$array =  array();
        
      
        
         $array[4] = "SELECT cd.*, ca.account_name FROM customer_details cd LEFT JOIN tbl_customer_accounts ca ON ca.ids = cd.customer_account_id ORDER BY cd.ids DESC";
           
         $array[5] = "UPDATE customer_details SET
                        company_id = ?,
                        customer_name = ?,
                        customer_mobile = ?,
                        customer_email = ?,
                        customer_addr = ?,
                        customer_attn = ?,
                        customer_cr_cpr = ?,
                        cpr_expiry_date = ?,
                        customer_type = ?,
                        customer_account_id = ?,
                        nationality = ?,
                        license_no = ?,
                        license_issue_place = ?,
                        license_expiry_date = ?,
                        phone_1 = ?,
                        phone_2 = ?,
                        fax_no = ?,
                        website = ?,
                        vat_reg_no = ?,
                        is_blacklisted = ?,
                        blacklist_description = ?,
                        status = CASE WHEN ? = 1 THEN 'Blacklisted' WHEN status = 'Blacklisted' THEN 'Active' ELSE status END,
                        client_docs = ?
                    WHERE ids = ?";
                   
        $this->params[5] = [
            $this->company_id,
                $this->customerName,
                $this->ContactNumber,
                $this->emailId,
                $this->customerAddress,
                $this->custAttn,
                $this->cprno,
                $this->cprexpiryDate,
                $this->custType,
                $this->customer_account_id,
                $this->nationality,
                $this->license_no,
                $this->license_issue_place,
                $this->license_expiry_date,
                $this->phone_1,
                $this->phone_2,
                $this->fax_no,
                $this->website,
                $this->vat_reg_no,
                $this->is_blacklisted,
                $this->blacklist_description,
                $this->is_blacklisted,
                $this->customerDocObj,
                $this->customer_ids
        ];     
		return $array;
	}
	function DataRequest($action)
	{
	 	$var =  $this->SQLArray();
		switch($action)
		{
			

			case 'AddCustomerInformationnew':
			    $missingCust = [];
			    if (trim((string)$this->custType) === '') $missingCust[] = 'Customer Type';
			    if (trim((string)$this->customerName) === '') $missingCust[] = 'Customer Name';
			    if (trim((string)$this->ContactNumber) === '') $missingCust[] = 'Contact Number';
			    if (trim((string)$this->cprno) === '') $missingCust[] = 'ID Number (CR/CPR No.)';
			    if (trim((string)$this->customer_account_id) === '') $missingCust[] = 'Customer Account';
			    if (trim((string)$this->nationality) === '') $missingCust[] = 'Nationality';
			    if (!empty($missingCust)) {
			        echo json_encode([
			            'status' => false,
			            'message' => 'Required fields missing: ' . implode(', ', $missingCust)
			        ]);
			        break;
			    }
			    if (trim((string)$this->emailId) !== '' && !filter_var(trim((string)$this->emailId), FILTER_VALIDATE_EMAIL)) {
			        echo json_encode([
			            'status' => false,
			            'message' => 'Please enter a valid Email address.'
			        ]);
			        break;
			    }
			    
			     $sql = "
                    SELECT CONCAT(
                        'C',
                        LPAD(
                            IFNULL(MAX(CAST(SUBSTRING(customer_id, 2) AS UNSIGNED)), 0) + 1,
                            4,
                            '0'
                        )
                    ) AS next_customer_code
                    FROM customer_details";
                    
                    $stmt =  $this->varPDOModelObj->selectexecuteQuery($sql);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                   
                    $customerCode = $row['next_customer_code'];
                    $newStatus = ($this->is_blacklisted === 1) ? 'Blacklisted' : 'Active';
                    $sqlinsert = "INSERT INTO  customer_details
                        (customer_id,customer_name,customer_mobile,customer_email,customer_addr,customer_attn,customer_cr_cpr,customer_type,customer_account_id,cpr_expiry_date,nationality,license_no,license_issue_place,license_expiry_date,phone_1,phone_2,fax_no,website,vat_reg_no,status,is_blacklisted,blacklist_description,company_id,register_date,created_by,client_docs) VALUES
                        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
                        $insertParms = [
                                $customerCode,
                                $this->customerName,
                                $this->ContactNumber,
                                $this->emailId,
                                $this->customerAddress,
                                $this->custAttn,
                                $this->cprno,
                                $this->custType,
                                $this->customer_account_id,
                                $this->cprexpiryDate,
                                $this->nationality,
                                $this->license_no,
                                $this->license_issue_place,
                                $this->license_expiry_date,
                                $this->phone_1,
                                $this->phone_2,
                                $this->fax_no,
                                $this->website,
                                $this->vat_reg_no,
                                $newStatus,
                                $this->is_blacklisted,
                                $this->blacklist_description,
                                $this->company_id,
                                $this->insertedDate,
                                $this->user_id,
                                $this->customerDocObj
                        ];
                 
			 $this->ReturnData = $this->varPDOModelObj->AddToTableAndReturnSpecifiedColumn($sqlinsert,'ids','customer_details', $insertParms);

			    $Customer_id = json_decode(
                    json_decode($this->ReturnData, true)['data']['return_ids_value'],
                    true
                )['data'][0]['ids'] ?? null;
                $outSend = json_encode([
                    'status'  => true,
                    'message' => "Successfully Added..!",
                    'customer_id' => $Customer_id
                ]);
             
			    echo $outSend;
			break;
			case 'UpdateCustomerInformation':
			    
			     $result = $this->varPDOModelObj->UpdateTable($var[5], $this->params[5]);
			    
                echo $result;
			break;
			
		
            case 'ListCustomerMaster':
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[4]);
                $decodedList = json_decode($this->ReturnData, true);
                if (empty($decodedList['status']) || !isset($decodedList['data'])) {
                    $this->ReturnData = $this->varPDOModelObj->ListFromTable("SELECT * FROM customer_details ORDER BY ids DESC");
                    $decodedList = json_decode($this->ReturnData, true);
                }
                echo json_encode([
                    "status" => "success",
                    "data" => $decodedList ?: ['status' => true, 'data' => []]
                ]);
            break;	
            
            case 'get_driver_documnets':
			    
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[4]);
			   
                echo json_encode([
                    "status" => "success",
                    "data" => json_decode($this->ReturnData, true)
                ]);
		
			    
            break;	

           
            case 'toggle_blacklist':
                $blStatus = ($this->is_blacklisted === 1) ? 'Blacklisted' : 'Active';
                $blSql = "UPDATE customer_details SET is_blacklisted = ?, blacklist_description = ?, status = ?, updated_on = NOW() WHERE ids = ?";
                $blRes = $this->varPDOModelObj->UpdateTable($blSql, [$this->is_blacklisted, $this->blacklist_description, $blStatus, $this->customer_ids]);
                echo $blRes;
            break;

			default:
        	      $noAction= json_encode([
                    'status'  => false,
                    'message' => "No Action Found..!"
                 ]);
                 echo $noAction;
                 Logger::ActivityLog('VehiclesController',"default",[json_decode($noAction)]);
			break;
			
		}
	 }
	
}

$obj = new CustomerMasterController();
$obj->DataRequest($obj->actionevents);

?>
