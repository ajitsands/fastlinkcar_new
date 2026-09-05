<?php
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
} elseif (file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    require_once dirname(__DIR__) . '/vendor/autoload.php';
} elseif (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
}

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTClass
{
    private $secret_key;
    private $issuer;
    private $ip;

    public function __construct($key,$issuer,$users)
    {
        $this->secret_key = $key;
        $this->issuer = $issuer;
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }

    /* CREATE TOKEN */
    public function CreateJWToken($company_id, $username, $userId,$password, $status, $expiry_seconds = 3600)
    {
        $issued_at = time();
        $expire = $issued_at + $expiry_seconds;

        $payload = [
            "iss" => $this->issuer,
            "ip" => $this->ip,
            "iat" => $issued_at,
            "exp" => $expire,
            "token" => [
                "company_id" => $company_id,
                "user_id" => $userId,
                "username"   => $username,
                "password" => $password,
                "status"     => $status
            ]
        ];

        return JWT::encode($payload, $this->secret_key, 'HS256');
    }

    /* READ / DECODE TOKEN */
    public function ReadJWToken($token)
    {
        try {

            $decoded = JWT::decode($token, new Key($this->secret_key, 'HS256'));

            return [
                "status" => true,
                "data" => $decoded
            ];

        } catch (Exception $e) {

            return [
                "status" => false,
                "message" => $e->getMessage()
            ];
        }
    }
}