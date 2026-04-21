<?php
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH . '/envfiles');
$dotenv->load();
include(ROOT_PATH . '/model/db_connection/pdo_db_connection.php');

try {
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;

    $tables = ['customer_details', 'tbl_vehicle_bookings', 'tbl_quotation_master', 'tbl_quotation_details'];
    
    foreach ($tables as $table) {
        echo "Schema for $table:\n";
        $stmt = $pdo->query("DESC $table");
        print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
        echo "\n";
    }

    echo "Other tables like quotation:\n";
    $stmt = $pdo->query("SHOW TABLES LIKE '%quotation%'");
    print_r($stmt->fetchAll(PDO::FETCH_COLUMN));

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
