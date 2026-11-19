<?php
/**
 * Router script for PHP's built-in development server (php -S).
 * Mirrors the rewrite rules in .htaccess.
 */
$uriPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$decodedPath = urldecode($uriPath);
$filePath = __DIR__ . $decodedPath;

// Serve existing files directly
if ($decodedPath !== '/' && is_file($filePath)) {
    return false;
}

// Mirror .htaccess: RewriteRule ^assets/vendor/(.*)$ dist/$1 [L,NC]
if (preg_match('#^/assets/vendor/(.*)$#i', $decodedPath, $matches)) {
    $distPath = __DIR__ . '/dist/' . $matches[1];
    if (is_file($distPath)) {
        $ext = strtolower(pathinfo($distPath, PATHINFO_EXTENSION));
        $mimeTypes = [
            'css'   => 'text/css',
            'js'    => 'application/javascript',
            'json'  => 'application/json',
            'svg'   => 'image/svg+xml',
            'png'   => 'image/png',
            'jpg'   => 'image/jpeg',
            'jpeg'  => 'image/jpeg',
            'gif'   => 'image/gif',
            'woff'  => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf'   => 'font/ttf',
            'eot'   => 'application/vnd.ms-fontobject',
            'map'   => 'application/json',
        ];
        if (isset($mimeTypes[$ext])) {
            header('Content-Type: ' . $mimeTypes[$ext]);
        }
        readfile($distPath);
        return true;
    }
}

// Route everything else to index.php?url=...
$url = ltrim($decodedPath, '/');
if ($url !== '') {
    $_GET['url'] = $url;
}

require __DIR__ . '/index.php';
