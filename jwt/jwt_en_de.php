<?php
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
} elseif (file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    require_once dirname(__DIR__) . '/vendor/autoload.php';
} elseif (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
}

class JWTClass
{
    private $secret_key;
    private $issuer;
    private $ip;

    public function __construct($key, $issuer, $users = null)
    {
        $this->secret_key = $key;
        $this->issuer = $issuer;
        $this->ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }

    private static function base64UrlEncode($data)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    private static function base64UrlDecode($data)
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
    }

    /* CREATE TOKEN */
    public function CreateJWToken($company_id, $username, $userId, $password, $status, $expiry_seconds = 3600)
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

        if (class_exists('Firebase\JWT\JWT') && class_exists('Firebase\JWT\Key')) {
            return \Firebase\JWT\JWT::encode($payload, $this->secret_key, 'HS256');
        }

        // Native fallback for HS256 JWT encoding
        $header = self::base64UrlEncode(json_encode(["typ" => "JWT", "alg" => "HS256"]));
        $body = self::base64UrlEncode(json_encode($payload));
        $signature = self::base64UrlEncode(hash_hmac('sha256', "$header.$body", $this->secret_key, true));

        return "$header.$body.$signature";
    }

    /* READ / DECODE TOKEN */
    public function ReadJWToken($token)
    {
        try {
            if (class_exists('Firebase\JWT\JWT') && class_exists('Firebase\JWT\Key')) {
                $decoded = \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key($this->secret_key, 'HS256'));
                return [
                    "status" => true,
                    "data" => $decoded
                ];
            }

            // Native fallback for HS256 JWT decoding
            $parts = explode('.', $token);
            if (count($parts) !== 3) {
                return ["status" => false, "message" => "Invalid token format"];
            }

            list($headerB64, $payloadB64, $sigB64) = $parts;
            $expectedSig = self::base64UrlEncode(hash_hmac('sha256', "$headerB64.$payloadB64", $this->secret_key, true));

            if (!hash_equals($expectedSig, $sigB64)) {
                return ["status" => false, "message" => "Signature verification failed"];
            }

            $decoded = json_decode(self::base64UrlDecode($payloadB64));
            if ($decoded === null) {
                return ["status" => false, "message" => "Invalid token payload"];
            }

            if (isset($decoded->exp) && time() >= $decoded->exp) {
                return ["status" => false, "message" => "Expired token"];
            }

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