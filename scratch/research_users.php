<?php
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH . '/envfiles');
$dotenv->load();
include(ROOT_PATH . '/model/db_connection/pdo_db_connection.php');

try {
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;

    echo "Schema for tbl_users:\n";
    $stmt = $pdo->query("DESC tbl_users");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

    echo "\nSample user data:\n";
    $stmt = $pdo->query("SELECT * FROM tbl_users LIMIT 5");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
