<?php
class CivilStatus {

	public function getCivilStatusList(){
		$db = Database::getInstance();
		$sql = "SELECT id,status FROM civil_status";
		$result = $db->query($sql,false);
		return $result;
	}
}