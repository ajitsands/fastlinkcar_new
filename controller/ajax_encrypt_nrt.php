
<?php
header('Content-Type: text/plain');

$startDate     = $_GET['from'] ?? '';
$endDate       = $_GET['to'] ?? '';
$staff_id = $_GET['staff_id'] ?? '';
$vehicle_id = $_GET['vehicle_id'] ?? '';

$data = [
    'startDate'     => $startDate,
    'endDate'       => $endDate,
    'staff_id' => $staff_id,
    'vehicle_id' => $vehicle_id
];



$key = 'AA_CAR_RENTAL_SECRET_KEY_2026';

$iv_length = openssl_cipher_iv_length('aes-256-cbc');
$iv = random_bytes($iv_length);

$encrypted = openssl_encrypt(
    json_encode($data),
    'aes-256-cbc',
    $key,
    OPENSSL_RAW_DATA,
    $iv
);

if ($encrypted === false) {
    die(openssl_error_string());
}

$combined = $iv . $encrypted;

echo rtrim(strtr(base64_encode($combined), '+/', '-_'), '=');
?>


