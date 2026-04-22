<?php
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH . '/envfiles');
$dotenv->load();
include(ROOT_PATH . '/model/db_connection/pdo_db_connection.php');

try {
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;

    // 1. Create tbl_banks
    $sql1 = "CREATE TABLE IF NOT EXISTS tbl_banks (
        ids INT AUTO_INCREMENT PRIMARY KEY,
        bank_name VARCHAR(255) NOT NULL,
        account_no VARCHAR(100) NULL,
        company_id INT DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql1);
    echo "Table tbl_banks created successfully.\n";

    // 2. Add bank_id to tbl_customer_ledger
    // Check if column exists first
    $stmt = $pdo->query("SHOW COLUMNS FROM tbl_customer_ledger LIKE 'bank_id'");
    if (!$stmt->fetch()) {
        $sql2 = "ALTER TABLE tbl_customer_ledger ADD COLUMN bank_id INT NULL AFTER payment_method";
        $pdo->exec($sql2);
        echo "Column bank_id added to tbl_customer_ledger.\n";
    } else {
        echo "Column bank_id already exists in tbl_customer_ledger.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
