<?php

$db = new ClassDatabaseConnection();
$pdo = $db->pdo;


$stmt = $pdo->prepare("
    SELECT 
        ids,service_type,vat_perct
    FROM tbl_service_type");

$stmt->execute();


$data = [];

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

   $data[] = [
    "vat" => $row['vat_perct'],
    "value" => $row['service_type'],
    "id"    => $row['ids']
];
}

echo json_encode($data);