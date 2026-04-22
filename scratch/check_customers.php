<?php
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH . '/envfiles');
$dotenv->load();
include(ROOT_PATH . '/model/db_connection/pdo_db_connection.php');

try {
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;
    $count = $pdo->query("SELECT COUNT(*) FROM customer_details")->fetchColumn();
    echo "Customer Count in customer_details: " . $count . "\n";
    
    if ($count > 0) {
        $stmt = $pdo->query("SELECT * FROM customer_details LIMIT 5");
        print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
