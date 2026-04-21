<?php
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH . '/envfiles');
$dotenv->load();
include(ROOT_PATH . '/model/db_connection/pdo_db_connection.php');

try {
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;

    $sql = "ALTER TABLE `tbl_customer_ledger` 
            ADD COLUMN `cheque_status` ENUM('Pending', 'Collected', 'Bounced') DEFAULT 'Pending' AFTER `ref_no`,
            ADD COLUMN `collected_at` DATETIME DEFAULT NULL AFTER `cheque_status`";

    $pdo->exec($sql);
    echo "Success: tbl_customer_ledger updated with cheque status columns.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
