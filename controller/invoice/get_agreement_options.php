<?php

$db = new ClassDatabaseConnection();
$pdo = $db->pdo;

$customerCode = $_GET['customer_code'];
$stmt = $pdo->prepare("
    SELECT ids AS id, agreement_no AS text,vehicle_no,vehicle_id,  DATE_FORMAT(service_start_date_time, '%Y-%m-%d') AS period_from,
            DATE_FORMAT(service_end_date_time, '%Y-%m-%d') AS period_to,booking_ids,customer_code,vehicle_model_id, JSON_UNQUOTE(JSON_EXTRACT(vechile_details, '$.model_name')) AS model_name,JSON_UNQUOTE(JSON_EXTRACT(vechile_details, '$.vehicle_color')) AS vehicle_color FROM tbl_vehicle_rentout_contracts WHERE customer_code = ? ORDER BY ids DESC");

$stmt->execute([$customerCode]);

$data = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $data[] = [
        "id"    => $row['id'],
        "value" => $row['text'],
        "vehicle_no" => $row['vehicle_no'],
        "vehicle_id" => $row['vehicle_id'],
        "period_from" => $row['period_from'],
        "period_to" => $row['period_to'],
        "customer_code" => $row['customer_code'],
        "vehicle_model_id" => $row['vehicle_model_id'],
        "booking_ids" => $row['booking_ids'],
         "model_name" => $row['model_name'],
         "vehicle_color" => $row['vehicle_color'],
         
        
    ];
}

echo json_encode($data);