<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once ROOT_PATH . '/__db.php';

class VehicleLookupController
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getPDO();
    }

    public function handle()
    {
        $raw = file_get_contents('php://input');
        $json = $raw ? json_decode($raw, true) : null;
        $req = is_array($json) ? $json : array_merge($_GET, $_POST);
        $action = $req['action'] ?? 'list';
        $allowedTypes = ['color', 'body_type', 'engine_type', 'capacity_cc', 'transmission'];

        try {
            switch ($action) {
                case 'list':
                    $type = trim((string)($req['lookup_type'] ?? ''));
                    if ($type !== '' && in_array($type, $allowedTypes, true)) {
                        $stmt = $this->pdo->prepare("SELECT ids, lookup_type, lookup_value FROM tbl_vehicle_lookup_master WHERE status = 'Active' AND lookup_type = ? ORDER BY ids ASC");
                        $stmt->execute([$type]);
                        echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
                    } else {
                        $stmt = $this->pdo->query("SELECT ids, lookup_type, lookup_value FROM tbl_vehicle_lookup_master WHERE status = 'Active' ORDER BY lookup_type ASC, ids ASC");
                        $grouped = [];
                        foreach ($allowedTypes as $t) {
                            $grouped[$t] = [];
                        }
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $grouped[$row['lookup_type']][] = $row['lookup_value'];
                        }
                        echo json_encode(['status' => 'success', 'data' => $grouped]);
                    }
                    break;

                case 'save':
                    $type = trim((string)($req['lookup_type'] ?? ''));
                    $val  = trim((string)($req['lookup_value'] ?? ''));
                    if (!in_array($type, $allowedTypes, true) || $val === '') {
                        echo json_encode(['status' => false, 'message' => 'Invalid lookup type or empty value.']);
                        return;
                    }
                    $stmt = $this->pdo->prepare("INSERT INTO tbl_vehicle_lookup_master (lookup_type, lookup_value, status) VALUES (?, ?, 'Active') ON DUPLICATE KEY UPDATE status = 'Active'");
                    $stmt->execute([$type, $val]);
                    echo json_encode(['status' => true, 'message' => 'Added successfully.', 'lookup_type' => $type, 'lookup_value' => $val]);
                    break;

                default:
                    echo json_encode(['status' => false, 'message' => 'Unknown action.']);
            }
        } catch (Throwable $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}

$ctrl = new VehicleLookupController();
$ctrl->handle();
