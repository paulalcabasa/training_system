<?php
class Phzipcode {
	public function getProvincesList(){
		$db = Database::getInstance();
		$sql = "SELECT * FROM province ORDER BY province_name ASC";
		$result = $db->query($sql,false);
		return $result;
	}

	public function getMunicipalitiesList($province_id){
	/*	$conn = new Connection();

		$output = "<option value=''>Select Municipality</option>";
		$stmt = $conn->prepare("SELECT * FROM municipality WHERE province_id = :id ORDER BY municipality_name ASC");
		$stmt->bindParam(":id",$province_id,PDO::PARAM_INT);
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$zip_code = $row['zip_code'];
			$output .= "<option value='".$row['id']."' data-zip_code='$zip_code'>" . $row['municipality_name']  . "</option>";
		}
		$conn->closeConnection();

		return $output;*/
		$db = Database::getInstance();
		$sql = "SELECT * FROM municipality WHERE province_id = :id ORDER BY municipality_name ASC";
		$result = $db->query($sql,array(":id"=>$province_id));
		return $result;
	}

	
}
?>