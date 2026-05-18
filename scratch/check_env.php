<?php
require_once dirname(__DIR__) . '/envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__) . '/envfiles');
$dotenv->load();
echo "BASE_URL: " . $_ENV['BASE_URL'] . "\n";
?>
