<?php
/**
 * GitHub Deployment Webhook
 * 
 * Automatically pulls the latest code from the 'main' branch when a push event occurs.
 */

// Your secret key ("accesskey" as requested)
$secret = 'accesskey';

// The directory of your repository (the directory containing this script)
$repo_dir = __DIR__;

// Log file for troubleshooting
$log_file = $repo_dir . '/webhook.log';

function write_log($msg) {
    global $log_file;
    file_put_contents($log_file, date('Y-m-d H:i:s') . " - " . $msg . "\n", FILE_APPEND);
}

write_log("==== Webhook triggered ====");

// Get the payload and GitHub's signature
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? $_SERVER['HTTP_X_HUB_SIGNATURE'] ?? '';

// Check if a signature was provided
if (empty($signature)) {
    write_log("Error: Signature header is missing.");
    http_response_code(403);
    die("Forbidden: Missing signature. Make sure to configure the secret in GitHub webhook settings.");
}

// Calculate the expected signature
// GitHub uses sha256 by default now (HTTP_X_HUB_SIGNATURE_256)
if (strpos($signature, 'sha256=') === 0) {
    $expected_hash = 'sha256=' . hash_hmac('sha256', $payload, $secret);
} else {
    // Fallback for older sha1 (HTTP_X_HUB_SIGNATURE)
    $expected_hash = 'sha1=' . hash_hmac('sha1', $payload, $secret);
}

// Verify the signature securely
if (!hash_equals($expected_hash, $signature)) {
    write_log("Error: Signature verification failed.");
    http_response_code(403);
    die("Forbidden: Invalid signature.");
}

write_log("Signature verified successfully. Pulling latest code...");

// Change to repository directory
chdir($repo_dir);

// Execute git commands
$output = [];
$return_var = 0;

// Fetch and reset is safer than a raw pull as it ignores local modifications
exec('git fetch --all 2>&1', $output, $return_var);
exec('git reset --hard origin/main 2>&1', $output, $return_var);

$log_output = implode("\n", $output);
write_log("Git Output:\n" . $log_output);

if ($return_var === 0) {
    write_log("Deployment successful.");
    echo "Deployment successful.\n";
    echo $log_output;
} else {
    write_log("Deployment failed with exit code $return_var.");
    http_response_code(500);
    echo "Deployment failed.\n";
    echo $log_output;
}
?>