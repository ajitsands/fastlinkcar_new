<?php

class ClassDatabaseConnection
{
    public $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4",
            $_ENV['DB_USER'],
            $_ENV['DB_PASS'],
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]
        );
    }
}


// $apiKey = $_ENV['OPENAI_API_KEY'];

// function getPDO() {
//     $host = $_ENV['DB_HOST'] ?: '127.0.0.1';
//     $db   = $_ENV['DB_NAME'] ?: 'dbname';
//     $user = $_ENV['DB_USER'] ?: 'root';
//     $pass =  $_ENV['DB_PASS'] ?: 'nopassword';
//     $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
//     $opts = [
//         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//         PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
//     ];
//     return new PDO($dsn, $user, $pass, $opts);
// }
