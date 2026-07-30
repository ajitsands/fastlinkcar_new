<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$url = "https://aacar.sandslab.com/pdf/generate_contract.php?contract_no=AA%2F2026%2FAGR%2F0005";
$options = [
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
    ],
    "http" => [
        "ignore_errors" => true
    ]
];
$context = stream_context_create($options);

$data = file_get_contents($url, false, $context);
if ($data === false) {
    $error = error_get_last();
    echo "Error: " . $error['message'] . "\n";
} else {
    echo "Success, length: " . strlen($data) . "\n";
}
