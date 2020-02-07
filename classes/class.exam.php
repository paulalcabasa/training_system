<?php

class Exam {

	public function getExams($tp_id){
		$db = Database::getInstance();
		$sql = "SELECT te.exam_id,
					   pm.module_name,
					   te.exam,
					   te.module_id,
					   te.tp_id,
					   te.passing_score 
				FROM tp_exam te LEFT JOIN training_program_modules pm ON te.module_id = pm.id
				WHERE te.tp_id = :tp_id";
		$result = $db->query($sql,array(":tp_id"=>$tp_id));
		return $result;
	}

	public function updateExam($exam_id,$module_id,$exam,$passing_score,$user){
		$db = Database::getInstance();

		$sql = "UPDATE tp_exam SET module_id = :module_id,
								   exam = :exam, 
								   passing_score = :passing_score,
								   update_user = :user 
				WHERE exam_id = :id";
		$result = $db->query($sql,array(
								  	":module_id" => $module_id,
								  	":exam" => $exam,
								  	":passing_score" => $passing_score,
								  	":user" => $user,
								  	":id" => $exam_id
								  )
							);
	}

	public function getExamDetails($exam_id){
		$db = Database::getInstance();
		$sql = "SELECT te.exam_id,
					   pm.module_name,
					   te.exam,
					   te.module_id,
					   te.tp_id,
					   te.passing_score 
				FROM tp_exam te INNER JOIN program_module pm ON te.module_id = pm.module_id
				WHERE te.exam_id = :id";
		$result = $db->query($sql,array(":id"=>$exam_id));
		return (object)$result[0];
	}

	public function getExaminees($exam_id){
		$db = Database::getInstance();
		$sql = "SELECT a.id,
				       b.trainee_code,
				       FormatTraineeId(b.trainee_code,b.dealer_id,b.dealer_category) trainee_id,
				       FormatLastNameFirst(b.first_name,b.middle_name,b.last_name,d.suffix) trainee_name,
				       a.exam_id,
				       c.exam
				FROM trainee_exam_taken a LEFT JOIN 
				       trainees_masterfile b ON b.trainee_code = a.trainee_id
				     LEFT JOIN tp_exam c ON c.exam_id = a.exam_id
				     LEFT JOIN name_suffix d ON d.id = b.name_suffix_id
				where a.exam_id = :exam_id";
		$result = $db->query($sql,array(
									":exam_id"=>$exam_id
								  )
							);
		return $result;
	}

	public function addExaminee($trainee_id,$exam_id,$user,$tp_id,$tpa_id){
		$db = Database::getInstance();
		$sql = "INSERT INTO trainee_exam_taken(exam_id,trainee_id,tp_id,tpa_id,create_user,date_created)
				VALUES(:exam_id,:trainee_id,:tp_id,:tpa_id,:create_user,NOW())";
		$result = $db->query($sql,array(
									":exam_id" 		=> $exam_id,
									":trainee_id" 	=> $trainee_id,
									":create_user" 	=> $user,
									":tp_id" 		=> $tp_id,
									":tpa_id" 		=> $tpa_id
								  )
							);
	}
	
	public function getExamAnswerSheet($trainee_id,$exam_id){
		$conn = new Connection();
		$output = "";
		$get_items = $conn->prepare("SELECT item_id,exam_id,question,choice_id FROM tp_exam_items WHERE exam_id = :exam_id ORDER BY item_id ASC");
		$get_items->bindParam(":exam_id",$exam_id,PDO::PARAM_INT);
		$get_items->execute();
		$index = 1;
		$radio_ctr = 1;
		while($questions = $get_items->fetch(PDO::FETCH_ASSOC)){
			$item_id = $questions['item_id'];
			$correct_answer = $questions['choice_id'];
			$trainee_answer = $this->getTraineeAnswer($trainee_id,$item_id);
			$choices = "";
			$get_choices = $conn->prepare("SELECT choice_id,choice FROM tp_exam_choices WHERE item_id = :item_id ORDER BY choice_id ASC");
			$get_choices->bindParam(":item_id",$item_id,PDO::PARAM_INT);
			$get_choices->execute();
			while($choice_list = $get_choices->fetch(PDO::FETCH_ASSOC)){
				$choice_id = $choice_list['choice_id'];
				$choice_name = $choice_list['choice'];
				$isTraineeAnswer = ($trainee_answer == $choice_id) ? "checked" : "";
				if($choice_id == $correct_answer){
					$choices .= "<li>
	                    <div class='radio radio-danger'>
	                        <input name='"."exam_choice".($index)."' data-item_id='".$item_id."' class='rdo_answer' value='$choice_id' type='radio' id='"."rdo_choice".($radio_ctr)."' $isTraineeAnswer>
	                        <label for='"."rdo_choice".($radio_ctr)."'><em style='color:red;'>$choice_name</em></label>
	                    </div>
	                </li>";
				}
				else {
					$choices .= "<li>
	                    <div class='radio'>
	                        <input name='"."exam_choice".($index)."' data-item_id='".$item_id."' class='rdo_answer' value='$choice_id' type='radio' id='"."rdo_choice".($radio_ctr)."' $isTraineeAnswer>
	                        <label for='"."rdo_choice".($radio_ctr)."'>$choice_name</label>
	                    </div>
                    </li>";
                }
                $radio_ctr++; 
			}


			$output .= "<div class='exam_item'>";
			$output .= "<p class='exam_question'>" .$index . ". " . $questions['question'] . "</p>";
           	$output .= "<ol type='a' style='list-style-type:none;'>" . $choices . "</ol>";  
			$output .= "</div>";

			$index++;
		}


		$conn->closeConnection();
		return $output;

	}

	public function addExam($tp_id,$program_id,$module_id,$exam,$passing_score,$create_user){
		$db = Database::getInstance();
		$sql = "INSERT INTO tp_exam(tp_id,program_id,module_id,exam,passing_score,create_user,date_created)
				VALUES(:tp_id,:program_id,:module_id,:exam,:passing_score,:create_user,NOW())";
		$db->query($sql,array(
							":tp_id" 			=> $tp_id,
							":program_id" 		=> $program_id,
							":module_id" 		=> $module_id,
							":exam" 			=> $exam,
							":passing_score" 	=> $passing_score,
							":create_user" 		=> $create_user
						)
				  );
	}

	public function addExamQuestion($exam_id,$question,$create_user){
		$db = Database::getInstance();
		$sql = "INSERT INTO tp_exam_items(exam_id,question,create_user,date_created) 
				VALUES(:exam_id,:question,:create_user,NOW())";
		$exam_id = $db->query($sql,array(
								   		":exam_id" => $exam_id,
								   		":question" => $question,
								   		":create_user" => $create_user
								   )
							 );
		return $exam_id;
	}

	public function addQuestionChoices($item_id,$choice){
		$db = Database::getInstance();
		$sql = "INSERT INTO tp_exam_choices(item_id,choice) VALUES(:item,:choice)";
		$choice_id = $db->query($sql,array(
										":item" 	=> $item_id,
										":choice" 	=> $choice
									 )
							   );
		return $choice_id;
	}

	public function setQuestionAnswer($item_id,$choice_id,$user){
		$db = Database::getInstance();
		$sql = "UPDATE tp_exam_items 
				SET choice_id = :choice,
					update_user = :update_user, 
					date_updated = NOW()
				WHERE item_id = :item";
		$db->query($sql,array(
							":choice" 		=> $choice_id,
							":update_user"  => $user,
							":item" 		=> $item_id
						)
				  );
	}

	public function getQuestionChoicesList($item_id){
		$db = Database::getInstance();
		$sql = "SELECT choice_id,choice 
				FROM tp_exam_choices 
				WHERE item_id = :item_id 
				ORDER BY choice_id ASC";
		$result = $db->query($sql,array(
								  	":item_id" => $item_id
								  )
							);
		return $result;
	}

	public function updateQuestion($item_id,$question){
		$db = Database::getInstance();
		$sql = "UPDATE tp_exam_items 
				SET question = :question 
				WHERE item_id = :item_id";
		$db->query($sql,array(
							":question"	=> $question,
							":item_id"  => $item_id
						)
				  );
	}

	public function updateChoice($choice_id,$choice){
		$db = Database::getInstance();
		$sql = "UPDATE tp_exam_choices 
				SET choice = :choice 
				WHERE choice_id = :id";
		$db->query($sql,array(
							":choice" => $choice,
							":id"	  => $choice_id
						)
		);
	}

	public function deleteChoice($choice_id){
		$db = Database::getInstance();
		$sql = "DELETE 
				FROM tp_exam_choices 
				WHERE choice_id = :id";
		$db->query($sql,array(":id"=>$choice_id));	
	}

	public function getAnswerKey($exam_id){
		$conn = new Connection();
		$output = "";
		$get_items = $conn->prepare("SELECT item_id,exam_id,question,choice_id FROM tp_exam_items WHERE exam_id = :exam_id ORDER BY item_id ASC");
		$get_items->bindParam(":exam_id",$exam_id,PDO::PARAM_INT);
		$get_items->execute();
		$index = 1;
		while($questions = $get_items->fetch(PDO::FETCH_ASSOC)){
			$item_id = $questions['item_id'];
			$correct_answer = $questions['choice_id'];
		
			$choices = "";
			$get_choices = $conn->prepare("SELECT choice_id,choice FROM tp_exam_choices WHERE item_id = :item_id ORDER BY choice_id ASC");
			$get_choices->bindParam(":item_id",$item_id,PDO::PARAM_INT);
			$get_choices->execute();
			while($choice_list = $get_choices->fetch(PDO::FETCH_ASSOC)){
				$choice_id = $choice_list['choice_id'];
				$choice_name = $choice_list['choice'];
	
				if($choice_id == $correct_answer){
					$choices .= "<li><em style=\"color:red;\">$choice_name</em></li>";
				}
				else {
					$choices .= "<li>$choice_name</li>";
                }
    
			}
			$output .= "<p style=\"font-size:10px;\">" .$index . ". " . $questions['question'] . "</p>";
           	$output .= "<ol type=\"a\" style=\"font-size:10px;\">" . $choices . "</ol>";  
			

			$index++;
		}
		$conn->closeConnection();
		return $output;
	}

	public function getExamQuestionsList($exam_id){
		$db = Database::getInstance();
		$sql = "SELECT item_id,question,choice_id 
				FROM tp_exam_items 
				WHERE exam_id = :exam_id 
				ORDER BY item_id ASC";
		$result = $db->query($sql,array(":exam_id" => $exam_id));
		return $result;
	}

	public function getTraineeAnswerByItem($trainee_exam_taken_id,$item_id){
		$db = Database::getInstance();
		$sql = "SELECT choice_id 
				FROM trainee_exam_answers 
				WHERE trainee_exam_taken_id = :trainee_exam_taken_id 
					  AND item_id = :item_id";
		$result = $db->query($sql,array(
									":trainee_exam_taken_id"	=>	$trainee_exam_taken_id,
									":item_id"				    =>	$item_id
								  )
							);
		if(!empty($result)){
			$result = (object)$result[0];
			return $result->choice_id;
		}
		else {
			return null;
		}
	}

	public function setTraineeExamAnswer($trainee_exam_taken_id,$item_id,$choice_id,$update_user){
		$db = Database::getInstance();
		$answered_flag_sql = "SELECT COUNT(id) answer_total 
							  FROM trainee_exam_answers 
							  WHERE trainee_exam_taken_id = :trainee_exam_taken_id 
							  	    AND item_id = :item_id";
		$answered_flag_result = $db->query($answered_flag_sql,array(
													":trainee_exam_taken_id" => $trainee_exam_taken_id,
													":item_id"	  			 => $item_id,
												)
										  );
		$answered_flag_result = (object)$answered_flag_result[0];

		if($answered_flag_result->answer_total == 1){
			$update_answer_sql = "UPDATE trainee_exam_answers 
								  SET choice_id = :choice,
								  	  update_user = :update_user,
								  	  date_updated = NOW() 
								  WHERE trainee_exam_taken_id = :trainee_exam_taken_id 
								  		AND item_id = :item_id";
			$db->query($update_answer_sql,array(
											":trainee_exam_taken_id"  => $trainee_exam_taken_id,
										  	":item_id"	   			  => $item_id,
										  	":choice" 	   			  => $choice_id,
										  	":update_user" 			  => $update_user,
										  )
					  );
		}
		else {
			$insert_answer_query = "INSERT INTO trainee_exam_answers(trainee_exam_taken_id,item_id,choice_id,create_user,date_created) 
									VALUES(:trainee_exam_taken_id,:item_id,:choice_id,:create_user,NOW())";
			$db->query($insert_answer_query,array(
												":trainee_exam_taken_id"  => $trainee_exam_taken_id,
											  	":item_id"	   => $item_id,
												":choice_id"   => $choice_id,
											  	":create_user" => $update_user
											)
					   );
		}
	}

	public function getTraineeExamScore($trainee_exam_taken_id,$questions_list){
		$db = Database::getInstance();
		$total_items = 0;
		$score = 0;
		foreach($questions_list as $question){
			$question = (object)$question;
			$trainee_answer = $this->getTraineeAnswerByItem($trainee_exam_taken_id,$question->item_id);
			if($question->choice_id == $trainee_answer){
				$score++;
			}
			$total_items++;
		}
		return $score;
	}

	public function getTraineeExamAnswers($trainee_exam_taken_id){
		$db = Database::getInstance();
		$sql = "SELECT id,
					   item_id,
					   choice_id
				FROM trainee_exam_answers 
				WHERE trainee_exam_taken_id = :trainee_exam_taken_id";
		$result = $db->query($sql,array(
									":trainee_exam_taken_id" => $trainee_exam_taken_id
								  )
							);
		return $result;
	}

	public function getExamRemarks($trainee_answers_total,$total_items,$percentage_score,$passing_score){
		if($trainee_answers_total != $total_items){
		    $remarks = "<span class='label label-warning'>Incomplete answer</span>";
		}
		else {
		    $remarks = $percentage_score >= $passing_score ? "<span class='label label-success'>Passed</span>" : "<span class='label label-danger'>Failed</span>";
		}

		return $remarks;
	}

	public function getTraineeWhoAnsweredPerItem($item_id,$choice_id){
		$ctr = 0;
		$db = Database::getInstance();
		$sql = "SELECT a.id,
				   FormatFirstNameFirst(c.first_name,c.middle_name,c.last_name,d.suffix) trainee_name
				FROM trainee_exam_answers a LEFT JOIN trainee_exam_taken b 
					ON b.id = a.trainee_exam_taken_id
				 LEFT JOIN trainees_masterfile c 
					ON c.trainee_code = b.trainee_id
				  LEFT JOIN name_suffix d 
					ON c.name_suffix_id = d.id
				WHERE a.choice_id = :choice_id 
					  AND a.item_id = :item_id
				";
		$result = $db->query($sql,array(
								":choice_id" => $choice_id,
								":item_id"   => $item_id
							)
				  );
		return $result;
	}

	public function getExamineesByExam($exam_id){
		$db = Database::getInstance();
		$sql = "SELECT id,
		               trainee_id,
		               trainee_name,
		               exam_no
		        FROM v_examinees
		        WHERE exam_id = :exam_id
		        ORDER by trainee_name ASC";
		$result = $db->query($sql,array(":exam_id" => $exam_id));
		return $result;
	}

	public function getTraineeExamTakenDetails($id){
		$db = Database::getInstance();
		$sql = "SELECT a.id,
				       a.exam_id,
				       a.trainee_id,
				       b.exam,
				       b.passing_score,
				       f.module_name,
				       FormatFirstNameFirst(c.first_name,c.middle_name,c.last_name,d.suffix) trainee_name,
				       e.dealer_name
				FROM trainee_exam_taken a LEFT JOIN tp_exam b
				       ON a.exam_id = b.exam_id
				     LEFT JOIN trainees_masterfile c
				       ON a.trainee_id = c.trainee_code
				     LEFT JOIN name_suffix d
				       ON d.id = c.name_suffix_id
				     LEFT JOIN dealers_master e
				       ON e.id = c.dealer_id
				     LEFT JOIN training_program_modules f
				       ON f.id = b.module_id
				WHERE a.id = :id";
		$result = $db->query($sql,array(":id"=>$id));
		return (object)$result[0];
	}

	public function getExamineesListByExamDetails($exam_id){
		$db = Database::getInstance();
		$sql = "SELECT a.id,
				       b.trainee_code,
				       FormatTraineeId(b.trainee_code,e.dealer_abbrev) trainee_id,
				       FormatLastNameFirst(b.first_name,b.middle_name,b.last_name,d.suffix)  AS trainee_name,
				       a.exam_id,
				       GetExamScore(a.id) score,
				       FormatExamNo(a.id) exam_no
				FROM sys_training.trainee_exam_taken a
				   LEFT JOIN sys_training.trainees_masterfile b
				       ON b.trainee_code = a.trainee_id
				   LEFT JOIN sys_training.tp_exam c
				      ON c.exam_id = a.exam_id
				   LEFT JOIN sys_training.name_suffix d
				     ON d.id = b.name_suffix_id
				   LEFT JOIN sys_training.dealers_master e
				     ON e.id = b.dealer_id
				WHERE a.exam_id = :exam_id";
		$result = $db->query($sql,array(":exam_id" => $exam_id));
		return $result;
	}

	public function getExamByParticipantByModule($participant_id,$module_id){
		$db = Database::getInstance();
		$sql = "SELECT tet.id,
				       tet.tpa_id,
				       te.exam,
				       te.passing_score,
				       tpm.module_name,
				       te.module_id,
				       te.exam_id
				FROM trainee_exam_taken tet LEFT JOIN tp_exam te
					ON tet.exam_id = te.exam_id
				     LEFT JOIN training_program_modules tpm
					ON tpm.id = te.module_id
				WHERE tet.tpa_id = :participant_id
				      AND te.module_id = :module_id";
		$result = $db->query($sql,array(
								  	":participant_id" => $participant_id,
								  	":module_id" 	  => $module_id
								  )
							);
		return $result;
	}

	public function getExamScoreByParticipant($participant_id){
		$db = Database::getInstance();
		$sql = "SELECT GetExamScore(id) score
				FROM sys_training.trainee_exam_taken
				WHERE tpa_id = :tpa_id";
		$result = $db->query($sql,array(":tpa_id"=>$participant_id));
		return $result[0]['score'];
	}

}