<?php
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH . '/envfiles');
$dotenv->load();
include(ROOT_PATH . '/model/db_connection/pdo_db_connection.php');

try {
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;

    // 1. Create tbl_ledger_heads
    $sql1 = "CREATE TABLE IF NOT EXISTS tbl_ledger_heads (
        ids INT AUTO_INCREMENT PRIMARY KEY,
        head_name VARCHAR(100) NOT NULL UNIQUE,
        head_type ENUM('Debit', 'Credit') NOT NULL,
        is_locked TINYINT(1) DEFAULT 0,
        company_id INT DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql1);
    echo "Table tbl_ledger_heads created successfully.\n";

    // 2. Seed defaults
    $defaults = [
        ['Opening Balance', 'Debit', 1],
        ['Invoice', 'Debit', 1],
        ['Payment', 'Credit', 1],
        ['Advance', 'Credit', 1],
        ['Discount', 'Credit', 1],
        ['Other', 'Credit', 0]
    ];

    $stmt = $pdo->prepare("INSERT IGNORE INTO tbl_ledger_heads (head_name, head_type, is_locked) VALUES (?, ?, ?)");
    foreach ($defaults as $head) {
        $stmt->execute($head);
    }
    echo "Default heads seeded.\n";

    // 3. Modify tbl_customer_ledger.trans_type
    $sql2 = "ALTER TABLE tbl_customer_ledger MODIFY trans_type VARCHAR(100) NOT NULL";
    $pdo->exec($sql2);
    echo "Column trans_type modified to VARCHAR.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
