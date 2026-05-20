<?php
// ajax_encrypt_contract.php
// Returns an AES-256 encrypted, URL-safe token for a given contract number

header('Content-Type: text/plain');

$contract_no = $_GET['contract_no'] ?? '';
if (empty($contract_no)) {
    die('');
}

// Ensure secret key exists (fallback if environment variable is not set)
$key = 'AA_CAR_RENTAL_SECRET_KEY_2026';

// Generate a random Initialization Vector (IV) for maximum security
$iv_length = openssl_cipher_iv_length('aes-256-cbc');
$iv = openssl_random_pseudo_bytes($iv_length);

// Encrypt the contract number
$encrypted = openssl_encrypt($contract_no, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);

// Combine IV and encrypted data
$combined = $iv . $encrypted;

// Convert to URL-safe Base64
$token = strtr(base64_encode($combined), '+/', '-_');
$token = rtrim($token, '='); // Remove padding

echo $token;
?>
