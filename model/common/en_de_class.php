<?php
// Example usage of UrlEncryption class
class UrlEncryption
{
    private $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function encrypt($data)
    {
        $iv = substr($this->key, 0, 16);
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $this->key, 0, $iv);
        return urlencode(base64_encode($encrypted));
    }

    public function decrypt($data)
    {
        $iv = substr($this->key, 0, 16);
        $decoded = base64_decode(urldecode($data));
        return openssl_decrypt($decoded, 'aes-256-cbc', $this->key, 0, $iv);
    }
}


class EncryptionHelper {
    private $cipher = 'AES-128-CTR'; // Cipher method
    private $options = 0;
   
   
    // Encrypt function
    public function encrypt($data, $secretKey='1234567890123456') {
        $ivLength = openssl_cipher_iv_length($this->cipher); // Get the initialization vector length
        $iv = openssl_random_pseudo_bytes($ivLength); // Generate an IV

        // Encrypt the data
        $encryptedData = openssl_encrypt($data, $this->cipher, $secretKey, $this->options, $iv);

        // Base64 encode the IV and encrypted data, and make it URL-safe
        $base64 = base64_encode($iv . $encryptedData);
        $urlSafeEncryptedData = str_replace(['+', '/', '='], ['-', '_', ''], $base64); // Make URL-safe

        return $urlSafeEncryptedData;
    }

    // Decrypt function
   public function decrypt($encryptedData, $secretKey='1234567890123456') {
        // Reverse the URL-safe encoding
        $base64 = str_replace(['-', '_'], ['+', '/'], $encryptedData);

        // Base64 decode the encrypted data
        $encryptedData = base64_decode($base64);
        $ivLength = openssl_cipher_iv_length($this->cipher); // Get the IV length

        // Extract the IV and encrypted data
        $iv = substr($encryptedData, 0, $ivLength);
        $ciphertext = substr($encryptedData, $ivLength);

        // Decrypt the data
        return openssl_decrypt($ciphertext, $this->cipher, $secretKey, $this->options, $iv);
    }
}
?>