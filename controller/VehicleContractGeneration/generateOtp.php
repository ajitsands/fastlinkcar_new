<?php
session_start(); // MUST be first

header('Content-Type: application/json');

$mobile = $_POST['mobile'] ?? '';

if (!$mobile) {
    echo json_encode([
        "status" => false,
        "message" => "Mobile number required"
    ]);
    exit;
}

// Generate OTP
$otp = rand(100000, 999999);

// Store in session
$_SESSION['otp'][$mobile] = [
    'otp' => $otp
];

// Debug (optional)
error_log("Session ID: " . session_id());
error_log("Stored OTP: " . $otp);

// Response
echo json_encode([
    "status" => true,
    "message" => "OTP sent successfully",
    "otpval" => $otp,
    "mobile" => $mobile
]);