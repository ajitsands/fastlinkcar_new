<?php
// Fix for TCPDF missing cURL constants on some setups without the cURL extension
if (!extension_loaded('curl')) {
    $curl_constants = [
        'CURLOPT_CONNECTTIMEOUT', 'CURLOPT_TIMEOUT', 'CURLOPT_MAXREDIRS', 
        'CURLOPT_FOLLOWLOCATION', 'CURLOPT_URL', 'CURLOPT_RETURNTRANSFER',
        'CURLOPT_SSL_VERIFYPEER', 'CURLOPT_SSL_VERIFYHOST', 'CURLOPT_USERAGENT',
        'CURLINFO_HTTP_CODE', 'CURLOPT_HTTPGET', 'CURLOPT_POST', 'CURLOPT_POSTFIELDS',
        'CURLOPT_PROTOCOLS', 'CURLPROTO_HTTPS', 'CURLPROTO_HTTP', 'CURLPROTO_FTP', 
        'CURLPROTO_FTPS', 'CURLOPT_FAILONERROR'
    ];
    foreach ($curl_constants as $c) {
        if (!defined($c)) define($c, 1);
    }
}

// Load autoloader from pdf/vendor, root vendor, or envfiles
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../envfiles/vendor/autoload.php')) {
    require_once __DIR__ . '/../envfiles/vendor/autoload.php';
} elseif (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
}

if (!class_exists('TCPDF')) {
    if (file_exists(__DIR__ . '/vendor/tecnickcom/tcpdf/tcpdf.php')) {
        require_once __DIR__ . '/vendor/tecnickcom/tcpdf/tcpdf.php';
    }
}
