<?php
class Encryption {

	private $encrypt_method;
	private $secret_key;
	private $secret_iv;
	private $key;
	private $iv;
	private $instance;

	public function __construct(){
		$this->encrypt_method = "AES-256-CBC";
		$this->secret_key = 'jpma';
		$this->secret_iv = 'jpma181';
		$this->key = hash('sha256', $this->secret_key);
		$this->iv = substr(hash('sha256', $this->secret_iv), 0, 16);
	}

	public function encrypt($string) {
        return base64_encode(openssl_encrypt($string, $this->encrypt_method, $this->key, 0, $this->iv));
	}

	public function decrypt($string) {
        return openssl_decrypt(base64_decode($string), $this->encrypt_method, $this->key, 0, $this->iv);
	}

}