<?php
session_start();
header('Content-Type: application/json');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
class VehicleStatusJsonController
{
    var $varPDOModelObj;
    public $json, $actionevents, $ReturnData, $company_id, $user_id, $data, $createdDate,$next_date;
    public $params = array();
    public $action_cate, $next_passing_date, $vehicleId, $passingHistory, $next_insurance_date, $insuranceHistory, $next_maintenance_date, $maintenanceHistory;
        function __construct()
    {
        $this->varPDOModelObj = new CommonPDOModel();
        
        if (!isset($_POST['payload'])) {
            echo json_encode(["status" => "error", "message" => "Missing payload"]);
            exit;
        }
        
        $data = json_decode($_POST['payload'], true);
        
        if (!$data) {
            echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
            exit;
        }
            $this->action_cate = $data['action_cate']?? null;
            $this->actionevents = $data['action'];
            $this->next_passing_date = $data['next_passing_date']?? null;
            $this->passingHistory = $data['passingHistory']?? [];
            
            $this->next_insurance_date = $data['next_insurance_date']?? null;
            $this->insuranceHistory = $data['insuranceHistory']?? [];
            
            $this->next_maintenance_date = $data['next_maintenance_date']?? null;
            $this->maintenanceHistory = $data['maintenanceHistory']?? [];
            
            $this->vehicleId = $data['vehicleId']?? null;
       
            date_default_timezone_set('Asia/Bahrain');
            $this->createdDate = date('Y-m-d H:i:s');
            
           
        $this->company_id = $_SESSION['company_id'] ?? 1;
        $this->user_id = $_SESSION['user_id'] ?? 1;
        
     
       
    }

    function SQLArray()
    {
        $array = array();

       
        $array[1] = "SELECT passing_histroy FROM tbl_vehicles WHERE ids = :id";
        $this->params[1] = [
        ':id' => $this->vehicleId
       ];
        
       
        return $array;
    }

    function DataRequest($action)
    {
        $var = $this->SQLArray();

        switch ($action) {

              case 'add_vehicle_add_ons':
            
                    $newNodeJson = json_encode($this->newNode, JSON_UNESCAPED_SLASHES);
                    
                    $this->varPDOModelObj->executeQuery("SET @newNode = ?", [$newNodeJson]);
                    
                    $updateSql = "
                    UPDATE tbl_vehicles  
                    SET next_passing_date= :netpassingDate , passing_histroy = 
                      CASE  
                        WHEN passing_histroy IS NULL OR passing_histroy = '' 
                        THEN JSON_ARRAY(JSON_EXTRACT(@newNode, '$')) 
                        ELSE JSON_ARRAY_APPEND(passing_histroy, '$', JSON_EXTRACT(@newNode, '$')) 
                      END 
                    WHERE ids = :id
                    ";
                    
                    $this->varPDOModelObj->UpdateTable($updateSql, [
                        ':netpassingDate' =>  $this->next_date,
                        ':id' => $this->vehicleId
                    ]);
            
            break;
            case 'passing':
                
                $updateSql = "
                    UPDATE tbl_vehicles  
                    SET next_passing_date= :netpassingDate , passing_histroy = 
                      :passinghistroy WHERE ids = :id ";
                    
                   $this->ReturnData = $this->varPDOModelObj->UpdateTable($updateSql, [
                        ':netpassingDate' =>  $this->next_passing_date,
                        ':passinghistroy' =>  json_encode($this->passingHistory),
                        ':id' => $this->vehicleId
                    ]);
                    echo $this->ReturnData;
                 
            break;
            case 'insurance':
                
                $updateSql = "
                    UPDATE tbl_vehicles  
                    SET next_insurance_date= :netinsuranceDate , insurance_histroy = 
                      :insurancehistroy WHERE ids = :id ";
                    
                   $this->ReturnData = $this->varPDOModelObj->UpdateTable($updateSql, [
                        ':netinsuranceDate' =>  $this->next_insurance_date,
                        ':insurancehistroy' =>  json_encode($this->insuranceHistory),
                        ':id' => $this->vehicleId
                    ]);
                    echo $this->ReturnData;
                 
            break;
            
           case 'maintenance':
                
                $updateSql = "
                    UPDATE tbl_vehicles  
                    SET next_maintenance_date= :netmaintenanceDate , maintenance_histroy = 
                      :maintenancehistroy WHERE ids = :id ";
                    
                   $this->ReturnData = $this->varPDOModelObj->UpdateTable($updateSql, [
                        ':netmaintenanceDate' =>  $this->next_maintenance_date,
                        ':maintenancehistroy' =>  json_encode($this->maintenanceHistory),
                        ':id' => $this->vehicleId
                    ]);
                    echo $this->ReturnData;
                 
            break;
            default:
                $noAction = json_encode([
                    'status' => false,
                    'message' => "No Action Found"
                ]);

                echo $noAction;

                Logger::ActivityLog(
                    'VehicleStatusJsonController',
                    "default",
                    [json_decode($noAction)]
                );

           break;
        }
    }
}

$obj = new VehicleStatusJsonController();
$obj->DataRequest($obj->actionevents);
