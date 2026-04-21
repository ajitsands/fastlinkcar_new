<?php

$db = new ClassDatabaseConnection();
$pdo = $db->pdo;

$term = $_GET['term'] ?? '';

$stmt = $pdo->prepare("
    SELECT 
        m.ids AS model_ids,
        CONCAT(b.brand_name, ' ', m.modal_name) AS model_name,m.vehicle_modal_pic AS vehicle_modal_pic
    FROM tbl_vehicle_model m
    JOIN tbl_vehicle_brand b ON m.brand_id = b.ids
    WHERE CONCAT(b.brand_name, ' ', m.modal_name) LIKE :term
    ORDER BY b.brand_name, m.modal_name
    LIMIT 10
");

$stmt->execute([
    ':term' => "%$term%"
]);


$data = [];

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

   $data[] = [
    
    "value" => $row['model_name'],
    "id"    => $row['model_ids'],
    "vehicle_modal_pic"    => $row['vehicle_modal_pic']
    
];
}

echo json_encode($data);