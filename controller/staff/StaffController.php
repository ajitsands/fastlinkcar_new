<?PHP 
header('Content-Type: application/json');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
class DriverController
{
	  var $varPDOModelObj;
      public $actionevents,$json;
      public $booking, $payments, $drivers, $vehicles, $clients, $params =  array();
	  public $driver_name,$ContactNumber,$emailId,$cprno,$cprexpiryDate,$drivinglicenseno,$licenseissueplace,$licenseissueDate,$licenseexpiryDate,$driverAddress,$driver_ids,$driverStatus,$user_id,$company_id,$filter_date,$insertedDate,$driverDocObj,$ReturnData;
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
        $this->driver_name = $data['driverName'] ?? null;
        $this->ContactNumber = $data['ContactNumber'] ?? null;
        $this->emailId = $data['emailId'] ?? null;
        $this->cprno = $data['cprno'] ?? null;
        $this->cprexpiryDate = !empty($data['cprexpiryDate']) ? $data['cprexpiryDate'] : null;
        $this->drivinglicenseno = $data['drivinglicenseno'] ?? null;
        $this->licenseissueplace = $data['licenseissueplace'] ?? null;
        $this->licenseissueDate = !empty($data['licenseissueDate']) ? $data['licenseissueDate'] : null;
        $this->licenseexpiryDate = !empty($data['licenseexpiryDate']) ? $data['licenseexpiryDate'] : null;
        $this->driverAddress = $data['driverAddress'] ?? null;
        $this->driverDocObj = json_encode($data['driverDocObj']) ?? [];
        
        $this->driver_ids = $data['ids'] ?? null;
        
        $this->driverStatus = $data['driverStatus'] ?? null;
        
       
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
        
        $array[0] = "INSERT INTO  tbl_staff
                        (company_ids,staff_name,staff_contact_no,staff_email_id,staff_cpr_no,staff_cpr_expiry_date,license_no,license_issue_place,license_issue_date,license_expiry_date,staff_address,staff_status,created_on,created_by,staff_documents) VALUES
                        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $this->params[0] = [
                $this->company_id,
                $this->driver_name,
                $this->ContactNumber,
                $this->emailId,
                $this->cprno,
                $this->cprexpiryDate,
                $this->drivinglicenseno,
                $this->licenseissueplace,
                $this->licenseissueDate,
                $this->licenseexpiryDate,
                $this->driverAddress,
                $this->driverStatus,
                $this->insertedDate,
                $this->user_id,
                $this->driverDocObj
        ];
        
         $array[4] = "SELECT * FROM tbl_staff ORDER BY ids DESC";
        $array[5] = "UPDATE tbl_staff SET
                        company_ids = ?,
                        staff_name = ?,
                        staff_contact_no = ?,
                        staff_email_id = ?,
                        staff_cpr_no = ?,
                        staff_cpr_expiry_date = ?,
                        license_no = ?,
                        license_issue_place = ?,
                        license_issue_date = ?,
                        license_expiry_date = ?,
                        staff_address = ?,
                        staff_status = ?,
                        created_on = ?,
                        created_by = ?,
                        staff_documents = ?
                    WHERE ids = ?";
        $this->params[5] = [
            $this->company_id,
                $this->driver_name,
                $this->ContactNumber,
                $this->emailId,
                $this->cprno,
                $this->cprexpiryDate,
                $this->drivinglicenseno,
                $this->licenseissueplace,
                $this->licenseissueDate,
                $this->licenseexpiryDate,
                $this->driverAddress,
                $this->driverStatus,
                $this->insertedDate,
                $this->user_id,
                $this->driverDocObj,
                $this->driver_ids
        ];           
                    
                    
        //$array[6] = "SELECT driver_documents FROM tbl_drivers where ids=? ORDER BY ids DESC";

		return $array;
	}
	function DataRequest($action)
	{
	 	$var =  $this->SQLArray();
		switch($action)
		{
			

			case 'AddDriverInformationnew':
			 $this->ReturnData = $this->varPDOModelObj->AddToTableAndReturnSpecifiedColumn($var[0],'ids',' tbl_staff', $this->params[0]);

			    $Driver_id = json_decode(
                    json_decode($this->ReturnData, true)['data']['return_ids_value'],
                    true
                )['data'][0]['ids'] ?? null;
                $outSend = json_encode([
                    'status'  => true,
                    'message' => "Successfully Added..!",
                    'driver_id' => $Driver_id
                ]);
             
			    echo $outSend;
			break;
			case 'UpdateDriverInformation':
			    
			     $result = $this->varPDOModelObj->UpdateTable($var[5], $this->params[5]);
			    
                echo $result;
			break;
			
		
            case 'ListDriverMaster':
			    
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

$obj = new DriverController();
$obj->DataRequest($obj->actionevents);

?>
