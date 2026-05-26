<?php
require 'e:/aacar/pdf/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable('e:/aacar/envfiles');
$dotenv->load();
$mysqli = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
$res = $mysqli->query("SELECT vehicle_rentout_images FROM tbl_vehicle_rentout_contracts WHERE vehicle_rentout_images IS NOT NULL AND vehicle_rentout_images != '' LIMIT 1");
$row = $res->fetch_assoc();
print_r($row['vehicle_rentout_images']);
