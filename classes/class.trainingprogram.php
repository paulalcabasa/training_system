<?php
class TrainingProgram {
	
	public function getTrainingProgramAttendees($training_program_id){
		$db = Database::getInstance();
		$sql = "SELECT a.id, 
					   a.trainee_id,
				 	   FormatLastNameFirst(b.first_name,b.middle_name,b.last_name,c.suffix) trainee_name,
				       FormatTraineeId(a.trainee_id,d.dealer_abbrev) trainee_code
				FROM training_program_attendees a LEFT JOIN trainees_masterfile b 
					ON a.trainee_id = b.trainee_code 
				     LEFT JOIN name_suffix c 
				        ON c.id = b.name_suffix_id
				     LEFT JOIN dealers_master d
				        ON d.id = b.dealer_id
				WHERE a.training_program_id = :training_program_id AND b.date_deleted IS NULL
				ORDER BY trainee_name ASC";
		$result = $db->query($sql,array(":training_program_id"=>$training_program_id));
		return $result;
	}

	public function createTrainingProgram($program_id,$trainor_id,$venue,$start_date,$end_date,$user,$modules_list){
		$db = Database::getInstance();
		$sql = "INSERT INTO training_programs(program_id,trainor_id,venue,start_date,end_date,create_user,date_created) 
				VALUES(:program_id,:trainor_id,:venue,:start_date,:end_date,:create_user,NOW())";
		$tp_id = $db->query($sql,array(
					":program_id"  => $program_id,
					":trainor_id"  => $trainor_id,
					":venue" 	   => $venue,
					":start_date"  => $start_date,
					":end_date"    => $end_date,
					":create_user" => $user
				  )
			);

		$sql = "INSERT INTO training_program_modules(training_program_id,module_name,orig_module_id)
				VALUES(:tp_id,:module_name,:orig_module_id)";
		foreach($modules_list as $module){
			$module = (object)$module;
			$db->query($sql,array(
								":tp_id" 			=> $tp_id,
								":module_name" 		=> $module->module_name,
								":orig_module_id" 	=> $module->module_id
							)
					  );
		}
	}

	public function getTrainingPrograms(){
		$db = Database::getInstance();
		$sql = "SELECT t.first_name,
					   t.middle_name,
					   t.last_name,
					   t.name_extension,
					   p.title,
					   tp.start_date,
					   tp.end_date,
					   tp.venue,
					   tp.training_program_id,
					   ns.suffix
				FROM training_programs AS tp INNER JOIN program AS p ON tp.program_id = p.program_code
					INNER JOIN trainor AS t ON t.trainor_id = tp.trainor_id
					LEFT JOIN name_suffix ns ON t.name_extension = ns.id
					ORDER BY tp.date_created ASC";
		return $db->query($sql,false);
	}


    public function getTraineesListPerTrainingProgram($training_program_id){
    	$db = Database::getInstance();
    	$sql = "SELECT a.id,
				       a.training_program_id,
				       b.trainee_code,
				       FormatTraineeId(b.trainee_code,b.dealer_id,b.dealer_category) trainee_id,
				       FormatFirstNameFirst(b.first_name,b.middle_name,b.last_name,c.suffix) trainee_name,
				       GetDealerName(b.dealer_id,b.dealer_category) dealer_name,
				       d.job_description
				FROM training_program_attendees a LEFT JOIN trainees_masterfile b
				      ON a.trainee_id = b.trainee_code
				     LEFT JOIN name_suffix c ON c.id = b.name_suffix_id
				     LEFT JOIN job_position d ON d.job_id = b.job_position
				WHERE b.isDeleted IS NULL AND a.training_program_id = :training_program_id";
		$result = $db->query($sql,false);
		return $result;
    }

    public function checkTraineeExistenceForTrainingProgram($trainee_code,$tp_id){
		$db = Database::getInstance();
		$sql = "SELECT COUNT(trainee_id) count 
				FROM training_program_attendees 
				WHERE training_program_id = :tp_id AND trainee_id = :trainee_id";
		$result = $db->query($sql,array(":tp_id"=>$tp_id,":trainee_id"=>$trainee_code));
		$data = (object)$result[0];
		return $data->count;
	}

	public function getTrainingProgramDetails($training_program_id){
		$db = Database::getInstance();
		$sql = "SELECT a.training_program_id,
				       a.program_id,
				       b.title,
				       a.venue,
				       a.start_date,
				       a.end_date,
				       b.objectives,
				       b.description,
				       a.trainor_id,
				       FormatTrainingProgramId(a.training_program_id,a.date_created) tp_id,
				       FormatFirstNameFirst(c.first_name,c.middle_name,c.last_name,d.suffix) trainor_name
				FROM training_programs a LEFT JOIN program b 
				      ON a.program_id = b.program_code
				     LEFT JOIN trainor c ON c.trainor_id = a.trainor_id
				     LEFT JOIN name_suffix d ON d.id = c.name_extension
				WHERE a.training_program_id = :training_program_id";
		$result = $db->query($sql,array(":training_program_id"=>$training_program_id));
		$data = (object)$result[0];
		return $data;
	}

	public function addTraineInTrainingProgram($trainee_id,$tp_id,$user){
		$db = Database::getInstance();
		$sql = "INSERT INTO training_program_attendees(training_program_id,trainee_id,create_user,date_created)
				VALUES(:training_program_id,:trainee_id,:create_user,NOW())";
		$result = $db->query($sql,array(
									":training_program_id" => $tp_id,
									":trainee_id" => $trainee_id,
									":create_user" => $user
								  )
							);
		return $result;
	}

	private function getIntersection($a1,$a2,$b1,$b2){
		$a1 = strtotime($a1);
		$a2 = strtotime($a2);
		$b1 = strtotime($b1);
		$b2 = strtotime($b2);
		if($b1 > $a2 || $a1 > $b2 || $a2 < $a1 || $b2 < $b1)
		{
			return false;
		}
		$start = $a1 < $b1 ? $b1 : $a1;
		$end = $a2 < $b2 ? $a2 : $b2;

		return array('start' => $start, 'end' => $end);
	}

	public function checkSchedule($trainee_code,$tp_id){
		$db = Database::getInstance();

		$selected_tp = $this->getTrainingProgramDetails($tp_id);
		$start_date = $selected_tp->start_date;
		$end_date = $selected_tp->end_date;
		$daterange1 = array($start_date, $end_date);
		$ctr = 0;
	
		$sql_trainings_assigned = "SELECT a.id,
										  a.training_program_id,
										  b.start_date,
										  b.end_date 
								   FROM training_program_attendees a LEFT JOIN training_programs b
								   			ON a.training_program_id = b.training_program_id
								   WHERE a.trainee_id = :trainee_id AND a.training_program_id <> :tp_id";
		$trainings_assigned = $db->query($sql_trainings_assigned,array(":trainee_id"=>$trainee_code,":tp_id"=>$tp_id));
		foreach($trainings_assigned as $trainings){
			$trainings = (object)$trainings;
			$intersection = $this->getIntersection(
				$start_date,
				$end_date,
				$trainings->start_date,
				$trainings->end_date
			);

			if($intersection !== false){
				$ctr++;
			} 
		}
		return $ctr;
	}

	public function getTrainingProgramModule($tp_id){
		$db = Database::getInstance();
		$sql = "SELECT id,
					   module_name,
					   passing_score
				FROM training_program_modules
				WHERE training_program_id = :tp_id";
		$result = $db->query($sql,array(":tp_id" => $tp_id));
		return $result;
	}

	public function getTPMCriteriaList($tpm_id){
		$db = Database::getInstance();
		$sql = "SELECT id,
					   tpm_module_id,
					   criteria_name,
					   percentage
				FROM tpm_grading_criteria
				WHERE tpm_module_id = :tpm_id AND active = 1";
		$result = $db->query($sql,array(":tpm_id"=>$tpm_id));
		return $result;
	}

	public function addTPMCriteria($module_id,$criteria,$percentage,$create_user){
		$db = Database::getInstance();
		$sql = "INSERT INTO tpm_grading_criteria(tpm_module_id,criteria_name,percentage,create_user,date_created)
				VALUES(:tpm_module_id,:criteria_name,:percentage,:create_user,NOW())";
		$db->query($sql,array(
							":tpm_module_id" => $module_id,
							":criteria_name" => $criteria,
							":percentage" => $percentage,
							":create_user" => $create_user
						)
				  );
	}

	public function updateTPMCriteria($criteria_id,$criteria,$percentage,$update_user){
		$db = Database::getInstance();
		$sql = "UPDATE tpm_grading_criteria 
				SET criteria_name = :criteria,
					percentage = :percentage,
					update_user = :update_user,
					date_updated = NOW()
				WHERE id = :criteria_id";
		$db->query($sql,array(
							":criteria" => $criteria,
							":percentage" => $percentage,
							":update_user" => $update_user,
							":criteria_id" => $criteria_id
						)
				  );
	}

	public function deleteTPMCriteria($criteria_id,$update_user){
		$db = Database::getInstance();
		$sql = "UPDATE tpm_grading_criteria 
				SET active = 0,
					update_user = :update_user,
					date_updated = NOW()
				WHERE id = :criteria_id";
		$db->query($sql,array(
							":criteria_id" => $criteria_id,
							":update_user" => $update_user
						)
				  );
	}

	public function updateTrainingProgramInfo($tp_id,$trainor_id,$venue,$start_date,$end_date,$update_user){
		$db = Database::getInstance();
		$sql = "UPDATE training_programs 
				SET trainor_id = :trainor_id,
					venue = :venue,
					start_date = :start_date,
					end_date = :end_date, 
					update_user = :update_user 
				WHERE training_program_id = :training_program_id";
		$db->query($sql,array(
							":trainor_id" 		   => $trainor_id,
							":venue"	  		   => $venue,
							":start_date" 		   => $start_date,
							":end_date"   		   => $end_date,
							":update_user" 		   => $update_user,
							":training_program_id" => $tp_id
						)
				  );
	}

	public function changeTrainingProgram($tp_id,$program_id,$exams_list,$modules_list,$tpm_list,$update_user){
		$db = Database::getInstance();

		// change program
		$update_program_sql = "UPDATE training_programs 
							   SET program_id = :program_id,
							   	   update_user = :update_user,
							   	   date_updated = NOW() 
							   WHERE training_program_id = :tp_id";
		$db->query($update_program_sql,array(
									   		":program_id"  => $program_id,
									   		":tp_id"	   => $tp_id,
									   		":update_user" => $update_user
									   )
				  );

	
		// delete training program attendees
		$db->query("DELETE 
					FROM training_program_attendees 
					WHERE training_program_id = :tp_id",array(":tp_id" => $tp_id));

		// delete trainee attendance
		$db->query("DELETE 
					FROM tp_trainee_attendance 
					WHERE tp_id = :tp_id",array(":tp_id" => $tp_id));

		$delete_exam_answer_sql = "DELETE a 
								   FROM trainee_exam_answers a LEFT JOIN trainee_exam_taken b
										ON a.trainee_exam_taken_id = b.id
								   WHERE b.exam_id = :exam_id";
		$delete_exam_taken_sql = "DELETE FROM trainee_exam_taken WHERE exam_id = :id";
		// exams list
		foreach($exams_list as $e){
			$e = (object)$e;
			$db->query($delete_exam_answer_sql,array(":exam_id" => $e->exam_id));
		}
		foreach($exams_list as $e){
			$e = (object)$e;
			$db->query($delete_exam_taken_sql,array(":id" => $e->exam_id));
		}


		// modules list
		$delete_modules_sql = "DELETE FROM tpm_grading_criteria WHERE tpm_module_id = :id";
		foreach ($modules_list as $m) {
			$m = (object)$m;
			$db->query($delete_modules_sql,array(":id"=>$m->id));
		}

		// delete program_modules
		$db->query("DELETE FROM training_program_modules WHERE training_program_id = :tp_id",array(":tp_id" => $tp_id));

		// delete exam choices
		$db->query("SELECT a.exam_id,a.item_id,b.tp_id,a.question
					FROM tp_exam_items a LEFT JOIN tp_exam b 
							ON a.exam_id = b.exam_id 
						LEFT JOIN tp_exam_choices c 
							ON c.item_id = a.item_id
					WHERE b.tp_id = :tp_id",array(":tp_id" => $tp_id));

		// delete exam items
		$db->query("DELETE a 
					FROM tp_exam_items a LEFT JOIN tp_exam b 
					ON a.exam_id = b.exam_id 
					WHERE b.tp_id = :tp_id",array(":tp_id" => $tp_id));

		// delete exam
		$db->query("DELETE 
					FROM tp_exam 
					WHERE tp_id = :tp_id",array(":tp_id" => $tp_id));

		// insert new modules
		$insert_tpm_modules = "INSERT INTO training_program_modules(training_program_id,module_name,orig_module_id)
							   VALUES(:tp_id,:module_name,:orig_module_id)";
		foreach($tpm_list as $module){
			$module = (object)$module;
			$db->query($insert_tpm_modules,array(
								":tp_id" 			=> $tp_id,
								":module_name" 		=> $module->module_name,
								":orig_module_id" 	=> $module->module_id
							)
					  );
		}

	}

	public function getTraineeParticipantDetails($tp_id,$participant_id){
		$db = Database::getInstance();
		$sql = "SELECT id,
					   training_program_id,
					   trainee_id,
					   final_standing
				FROM training_program_attendees
				WHERE id = :participant_id AND training_program_id = :tp_id";
		$result = $db->query($sql,array(
								  	":participant_id" => $participant_id,
								  	":tp_id"		  => $tp_id
								  )
							);
		return (object)$result[0];
	}

	public function getGradingCriteriaPerTrainingProgram($training_program_id){
		$db = Database::getInstance();
		$sql = "SELECT tpm.id tpm_id,
				       tgc.id training_program_grading_criteria_id
				FROM training_program_modules tpm LEFT JOIN tpm_grading_criteria tgc
					ON tpm.id = tgc.tpm_module_id
				WHERE tpm.training_program_id = :training_program_id";
		$result = $db->query($sql,array(
									":training_program_id" => $training_program_id
								  )
							);
		return $result;
	}

	public function addParticipantGradeByCriteria($tpm_grading_criteria_id,$tpa_id,$user){
		$db = Database::getInstance();
		$grade = 0;
		$sql = "INSERT INTO tpa_tpm_grade(tpm_grading_criteria_id,training_program_attendee_id,grade,create_user,date_created)
				VALUES(:tpm_grading_criteria_id,:training_program_attendee_id,:grade,:create_user,NOW())";
		$result = $db->query($sql,array(
									":tpm_grading_criteria_id" 		=> $tpm_grading_criteria_id,
									":training_program_attendee_id" => $tpa_id,
									":grade" 						=> $grade,
									":create_user" 					=> $user
								  )
							);
	}

	public function getTrainingProgramModuleDetails($tpm_id){
		$db = Database::getInstance();
		$sql = "SELECT id,
					   module_name,
					   passing_score,
					   training_program_id
				FROM training_program_modules
				WHERE id = :tpm_id";
		$result = $db->query($sql,array(":tpm_id" => $tpm_id));
		return $result;
	}

	public function updateTPModulePassingScore($module_id,$passing_score){
		$db = Database::getInstance();
		$sql = "UPDATE training_program_modules
				SET passing_score = :passing_score
				WHERE id = :id";
		$result = $db->query($sql,array(
									":passing_score" => $passing_score, 
									":id" 			 => $module_id
							 	  )
							);
		return $result;
	}

	public function updateFinalStanding($attendee_id,$final_standing){
		$db = Database::getInstance();
		$sql = "UPDATE training_program_attendees
				SET final_standing = :final_standing
				WHERE id = :id";
		$result = $db->query($sql,array(
									":final_standing" => $final_standing, 
									":id" 			 => $attendee_id
							 	  )
							);
		return $result;
	}

}
?>