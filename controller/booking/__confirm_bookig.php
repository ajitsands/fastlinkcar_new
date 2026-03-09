<?php
header('Content-Type: application/json');

// Get raw JSON
$json = file_get_contents("php://input");

if (!$json) {
    echo json_encode([
        "status" => "error",
        "message" => "No input data received"
    ]);
    exit;
}

$data = json_decode($json, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid JSON"
    ]);
    exit;
}

$booking  = $data['bookingInfo'] ?? [];
$payments = $data['payments'] ?? [];

$drivers  = json_encode($data['drivers'] ?? []);
$vehicles = json_encode($data['vehicles'] ?? []);
$clients  = json_encode($data['clients'] ?? []);

function onOff($val) {
    return ($val === 'on') ? 1 : 0;
}


$sql = "INSERT INTO booking_info (
    reg_number, car_id, company_id, company_name, customer_id, customer_name,

    rent_start_date, rent_end_date, total_days_taken, rent_per_day,
    rent_total_cost, rent_discount_if_any, rent_after_discount,
    rent_tax_any, rent_grand_total,

    jack_and_tools, spare_tyre, radio_yes_no, cd_recorder,

    drivers, vehicles, clients
) VALUES (?,?,?,?,?,?,
          ?,?,?,?,?,?,?,?,?,?,
          ?,?,?,?,
          ?,?,?)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $booking['regNumber'],
    $booking['carId'],
    $booking['companyId'],
    $booking['companyName'],
    $booking['customerId'],
    $booking['customerName'],

    $payments['rent_start_date'],
    $payments['rent_end_date'],
    $payments['total_days_taken'],
    $payments['rent_per_day'],
    $payments['rent_total_cost'],
    $payments['rent_discount_if_any'],
    $payments['rent_after_discount'],
    $payments['rent_tax_any'],
    $payments['rent_grand_total'],

    onOff($payments['jack_and_tools']),
    onOff($payments['spare_tyre']),
    onOff($payments['radio_yes_no']),
    onOff($payments['cd_recorder']),

    $drivers,
    $vehicles,
    $clients
]);

echo json_encode([
    "status" => "success",
    "booking_id" => $pdo->lastInsertId()
]);




