<?php
require_once ROOT_PATH . '/model/common/VehicleStatusHelper.php';

header('Content-Type: application/json');

$action = $_REQUEST['action'] ?? '';

try {
    $host = $_ENV['DB_HOST'] ?? (defined('DB_HOST') ? DB_HOST : '127.0.0.1');
    $db   = $_ENV['DB_NAME'] ?? (defined('DB_NAME') ? DB_NAME : 'db_fastlink_carrental');
    $user = $_ENV['DB_USER'] ?? (defined('DB_USER') ? DB_USER : 'root');
    $pass = $_ENV['DB_PASS'] ?? (defined('DB_PASS') ? DB_PASS : '');
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    VehicleStatusHelper::ensureTableAndDefaults($pdo);

    if ($action === 'list') {
        $rows = $pdo->query("SELECT ids, status_name, status_key, badge_color, text_color FROM tbl_vehicle_status_colors ORDER BY ids ASC")->fetchAll();
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
        $stmt = $pdo->prepare("UPDATE tbl_vehicle_status_colors SET badge_color = ?, text_color = ? WHERE status_key = ?");
        foreach ($items as $it) {
            $key = trim((string)($it['status_key'] ?? ''));
            $color = trim((string)($it['badge_color'] ?? ''));
            if ($key === '' || !preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
                continue;
            }
            $textColor = VehicleStatusHelper::getContrastTextColor($color);
            $stmt->execute([$color, $textColor, $key]);
        }
        $updated = VehicleStatusHelper::getStatusColorMap(true);
        echo json_encode(['status' => 'success', 'message' => 'Vehicle status colors updated successfully', 'map' => $updated]);
        exit;
    }

    if ($action === 'reset') {
        $defaults = [
            'available'   => '#28c76f',
            'parking'     => '#00cfe8',
            'rentout'     => '#ea5455',
            'staffuse'    => '#ff4c51',
            'maintenance' => '#ff9f43',
            'blocked'     => '#4b4b4b',
            'saleout'     => '#1b3d94',
            'deactivated' => '#82868b',
        ];
        $stmt = $pdo->prepare("UPDATE tbl_vehicle_status_colors SET badge_color = ?, text_color = ? WHERE status_key = ?");
        foreach ($defaults as $k => $c) {
            $stmt->execute([$c, VehicleStatusHelper::getContrastTextColor($c), $k]);
        }
        $updated = VehicleStatusHelper::getStatusColorMap(true);
        echo json_encode(['status' => 'success', 'message' => 'Status colors reset to defaults', 'map' => $updated]);
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
