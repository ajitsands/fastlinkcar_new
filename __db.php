<?php
require_once __DIR__ . '/envfiles/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['OPENAI_API_KEY'];

function getPDO() {
    $host = $_ENV['DB_HOST'] ?: '127.0.0.1';
    $db   = $_ENV['DB_NAME'] ?: 'meeting_ai';
    $user = $_ENV['DB_USER'] ?: 'root';
    $pass =  $_ENV['DB_PASS'] ?: '';
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $opts = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
    ];
    return new PDO($dsn, $user, $pass, $opts);
}
