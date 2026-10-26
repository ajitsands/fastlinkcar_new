
<?php
header('Content-Type: text/plain');

$startDate     = $_GET['from'] ?? '';
$endDate       = $_GET['to'] ?? '';
$customer_code = $_GET['customer_code'] ?? '';
$vehicle_model = $_GET['vehicle_model'] ?? '';
$company_id    = $_GET['company_id'] ?? '';

$data = [
    'startDate'     => $startDate,
    'endDate'       => $endDate,
    'customer_code' => $customer_code,
    'vehicle_model' => $vehicle_model,
    'company_id'    => $company_id
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


