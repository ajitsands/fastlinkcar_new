<?php

header('Content-Type: application/json');
session_start();

$mobile = $_POST['mobile'] ?? '';
$otp    = $_POST['otp'] ?? '';
$other_details    = $_POST['other_details'] ?? '';
$data = json_decode($other_details, true);

$customer= $data['customer_name'] ?? '';
$veh_model= $data['model_name'] ?? '';
$veh_no= $data['vehicle_no'] ?? '';
$balance= $data['balance'] ?? '';
$total_debit= $data['total_debit'] ?? '';
$total_credit= $data['total_credit'] ?? '';
$agreement_no= $data['agreement_no'] ?? '';
$customer_mobile= $data['customer_mobile'] ?? '';
$customer_email= $data['customer_email'] ?? '';
$service_type= $data['service_type'] ?? '';
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



if ($data['otp'] == $otp) {

    unset($_SESSION['otp'][$mobile]); // clear after success

   echo json_encode([
    "status" => true,
    "message" => "OTP verified",
   "info_message" =>
    "OTP verification has been successfully completed on {$currentDateTime} " .
    "for the mobile number {$mobile}. " .
    "Agreement No: {$agreement_no}. " .
    "Outstanding balance: {$balance} BHD."
]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "Invalid OTP"
    ]);
}