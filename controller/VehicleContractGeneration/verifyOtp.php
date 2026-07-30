<?php

header('Content-Type: application/json');
session_start();

$mobile = $_POST['mobile'] ?? '';
$otp    = $_POST['otp'] ?? '';
$other_details    = $_POST['other_details'] ?? '';
$data = json_decode($other_details, true);

$customer= $data['customer'] ?? '';
$veh_model= $data['veh_model'] ?? '';
$veh_no= $data['veh_no'] ?? '';
$unit_price= $data['unit_price'] ?? '';
$min_price= $data['min_price'] ?? '';
$booking_ref_no= $data['booking_ref_no'] ?? '';
$book_period_from= $data['book_period_from'] ?? '';
$book_period_to= $data['book_period_to'] ?? '';
date_default_timezone_set('Asia/Bahrain');

$currentDateTime = date("d-m-Y H:i");
if (!isset($_SESSION['otp'][$mobile])) {
    echo json_encode([
        "status" => false,
        "message" => "OTP not found or expired"
    ]);
    exit;
}

$data = $_SESSION['otp'][$mobile];

// if (strtotime($data['expires_at']) < time()) {
//     echo json_encode([
//         "status" => false,
//         "message" => "OTP expired"
//     ]);
//     exit;
// }

if ($data['otp'] == $otp) {

    unset($_SESSION['otp'][$mobile]); // clear after success

   echo json_encode([
    "status" => true,
    "message" => "OTP verified",
    "info_message" =>
        "OTP verification has been successfully completed on {$currentDateTime} " .
        "for the mobile number {$mobile}. " .
        "The applicable unit price is {$unit_price} BHD."
]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "Invalid OTP"
    ]);
}