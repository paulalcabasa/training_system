<?php
class Attendance {

	public function addAttendance($tp_id,$module_id,$selected_trainees,$attendance_date,$create_user){
		$db = Database::getInstance();

		$sql = "INSERT INTO tp_trainee_attendance(tp_id,tpm_module_id,trainee_id,time_in,create_user,date_created) 
								VALUES(:tp_id,:module_id,:trainee_id,:time_in,:create_user,NOW())";
		foreach($selected_trainees as $t){
			$db->query($sql,array(
								":tp_id"	   => $tp_id,
								":module_id"   => $module_id,
								":trainee_id"  => $t,
								":time_in"	   => $attendance_date,
								":create_user" => $create_user
						 	)
			  		  );
		}
	}
	
	public function getAttendanceDetailsById($id){
		$db = Database::getInstance();
		$sql = "SELECT a.id,
				       a.tp_id,
				       a.tpm_module_id,
				       FormatTraineeId(b.trainee_code,d.dealer_abbrev) trainee_id,
				       FormatLastNameFirst(b.first_name,b.middle_name,b.last_name,c.suffix) trainee_name,
				       d.dealer_name,
				       a.time_in
				FROM tp_trainee_attendance a LEFT JOIN trainees_masterfile b
					ON a.trainee_id = b.trainee_code 
				     LEFT JOIN name_suffix c
					ON c.id = b.name_suffix_id
				     LEFT JOIN dealers_master d
					ON d.id = b.dealer_id
				WHERE a.id = :id";
		$result = $db->query($sql,array(":id" => $id));
		return (object)$result[0];
	}

	public function deleteAttendance($id){
		$db = Database::getInstance();
		$sql = "DELETE FROM tp_trainee_attendance WHERE id = :id";
		$result = $db->query($sql,array(":id" => $id));
	}

	public function updateAttendance($id,$date,$update_user){
		$db = Database::getInstance();
		$sql = "UPDATE tp_trainee_attendance 
				SET time_in = :time_in,
					update_user = :update_user,
					date_updated = NOW()
				WHERE id = :id";
		$db->query($sql,array(
							":time_in"		=>	$date,
							":update_user"	=>	$update_user,
							":id"			=>	$id
						)
				  );
	}
}