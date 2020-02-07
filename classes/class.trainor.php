<?php
	
class Trainor {

	public function addTrainor($first_name,$middle_name,$last_name,$name_extension,$trainor_source_id,$create_user){
		$db = Database::getInstance();
		$sql = "INSERT INTO trainor(first_name,middle_name,last_name,name_extension,trainor_source_id,create_user,date_created) 
				VALUES(:first_name,:middle_name,:last_name,:name_extension,:trainor_source_id,:create_user,NOW())";
		$result = $db->query($sql,array(
									":first_name" => $first_name,
									":middle_name" => $middle_name,
									":last_name" =>$last_name,
									":name_extension" => $name_extension,
									":trainor_source_id" => $trainor_source_id,
									":create_user" => $create_user
								  )
							);
	}

	public function deleteTrainor($id){
		$conn = new Connection();
		$stmt = $conn->prepare("DELETE FROM trainor WHERE trainor_id = :trainor_id");
		$stmt->bindParam(":trainor_id",$id,PDO::PARAM_INT);
		$stmt->execute();
		$conn->closeConnection();
	}

	public function getTrainorInfo($id){
		$conn = new Connection();
		$stmt = $conn->prepare("SELECT * FROM trainor WHERE trainor_id = :trainor_id");
		$stmt->bindParam(":trainor_id",$id,PDO::PARAM_INT);
		$stmt->execute();
		$data = $stmt->fetch();
		$conn->closeConnection();
		return $data;
	}

	public function updateTrainor($id,$fname,$mname,$lname,$name_ext,$trainor_source_id,$user){
		$db = Database::getInstance();

		$sql = "UPDATE trainor SET first_name = :fname,
								   middle_name = :mname,
								   last_name = :lname,
								   name_extension = :name_ext,
								   update_user = :update_user,
								   trainor_source_id = :trainor_source_id,
								   date_updated = NOW()
				WHERE trainor_id = :trainor_id";

		$result = $db->query($sql,array(
									":fname" => $fname,
									":mname" => $mname,
									":lname" => $lname,
									":name_ext" => $name_ext,
									":update_user" => $user,
									":trainor_source_id" => $trainor_source_id,
									":trainor_id" => $id
								  )
							);
		
	}

	public function getTrainorOption(){
		$conn = new Connection();
		$stmt = $conn->prepare("SELECT a.trainor_id,a.first_name,a.middle_name,a.last_name,b.suffix FROM trainor a LEFT JOIN name_suffix b ON a.name_extension = b.id");
		$stmt->execute();
		$output = "";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$id = $row['trainor_id'];
			$name = $this->transformName1($row['first_name'],$row['middle_name'],$row['last_name'],$row['suffix'],$conn);
			$output .= "<option value='".$id."'>" . $name . "</option>";
		}
		return $output;
	}

	public function transformName1($fname,$mname,$lname,$name_ext,$conn){
		$mname = ($mname!="") ? substr($conn->makeUpperCase($mname),0,1) . ". " : "";
		$name_ext = ($name_ext!="") ? "," . ($name_ext) : "";
		$name =   $conn->makeUpperCase($fname) . " ".  $mname . $conn->makeUpperCase($lname) . $name_ext;
		return $name;
	}

	public function getTrainorSources(){
		$db = Database::getInstance();
		$sql = "SELECT id,
					   source_name
				FROM trainor_source
				ORDER BY source_name ASC";
		$result = $db->query($sql,false);
		return $result;
	}

	public function addTrainorSource($source_name){
		$db = Database::getInstance();
		$sql = "INSERT INTO trainor_source(source_name) VALUES(:source_name)";
		$result = $db->query($sql,array(":source_name"=>$source_name));
	}

	public function getTrainorDetails($trainor_id){
		$db = Database::getInstance();
		$sql = "SELECT a.trainor_id,
				       a.first_name,
				       a.middle_name,
				       a.last_name,
				       a.name_extension,
				       a.trainor_source_id,
				       b.source_name 
				FROM trainor a LEFT JOIN trainor_source b 
					ON a.trainor_source_id = b.id
				WHERE trainor_id = :trainor_id";
		$result = $db->query($sql,array(":trainor_id"=>$trainor_id));
		return (object)$result[0];
	}

	public function getTrainorList(){
		$db = Database::getInstance();
		$sql = "SELECT a.trainor_id,
					FormatLastNameFirst(a.first_name,a.middle_name,a.last_name,b.suffix) trainor_name,
					c.source_name trainor_source
				FROM trainor a
				    LEFT JOIN name_suffix b
				      ON a.name_extension = b.id
				   LEFT JOIN trainor_source c
				     ON c.id = a.trainor_source_id";
		$result = $db->query($sql,false);
		return $result;
	}
}

?>