<?php
// e:\aacar\controller\send_contract_mail.php

$contract_no = $_GET['contract_no'] ?? '';
if (empty($contract_no)) {
    die("No contract number provided.");
}

// 1. Get the PDF generation URL
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$host = $_SERVER['HTTP_HOST'];
$pdf_url = $protocol . "://" . $host . "/PrintAgreement?token=" . urlencode($contract_no);

$pdf_content = false;

// Attempt with cURL first if available
if (function_exists('curl_version')) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $pdf_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
    $pdf_content = curl_exec($ch);
    curl_close($ch);
}

// Fallback to stream_context if cURL failed or is unavailable
if (empty($pdf_content)) {
    $options = [
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false,
        ],
        "http" => [
            "ignore_errors" => true,
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
        ]
    ];
    $context = stream_context_create($options);
    $pdf_content = @file_get_contents($pdf_url, false, $context);
}

if (empty($pdf_content)) {
    die("Error generating PDF from URL: " . $pdf_url);
}

// 2. We need the customer's email. We can fetch it from the database here.
define('ROOT_PATH', __DIR__ . '/..');
require_once ROOT_PATH . '/envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH . '/envfiles');
$dotenv->load();

$mysqli = @new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
if ($mysqli->connect_error) {
    die("Database Connection Error");
}

$stmt = $mysqli->prepare("SELECT customer_details, agreement_no FROM tbl_vehicle_rentout_contracts WHERE agreement_no = ? ");
$stmt->bind_param("s", $contract_no);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Contract not found in database.");
}

$customer = json_decode($data['customer_details'] ?? '{}', true);
$customer_email = $customer['customer_email'] ?? '';
$customer_name = $customer['customer_name'] ?? 'Customer';

if (empty($customer_email)) {
    die("No email address found for this customer.");
}

// 3. Send Email with Attachment
$to = $customer_email;
$subject = "Your Car Rental Contract - " . $data['agreement_no'];
$message = "Dear $customer_name,\n\nPlease find attached your car rental contract (Agreement No: " . $data['agreement_no'] . ").\n\nBest Regards,\nAA Car Rental";
$from = "noreply@" . $host;

// Boundary 
$separator = md5(time());

// Headers
$headers = "From: AA Car Rental <" . $from . ">\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"";

// Body
$body = "--" . $separator . "\r\n";
$body .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
$body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
$body .= $message . "\r\n\r\n";

// Attachment
$encoded_content = chunk_split(base64_encode($pdf_content));
$filename = "Contract_" . $data['agreement_no'] . ".pdf";

$body .= "--" . $separator . "\r\n";
$body .= "Content-Type: application/pdf; name=\"" . $filename . "\"\r\n";
$body .= "Content-Transfer-Encoding: base64\r\n";
$body .= "Content-Disposition: attachment; filename=\"" . $filename . "\"\r\n\r\n";
$body .= $encoded_content . "\r\n\r\n";
$body .= "--" . $separator . "--";

// Send the email
if (mail($to, $subject, $body, $headers)) {
    echo "Contract successfully sent to " . $to;
} else {
    echo "Failed to send email to " . $to;
}
?>
