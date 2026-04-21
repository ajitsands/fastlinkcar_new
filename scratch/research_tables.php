<?php
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH . '/envfiles');
$dotenv->load();
include(ROOT_PATH . '/model/db_connection/pdo_db_connection.php');

try {
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;

    echo "ALL TABLES:\n";
    $stmt = $pdo->query("SHOW TABLES");
    $all_tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    print_r($all_tables);

    foreach ($all_tables as $table) {
        if (stripos($table, 'quotation') !== false) {
             echo "\nSchema for $table:\n";
             $stmt = $pdo->query("DESC $table");
             print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
