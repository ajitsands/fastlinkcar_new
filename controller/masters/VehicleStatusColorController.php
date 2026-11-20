<?php
require_once ROOT_PATH . '/model/common/VehicleStatusHelper.php';

header('Content-Type: application/json');

$action = $_REQUEST['action'] ?? '';
$type   = $_REQUEST['type'] ?? 'vehicle';
$isContract = ($type === 'contract');
$tableName  = $isContract ? 'tbl_contract_status_colors' : 'tbl_vehicle_status_colors';

try {
    $host = $_ENV['DB_HOST'] ?? (defined('DB_HOST') ? DB_HOST : '127.0.0.1');
    $db   = $_ENV['DB_NAME'] ?? (defined('DB_NAME') ? DB_NAME : 'db_fastlink_carrental');
    $user = $_ENV['DB_USER'] ?? (defined('DB_USER') ? DB_USER : 'root');
    $pass = $_ENV['DB_PASS'] ?? (defined('DB_PASS') ? DB_PASS : '');
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    if ($isContract) {
        VehicleStatusHelper::ensureContractTableAndDefaults($pdo);
    } else {
        VehicleStatusHelper::ensureTableAndDefaults($pdo);
    }

    if ($action === 'list') {
        $rows = $pdo->query("SELECT ids, status_name, status_key, badge_color, text_color FROM {$tableName} ORDER BY ids ASC")->fetchAll();
        echo json_encode(['status' => 'success', 'data' => $rows]);
        exit;
    }

    if ($action === 'save') {
        $raw = file_get_contents('php://input');
        $body = json_decode($raw, true);
        $items = $body['items'] ?? ($_POST['items'] ?? []);
        if (!is_array($items) || empty($items)) {
            echo json_encode(['status' => 'error', 'message' => 'No status colors provided']);
            exit;
        }
        $stmt = $pdo->prepare("UPDATE {$tableName} SET badge_color = ?, text_color = ? WHERE status_key = ?");
        foreach ($items as $it) {
            $key = trim((string)($it['status_key'] ?? ''));
            $color = trim((string)($it['badge_color'] ?? ''));
            if ($key === '' || !preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
                continue;
            }
            $textColor = VehicleStatusHelper::getContrastTextColor($color);
            $stmt->execute([$color, $textColor, $key]);
        }
        $updated = $isContract ? VehicleStatusHelper::getContractStatusColorMap(true) : VehicleStatusHelper::getStatusColorMap(true);
        echo json_encode(['status' => 'success', 'message' => ($isContract ? 'Contract' : 'Vehicle') . ' status colors updated successfully', 'map' => $updated]);
        exit;
    }

    if ($action === 'reset') {
        $defaults = $isContract ? [
            'generated' => '#ff9f43',
            'rentout'   => '#28c76f',
            'extended'  => '#00cfe8',
            'returned'  => '#1b3d94',
            'closed'    => '#20c997',
            'onhold'    => '#ff4c51',
            'cancelled' => '#ea5455',
            'replaced'  => '#6f42c1',
        ] : [
            'available'   => '#28c76f',
            'parking'     => '#00cfe8',
            'rentout'     => '#ea5455',
            'staffuse'    => '#ff4c51',
            'maintenance' => '#ff9f43',
            'blocked'     => '#4b4b4b',
            'saleout'     => '#1b3d94',
            'deactivated' => '#82868b',
        ];
        $stmt = $pdo->prepare("UPDATE {$tableName} SET badge_color = ?, text_color = ? WHERE status_key = ?");
        foreach ($defaults as $k => $c) {
            $stmt->execute([$c, VehicleStatusHelper::getContrastTextColor($c), $k]);
        }
        $updated = $isContract ? VehicleStatusHelper::getContractStatusColorMap(true) : VehicleStatusHelper::getStatusColorMap(true);
        echo json_encode(['status' => 'success', 'message' => 'Status colors reset to defaults', 'map' => $updated]);
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
