<?php
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH . '/envfiles');
$dotenv->load();
include(ROOT_PATH . '/model/db_connection/pdo_db_connection.php');

try {
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;

    $sql = "CREATE TABLE IF NOT EXISTS `tbl_customer_ledger` (
        `ids` int(11) NOT NULL AUTO_INCREMENT,
        `customer_code` varchar(100) NOT NULL,
        `quotation_no` varchar(100) DEFAULT NULL,
        `booking_no` varchar(100) DEFAULT NULL,
        `trans_date` date NOT NULL,
        `trans_type` enum('Opening Balance','Invoice','Payment','Advance','Discount','Other') NOT NULL,
        `payment_method` enum('Cash','Cheque','BankTransfer','CreditCard','Other','N/A') DEFAULT 'N/A',
        `debit` decimal(18,5) DEFAULT 0.00000,
        `credit` decimal(18,5) DEFAULT 0.00000,
        `ref_no` varchar(200) DEFAULT NULL,
        `description` text DEFAULT NULL,
        `user_id` int(11) NOT NULL,
        `company_id` int(11) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`ids`),
        KEY `idx_customer` (`customer_code`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $pdo->exec($sql);
    echo "Success: tbl_customer_ledger created.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
