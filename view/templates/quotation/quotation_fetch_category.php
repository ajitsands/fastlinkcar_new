<?php

require '../../model/db_connection/pdo_db_connection.php';
$db = new ClassDatabaseConnection();
$pdo = $db->pdo;



$stmt = $pdo->prepare("
    SELECT ids,category_name
    FROM  tbl_vehicle_category
    WHERE item_name 
    ORDER BY item_name
");

$stmt->execute();

$data = [];

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $data[] = [
       
        "name" => $row['category_name'],
        "id"    => $row['ids']
    ];
}

echo json_encode($data);