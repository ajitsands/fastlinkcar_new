<?php
require 'index.php';
$pdo = new CommonPDOModel();
$stmt = $pdo->varDBPDO->query("SHOW TABLES LIKE 'tbl_garages'");
if ($stmt->rowCount() > 0) {
    echo "tbl_garages exists\n";
} else {
    echo "tbl_garages DOES NOT EXIST\n";
}
$stmt = $pdo->varDBPDO->query("SHOW TABLES LIKE 'tbl_garage_services'");
if ($stmt->rowCount() > 0) {
    echo "tbl_garage_services exists\n";
} else {
    echo "tbl_garage_services DOES NOT EXIST\n";
}
