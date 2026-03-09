<?php
$conn = new mysqli("localhost", "root", "", "your_db");

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 6;
$offset = ($page - 1) * $limit;

$sql = "SELECT id, vehicle_name, vehicle_reg_no, vehicle_modal, vehicle_status, vehicle_details 
        FROM vehicles
        ORDER BY id DESC
        LIMIT $limit OFFSET $offset ";

$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {

    $details = json_decode($row['vehicle_details'], true);

    $data[] = [
        'id' => $row['id'],
        'vehicleName' => $row['vehicle_name'],
        'vehicleRegNumber' => $row['vehicle_reg_no'],
        'model' => $row['vehicle_modal'],
        'status' => $row['vehicle_status'],
        'fuelType' => $details['fuelType'] ?? '',
        'gearType' => $details['gearType'] ?? '',
        'description' => $details['description'] ?? '',
        'image' => $details['images'][0] ?? 'default.jpg'
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
