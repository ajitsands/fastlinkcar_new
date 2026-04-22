<?php
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH . '/envfiles');
$dotenv->load();
include(ROOT_PATH . '/model/db_connection/pdo_db_connection.php');

try {
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;

    $tables = ['tbl_customer_ledger', 'tbl_users'];
    
    foreach ($tables as $table) {
        echo "Schema for $table:\n";
        $stmt = $pdo->query("DESC $table");
        print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
        echo "\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
