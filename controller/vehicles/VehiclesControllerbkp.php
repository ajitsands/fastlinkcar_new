<?PHP 
header('Content-Type: application/json');

class VehiclesController
{
	  var $varPDOModelObj;
      public $actionevents,$json;
      public $booking, $payments, $drivers, $vehicles, $clients, $params =  array();
      public $vehicleName, $vehicleRegNumber, $vehicleModal, $vehiclePurchaseDate, $vehiclePassingDate, $vehicleInsuranceExpDate, $vehicleStatus, $category, $vehicleDetails, $modelName;
	  public $belongsToCompanyID,$belongsToCompanyName,$category_id,$brand_id,$vehiclesDocObj,$vehicleimages,$vehicle_ids;
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
        $this->vehicleYear = $data['vehicleYear'] ?? null;
        $this->vehicleColor = $data['vehicleColor'] ?? null;
        $this->vehicleRegNumber = $data['vehicleNumber'] ?? null;
        $this->vehicleModal = $data['vehicleModel'] ?? null;
        $this->vehiclePurchaseDate = $data['vehiclePurchaseDate'] ?? null;
        $this->brand_id = $data['brand_id'] ?? null;
        $this->category_id = $data['category_id'] ?? null;
        $this->modelName = $data['modelName'] ?? null;
        
        $this->vehicle_ids = $data['ids'] ?? null;
        
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
        $this->vehiclesDocObj = json_encode($data['vehiclesDocObj']) ?? [];
        $this->vehicleimages = json_encode($data['vehicleimages']) ?? [];
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
        
        $array[0] = "INSERT INTO tbl_vehicles
                        (category_id,model_id,model_names,brand_id,company_id,vehicle_number,vehicle_year,vehicle_color,image_json,other_details_json,vehicle_attachments,vehicle_status,created_on,created_by,vehicle_purchase_date) VALUES
                        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $this->params[0] = [
                $this->category_id,
                $this->vehicleModal,
                $this->modelName,
                $this->brand_id,
                $this->company_id,
                $this->vehicleRegNumber,
                $this->vehicleYear,
                $this->vehicleColor,
                $this->vehicleimages,
                $this->vehicleDetails,
                $this->vehiclesDocObj,
                'Available',
                $this->insertedDate,
                $this->user_id,
                $this->vehiclePurchaseDate
        ];
        
        $array[4] = "SELECT * FROM tbl_vehicles ORDER BY ids DESC";
        $array[5] = "UPDATE tbl_vehicles SET
                        category_id = ?,
                        model_id = ?,
                        model_names = ?,
                        brand_id = ?,
                        company_id = ?,
                        vehicle_number = ?,
                        vehicle_year = ?,
                        vehicle_color = ?,
                        image_json = ?,
                        other_details_json = ?,
                        vehicle_attachments = ?,
                        vehicle_purchase_date = ?
                    WHERE ids = ?";
        $this->params[5] = [
            $this->category_id,
            $this->vehicleModal,
            $this->modelName,
            $this->brand_id,
            $this->company_id,
            $this->vehicleRegNumber,
            $this->vehicleYear,
            $this->vehicleColor,
            $this->vehicleimages,
            $this->vehicleDetails,
            $this->vehiclesDocObj,
            $this->vehiclePurchaseDate,
            $this->vehicle_ids
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
			

			case 'AddVehicleInformationnew':
			 $this->ReturnData = $this->varPDOModelObj->AddToTableAndReturnSpecifiedColumn($var[0],'ids',' tbl_vehicles', $this->params[0]);
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
			case 'UpdateVehicleInformation':
			    
			     $result = $this->varPDOModelObj->UpdateTable($var[5], $this->params[5]);
			      Logger::ActivityLog('UpdateVehicleInformation',"Send to Client - 103 ",[$var[5],$this->params[5]]);
			    
                echo $result;
			break;
			
			
			case 'LoadAvlVehicle':
			    
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[1],$this->params[1]);
			   
                echo json_encode([
                    "status" => "success",
                    "data" => json_decode($this->ReturnData, true)
                ]);
		
			    
            break;
            case 'ListVehicleMaster':
			    
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[4]);
			   
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
