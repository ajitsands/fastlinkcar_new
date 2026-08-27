<?php
require 'envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable('envfiles');
$dotenv->load();
require 'model/db_connection/pdo_db_connection.php';
require 'model/common/pdoCommonFunctions.php';

$db = new CommonPDOModel();

echo "tbl_vehicle_log_movement schema:\n";
$stmt = $db->varDBPDO->query("SHOW COLUMNS FROM tbl_vehicle_log_movement");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

