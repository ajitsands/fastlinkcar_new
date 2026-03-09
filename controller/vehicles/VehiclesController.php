<?PHP 
header('Content-Type: application/json');

class VehiclesController
{
	  var $varPDOModelObj;
      public $actionevents,$json;
      public $booking, $payments, $drivers, $vehicles, $clients, $params =  array();
      public $vehicleName, $vehicleRegNumber, $vehicleModal, $vehiclePurchaseDate, $vehiclePassingDate, $vehicleInsuranceExpDate, $vehicleStatus, $category, $vehicleDetails;
	  public $belongsToCompanyID,$belongsToCompanyName;
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
        $this->vehicleName = $data['vehicleName'] ?? null;
        $this->vehicleRegNumber = $data['vehicleRegNumber'] ?? null;
        $this->vehicleModal = $data['vehicleModal'] ?? null;
        $this->vehiclePurchaseDate = $data['vehiclePurchaseDate'] ?? null;
        $this->vehiclePassingDate = $data['vehiclePassingDate'] ?? null;
        $this->vehicleInsuranceExpDate = $data['vehicleInsuranceExpDate'] ?? null;
        $this->vehicleStatus = $data['vehicleStatus'] ?? null;
        $this->category = $data['category'] ?? null;
        $this->belongsToCompanyID = $data['belongsToCompanyID'] ?? null;
        $this->belongsToCompanyName = $data['belongsToCompanyName'] ?? null;
        
        $this->status = $data['status'] ?? 'Available';
        
        date_default_timezone_set('Asia/Bahrain');
        
        
        $this->actionevents = $data['action'] ?? null;
        
        // Convert vehicleDetails to JSON string for DB
        $this->vehicleDetails = json_encode($data['vehicleDetails']) ?? [];
        
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
        
        $array[0] = "INSERT INTO vehicles
                        (vehicles_name,
                         vehicles_details,
                         vehicles_status,
                         vehicles_number,
                         vehicles_passing_date,
                         vehicles_insurance_date,
                         vehicles_purchase_date,
                         vehicles_modal,
                         category,
                         company_id,
                         company_name
                         )
                        VALUES
                        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $this->params[0] = [
                $this->vehicleName,
                $this->vehicleDetails,
                $this->vehicleStatus,
                $this->vehicleRegNumber,
                $this->vehiclePassingDate,
                $this->vehicleInsuranceExpDate,
                $this->vehiclePurchaseDate,
                $this->vehicleModal,
                $this->category,
                $this->belongsToCompanyID,
                $this->belongsToCompanyName
        ];
        

        $array[1] = "SELECT * FROM vehicles WHERE vehicles_status = ?
        ORDER BY ids DESC LIMIT ". $this->limit." OFFSET ".$this->offset;
        $this->params[1] =[
                'Available'
            ];
            
       $array[2] = "SELECT 
                    ids,
                    vehicles_name,
                    vehicles_number,
                    vehicles_modal,
                    category,
                    vehicles_status,
                    JSON_UNQUOTE(JSON_EXTRACT(vehicles_details, '$.vehicleFuelType')) AS fuel_type,
                    JSON_UNQUOTE(JSON_EXTRACT(vehicles_details, '$.vehicleCostPerDay')) AS cost_per_day,
                    JSON_UNQUOTE(JSON_EXTRACT(vehicles_details, '$.images[0]')) AS vehicle_image
                FROM vehicles where vehicles_status = ";
       $this->params[2] =[
                $this->status
            ];
            
              $array[3] = "SELECT 
                    ids,
                    vehicles_name,
                    vehicles_number,
                    vehicles_modal,
                    category,
                    vehicles_status,
                    vehicles_passing_date,
                    vehicles_insurance_date,
                    vehicles_purchase_date,
                     DATE_FORMAT(vehicles_passing_date, '%b %d %Y') AS passing_date,
                    DATE_FORMAT(vehicles_insurance_date, '%b %d %Y') AS insurance_date,
                    DATE_FORMAT(vehicles_purchase_date, '%b %d %Y') AS purchase_date,
                    DATEDIFF(vehicles_passing_date,CURDATE()) AS passing_age_days,
                    DATEDIFF(vehicles_insurance_date,CURDATE()) AS insurance_age_days,
                    DATEDIFF(CURDATE(), vehicles_purchase_date) AS purchase_age_days,
                    company_name,
                    JSON_UNQUOTE(JSON_EXTRACT(vehicles_details, '$.vehicleFuelType')) AS fuel_type,
                    JSON_UNQUOTE(JSON_EXTRACT(vehicles_details, '$.vehicleCostPerDay')) AS cost_per_day,
                    JSON_UNQUOTE(JSON_EXTRACT(vehicles_details, '$.images[0]')) AS vehicle_image,
                    JSON_UNQUOTE(JSON_EXTRACT(vehicles_details, '$.images')) AS all_vehicle_images
                FROM vehicles  order by ids desc";
       

		return $array;
	}
	function DataRequest($action)
	{
	 	$var =  $this->SQLArray();
		switch($action)
		{
			
			case 'AddVehicleInformation':
			 $this->ReturnData = $this->varPDOModelObj->AddToTableAndReturnSpecifiedColumn($var[0],'ids','vehicles', $this->params[0]);
			 Logger::ActivityLog('AddVehicleInformation',"Send to Client - 103 ",[$this->ReturnData]);
			    $Vehicle_id = json_decode(
                    json_decode($this->ReturnData, true)['data']['return_ids_value'],
                    true
                )['data'][0]['ids'] ?? null;
                $outSend = json_encode([
                    'status'  => true,
                    'message' => "Successfully Added..!",
                    'vehicle_id' => $Vehicle_id
                ]);
                Logger::ActivityLog('AddVehicleInformation',"Send to Client - 103 ",[json_decode($outSend)]);
			    echo $outSend;
			break;
			case 'LoadAvlVehicle':
			    
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[1],$this->params[1]);
			   
                echo json_encode([
                    "status" => "success",
                    "data" => json_decode($this->ReturnData, true)
                ]);
		
			    
            break;	
            case 'LoadVehicleByUserSellection':
			    
			   $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[2],$this->params[2]);
	           echo $this->ReturnData;
			    
            break;	
            case 'LoadVehicleToMasterList':
			  
			    header('Content-Type: application/json'); // force JSON header
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[3]);
	           echo $this->ReturnData;
			    
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

$obj = new VehiclesController();
$obj->DataRequest($obj->actionevents);

?>
