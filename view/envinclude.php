<?php
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', realpath(__DIR__ . '/..'));
}

// Only attempt to load if not already initialized by index.php
if (empty($_ENV['MAINSERVER']) || empty($_ENV['DB_NAME'])) {
    $envDir  = file_exists(ROOT_PATH . '/envfiles/.env') ? (ROOT_PATH . '/envfiles') : ROOT_PATH;
    $envFile = $envDir . '/.env';
    if (file_exists(ROOT_PATH . '/envfiles/vendor/autoload.php')) {
        require_once ROOT_PATH . '/envfiles/vendor/autoload.php';
        if (file_exists($envFile)) {
            try {
                $dotenv = Dotenv\Dotenv::createImmutable($envDir);
                $dotenv->load();
            } catch (Throwable $e) {
                // Ignore if already loaded or fallback
            }
        }
    }
    // Safe fallback if vendor or dotenv is missing
    if (file_exists($envFile) && function_exists('loadEnvironmentVariables')) {
        loadEnvironmentVariables($envFile);
    }

    if (!empty($_SERVER['HTTP_HOST'])) {
        $reqHostLow = strtolower(explode(':', $_SERVER['HTTP_HOST'])[0]);
        if ($reqHostLow !== 'localhost' && $reqHostLow !== '127.0.0.1') {
            $_ENV['DB_HOST'] = $_ENV['SERVER_DB_HOST'] ?? 'localhost';
            $_ENV['DB_NAME'] = $_ENV['SERVER_DB_NAME'] ?? 'fastlinkpayment_carrental_db_new';
            $_ENV['DB_USER'] = $_ENV['SERVER_DB_USER'] ?? 'fastlinkpayment_carrental_db_new_user';
            $_ENV['DB_PASS'] = $_ENV['SERVER_DB_PASS'] ?? 'S@nds1@b';
        }
    }
}
?>