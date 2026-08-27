<?php
class GarageController {
    public $varPDOModelObj;
    public $json;
    
    // Request params
    public $actionevents;
    public $garage_id, $garage_code, $garage_name, $address, $contact_person, $contact_number, $email_id, $status;
    public $service_id, $service_name, $unit, $charge_per_unit;
    public $company_id, $user_id, $insertedDate;
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            echo json_encode(["status" => false, "message" => "Session expired"]);
            exit;
        }

        $this->varPDOModelObj = new CommonPDOModel();
        
        $this->json = file_get_contents("php://input");
        if (!$this->json) {
            echo json_encode(["status" => "error", "message" => "No input data received"]);
            exit;
        }
        
        $data = json_decode($this->json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
            exit;
        }
        
        $this->actionevents = $data['action'] ?? null;
        
        // Garage Params
        $this->garage_id = $data['garage_id'] ?? null;
        $this->garage_code = $data['garage_code'] ?? null;
        $this->garage_name = $data['garage_name'] ?? null;
        $this->address = $data['address'] ?? null;
        $this->contact_person = $data['contact_person'] ?? null;
        $this->contact_number = $data['contact_number'] ?? null;
        $this->email_id = $data['email_id'] ?? null;
        
        // Service Params
        $this->service_id = $data['service_id'] ?? null;
        $this->service_name = $data['service_name'] ?? null;
        $this->unit = $data['unit'] ?? null;
        $this->charge_per_unit = isset($data['charge_per_unit']) ? floatval($data['charge_per_unit']) : 0.00;
        
        $this->status = $data['status'] ?? 'Available';
        $this->company_id = $_SESSION['company_id'] ?? 1;
        $this->user_id = $_SESSION['user_id'] ?? 1;
        $this->insertedDate = date('Y-m-d H:i:s');
    }

    public function DataRequest($action) {
        switch($action) {
            case 'LoadGarages':
                $sql = "SELECT * FROM tbl_garages WHERE company_id = ? ORDER BY ids DESC";
                $result = $this->varPDOModelObj->ListFromTable($sql, [$this->company_id]);
                echo $result;
                break;
                
            case 'AddGarage':
                if(empty($this->garage_code)) {
                    // Generate unique code if empty
                    $stmt = $this->varPDOModelObj->varDBPDO->query("SELECT MAX(ids) as max_id FROM tbl_garages");
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $next_id = ($row['max_id'] ?? 0) + 1;
                    $this->garage_code = 'GAR-' . str_pad($next_id, 4, '0', STR_PAD_LEFT);
                } else {
                    // Check if exists
                    $checkStmt = $this->varPDOModelObj->varDBPDO->prepare("SELECT ids FROM tbl_garages WHERE garage_code = ? AND company_id = ?");
                    $checkStmt->execute([$this->garage_code, $this->company_id]);
                    if($checkStmt->rowCount() > 0) {
                        echo json_encode(['status' => false, 'message' => 'Garage Code already exists']);
                        break;
                    }
                }
                
                $sql = "INSERT INTO tbl_garages (garage_code, garage_name, address, contact_person, contact_number, email_id, company_id, created_by, created_on, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $params = [
                    $this->garage_code, $this->garage_name, $this->address, $this->contact_person, 
                    $this->contact_number, $this->email_id, $this->company_id, $this->user_id, $this->insertedDate, 'Available'
                ];
                
                $result = $this->varPDOModelObj->AddToTableAndReturnSpecifiedColumn($sql, 'ids', 'tbl_garages', $params);
                $resp = json_decode($result, true);
                if(isset($resp['status']) && $resp['status'] == true) {
                    echo json_encode(['status' => true, 'message' => 'Garage added successfully']);
                } else {
                    echo json_encode(['status' => false, 'message' => 'Failed to add garage. Debug: ' . print_r($result, true)]);
                }
                break;
                
            case 'UpdateGarage':
                // Check if code exists for another ID
                $checkStmt = $this->varPDOModelObj->varDBPDO->prepare("SELECT ids FROM tbl_garages WHERE garage_code = ? AND ids != ? AND company_id = ?");
                $checkStmt->execute([$this->garage_code, $this->garage_id, $this->company_id]);
                if($checkStmt->rowCount() > 0) {
                    echo json_encode(['status' => false, 'message' => 'Garage Code already exists']);
                    break;
                }
                
                $sql = "UPDATE tbl_garages SET garage_code = ?, garage_name = ?, address = ?, contact_person = ?, contact_number = ?, email_id = ? WHERE ids = ?";
                $params = [
                    $this->garage_code, $this->garage_name, $this->address, $this->contact_person, 
                    $this->contact_number, $this->email_id, $this->garage_id
                ];
                echo $this->varPDOModelObj->UpdateTable($sql, $params);
                break;
                
            case 'ChangeGarageStatus':
                $sql = "UPDATE tbl_garages SET status = ? WHERE ids = ?";
                echo $this->varPDOModelObj->UpdateTable($sql, [$this->status, $this->garage_id]);
                break;
                
            case 'LoadGarageServices':
                $sql = "SELECT * FROM tbl_garage_services WHERE company_id = ? ORDER BY ids DESC";
                $result = $this->varPDOModelObj->ListFromTable($sql, [$this->company_id]);
                echo $result;
                break;
                
            case 'AddGarageService':
                $sql = "INSERT INTO tbl_garage_services (service_name, unit, charge_per_unit, company_id, created_by, created_on, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $params = [
                    $this->service_name, $this->unit, $this->charge_per_unit, 
                    $this->company_id, $this->user_id, $this->insertedDate, 'Available'
                ];
                
                $result = $this->varPDOModelObj->AddToTableAndReturnSpecifiedColumn($sql, 'ids', 'tbl_garage_services', $params);
                $resp = json_decode($result, true);
                if(isset($resp['status']) && $resp['status'] == true) {
                    echo json_encode(['status' => true, 'message' => 'Service added successfully']);
                } else {
                    echo json_encode(['status' => false, 'message' => 'Failed to add service. Debug: ' . print_r($result, true)]);
                }
                break;
                
            case 'UpdateGarageService':
                $sql = "UPDATE tbl_garage_services SET service_name = ?, unit = ?, charge_per_unit = ? WHERE ids = ?";
                $params = [
                    $this->service_name, $this->unit, $this->charge_per_unit, $this->service_id
                ];
                echo $this->varPDOModelObj->UpdateTable($sql, $params);
                break;
                
            case 'ChangeGarageServiceStatus':
                $sql = "UPDATE tbl_garage_services SET status = ? WHERE ids = ?";
                echo $this->varPDOModelObj->UpdateTable($sql, [$this->status, $this->service_id]);
                break;
        }
    }
}

$obj = new GarageController();
$obj->DataRequest($obj->actionevents);
?>
