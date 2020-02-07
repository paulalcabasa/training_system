<?php

class Connection {

	private $dsn = "mysql:host=localhost;dbname=sys_training";
	private $username = "root";
	private $password = "latropcpi";
	public $conn = null;

	public function __construct(){
		try {
			$this->conn = new PDO($this->dsn,$this->username,$this->password);
			$this->exec("set names utf8");
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
	}
	
	public function exec($str){
		return $this->conn->exec($str);
	}

	public function closeConnection(){
		$this->conn = null;
	}

	public function query($sql){
		return $this->conn->query($sql);
	}

	public function prepare($sql){
		return $this->conn->prepare($sql);
	}

	public function lastInsertId(){
		return $this->conn->lastInsertId();
	}

	public function diverse_array($vector) {
	    $result = array();
	    foreach($vector as $key1 => $value1)
	        foreach($value1 as $key2 => $value2)
	            $result[$key2][$key1] = $value2;
	    return $result;
	} 

	public function format_date($date){
		$date_create = date_create($date);
		$formatted_date = date_format($date_create,"F j, Y, g:i a");
		return $formatted_date;
	}

	public function format_date_only($date){
		$date_create = date_create($date);
		$formatted_date = date_format($date_create,"F j, Y");
		return $formatted_date;
	}

	public function getDateToday(){
		$now = new DateTime();
		$now->setTimezone(new DateTimeZone('Asia/Taipei'));
		$today = $now->format('Y-m-d H:i:s');
		return $today;
	}


	public function getDateOnlyToday(){
		$now = new DateTime();
		$now->setTimezone(new DateTimeZone('Asia/Taipei'));
		$today = $now->format('Y-m-d');
		return $today;
	}
    
    public function format_time_only($date){
		$date_create = date_create($date);
		$formatted_date = date_format($date_create,"g:i a");
		return $formatted_date;
	}


	public function encryptor($action, $string) {
	    $output = false;

	    $encrypt_method = "AES-256-CBC";
	    //pls set your unique hashing key
	    $secret_key = 'jpma';
	    $secret_iv = 'jpma181';

	    // hash
	    $key = hash('sha256', $secret_key);

	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);

	    //do the encyption given text/string/number
	    if( $action == 'encrypt' ) {
	        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	        $output = base64_encode($output);
	    }
	    else if( $action == 'decrypt' ){
	    	//decrypt the given text/string/number
	        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	    }

    	return $output;
	}

	public function makeUpperCase($str){
		return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
	}
	
	public function transformName1($fname,$mname,$lname,$name_ext,$conn){
		$mname = ($mname!="") ? substr($conn->makeUpperCase($mname),0,1) . ". " : "";
		$name_ext = ($name_ext!="") ? "," . ($name_ext) : "";
		$name =   $conn->makeUpperCase($fname) . " ".  $mname . $conn->makeUpperCase($lname) . $name_ext;
		return $name;
	}

	


}


?>