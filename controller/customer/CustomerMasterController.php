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
        
      
        
         $array[4] = "SELECT * FROM  customer_details ORDER BY ids DESC";
           
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
                    $sqlinsert = "INSERT INTO  customer_details
                        (customer_id,customer_name,customer_mobile,customer_email,customer_addr,customer_attn,customer_cr_cpr,customer_type,cpr_expiry_date,company_id,register_date,created_by,client_docs) VALUES
                        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
                        $insertParms = [
                                $customerCode,
                                $this->customerName,
                                $this->ContactNumber,
                                $this->emailId,
                                $this->customerAddress,
                                $this->custAttn,
                                $this->cprno,
                                $this->custType,
                                $this->cprexpiryDate,
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
			   
                echo json_encode([
                    "status" => "success",
                    "data" => json_decode($this->ReturnData, true)
                ]);
		
			    
            break;	
            
            case 'get_driver_documnets':
			    
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[4]);
			   
                echo json_encode([
                    "status" => "success",
                    "data" => json_decode($this->ReturnData, true)
                ]);
		
			    
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
