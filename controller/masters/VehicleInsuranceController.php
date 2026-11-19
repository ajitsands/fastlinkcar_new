<?php
session_start();
require_once __DIR__ . '/../../model/db_connection/pdo_db_connection.php';
require_once __DIR__ . '/../../model/common/pdoCommonFunctions.php';

class VehicleInsuranceController {
    
    private $db;
    private $commonModel;
    
    public function __construct() {
        $this->commonModel = new CommonPDOModel();
        $this->db = $this->commonModel->varDBPDO;
    }

    public function listVehicles() {
        $allowedCompanies = [];
        if (!empty($_SESSION['company_json'])) {
            $companyData = json_decode($_SESSION['company_json'], true);
            if (is_array($companyData)) {
                $allowedCompanies = array_column($companyData, 'ids');
            }
        }
        
        // Fallback to active session company if empty
        if (empty($allowedCompanies)) {
            $allowedCompanies = [$_SESSION['company_id'] ?? 1];
        }

        $selectedCompanyId = $_GET['company_id'] ?? '';
        $filterCompanyId = '';
        if ($selectedCompanyId !== '' && in_array($selectedCompanyId, $allowedCompanies)) {
            $filterCompanyId = $selectedCompanyId;
        }

        $sql = "SELECT v.ids as vehicle_id, v.vehicle_number, v.chassis_number, 
                       v.next_insurance_date, v.next_passing_date, v.vehicle_status,
                       v.insurance_histroy, v.passing_histroy,
                       v.is_outsourced, 
                       c.company_name as ownership_company,
                       oc.company_name as outsourcing_company,
                       (SELECT category_name FROM tbl_vehicle_category cat WHERE cat.ids = v.category_id) as category_name,
                       (SELECT brand_name FROM tbl_vehicle_brand b WHERE b.ids = v.brand_id) as brand_name,
                       v.model_names
                FROM tbl_vehicles v
                LEFT JOIN tbl_company c ON v.company_id = c.ids
                LEFT JOIN tbl_outsourcing_companies oc ON v.outsourcing_company_id = oc.ids
                WHERE 1=1 ";
        
        $params = [];
        
        if ($filterCompanyId !== '') {
            $sql .= " AND v.company_id = ? ";
            $params[] = $filterCompanyId;
        } else {
            // Filter by all allowed companies
            $inQuery = implode(',', array_fill(0, count($allowedCompanies), '?'));
            $sql .= " AND v.company_id IN ($inQuery) ";
            $params = array_merge($params, $allowedCompanies);
        }

        $sql .= " ORDER BY v.ids DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['status' => true, 'data' => $vehicles]);
    }
    
    public function addInsurance() {
        $this->addEntry('insurance');
    }
    
    public function addPassing() {
        $this->addEntry('passing');
    }
    
    private function addEntry($type) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => false, 'message' => 'Invalid request method']);
            return;
        }

        $vehicleId = $_POST['vehicle_id'] ?? null;
        $date = $_POST['date'] ?? null;
        $amount = $_POST['amount'] ?? null;
        $remarks = $_POST['remarks'] ?? null;
        
        if (!$vehicleId || !$date) {
            echo json_encode(['status' => false, 'message' => 'Vehicle ID and Date are required']);
            return;
        }

        $attachmentUrl = null;
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = dirname(__DIR__, 2) . '/uploads/vehicles/documents/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $filename = time() . '_' . basename($_FILES['attachment']['name']);
            $targetPath = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetPath)) {
                $attachmentUrl = $_ENV['BASE_URL'] . 'uploads/vehicles/documents/' . $filename;
            }
        }

        $colName = ($type === 'insurance') ? 'insurance_histroy' : 'passing_histroy';
        $nextDateCol = ($type === 'insurance') ? 'next_insurance_date' : 'next_passing_date';

        $sql = "SELECT $colName FROM tbl_vehicles WHERE ids = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$vehicleId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$row) {
            echo json_encode(['status' => false, 'message' => 'Vehicle not found']);
            return;
        }

        $history = $row[$colName] ? json_decode($row[$colName], true) : [];
        if (!is_array($history)) {
            $history = [];
        }

        $newEntry = [
            'id' => uniqid(),
            'date' => $date,
            'amount' => $amount,
            'remarks' => $remarks,
            'provider' => trim((string)($_POST['provider'] ?? '')),
            'policy_no' => trim((string)($_POST['policy_no'] ?? '')),
            'insurance_type' => trim((string)($_POST['insurance_type'] ?? '')),
            'start_date' => trim((string)($_POST['start_date'] ?? '')),
            'passed_date' => trim((string)($_POST['passed_date'] ?? '')),
            'attachment' => $attachmentUrl,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $_SESSION['user_id'] ?? 1
        ];

        $history[] = $newEntry;

        usort($history, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        // Use the newly entered date as the next expiry date
        $nextDate = $date;

        $updateSql = "UPDATE tbl_vehicles SET $colName = ?, $nextDateCol = ? WHERE ids = ?";
        $updateStmt = $this->db->prepare($updateSql);
        $result = $updateStmt->execute([json_encode($history), $nextDate, $vehicleId]);

        if ($result) {
            echo json_encode(['status' => true, 'message' => ucfirst($type) . ' record added successfully', 'entry' => $newEntry, 'history' => $history, 'next_date' => $nextDate]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to add record']);
        }
    }

    public function getTimeline() {
        $vehicleId = $_GET['vehicle_id'] ?? null;
        if (!$vehicleId) {
            echo json_encode(['status' => false, 'message' => 'Vehicle ID required']);
            return;
        }

        $sql = "SELECT insurance_histroy, passing_histroy FROM tbl_vehicles WHERE ids = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$vehicleId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo json_encode(['status' => false, 'message' => 'Vehicle not found']);
            return;
        }

        $insurance = $row['insurance_histroy'] ? json_decode($row['insurance_histroy'], true) : [];
        if (!is_array($insurance)) $insurance = [];
        foreach ($insurance as &$i) $i['type'] = 'insurance';

        $passing = $row['passing_histroy'] ? json_decode($row['passing_histroy'], true) : [];
        if (!is_array($passing)) $passing = [];
        foreach ($passing as &$p) $p['type'] = 'passing';

        $timeline = array_merge($insurance, $passing);

        usort($timeline, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        echo json_encode(['status' => true, 'data' => $timeline]);
    }
    
    public function deleteEntry() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => false, 'message' => 'Invalid request method']);
            return;
        }
        
        $vehicleId = $_POST['vehicle_id'] ?? null;
        $entryId = $_POST['entry_id'] ?? null;
        $type = $_POST['type'] ?? null; // 'insurance' or 'passing'
        
        if (!$vehicleId || !$entryId || !$type) {
            echo json_encode(['status' => false, 'message' => 'Missing parameters']);
            return;
        }

        $colName = ($type === 'insurance') ? 'insurance_histroy' : 'passing_histroy';
        $nextDateCol = ($type === 'insurance') ? 'next_insurance_date' : 'next_passing_date';

        $sql = "SELECT $colName FROM tbl_vehicles WHERE ids = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$vehicleId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo json_encode(['status' => false, 'message' => 'Vehicle not found']);
            return;
        }

        $history = $row[$colName] ? json_decode($row[$colName], true) : [];
        if (!is_array($history)) {
            $history = [];
        }

        $updatedHistory = array_filter($history, function($item) use ($entryId) {
            return $item['id'] !== $entryId;
        });

        $updatedHistory = array_values($updatedHistory);

        $nextDate = null;
        if (count($updatedHistory) > 0) {
            $nextDate = $updatedHistory[0]['date']; // Assume next is most recent future date (since it's sorted desc, this gets latest date added)
        }

        $updateSql = "UPDATE tbl_vehicles SET $colName = ?, $nextDateCol = ? WHERE ids = ?";
        $updateStmt = $this->db->prepare($updateSql);
        $result = $updateStmt->execute([json_encode($updatedHistory), $nextDate, $vehicleId]);

        if ($result) {
            echo json_encode(['status' => true, 'message' => 'Entry deleted successfully', 'history' => $updatedHistory, 'next_date' => $nextDate]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to delete entry']);
        }
    }

    public function updateEntry() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => false, 'message' => 'Invalid request method']);
            return;
        }

        $vehicleId = $_POST['vehicle_id'] ?? null;
        $entryId   = $_POST['entry_id'] ?? null;
        $type      = $_POST['type'] ?? null;
        $date      = $_POST['date'] ?? null;
        $amount    = $_POST['amount'] ?? null;
        $remarks   = $_POST['remarks'] ?? null;

        if (!$vehicleId || !$entryId || !$type || !$date) {
            echo json_encode(['status' => false, 'message' => 'Vehicle ID, Entry ID, Type, and Date are required']);
            return;
        }

        $colName     = ($type === 'insurance') ? 'insurance_histroy' : 'passing_histroy';
        $nextDateCol = ($type === 'insurance') ? 'next_insurance_date' : 'next_passing_date';

        $stmt = $this->db->prepare("SELECT $colName FROM tbl_vehicles WHERE ids = ?");
        $stmt->execute([$vehicleId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            echo json_encode(['status' => false, 'message' => 'Vehicle not found']);
            return;
        }

        $history = $row[$colName] ? json_decode($row[$colName], true) : [];
        if (!is_array($history)) {
            $history = [];
        }

        $attachmentUrl = null;
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = dirname(__DIR__, 2) . '/uploads/vehicles/documents/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $filename = time() . '_' . basename($_FILES['attachment']['name']);
            $targetPath = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetPath)) {
                $attachmentUrl = $_ENV['BASE_URL'] . 'uploads/vehicles/documents/' . $filename;
            }
        }

        $found = false;
        foreach ($history as &$item) {
            if (($item['id'] ?? '') === $entryId) {
                $item['date']           = $date;
                $item['amount']         = $amount;
                $item['remarks']        = $remarks;
                $item['provider']       = trim((string)($_POST['provider'] ?? ''));
                $item['policy_no']      = trim((string)($_POST['policy_no'] ?? ''));
                $item['insurance_type'] = trim((string)($_POST['insurance_type'] ?? ''));
                $item['start_date']     = trim((string)($_POST['start_date'] ?? ''));
                $item['passed_date']    = trim((string)($_POST['passed_date'] ?? ''));
                if ($attachmentUrl !== null) {
                    $item['attachment'] = $attachmentUrl;
                }
                $item['updated_at'] = date('Y-m-d H:i:s');
                $found = true;
                break;
            }
        }
        unset($item);

        if (!$found) {
            echo json_encode(['status' => false, 'message' => 'History entry not found']);
            return;
        }

        usort($history, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        $nextDate = $history[0]['date'] ?? $date;
        $updateStmt = $this->db->prepare("UPDATE tbl_vehicles SET $colName = ?, $nextDateCol = ? WHERE ids = ?");
        $result = $updateStmt->execute([json_encode($history), $nextDate, $vehicleId]);

        if ($result) {
            echo json_encode(['status' => true, 'message' => ucfirst($type) . ' record updated successfully', 'history' => $history, 'next_date' => $nextDate]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to update entry']);
        }
    }
}

$action = $_GET['action'] ?? null;
if ($action) {
    $controller = new VehicleInsuranceController();
    if (method_exists($controller, $action)) {
        header('Content-Type: application/json');
        $controller->$action();
        exit;
    }
}
?>
