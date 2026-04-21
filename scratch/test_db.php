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

    // Try to query view_vehicle_model
    $stmt = $pdo->query("SELECT * FROM view_vehicle_model LIMIT 1");
    echo "Success: view_vehicle_model exists and is queryable.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
