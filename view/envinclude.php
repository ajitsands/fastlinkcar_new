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
}
?>