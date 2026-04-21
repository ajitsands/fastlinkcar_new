<?PHP 
header('Content-Type: application/json');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
class VehiclesController
{
	  var $varPDOModelObj;
      public $actionevents,$json;
      public $booking, $payments, $drivers, $vehicles, $clients, $params =  array();
      public $vehicleName, $vehicleRegNumber, $vehicleModal, $vehiclePurchaseDate, $vehiclePassingDate, $vehicleInsuranceExpDate, $vehicleStatus, $category, $vehicleDetails, $modelName;
	  public $belongsToCompanyID,$belongsToCompanyName,$category_id,$brand_id,$vehiclesDocObj,$vehicleimages,$vehicle_ids,$filter_date,$vehicle_model,$vehicleYear,$vehicleColor,$user_id,$company_id;
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
        $this->filter_date = $data['filter_date '] ?? null;
        $this->vehicle_model  = $data['vehicle_model '] ?? null;
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
                    
                    
       

		return $array;
	}
	function DataRequest($action)
	{
	 	$var =  $this->SQLArray();
		switch($action)
		{
			

			case 'AddVehicleInformationnew':
			 $this->ReturnData = $this->varPDOModelObj->AddToTableAndReturnSpecifiedColumn($var[0],'ids',' tbl_vehicles', $this->params[0]);
		//	 Logger::ActivityLog('AddVehicleInformation',"Send to Client - 103 ",[$this->ReturnData]);
			    $Vehicle_id = json_decode(
                    json_decode($this->ReturnData, true)['data']['return_ids_value'],
                    true
                )['data'][0]['ids'] ?? null;
                $outSend = json_encode([
                    'status'  => true,
                    'message' => "Successfully Added..!",
                    'vehicle_id' => $Vehicle_id
                ]);
               // Logger::ActivityLog('AddVehicleInformation',"Send to Client - 103 ",[json_decode($outSend)]);
			    echo $outSend;
			break;
			case 'UpdateVehicleInformation':
			    
			     $result = $this->varPDOModelObj->UpdateTable($var[5], $this->params[5]);
			     // Logger::ActivityLog('UpdateVehicleInformation',"Send to Client - 103 ",[$var[5],$this->params[5],$result]);
			    
                echo $result;
			break;
			
		
            case 'ListVehicleMaster':
			    
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[4]);
			   
                echo json_encode([
                    "status" => "success",
                    "data" => json_decode($this->ReturnData, true)
                ]);
		
			    
            break;	
            case 'ListVehicleMaster_Due_days':
                $sql = "
                SELECT 
                    v.ids,
                    v.model_names,
                    v.vehicle_number,
                    v.vehicle_year,
                    v.vehicle_color,
                    v.other_details_json,
                    v.vehicle_status,
                    v.vehicle_purchase_date,
                    v.next_passing_date,
                    v.next_insurance_date,
                    v.next_maintenance_date,
                
                    DATEDIFF(v.next_passing_date, :filter_date) AS passing_age_days,
                    DATEDIFF(v.next_insurance_date, :filter_date) AS insurance_age_days,
                    DATEDIFF(v.next_maintenance_date, :filter_date) AS maintenance_age_days
                
                FROM tbl_vehicles v
                WHERE v.vehicle_status != 'Sold Out'
                ";
                
                $sqlparams = [
                    ':filter_date' => $this->filter_date
                ];
                
                
                if ($this->vehicle_model !== 'All') {
                    $sql .= " AND v.model_id = :vehicle_model";
                    $sqlparams[':vehicle_model'] = $this->vehicle_model;
                }
			    
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql, $sqlparams);

                echo json_encode([
                    "status" => "success",
                    "data" => $this->ReturnData
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

$obj = new VehiclesController();
$obj->DataRequest($obj->actionevents);

?>
