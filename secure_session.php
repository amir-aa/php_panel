<?php
require 'db.php';

class EncryptedSessionHandler extends SessionHandler {
    private $key;

    public function __construct($key) {
        $this->key = $key;
    }

    public function read($id) {
        $data = parent::read($id);
        return $data ? $this->decrypt($data) : '';
    }

    public function write($id, $data) {
        $data = $this->encrypt($data);
        return parent::write($id, $data);
    }

    private function encrypt($data) {
        $iv = random_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $this->key, 0, $iv);
        return base64_encode($iv . $encrypted);
    }

    private function decrypt($data) {
        $data = base64_decode($data);
        $iv = substr($data, 0, openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = substr($data, openssl_cipher_iv_length('aes-256-cbc'));
        return openssl_decrypt($encrypted, 'aes-256-cbc', $this->key, 0, $iv);
    }
}

$key = '%4dMerZqRp(p8896hJz1'; 
$handler = new EncryptedSessionHandler($key);
session_set_save_handler($handler, true);

session_start();
