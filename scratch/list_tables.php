<?php
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH . '/envfiles');
$dotenv->load();
include(ROOT_PATH . '/model/db_connection/pdo_db_connection.php');

try {
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables in Database:\n";
    print_r($tables);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
