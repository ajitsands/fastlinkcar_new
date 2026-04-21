<?php
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH . '/envfiles');
$dotenv->load();

include(ROOT_PATH . '/model/db_connection/pdo_db_connection.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;

    $stmt = $pdo->query("SHOW CREATE VIEW view_vehicle_model");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "View Definition:\n";
    print_r($row);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
