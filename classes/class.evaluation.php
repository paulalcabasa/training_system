<?php

class Evaluation {

	public function addCompetency($competency,$create_user){
		$db = Database::getInstance();
		$sequence_no = 1;
		$last_sequence_no_data = $this->getLastSequenceNo();
		if(!empty($last_sequence_no_data)){
			$last_sequence_no_data = (object)$last_sequence_no_data[0];
			$sequence_no = $last_sequence_no_data->sequence_no + 1;
		}	

		$sql = "INSERT INTO evaluation_competency_master(sequence_no,competency,create_user,date_created)
				VALUES(:sequence_no,:competency,:create_user,NOW())";
		$comptency_id = $db->query($sql,array(
											":sequence_no" => $sequence_no,
											":competency"  => $competency,
											":create_user" => $create_user	
										)
								  );
	}

	public function getLastSequenceNo(){
		$db = Database::getInstance();
		$sql = "SELECT sequence_no 
				FROM evaluation_competency_master
				WHERE  active = 1
				ORDER BY sequence_no DESC 
				LIMIT 1";
		$result = $db->query($sql,false);
		return $result;
	}

	public function getCompetencyList(){
		$db = Database::getInstance();
		$sql = "SELECT id,
					   sequence_no,
					   competency
				FROM evaluation_competency_master
				WHERE active = 1
				ORDER BY sequence_no ASC";
		$result = $db->query($sql,false);
		return $result;
	}

	public function updateCompetencySequence($competency_list,$update_user){
		$db = Database::getInstance();
		$sequence_no = 1;
		$sql = "UPDATE evaluation_competency_master 
				SET sequence_no = :sequence_no,
					update_user = :update_user,
					date_updated = NOW() 
				WHERE id = :id";
		foreach($competency_list as $competency){

			$db->query($sql,array(
								":sequence_no"	=>	$sequence_no,
								":update_user"	=>	$update_user,
								":id"			=>	$competency
							)
					  );
			$sequence_no++;
		}
	}

	public function updateCompetencyDescription($competency_id,$description,$update_user){
		$db = Database::getInstance();
		$sql = "UPDATE evaluation_competency_master
				SET competency = :competency,
					update_user = :update_user,
					date_updated = NOW()
				WHERE id = :competency_id";
		$db->query($sql,array(
							":competency" 		=> $description,
							":update_user" 		=> $update_user,
							":competency_id" 	=> $competency_id
						)
				  );
	}

	public function deactivateCompetency($competency_id,$update_user){
		$db = Database::getInstance();
		$sql = "UPDATE evaluation_competency_master SET active = 0,
					update_user = :update_user,
					date_updated = NOW()
				WHERE id = :competency_id";
		$db->query($sql,array(		
							":competency_id" => $competency_id,
							":update_user" => $update_user
						)
				  );
	}

	public function getRatingsList(){
		$db = Database::getInstance();
		$sql = "SELECT id,
					   sequence_no,
					   rating
				FROM evaluation_rating_master
				WHERE active = 1
				ORDER BY sequence_no ASC";
		$result = $db->query($sql,false);
		return $result;
	}

	public function getLastRatingNo(){
		$db = Database::getInstance();
		$sql = "SELECT sequence_no 
				FROM evaluation_rating_master
				WHERE  active = 1
				ORDER BY sequence_no DESC 
				LIMIT 1";
		$result = $db->query($sql,false);
		return $result;
	}

	public function addRating($rating,$create_user){
		$db = Database::getInstance();
		$sequence_no = 1;
		$last_sequence_no_data = $this->getLastRatingNo();
		if(!empty($last_sequence_no_data)){
			$last_sequence_no_data = (object)$last_sequence_no_data[0];
			$sequence_no = $last_sequence_no_data->sequence_no + 1;
		}	

		$sql = "INSERT INTO evaluation_rating_master(sequence_no,rating,create_user,date_created)
				VALUES(:sequence_no,:rating,:create_user,NOW())";
		$rating_id = $db->query($sql,array(
											":sequence_no" => $sequence_no,
											":rating"  => $rating,
											":create_user" => $create_user	
										)
								  );
	}

	public function updateRatingSequence($rating_list,$update_user){
		$db = Database::getInstance();
		$sequence_no = 1;
		$sql = "UPDATE evaluation_rating_master 
				SET sequence_no = :sequence_no,
					update_user = :update_user,
					date_updated = NOW() 
				WHERE id = :id";
		foreach($rating_list as $rating){

			$db->query($sql,array(
								":sequence_no"	=>	$sequence_no,
								":update_user"	=>	$update_user,
								":id"			=>	$rating
							)
					  );
			$sequence_no++;
		}
	}

	public function updateRatingDescription($rating_id,$description,$update_user){
		$db = Database::getInstance();
		$sql = "UPDATE evaluation_rating_master
				SET rating = :rating,
					update_user = :update_user,
					date_updated = NOW()
				WHERE id = :rating_id";
		$db->query($sql,array(
							":rating" 		=> $description,
							":update_user" 		=> $update_user,
							":rating_id" 	=> $rating_id
						)
				  );
	}

	public function deactivateRating($rating_id,$update_user){
		$db = Database::getInstance();
		$sql = "UPDATE evaluation_rating_master SET active = 0,
					update_user = :update_user,
					date_updated = NOW()
				WHERE id = :rating_id";
		$db->query($sql,array(		
							":rating_id" => $rating_id,
							":update_user" => $update_user
						)
				  );
	}

	public function getGradeByParticipant($tpm_grading_criteria_id,$tpa_id){
		$db = Database::getInstance();
		$sql = "SELECT id,grade
				FROM tpa_tpm_grade 
				WHERE tpm_grading_criteria_id = :tpm_grading_criteria_id 
					  AND training_program_attendee_id = :tpa_id";
		$result = $db->query($sql,array(
									":tpm_grading_criteria_id" => $tpm_grading_criteria_id,
									":tpa_id"				   => $tpa_id
								  )
							);
		return (object)$result[0];
	}

	public function updateParticipantGrade($tpa_tpm_id,$grade){
		$db = Database::getInstance();
		$sql = "UPDATE tpa_tpm_grade 
				SET grade = :grade
				WHERE id = :id";
		$result = $db->query($sql,array(
									":id" => $tpa_tpm_id,
									":grade" => $grade
								  )
							);
		return $result;
	}

	public function getParticipantEvaluationDetails($tpa_id,$tp_id,$competency_id){
		$db = Database::getInstance();
		$sql = "SELECT id,
					   tpa_id,
					   tp_id,
					   competency_id,
					   rating_id
				FROM tp_trainee_evaluation
				WHERE tpa_id = :tpa_id
					  AND tp_id = :tp_id
					  AND competency_id = :competency_id";
		$result = $db->query($sql,array(
									":tpa_id" 		 => $tpa_id,
									":tp_id"  		 => $tp_id,
									":competency_id" => $competency_id
								  )
							);
		return $result;
	}

	public function addParticipantEvaluation($tpa_id,$tp_id,$competency_id,$rating_id,$create_user){
		$db = Database::getInstance();
		$sql = "INSERT INTO tp_trainee_evaluation(tpa_id,tp_id,competency_id,rating_id,create_user,date_created)
				VALUES(:tpa_id,:tp_id,:competency_id,:rating_id,:create_user,NOW())";
		$result = $db->query($sql,array(
									":tpa_id" 		 => $tpa_id,
									":tp_id" 		 => $tp_id,
									":competency_id" => $competency_id,
									":rating_id" 	 => $rating_id,
									":create_user" 	 => $create_user
								  )
							);

	}

	public function updateParticipantEvaluation($tpa_id,$tp_id,$competency_id,$rating_id,$update_user){
		$db = Database::getInstance();
		$sql = "UPDATE tp_trainee_evaluation
				SET rating_id = :rating_id,
					update_user = :update_user,
					date_updated = NOW()
				WHERE tpa_id = :tpa_id
					  AND tp_id = :tp_id
					  AND competency_id = :competency_id";
		$result = $db->query($sql,array(
									":tpa_id" 		 => $tpa_id,
									":tp_id" 		 => $tp_id,
									":competency_id" => $competency_id,
									":rating_id" 	 => $rating_id,
									":update_user" 	 => $update_user
								  )
							);
		
	}

	public function getParticipantEvaluationDetailsAll($participant_id,$tp_id){
		$db = Database::getInstance();
		$sql = "SELECT id,
					   tpa_id,
					   tp_id,
					   competency_id,
					   rating_id
				FROM tp_trainee_evaluation
				WHERE tpa_id = :tpa_id AND tp_id = :tp_id";
		$result = $db->query($sql,array(
									":tpa_id" 		 => $participant_id,
									":tp_id"  		 => $tp_id
								  )
							);
		return $result;
	}


}