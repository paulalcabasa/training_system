<?php

class Trainee {

	public function addTrainee($dealer_id,$first_name,$middle_name,$last_name,$name_suffix_id,$province_id,$municipality_id,
				$street_address,$telephone_no,$job_position_id,$employment_status_id,$date_hired,$date_of_birth,$civil_status_id,$gender,
				$education_id,$picture,$create_user,$mobile,$nickname,$email){
		$db = Database::getInstance();
		$add_trainee_sql = "INSERT INTO trainees_masterfile(dealer_id,first_name,middle_name,last_name,name_suffix_id,nickname,province_id,municipality_id,
				street_address,telephone_no,email,job_position_id,employment_status_id,date_hired,date_of_birth,civil_status_id,gender,
				education_id,picture,create_user,date_created) 
				VALUES(:dealer_id,:first_name,:middle_name,:last_name,:name_suffix_id,:nickname,:province_id,:municipality_id,:street_address,
				:telephone_no,:email,:job_position_id,:employment_status_id,:date_hired,:date_of_birth,:civil_status_id,:gender,:education_id,
				:picture,:create_user,NOW())";
	
		$trainee_id = $db->query($add_trainee_sql,array(
													":dealer_id"=>$dealer_id, 
													":first_name"=>$first_name,
													":middle_name"=>$middle_name,
													":last_name"=>$last_name,
													":name_suffix_id"=>$name_suffix_id,
													":nickname"=>$nickname,
													":province_id"=>$province_id,
													":municipality_id"=>$municipality_id,
													":street_address"=>$street_address,
													":telephone_no"=>$telephone_no,
													":email"=>$email,
													":job_position_id"=>$job_position_id,
													":employment_status_id"=>$employment_status_id,
													":date_hired"=>$date_hired,
													":date_of_birth"=>$date_of_birth,
													":civil_status_id"=>$civil_status_id,
													":gender"=>$gender,
													":education_id"=>$education_id,
													":picture"=>$picture,
													":create_user"=>$create_user
												  )
								);

		$pwd = $this->generate_password();

		$create_password_sql = "INSERT INTO trainees_password(trainee_id,password,create_user,date_created)  
								VALUES(:trainee_id,:password,:create_user,NOW())";
		$db->query($create_password_sql,array(
							":trainee_id"=>$trainee_id,
							":password" => $pwd,
							":create_user" => $create_user
						)
				  );
		
		$add_mobile_sql = "INSERT INTO trainee_mobile_no(trainee_id,mobile_no) VALUES(:trainee_id,:mobile_no)";
		foreach($mobile as $number){
			$db->query($add_mobile_sql,array(":trainee_id"=>$trainee_id,":mobile_no"=>$number));
		}

	}

	public function generate_password( $length = 8 ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$password = substr( str_shuffle( $chars ), 0, $length );
		return $password;
	}

	public function deleteTrainee($id,$user_id){
		$db = Database::getInstance();
		$sql = "UPDATE trainees_masterfile SET delete_user = :delete_user, 
											   date_deleted = NOW() 
				WHERE trainee_code = :id";
		$result = $db->query($sql,array(":delete_user"=>$user_id,":id"=>$id));
	}

	public function getTraineeDetails($trainee_code){
		$db = Database::getInstance();
		$sql = "SELECT a.trainee_code,
		       FormatTraineeId(a.trainee_code,c.dealer_abbrev) trainee_id,
		       FormatLastNameFirst(a.first_name,a.middle_name,a.last_name,b.suffix) trainee_name,
		       FormatFirstNameFirst(a.first_name,a.middle_name,a.last_name,b.suffix) trainee_name2,
		       c.dealer_name,
		       a.picture,
		       d.job_description,
		       a.civil_status_id,
		       a.date_of_birth,
		       a.dealer_id,
		       a.education_id,
		       a.employment_status_id,
		       a.first_name,
		       a.middle_name,
		       a.last_name,
		       a.nickname,
		       a.municipality_id,
		       a.name_suffix_id,
		       a.province_id,
		       a.street_address,
		       a.telephone_no,
		       a.gender,
		       e.zip_code,
		       a.date_hired,
		       a.job_position_id,
		       f.description employment_status,
		       e.municipality_name,
		       g.province_name,
		       CASE WHEN a.gender = 0 THEN 'Male' ELSE 'Female' END AS gender_description,
		       h.status c_status,
		       i.suffix,
		       j.education_desc,
		       a.email

		FROM trainees_masterfile a LEFT JOIN name_suffix b 
			ON a.name_suffix_id = b.id
		     LEFT JOIN dealers_master c 
		        ON c.id = a.dealer_id
		     LEFT JOIN job_position d
		        ON d.job_id = a.job_position_id
		     LEFT JOIN municipality e
		        ON e.id = a.municipality_id
		     LEFT JOIN employment_status f 
		     	ON f.id = a.employment_status_id
		     LEFT JOIN province g 
		        ON g.id = a.province_id
		     LEFT JOIN civil_status h
		        ON h.id = a.civil_status_id
		     LEFT JOIN name_suffix i
		     	ON i.id = a.name_suffix_id
		     LEFT JOIN education j 
		     	ON j.id = a.education_id
		WHERE trainee_code = :trainee_code";
		$result = $db->query($sql,array(":trainee_code"=>$trainee_code));
		return (object)$result[0];
		
	}

	public function getLoginDetails($id){
		$conn = new Connection();
		$stmt = $conn->prepare("SELECT * FROM trainees_password WHERE trainee_code = :id");
		$stmt->bindParam(":id",$id,PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch();
		$conn->closeConnection();
		return $row;
	}

	public function updateTrainee($trainee_code,$first_name,$middle_name,$last_name,$name_suffix_id,$date_of_birth,$civil_status_id,$gender,$education_id,$dealer_id,$job_position_id,$employment_status_id,$date_hired,$telephone_no,$province_id,$municipality_id,$street_address,$update_user,$nickname,$email){
		$db = Database::getInstance();
		$trainee_details = $this->getTraineeDetails($trainee_code);
		/*
		 * Saves into history table if position of trainee has changed
		 *
		 */
		if($trainee_details->job_position_id != $job_position_id){
			$add_job_history_sql = "INSERT INTO trainee_position_history(trainee_id,job_position_id,dealer_id,employment_status_id,date_hired,update_user) 
									VALUES(:trainee_id,:job_position_id,:dealer_id,:employment_status_id,:date_hired,:update_user)";
			$db->query($add_job_history_sql,array(
								":trainee_id" => $trainee_code,
								":job_position_id" => $trainee_details->job_position_id,
								":dealer_id" => $trainee_details->dealer_id,
								":employment_status_id" => $trainee_details->employment_status_id,
								":date_hired" => $trainee_details->date_hired,
								":update_user" => $update_user
							)
					   );
		}

	    /*
		 * Saves into history table if dealer of trainee has changed
		 *
		 */
		if($trainee_details->dealer_id != $dealer_id){
			$add_dealership_history_sql = "INSERT INTO trainee_dealership_history(trainee_id,job_position_id,dealer_id,employment_status_id,date_hired,update_user) 
									VALUES(:trainee_id,:job_position_id,:dealer_id,:employment_status_id,:date_hired,:update_user)";
			$db->query($add_dealership_history_sql,array(
								":trainee_id" => $trainee_code,
								":job_position_id" => $trainee_details->job_position_id,
								":dealer_id" => $trainee_details->dealer_id,
								":employment_status_id" => $trainee_details->employment_status_id,
								":date_hired" => $trainee_details->date_hired,
								":update_user" => $update_user
							)
					   );
		}


		$sql = "UPDATE trainees_masterfile SET dealer_id=:dealer_id,
											   first_name=:first_name,
											   middle_name=:middle_name,
											   last_name=:last_name,
											   nickname=:nickname,
											   name_suffix_id=:name_suffix_id,
											   province_id=:province_id,
											   municipality_id=:municipality_id,
											   street_address=:street_address,
											   telephone_no=:telephone_no,
											   email=:email,
											   job_position_id=:job_position_id,
											   employment_status_id = :employment_status_id,
											   date_hired=:date_hired,
											   date_of_birth=:date_of_birth,
											   civil_status_id=:civil_status_id,
											   gender=:gender,
											   education_id=:education_id,
											   update_user =:update_user		   
				WHERE trainee_code=:trainee_code";
		$db->query($sql,array(
							":dealer_id"			=>	$dealer_id,
							":first_name"			=>	$first_name,
							":middle_name"			=>	$middle_name,
							":last_name"			=>	$last_name,
							":nickname"				=>	$nickname,
							":name_suffix_id"		=>	$name_suffix_id,
							":province_id"			=>	$province_id,
							":municipality_id"		=>	$municipality_id,
							":street_address"		=>	$street_address,
							":telephone_no"			=>	$telephone_no,
							":email"				=>	$email,
							":job_position_id"		=>	$job_position_id,
							":employment_status_id" => 	$employment_status_id,
							":date_hired"			=>	$date_hired,
							":date_of_birth"		=>	$date_of_birth,
							":civil_status_id"		=>	$civil_status_id,
							":gender"				=>	$gender,
							":education_id"			=>	$education_id,
							":update_user"			=> 	$update_user,
							":trainee_code" 		=> $trainee_code
						)
				  );
	}

    public function countModules($id,$conn){
		$stmt = $conn->prepare("SELECT COUNT(*) as no_of_modules FROM program_module WHERE program_code = :id");
		$stmt->bindParam(":id",$id,PDO::PARAM_INT);
		$stmt->execute();
		$data = $stmt->fetch();
		return $data['no_of_modules'];
	}
    
	public function getTrainings($id){
		$conn = new Connection();
		$sql = "SELECT ta.trainee_code,ta.program_code,ta.attendance_id,p.title,ta.conducted_by,ta.venue,ta.start_date,ta.end_date,tm.dealer_id,tm.dealer_category,tm.job_position,tm.first_name,tm.middle_name,tm.last_name,tm.name_extension,ta.last_user_update,ta.last_user_create,trn.first_name AS trn_fname,trn.middle_name AS trn_mname,trn.last_name AS trn_lname,trn.name_extension AS trn_name_ext FROM ((trainees_masterfile AS tm INNER JOIN trainings_attended AS ta ON tm.trainee_code = ta.trainee_code) INNER JOIN program AS p ON ta.program_code = p.program_code) INNER JOIN trainor AS trn ON trn.trainor_id = ta.conducted_by WHERE ta.trainee_code = :trainee_code";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(":trainee_code",$id,PDO::PARAM_INT);
		$stmt->execute();
		$output = "";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$attendance_id = $row['attendance_id']; 
			$title = ucwords($row['title']);
			$conducted_by = ucwords($row['conducted_by']);
			$venue = ucwords($row['venue']);
			$start_date = $conn->format_date_only($row['start_date']);
			$end_date = $conn->format_date_only($row['end_date']);
			
            /*if($row['dealer_category'] == "main"){
				$dealer = $this->getDealerName($row['dealer_id'],"dealer_main","dealer_main_name","dealer_main_id",$conn);
			}
			else {
				$dealer = $this->getDealerName($row['dealer_id'],"dealer_satellite","dealer_satellite_name","dealer_satellite_id",$conn);
			}
			*/
			
			/*$position = ucwords($row['job_position']);*/
			$trainee_name = $this->transformName1($row['first_name'],$row['middle_name'],$row['last_name'],$row['name_extension'],$conn); 
			$trainor_name = $this->transformName1($row['trn_fname'],$row['trn_mname'],$row['trn_lname'],$row['trn_name_ext'],$conn);
			$trainee_code = $row['trainee_code'];
			$program_code = $row['program_code'];
			$enc_tc = $this->encryptor("encrypt",$trainee_code);
			$enc_attendance_id = $this->encryptor("encrypt",$attendance_id);
			$enc_name = $this->encryptor("encrypt",$trainee_name);
			$enc_title = $this->encryptor("encrypt",$title);

			$mod_date = ($row['last_user_update'] != "") ? "Updated : " . $conn->format_date($row['last_user_update']) : "" ;
			$timestamp = "Created : " . $conn->format_date($row['last_user_create']) . " " . $mod_date;

			$module_workshop_data = $this->getEvaluationWorkshop($attendance_id);
			$attendance_data = $this->getEvaluationAttendance($attendance_id);
			$product_knowledge_data = $this->getEvaluationProductKnowledgeExam($attendance_id);
			$final_written_data = $this->getEvaluationWrittenExam($attendance_id);
			$total_grade = $module_workshop_data['grade'] + $attendance_data['grade'] + $product_knowledge_data['grade'] + $final_written_data['grade'];
			$status = $this->getGradeStatus($total_grade);
            
            $module_count = $this->countModules($program_code,$conn);
            
            $grade_status = $this->checkEvaluationStatus($attendance_id,$module_count,$total_grade);
           
			$output .= "<tr title='$timestamp'>";
			$output .= "<td><span title='$title'>" .$title. "</span></td>";
			$output .= "<td>" .$trainor_name. "</td>";
			$output .= "<td><span title='$venue'>" .$venue. "</span></td>";
			$output .= "<td>" .$start_date. "</td>";
			$output .= "<td>" .$end_date. "</td>";
			$output .= "<td>$grade_status</td>";
			//$output .= "<td>".$dealer."</td>";
			//$output .= "<td>" .$position. "</td>";
			$output .= "<td>
						<div class='btn-group'>
						  <button type='button' class='btn btn-primary btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
						    Action <span class='caret'></span>
						  </button>
						  <ul class='dropdown-menu dropdown-menu-right'>
						    <li><a href='evaluate_modules_workshops.php?d=$enc_attendance_id&tc=$enc_tc&n=$enc_name&t=$enc_title'>Evaluate Modules and Workshop</a></li>
						    <li><a href='evaluate_attendance.php?d=$enc_attendance_id&tc=$enc_tc&n=$enc_name&t=$enc_title'>Evaluate Attendance</a></li>
						    <li><a href='evaluate_product_knowledge.php?tc=$enc_tc&d=$enc_attendance_id&t=$enc_title&n=$enc_name'>Evaluate Product Knowledge Exam</a></li>
						    <li><a href='evaluate_written_exam.php?tc=$enc_tc&d=$enc_attendance_id&t=$enc_title&n=$enc_name'>Evaluate Final Written Exam</a></li>
						    <li><a href='general_assessment.php?tc=$enc_tc&d=$enc_attendance_id&t=$enc_title&n=$enc_name'>General Assessment</a></li>
						    <li><a href='evaluation_summary.php?tc=$enc_tc&d=$enc_attendance_id&t=$enc_title&n=$enc_name'>View Record Summary</a></li>
						    <li><a href='update_training.php?d=$enc_attendance_id&n=$enc_name&tc=$enc_tc&t=$enc_title'>Edit Record</a></li>
						    <li><a href='#' class='btn_delete' data-traineeCode='$trainee_code' data-programCode='$program_code' data-title='$title' data-id='$attendance_id'>Delete Record</a></li>
						  </ul>
						</div></td>";
			$output .= "</tr>";
		}

		$conn->closeConnection();

		return $output;
	}


	public function deleteTrainingRecord($attendance_id,$program_code,$trainee_code){
		$conn = new Connection();

		// delete records from workshop
		$del_workshop = $conn->prepare("DELETE FROM workshop WHERE attendance_id = :attendance_id");
		$del_workshop->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$del_workshop->execute();

		// delete records from final written exam
		$del_fwe = $conn->prepare("DELETE FROM final_written_exam WHERE attendance_id = :attendance_id");
		$del_fwe->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$del_fwe->execute();

		// delete records from product knowledge exam
		$del_pke = $conn->prepare("DELETE FROM product_knowledge_exam WHERE attendance_id = :attendance_id");
		$del_pke->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$del_pke->execute();

		// delete records from attendance
		$del_att = $conn->prepare("DELETE FROM attendance WHERE attendance_id = :attendance_id");
		$del_att->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$del_att->execute();

		// delete records from general assessment
		$del_ass = $conn->prepare("DELETE FROM general_assessment WHERE attendance_id = :attendance_id");
		$del_ass->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$del_ass->execute();

		// delete records from trainings
		$del_training = $conn->prepare("DELETE FROM trainings_attended WHERE attendance_id = :attendance_id AND program_code = :program_code AND trainee_code = :trainee_code");
		$del_training->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$del_training->bindParam(":program_code",$program_code,PDO::PARAM_INT);
		$del_training->bindParam(":trainee_code",$trainee_code,PDO::PARAM_INT);
		$del_training->execute();
	}

	public function deleteTrainingRecordByTrainee($trainee_code){
		$conn = new Connection();

		$get_trainings = $conn->prepare("SELECT * FROM trainings_attended WHERE trainee_code = :trainee_code");
		$get_trainings->bindParam(":trainee_code",$trainee_code,PDO::PARAM_INT);
		$get_trainings->execute();
		while($row = $get_trainings->fetch(PDO::FETCH_ASSOC)){
			$attendance_id = $row['attendance_id'];
			// delete records from workshop
			$del_workshop = $conn->prepare("DELETE FROM workshop WHERE attendance_id = :attendance_id");
			$del_workshop->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
			$del_workshop->execute();

			// delete records from final written exam
			$del_fwe = $conn->prepare("DELETE FROM final_written_exam WHERE attendance_id = :attendance_id");
			$del_fwe->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
			$del_fwe->execute();

			// delete records from product knowledge exam
			$del_pke = $conn->prepare("DELETE FROM product_knowledge_exam WHERE attendance_id = :attendance_id");
			$del_pke->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
			$del_pke->execute();

			// delete records from attendance
			$del_att = $conn->prepare("DELETE FROM attendance WHERE attendance_id = :attendance_id");
			$del_att->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
			$del_att->execute();

			// delete records from general assessment
			$del_ass = $conn->prepare("DELETE FROM general_assessment WHERE attendance_id = :attendance_id");
			$del_ass->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
			$del_ass->execute();

		}


		// delete records from trainings
		$del_training = $conn->prepare("DELETE FROM trainings_attended WHERE trainee_code = :trainee_code");
		$del_training->bindParam(":trainee_code",$trainee_code,PDO::PARAM_INT);
		$del_training->execute();

		$conn->closeConnection();
	}

	public function getModuleWorkshopOption($attendance_id,$program_code){
		$conn = new Connection();
		$output = "";
		$get_program_modules = $conn->prepare("SELECT * FROM program_module WHERE program_code = :program_code");
		$get_program_modules->bindParam(":program_code",$program_code,PDO::PARAM_INT);
		$get_program_modules->execute();

		while($row = $get_program_modules->fetch(PDO::FETCH_ASSOC)){
			$module_id = $row['module_id'];
			$module_name = $row['module_name'];
			$find_module = $conn->prepare("SELECT module_id FROM workshop WHERE attendance_id = :attendance_id");
			$find_module->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
			$find_module->execute();
			$graded_modules = $find_module->fetchAll(PDO::FETCH_COLUMN,0);
			if(!in_array($module_id,$graded_modules)){
				$output .= "<option value='$module_id'>" .$module_name. "</option>";
			}
		}
		$conn->closeConnection();
		return $output;
	}

	public function getTrainingDetails($attendance_id){
		$conn = new Connection();
		$stmt = $conn->prepare("SELECT * FROM trainings_attended WHERE attendance_id = :attendance_id");
		$stmt->bindParam(":attendance_id",$attendance_id,PDO::FETCH_ASSOC);
		$stmt->execute();
		$conn->closeConnection();
		return $stmt->fetch();
	}

	public function addModuleGrade($attendance_id,$module_id = 0,$participation,$module_ending_exam,$module_evaluation_exam){
		$conn = new Connection();
		$today = $conn->getDateToday();
		$stmt = $conn->prepare("INSERT INTO workshop(attendance_id,module_id,participation,module_ending_exam,module_ending_evaluation,last_user_create) VALUES(:att_id,:mod_id,:part,:mee,:mev,:last_user_create)");
		$stmt->bindParam(":att_id",$attendance_id,PDO::PARAM_INT);
		$stmt->bindParam(":mod_id",$module_id,PDO::PARAM_INT);
		$stmt->bindParam(":part",$participation,PDO::PARAM_INT);
		$stmt->bindParam(":mee",$module_ending_exam,PDO::PARAM_INT);
		$stmt->bindParam(":mev",$module_evaluation_exam,PDO::PARAM_INT);
		$stmt->bindParam(":last_user_create",$today,PDO::PARAM_STR);
		$stmt->execute();
		$workshop_id = $conn->lastInsertId();
		$conn->closeConnection();
		return $workshop_id;
	}

	public function getModuleName($module_id,$program_code){
		$output = "";
		$conn = new Connection();
		if($module_id!=0){
			
			$stmt = $conn->prepare("SELECT module_name FROM program_module WHERE module_id = :id");
			$stmt->bindParam(":id",$module_id,PDO::PARAM_INT);
			$stmt->execute();
			$data = $stmt->fetch();
			$output = $data['module_name'];
		
		}
		else {
			$stmt = $conn->prepare("SELECT title FROM program WHERE program_code = :program_code");
			$stmt->bindParam(":program_code",$program_code,PDO::PARAM_INT);
			$stmt->execute();
			$data = $stmt->fetch();
			$output = $data['title'];
			
		}
		$conn->closeConnection();
		return $output;
	}



	public function countProgramModules($program_code){
		$conn = new Connection();
		$stmt = $conn->prepare("SELECT COUNT(module_id) as ids FROM program_module WHERE program_code = :program_code");
		$stmt->bindParam(":program_code",$program_code,PDO::PARAM_INT);
		$stmt->execute();
		$data = $stmt->fetch();
		return $data['ids'];
	}

	public function getProgramCode($attendance_id){
		$conn = new Connection();
		$stmt = $conn->prepare("SELECT program_code FROM trainings_attended WHERE attendance_id = :attendance_id");
		$stmt->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$stmt->execute();
		$data = $stmt->fetch();
		$conn->closeConnection();
		return $data['program_code'];
	}

	public function getModuleGrade($attendance_id,$trainee_id){
		$conn = new Connection();
		$output = "";
		$stmt = $conn->prepare("SELECT * FROM workshop WHERE attendance_id = :attendance_id AND trainee_id = :trainee_id");
		$stmt->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$stmt->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$workshop_id = $row['workshop_id'];
			$attendance_id = $row['attendance_id'];
			$participation = $row['participation'];
			$module_ending_exam=  $row['module_ending_exam'];
			$module_ending_evaluation = $row['module_ending_evaluation'];
			$program_code = $this->getProgramCode($attendance_id);
			$module_name = $this->getModuleName($row['module_id'],$program_code);	
			$total = ($participation + $module_ending_evaluation + $module_ending_exam)/3;
			$total = number_format((float)$total, 2, '.', '');
			$date_created = $row['last_user_create'];
			$date_updated = $row['last_user_update'];
			$output .= "<tr>";
				$output .= "<td>" . $module_name . "</td>";
				$output .= "<td><input type='text' maxlength='3' class='form-control input-md txt_participation' data-workshop_id='$workshop_id' data-attendance_id='$attendance_id' value='$participation'/></td>";
				$output .= "<td><input type='text' maxlength='3' class='form-control input-md txt_mee' data-workshop_id='$workshop_id' data-attendance_id='$attendance_id' value='$module_ending_exam'/></td>";
				$output .= "<td><input type='text' maxlength='3' class='form-control input-md txt_mev' data-workshop_id='$workshop_id' data-attendance_id='$attendance_id' value='$module_ending_evaluation'/></td>";
				$output .= "<td>$total</td>";
				$output .= "<td>" . $date_created . "</td>";
				$output .= "<td>" . $date_updated . "</td>";
			$output .= "</tr>";
		}
		$conn->closeConnection();
		return $output;
	}


	public function deleteModuleGrade($workshop_id){
		$conn = new Connection();
		$stmt = $conn->prepare("DELETE FROM workshop WHERE workshop_id = :workshop_id");
		$stmt->bindParam(":workshop_id",$workshop_id,PDO::PARAM_INT);
		$stmt->execute();
		$conn->closeConnection();
	}

	public function updateModuleGrade($workshop_id,$attendance_id,$trainee_id,$participation,$module_ending_exam,$module_ending_evaluation){
		$conn = new Connection();
		$today = $conn->getDateToday();
		$stmt = $conn->prepare("UPDATE workshop SET participation = :participation,module_ending_exam = :module_ending_exam,module_ending_evaluation= :module_ending_evaluation,last_user_update = :last_user_update WHERE workshop_id = :workshop_id AND attendance_id = :attendance_id AND trainee_id = :trainee_id");
		$stmt->bindParam(":workshop_id",$workshop_id,PDO::PARAM_INT);
		$stmt->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$stmt->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$stmt->bindParam(":participation",$participation,PDO::PARAM_INT);
		$stmt->bindParam(":module_ending_exam",$module_ending_exam,PDO::PARAM_INT);
		$stmt->bindParam(":module_ending_evaluation",$module_ending_evaluation,PDO::PARAM_INT);
		$stmt->bindParam(":last_user_update",$today,PDO::PARAM_STR);
		$stmt->execute();
		$conn->closeConnection();
	}


	public function getAttendanceOption($attendance_id,$program_code){
		$conn = new Connection();
		$output = "";
		$get_program_modules = $conn->prepare("SELECT * FROM program_module WHERE program_code = :program_code");
		$get_program_modules->bindParam(":program_code",$program_code,PDO::PARAM_INT);
		$get_program_modules->execute();

		while($row = $get_program_modules->fetch(PDO::FETCH_ASSOC)){
			$module_id = $row['module_id'];
			$module_name = $row['module_name'];
			$find_module = $conn->prepare("SELECT module_id FROM attendance WHERE attendance_id = :attendance_id");
			$find_module->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
			$find_module->execute();
			$graded_modules = $find_module->fetchAll(PDO::FETCH_COLUMN,0);
			if(!in_array($module_id,$graded_modules)){
				$output .= "<option value='$module_id'>" .$module_name. "</option>";
			}
		}
		$conn->closeConnection();
		return $output;
	}


	public function getAttendance($attendance_id,$trainee_id){
		$conn = new Connection();
		$output = "";
		$stmt = $conn->prepare("SELECT * FROM attendance WHERE attendance_id = :attendance_id AND trainee_id = :trainee_id");
		$stmt->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$stmt->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$att_id = $row['att_id'];
			$module_id = $row['module_id'];
			$attendance_id = $row['attendance_id'];
			$time_in = ($row['time_in'] == "00:00:00") ? "" : $conn->format_time_only($row['time_in']);
			

			$score = $row['score'];
			$program_code = $this->getProgramCode($attendance_id);
			$module_name = $this->getModuleName($module_id,$program_code);
			$mod_date = ($row['last_user_update'] != "") ? "Updated : " . $row['last_user_update'] : "" ;
			$timestamp = "Created : " . $row['last_user_create'] . " " . $mod_date;
			$output .= "<tr title='$timestamp'>";				
				$output .= "<td>".$module_name."</td>";
				$output .= "<td>
                 <div class='input-group date txt_time_in' data-att_id='$att_id'>
                    <input type='text' class='form-control' value='$time_in' />
                    <span class='input-group-addon'>
                        <span class='glyphicon glyphicon-time'></span>
                    </span>
                </div>
                </td>";	
				$output .= "<td><input type='text' data-att_id='$att_id' class='form-control input-md txt_score' value='$score' maxlength='3' /></td>";
				//$output .= "<td><button type='button' class='btn btn-primary btn-sm btn_edit' data-att_id='$att_id' data-mod_name='$module_name' data-time_in='$time_in' data-score='$score'>Edit</button></td>";	
				//$output .= "<td><button type='button' class='btn btn-danger btn-sm btn_delete' data-att_id='$att_id'>Delete</button></td>";		
			$output .= "</tr>";
		}
		$conn->closeConnection();
		return $output;
	}

	public function deleteAttendance($att_id){
		$conn = new Connection();
		$stmt = $conn->prepare("DELETE FROM attendance WHERE att_id = :att_id");
		$stmt->bindParam(":att_id",$att_id,PDO::PARAM_INT);
		$stmt->execute();
		$conn->closeConnection();
	}

	public function updateAttendance($att_id,$attendance_id,$trainee_id,$time_in,$score){
		$conn = new Connection();
		$today = $conn->getDateToday();
		$stmt = $conn->prepare("UPDATE attendance SET time_in = :time_in, score = :score, last_user_update = :last_user_update WHERE att_id = :att_id AND attendance_id = :attendance_id AND trainee_id = :trainee_id");
		$stmt->bindParam(":time_in",$time_in,PDO::PARAM_STR);
		$stmt->bindParam(":score",$score,PDO::PARAM_INT);
		$stmt->bindParam(":att_id",$att_id,PDO::PARAM_INT);
		$stmt->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$stmt->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$stmt->bindParam(":last_user_update",$today,PDO::PARAM_STR);
		$stmt->execute();
	
		$conn->closeConnection();
	
	}

	public function addProductKnowledgeExam($attendance_id,$exam,$score,$trainee_id){
		$conn = new Connection();
		$today = $conn->getDateToday();
		$stmt = $conn->prepare("INSERT INTO product_knowledge_exam(attendance_id,trainee_id,exam,score,last_user_create) VALUES(:attendance_id,:trainee_id,:exam,:score,:last_user_create)");
		$stmt->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$stmt->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$stmt->bindParam(":exam",$exam,PDO::PARAM_STR);
		$stmt->bindParam(":score",$score,PDO::PARAM_INT);
		$stmt->bindParam(":last_user_create",$today,PDO::PARAM_STR);
		$stmt->execute();
		$id = $conn->lastInsertId();
		$conn->closeConnection();
		return $id;
	}

	public function getProductKnowledgeExam($attendance_id,$trainee_id){
		$conn = new Connection();
		$output = "";
		$stmt = $conn->prepare("SELECT * FROM product_knowledge_exam WHERE attendance_id = :attendance_id AND trainee_id = :trainee_id");
		$stmt->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$stmt->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$exam_id = $row['exam_id'];
			$exam = $row['exam'];
			$score = $row['score'];
			$mod_date = ($row['last_user_update'] != "") ? "Updated : " . $row['last_user_update'] : "" ;
			$timestamp = "Created : " . $row['last_user_create'] . " " . $mod_date;

			$output .= "<tr title='$timestamp'>";
				$output .= "<td>" . $exam . "</td>";
				$output .= "<td>" . $score . "</td>";
				$output .= "<td><button type='button' class='btn btn-primary btn-sm btn_edit' data-exam_id='$exam_id' data-exam='$exam' data-score='$score'>Edit</button></td>";
				$output .= "<td><button type='button' class='btn btn-danger btn-sm btn_delete' data-exam_id='$exam_id'>Delete</button></td>";
			$output .= "</tr>";
		}	
		$conn->closeConnection();
		return $output;
	}

	public function deleteProductKnowledge($exam_id){
		$conn = new Connection();
		$stmt = $conn->prepare("DELETE FROM product_knowledge_exam WHERE exam_id = :exam_id");
		$stmt->bindParam(":exam_id",$exam_id,PDO::PARAM_INT);
		$stmt->execute();
		$conn->closeConnection();
	}

	public function updateProductKnowledge($exam_id,$exam,$score){
		$conn = new Connection();
		$today = $conn->getDateToday();
		$stmt = $conn->prepare("UPDATE product_knowledge_exam SET exam = :exam, score = :score, last_user_update = :last_user_update WHERE exam_id = :exam_id");
		$stmt->bindParam(":exam",$exam,PDO::PARAM_STR);
		$stmt->bindParam(":score",$score,PDO::PARAM_INT);
		$stmt->bindParam(":exam_id",$exam_id,PDO::PARAM_INT);
		$stmt->bindParam(":last_user_update",$today,PDO::PARAM_STR);
		$stmt->execute();
		$conn->closeConnection();
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

	public function addWrittenExam($attendance_id,$trainee_id,$exam,$score){
		$conn = new Connection();
		$today = $conn->getDateToday();
		$stmt = $conn->prepare("INSERT INTO final_written_exam(attendance_id,trainee_id,exam,score,last_user_create) VALUES(:attendance_id,:trainee_id,:exam,:score,:last_user_create)");
		$stmt->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$stmt->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$stmt->bindParam(":exam",$exam,PDO::PARAM_STR);
		$stmt->bindParam(":score",$score,PDO::PARAM_INT);
		$stmt->bindParam(":last_user_create",$today,PDO::PARAM_STR);
		$stmt->execute();
		$conn->closeConnection();
	}

	public function getWrittenExam($attendance_id,$trainee_id){
		$conn = new Connection();
		$output = "";
		$stmt = $conn->prepare("SELECT * FROM final_written_exam WHERE attendance_id = :attendance_id AND trainee_id = :trainee_id");
		$stmt->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$stmt->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$stmt->execute();

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$exam_id = $row['exam_id'];
			$exam = $row['exam'];
			$score = $row['score'];
			$attendance_id = $row['attendance_id'];
			$mod_date = ($row['last_user_update'] != "") ? "Updated : " . $row['last_user_update'] : "" ;
			$timestamp = "Created : " . $row['last_user_create'] . " " . $mod_date;

			$output .= "<tr title='$timestamp'>";
				$output .= "<td>" . $exam . "</td>";
				$output .= "<td>" . $score . "</td>";
				$output .= "<td><button type='button' class='btn btn-primary btn-sm btn_edit' data-exam_id='$exam_id' data-exam='$exam' data-score='$score'>Edit</button></td>";
				$output .= "<td><button type='button' class='btn btn-danger btn-sm btn_delete' data-exam_id='$exam_id'>Delete</button></td>";
			$output .= "</tr>";
		}	

		$conn->closeConnection();
		return $output;
	}

	public function updateTraineePassword($trainee_code,$password){
		$conn = new Connection();
		$now = new DateTime();
		$now->setTimezone(new DateTimeZone('Asia/Taipei'));
		$today = $now->format('Y-m-d H:i:s');
		$update_user = $conn->prepare("UPDATE trainees_password SET password = :pass, last_user_update=:last_user_update WHERE trainee_code = :trainee_code");
		$update_user->bindParam(":pass",$password,PDO::PARAM_STR);
		$update_user->bindParam(':trainee_code',$trainee_code,PDO::PARAM_INT);
		$update_user->bindParam(':last_user_update',$today,PDO::PARAM_STR);
		$update_user->execute();
		$conn->closeConnection();
	}

	public function getDateToday(){
		$now = new DateTime();
		$now->setTimezone(new DateTimeZone('Asia/Taipei'));
		$today = $now->format('Y-m-d H:i:s');
		return $today;
	}

	public function updateTraineePic($trainee_code,$old_pic,$new_pic,$user){
		$db = Database::getInstance();

		if($old_pic!=""){
			unlink("../trainee_pics/" . $old_pic);
		}

		$sql = "UPDATE trainees_masterfile SET picture = :picture,
											   update_user = :update_user,
											   date_updated = NOW() 
				WHERE trainee_code = :trainee_code";
		$result = $db->query($sql,array(
									":picture"=>$new_pic,
									":update_user"=>$user,
									":trainee_code"=>$trainee_code
								 )
							);
		return $result;

	}

	public function updateTrainingInfo($attendance_id,$trainee_code,$start_date,$end_date,$conducted_by,$venue){
		$conn = new Connection();
		$today = $conn->getDateToday();

		$stmt = $conn->prepare("UPDATE trainings_attended SET start_date = :start_date, end_date = :end_date, conducted_by = :conducted_by, venue = :venue, last_user_update = :last_user_update WHERE attendance_id = :attendance_id AND trainee_code = :trainee_code");
		$stmt->bindParam(":start_date",$start_date,PDO::PARAM_STR);
		$stmt->bindParam(":end_date",$end_date,PDO::PARAM_STR);
		$stmt->bindParam(":conducted_by",$conducted_by,PDO::PARAM_STR);
		$stmt->bindParam(":venue",$venue,PDO::PARAM_STR);
		$stmt->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$stmt->bindParam(":trainee_code",$trainee_code,PDO::PARAM_INT);
		$stmt->bindParam(":last_user_update",$today,PDO::PARAM_STR);
		$stmt->execute();

		$conn->closeConnection();
	}

	public function deleteWrittenExam($exam_id){
		$conn = new Connection();

		$stmt = $conn->prepare("DELETE FROM final_written_exam WHERE exam_id = :exam_id");
		$stmt->bindParam(":exam_id",$exam_id,PDO::PARAM_INT);
		$stmt->execute();

		$conn->closeConnection();
	}

	public function updateWrittenExam($exam_id,$exam,$score){
		$conn = new Connection();
		$today = $conn->getDateToday();
		$stmt = $conn->prepare("UPDATE final_written_exam SET exam = :exam, score = :score,last_user_update = :last_user_update WHERE exam_id = :exam_id");
		$stmt->bindParam(":exam",$exam,PDO::PARAM_INT);
		$stmt->bindParam(":exam_id",$exam_id,PDO::PARAM_INT);
		$stmt->bindParam(":score",$score,PDO::PARAM_INT);
		$stmt->bindParam(":last_user_update",$last_user_update,PDO::PARAM_STR);
		$stmt->execute();
		$conn->closeConnection();
	}

	public function updateGeneralAssessment($attendance_id,$trainee_id,$content){
		$conn = new Connection();
	
		$stmt = $conn->prepare("UPDATE training_program_attendees SET general_assessment = :content WHERE training_program_id = :attendance_id AND trainee_id = :trainee_id");
		$stmt->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$stmt->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$stmt->bindParam(":content",$content,PDO::PARAM_STR);
	
		$stmt->execute();
		$conn->closeConnection();
	}

	public function getEvaluationWorkshop($attendance_id,$trainee_id){
		$conn = new Connection();
		$output = "";
		$grand_total = "";
		$ctr = 0;
		$grand_total_percentage = 0;
		$stmt = $conn->prepare("SELECT * FROM workshop WHERE attendance_id = :attendance_id AND trainee_id = :trainee_id");
		$stmt->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$stmt->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$stmt->execute();
		if($stmt->rowCount() > 0){
			$output .= "<table class='table' style='margin-left:1em;'>";
            $output .= "<thead>";
            $output .= "<tr>";
            $output .= "<th>Module</th>";
            $output .= "<th>Participation</th>";
            $output .= "<th>Module-ending Exam</th>";
            $output .= "<th>Module-ending Evaluation</th>";
            $output .= "<th>Total</th>";
            $output .= "</tr>";
            $output .= "</thead>";
            $output .= "<tbody>";
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$workshop_id = $row['workshop_id'];
				$attendance_id = $row['attendance_id'];
				$participation = $row['participation'];
				$module_ending_exam=  $row['module_ending_exam'];
				$module_ending_evaluation = $row['module_ending_evaluation'];
				$program_code = $this->getProgramCode($attendance_id);
				$module_name = $this->getModuleName($row['module_id'],$program_code);	
				$total = ($participation + $module_ending_evaluation + $module_ending_exam)/3;
				$grand_total += $total;
				$total = number_format((float)$total, 2, '.', '');
				$output .= "<tr>";
					$output .= "<td>" . $module_name . "</td>";
					$output .= "<td>" . $participation . "</td>";
					$output .= "<td>" . $module_ending_exam . "</td>";
					$output .= "<td>" . $module_ending_evaluation . "</td>";
					$output .= "<td>$total</td>";
				$output .= "</tr>";
				$ctr++;
			}
			$grand_total = $grand_total / $ctr;
			$grand_total = number_format((float)$grand_total, 2, '.', '');

			$output .= "</tbody>";
			$output .= "<tfoot>";
			$output .= "<tr>";
			$output .= "<td colspan='4' align='right'><strong>Total :</strong></td>";
			$output .= "<td>$grand_total</td>";
			$output .= "</tr>";
			$output .= "</tfoot>";
			$output .= "</table>";         
		}
		else {
			$output = "<span class='badge badge-warning'>No records found.</span>";
		}
		
		$grand_total_percentage = $grand_total * 0.50;
		$grand_total_percentage = number_format((float)$grand_total_percentage, 2, '.', '');
		$data = array("breakdown"=>$output,"grade"=>$grand_total_percentage);

		$conn->closeConnection();

		return $data;
	}

	public function getEvaluationAttendance($attendance_id,$trainee_id){
		$conn = new Connection();
		$output = "";
		$grand_total = 0;
		$grand_total_percentage = "";
		$ctr = 0;
		$stmt = $conn->prepare("SELECT * FROM attendance WHERE attendance_id = :attendance_id AND trainee_id = :trainee_id");
		$stmt->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$stmt->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$stmt->execute();
		if($stmt->rowCount() > 0){
			$output .= "<table class='table' style='margin-left:1em;'>";
            $output .= "<thead>";
            $output .= "<tr>";
            $output .= "<th>Module</th>";
            $output .= "<th>Time In</th>";
            $output .= "<th>Score</th>";
            $output .= "</tr>";
            $output .= "</thead>";
            $output .= "<tbody>";
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$att_id = $row['att_id'];
				$module_id = $row['module_id'];
				$attendance_id = $row['attendance_id'];
				$time_in = $conn->format_date($row['time_in']);
				$score = $row['score'];
				$program_code = $this->getProgramCode($attendance_id);
				$module_name = $this->getModuleName($module_id,$program_code);
				$grand_total += $score;
				$output .= "<tr>";				
					$output .= "<td>".$module_name."</td>";
					$output .= "<td><span class='time-in'>$time_in</span></td>";	
					$output .= "<td>$score</td>";		
				$output .= "</tr>";
				$ctr++;
			}
			$grand_total = $grand_total / $ctr;
			$grand_total_percentage = $grand_total * 0.10;
			$grand_total_percentage = number_format((float)$grand_total_percentage, 2, '.', '');
			$grand_total = number_format((float)$grand_total, 2, '.', '');
			$output .= "</tbody>";
			$output .= "<tfoot>";
			$output .= "<tr>";
			$output .= "<td colspan='2' align='right'><strong>Total :</strong></td>";
			$output .= "<td>$grand_total</td>";
			$output .= "</tr>";
			$output .= "</tfoot>";
			$output .= "</table>";       
		}
		else {
			$output = "<span class='badge badge-warning'>No records found</span>";
		}
		$data = array("breakdown"=>$output,"grade"=>$grand_total_percentage);
		$conn->closeConnection();
		return $data;
	}

	public function getEvaluationProductKnowledgeExam($attendance_id,$trainee_id){
		$conn = new Connection();
		$output = "";
		$grand_total_percentage = 0;
		$grand_total = 0;
		$ctr = 0;
		$stmt = $conn->prepare("SELECT * FROM product_knowledge_exam WHERE attendance_id = :attendance_id AND trainee_id = :trainee_id");
		$stmt->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$stmt->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$stmt->execute();
		if($stmt->rowCount() > 0){
			$output .= "<table class='table' style='margin-left:1em;'>";
            $output .= "<thead>";
            $output .= "<tr>";
            $output .= "<th>Exam</th>";
            $output .= "<th>Score</th>";
            $output .= "</tr>";
            $output .= "</thead>";
            $output .= "<tbody>";
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$exam = $row['exam'];
				$score = $row['score'];
				$grand_total += $score;
				$ctr++;
				$output .= "<tr>";
				$output .= "<td>" . $exam . "</td>";
				$output .= "<td>" . $score . "</td>";
				$output .= "</tr>";
			}

			$grand_total = $grand_total / $ctr;
			$grand_total_percentage = $grand_total * 0.10;
			$grand_total_percentage = number_format((float)$grand_total_percentage, 2, '.', '');
			$grand_total = number_format((float)$grand_total, 2, '.', '');
			$output .= "</tbody>";
			$output .= "<tfoot>";
			$output .= "<tr>";
			$output .= "<td align='right'><strong>Total :</strong></td>";
			$output .= "<td>$grand_total</td>";
			$output .= "</tr>";
			$output .= "</tfoot>";
			$output .= "</table>";     	
		}
		else {
			$output = "<span class='badge badge-warning'>No records found</span>";
		}
		$data = array("breakdown"=>$output,"grade"=>$grand_total_percentage);
		$conn->closeConnection();
		return $data;
	}

	public function getEvaluationWrittenExam($attendance_id,$trainee_id){
		$conn = new Connection();
		$output = "";
		$grand_total_percentage = 0;
		$grand_total = 0;
		$ctr = 0;
		$stmt = $conn->prepare("SELECT * FROM final_written_exam WHERE attendance_id = :attendance_id AND trainee_id = :trainee_id");
		$stmt->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
		$stmt->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$stmt->execute();
		if($stmt->rowCount() > 0){
			$output .= "<table class='table' style='margin-left:1em;'>";
            $output .= "<thead>";
            $output .= "<tr>";
            $output .= "<th>Exam</th>";
            $output .= "<th>Score</th>";
            $output .= "</tr>";
            $output .= "</thead>";
            $output .= "<tbody>";
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$exam = $row['exam'];
				$score = $row['score'];
				$grand_total += $score;
				$ctr++;
				$output .= "<tr>";
				$output .= "<td>" . $exam . "</td>";
				$output .= "<td>" . $score . "</td>";
				$output .= "</tr>";
			}

			$grand_total = $grand_total / $ctr;
			$grand_total_percentage = $grand_total * 0.30;
			$grand_total_percentage = number_format((float)$grand_total_percentage, 2, '.', '');
			$grand_total = number_format((float)$grand_total, 2, '.', '');
			$output .= "</tbody>";
			$output .= "<tfoot>";
			$output .= "<tr>";
			$output .= "<td align='right'><strong>Total :</strong></td>";
			$output .= "<td>$grand_total</td>";
			$output .= "</tr>";
			$output .= "</tfoot>";
			$output .= "</table>";     	
		}
		else {
			$output = "<span class='badge badge-warning'>No records found</span>";
		}
		$data = array("breakdown"=>$output,"grade"=>$grand_total_percentage);
		$conn->closeConnection();
		return $data;
	}

	public function getGradeStatus($grade){
		if($grade >= 80.0){
			return "<span class='label label-success' style='font-size:10pt;'>Passed</span>";
		}
		else {
			return "<span class='label label-danger' style='font-size:10pt;'>Failed</span>";
		}
	}
    
    public function checkEvaluationStatus($attendance_id,$trainee_id,$module_count,$total_grade){
        $conn = new Connection();
        $output = "";
        $incomplete_details = "";
        $isIncomplete = true;
      
        $stmt1 = $conn->prepare("SELECT COUNT(workshop_id) AS count FROM workshop WHERE (participation IS NULL OR module_ending_exam IS NULL OR module_ending_evaluation IS NULL) AND attendance_id = :attendance_id AND trainee_id = :trainee_id");
        $stmt1->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
        $stmt1->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
        $stmt1->execute();
        $data1 = $stmt1->fetch();
        $workshop_null = $data1['count'];
   		
   		$enc_tp_id = $conn->encryptor("encrypt",$attendance_id);
   		$enc_tc = $conn->encryptor("encrypt",$trainee_id);

        if($workshop_null == $module_count){
            $incomplete_details .= "<li>"."<a href='evaluate_modules_workshops.php?d=$enc_tp_id&tc=$enc_tc'>Modules and Workshop</a> "."is not yet evaluated.</li>";
            $isIncompelete = true;
        } else if($workshop_null == 0){
            $isIncompelete = false;
        } else {
            $incomplete_details .= "<li>Incomplete evaluation for <a href='evaluate_modules_workshops.php?d=$enc_tp_id&tc=$enc_tc'>Modules and Workshop</a>. </li>";
            $isIncompelete = true;
        }
        
        $stmt2 = $conn->prepare("SELECT COUNT(att_id) AS count FROM attendance WHERE last_user_update IS NULL AND attendance_id = :attendance_id AND trainee_id = :trainee_id");
        $stmt2->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
        $stmt2->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
        $stmt2->execute();
        $data2 = $stmt2->fetch();
        $attendance_null = $data2['count']; 
        if($attendance_null == $module_count){
             $incomplete_details .= "<li><a href='evaluate_attendance.php?d=$enc_tp_id&tc=$enc_tc'>Attendance</a> is not yet evaluated.</li>";
             $isIncomplete = true;
        } else if($attendance_null == 0) {
            $isIncompelete = false;
        } else {
             $incomplete_details .= "<li>Incomplete evaluation for <a href='evaluate_attendance.php?d=$enc_tp_id&tc=$enc_tc'>Attendance</a>.</li>";
             $isIncompelete = true;
        }
        
        $stmt3 = $conn->prepare("SELECT COUNT(exam_id) AS count FROM final_written_exam WHERE attendance_id = :attendance_id AND trainee_id = :trainee_id");
        $stmt3->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
        $stmt3->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
        $stmt3->execute();
        $data3 = $stmt3->fetch();
        $written_exam_count = $data3['count'];
        if($written_exam_count == 0){
            $incomplete_details .= "<li><a href='evaluate_written_exam.php?d=$enc_tp_id&tc=$enc_tc'>Final written exam</a> is not yet graded.</li>";
            $isIncomplete = true;
        } else {
            $isIncomplete = false;
        }
        
        $stmt4 = $conn->prepare("SELECT COUNT(exam_id) AS count FROM product_knowledge_exam WHERE attendance_id = :attendance_id AND trainee_id = :trainee_id");
        $stmt4->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
        $stmt4->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
        $stmt4->execute();
        $data4 = $stmt4->fetch();
        $written_exam_count = $data4['count'];
        if($written_exam_count == 0){
            $incomplete_details .= "<li><a href='evaluate_product_knowledge.php?d=$enc_tp_id&tc=$enc_tc'>Product knowledge exam</a> is not yet graded.</li>";
            $isIncomplete = true;
        } else {
            $isIncomplete = false;
        }
        
        $stmt5 = $conn->prepare("SELECT COUNT(id) AS count FROM training_program_attendees WHERE attendance_id = :attendance_id AND general_assessment IS NULL AND trainee_id = :trainee_id");
        $stmt5->bindParam(":attendance_id",$attendance_id,PDO::PARAM_INT);
        $stmt5->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
        $stmt5->execute();
        $data5 = $stmt5->fetch();
        $gen_assessment_count = $data5['count'];
        if($gen_assessment_count == 1){
            $incomplete_details .= "<li>General assessment is not yet evaluated.</li>";
            $isIncomplete = true;
        } else {
            $isIncomplete = false;
        }
        
        if($incomplete_details != ""){
           $incomplete_details = "<ul>".$incomplete_details."</ul>";
           $output = " <a href='#' data-placement='top' data-toggle='popover' title='Evaluation Status' data-html='true' data-content=\"$incomplete_details\">Incomplete Evaluation</a>";
        }
        else {
            $output = $this->getGradeStatus($total_grade);
        }
        
        $conn->closeConnection();
        return $output;
    }

    public function getTrainingList($id){
    	$conn = new Connection();
    	$output = "";
    	$stmt = $conn->prepare("SELECT p.`title`, t.`first_name`,t.`middle_name`,t.`last_name`,t.`name_extension`,tp.`venue`,tp.`start_date`,tp.`end_date`,tpa.`training_program_id`,tp.`program_id` 
    		FROM ((training_program_attendees AS tpa INNER JOIN training_programs AS tp ON tpa.`training_program_id` = tp.`training_program_id`) 
    			INNER JOIN program AS p ON p.`program_code` = tp.`program_id`)
    			INNER JOIN trainor as t ON t.`trainor_id` = tp.`trainor_id`
    			 WHERE tpa.`trainee_id` = :trainee_id ORDER BY tp.`date_created`");
    	$stmt->bindParam(":trainee_id",$id,PDO::PARAM_STR);
    	$stmt->execute();
    	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    		$name = $conn->transformName1($row['first_name'],$row['middle_name'],$row['last_name'],$row['name_extension'],$conn);
    		
    		$attendance_id = $row['training_program_id'];
    		
    		$module_workshop_data = $this->getEvaluationWorkshop($attendance_id,$id);
			$attendance_data = $this->getEvaluationAttendance($attendance_id,$id);
			$product_knowledge_data = $this->getEvaluationProductKnowledgeExam($attendance_id,$id);
			$final_written_data = $this->getEvaluationWrittenExam($attendance_id,$id);
			$total_grade = $module_workshop_data['grade'] + $attendance_data['grade'] + $product_knowledge_data['grade'] + $final_written_data['grade'];
			$status = $this->getGradeStatus($total_grade);
            
            $module_count = $this->countModules($row['program_id'],$conn);
            
            $grade_status = $this->checkEvaluationStatus($attendance_id,$id,$module_count,$total_grade);
           

    		$output .= "<tr>";
    			$output .= "<td>" . $row['title'] . "</td>";
    			$output .= "<td>" . $name . "</td>";
    			$output .= "<td>" . $row['venue'] . "</td>";
    			$output .= "<td>" . $conn->format_date_only($row['start_date']) . "</td>";
    			$output .= "<td>" . $conn->format_date_only($row['end_date']) . "</td>";
    			$output .= "<td>" . $grade_status."</td>";
    		$output .= "</tr>";
    	}

    	$conn->closeConnection();
    	return $output;

    }

    public function getNameSuffixesList(){
    	$db = Database::getInstance();
    	$sql = "SELECT id,suffix FROM name_suffix ORDER BY suffix ASC";
    	$result = $db->query($sql,false);
    	return $result;
    }

    public function getDepartments(){
    	$conn = new Connection();
    	$output = "";
    	$stmt = $conn->prepare("SELECT id,description FROM department ORDER BY description ASC");
    	$stmt->execute();
    	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    		$output .= "<option value='".$row['id']."'>" . ucfirst($row['description']) . "</option>";
    	}
    	$conn->closeConnection();
    	return $output;
    }

    public function getEducation(){
    	$conn = new Connection();
    	$output = "";
    	$stmt = $conn->prepare("SELECT id,education_desc FROM education");
    	$stmt->execute();
    	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    		$output .= "<option value='".$row['id']."'>" . ucfirst($row['education_desc']) . "</option>";
    	}
    	$conn->closeConnection();
    	return $output;

    }

    public function getMobileList($trainee_id){
    	$db = Database::getInstance();
    	$sql = "SELECT id,trainee_id,mobile_no FROM trainee_mobile_no WHERE trainee_id = :trainee_id";
    	$result = $db->query($sql,array(":trainee_id"=>$trainee_id));
    	return $result;
    }

    public function addMobile($trainee_id,$mobile_no){
    	$db = Database::getInstance();
    	$sql = "INSERT INTO trainee_mobile_no(trainee_id,mobile_no) VALUES(:trainee_id,:mobile_no)";
    	$id = $db->query($sql,array(":trainee_id"=>$trainee_id,":mobile_no"=>$mobile_no));
    	return $id;
    }

    public function deleteMobile($id){
    	$db = Database::getInstance();
    	$sql = "DELETE FROM trainee_mobile_no WHERE id = :id";
    	$result = $db->query($sql,array(":id"=>$id));
    }

    public function addNameSuffix($name_suffix){
    	$db = Database::getInstance();
    	$sql = "INSERT INTO name_suffix(suffix) VALUES(:suffix)";
    	$result = $db->query($sql,array(":suffix"=>$name_suffix));
    }

    public function getSuffixList(){
    	$conn = new Connection();
    	$output = "";
    	$stmt = $conn->prepare("SELECT * FROM name_suffix ORDER BY suffix ASC");
    	$stmt->execute();
    	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    		$id = $row['id'];
    		$name_suffix = $row['suffix'];
    		$output .= "<tr>";
			$output .= "<td>
				<span class='name_suffix' title='Click to edit'>$name_suffix</span>
				<div class='input-group' style='display:none;'>
					<input type='text' style='text-align:center;border-right:none;' class='form-control input-md' value='$name_suffix' />
					<span class='input-group-addon' style='background-color:#ffffff;border-left:none;display:none;'><img src='../../../img/ajax-loader.gif' /></span>
					<span class='input-group-btn'>
						<button type='button' class='btn btn-primary btn-md btn_edit' data-id='$id'><i class='fa fa-save fa-1x'></i></button>	
					</span>
				</div>
			</td>";

			$output .= "<td><button type='button' data-id='$id' class='btn btn-danger btn-sm btn_delete'>Delete</button></td>";

			$output .= "</tr>";
    	}

    	$conn->closeConnection();

    	return $output;
    }

    public function updateSuffix($id,$suffix){
    	$db = Database::getInstance();
    	$sql = "UPDATE name_suffix SET suffix = :suffix WHERE id = :id";
    	$db->query($sql,array(":suffix"=>$suffix,":id"=>$id));
    }

    public function deleteSuffix($id){
    	$db = Database::getInstance();
    	$sql = "DELETE FROM name_suffix WHERE id = :id";
    	$db->query($sql,array(":id"=>$id));
    }

    public function getEmploymentStatusOptionProgram(){
    	$conn = new Connection();
    	$output = "";
    	$status1 = "Newly Hired";
    	$status2 = "Resigned";
    	$stmt = $conn->prepare("SELECT id,description FROM status WHERE description <> :status1 AND description <> :status2");
    	$stmt->bindParam(":status1",$status1,PDO::PARAM_STR);
    	$stmt->bindParam(":status2",$status2,PDO::PARAM_STR);
    	$stmt->execute();
    	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    		$output .= "<option value='".$row['id']."'>" . $row['description'] . "</option>";
    	}
    	return $output;
    }

    public function getTraineesList(){
    	$db = Database::getInstance();
    	$sql = "SELECT a.trainee_code,
				       FormatLastNameFirst(a.first_name,a.middle_name,a.last_name,b.suffix) trainee_name,
				       FormatTraineeId(a.trainee_code,c.dealer_abbrev) trainee_id
				FROM trainees_masterfile a 
				     LEFT JOIN name_suffix b ON b.id = a.name_suffix_id
				     LEFT JOIN dealers_master c ON c.id = a.dealer_id
				WHERE a.date_deleted IS NULL";
		$result = $db->query($sql,false);
		return $result;
    }
    
    public function getEducationList(){
    	$db = Database::getInstance();
    	$sql = "SELECT id,
    				   education_desc 
    			FROM education";
    	$result = $db->query($sql,false);
    	return $result;
    }
    
    public function getEmploymentStatusList(){
    	$db = Database::getInstance();
    	$sql = "SELECT id,
    				   description 
    			FROM employment_status";
    	$result = $db->query($sql,false);
    	return $result;
    }

    public function getDealershipHistory($trainee_id){
    	$db = Database::getInstance();
    	$sql = "SELECT a.id,
    				   b.dealer_name,
    				   d.description emp_status,
    				   c.job_description,
    				   a.date_hired,
    				   a.date_updated
    		 	FROM trainee_dealership_history a LEFT JOIN dealers_master b 
    		 			ON a.dealer_id = b.id
    		 		 LEFT JOIN job_position c 
    		 		    ON c.job_id = a.job_position_id
    		 		 LEFT JOIN employment_status d
    		 		 	ON d.id = a.employment_status_id
    		 	WHERE a.trainee_id = :trainee_id";
    	$result = $db->query($sql,array(":trainee_id"=>$trainee_id));
    	return $result;
    }

    public function getJobPositionHistory($trainee_id){
    	$db = Database::getInstance();
    	$sql = "SELECT a.id,
    				   b.dealer_name,
    				   d.description emp_status,
    				   c.job_description,
    				   a.date_hired,
    				   a.date_updated
    		 	FROM trainee_position_history a LEFT JOIN dealers_master b 
    		 			ON a.dealer_id = b.id
    		 		 LEFT JOIN job_position c 
    		 		    ON c.job_id = a.job_position_id
    		 		 LEFT JOIN employment_status d
    		 		 	ON d.id = a.employment_status_id
    		 	WHERE a.trainee_id = :trainee_id";
    	$result = $db->query($sql,array(":trainee_id"=>$trainee_id));
    	return $result;
    }

    public function getRandomTraineePerDealer($dealer_id,$trainee_code){
    	$db = Database::getInstance();
    	$sql = "SELECT a.trainee_code,
				       FormatFirstNameFirst(a.first_name,a.middle_name,a.last_name,b.suffix) trainee_name,
				       a.picture,
				       a.nickname,
				       a.first_name
				FROM trainees_masterfile a LEFT JOIN name_suffix b ON a.name_suffix_id = b.id 
				WHERE a.dealer_id = :dealer_id AND a.trainee_code <> :trainee_code
				ORDER BY RAND()
				LIMIT 10";
		$result = $db->query($sql,array(
									":dealer_id"=>$dealer_id,
									":trainee_code"=>$trainee_code
								   )
							);
		return $result;
    }

} // end of class

?>