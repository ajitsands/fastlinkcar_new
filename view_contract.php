<?php
// view_contract.php - Decodes token from WhatsApp link and redirects to view the PDF

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Add back Base64 padding
    $padLength = 4 - (strlen($token) % 4);
    if ($padLength < 4) {
        $token .= str_repeat('=', $padLength);
    }
    
    // Decode URL-safe Base64
    $decoded = base64_decode(strtr($token, '-_', '+/'));
    
    // Extract IV and Encrypted Data
    $iv_length = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($decoded, 0, $iv_length);
    $encrypted = substr($decoded, $iv_length);
    
    $key = 'AA_CAR_RENTAL_SECRET_KEY_2026';
    
    // Decrypt
    $contract_no = openssl_decrypt($encrypted, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    
    if ($contract_no) {
        // Securely pass the decrypted contract number to the PDF engine
        $_GET['contract_no'] = $contract_no;
        
        // Emulate view mode
        $params['view'] = 'true';
        
        // Load the PDF generator internally so the browser URL never changes
        chdir(__DIR__ . '/pdf');
        require_once 'generate_contract.php';
        exit;
    }
}

echo "<h1>Invalid or Expired Contract Link.</h1>";
exit;
?>
