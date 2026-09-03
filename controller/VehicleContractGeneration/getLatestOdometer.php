<?php
require_once __DIR__ . '/../../envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../envfiles');
$dotenv->load();

include_once __DIR__ . '/../../model/db_connection/pdo_db_connection.php';
$db = new ClassDatabaseConnection();
$pdo = $db->pdo;

$vid = isset($_POST['vehicle_id']) ? intval($_POST['vehicle_id']) : 0;
$odometer = '';

if ($vid > 0) {
    try {
        $stmt = $pdo->prepare("SELECT odometer FROM tbl_vehicle_log_movement WHERE vehicle_ids = ? AND odometer IS NOT NULL AND odometer != '' ORDER BY log_datetime DESC, ids DESC LIMIT 1");
        $stmt->execute([$vid]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && isset($row['odometer'])) {
            $odometer = $row['odometer'];
        }
    } catch(Exception $e) {
        // Return empty on error
    }
}

echo json_encode(['status' => 'success', 'odometer' => $odometer]);
?>
