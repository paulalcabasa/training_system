<?php

class Program {

	public function addProgram($category_id,$title,$description,$objectives,$modules,$module_ctr,$create_user){
		$db = Database::getInstance();
		$sql = "INSERT INTO program(program_category_id,title,description,objectives,create_user,date_created) 
				VALUES(:category_id,:title,:description,:objectives,:create_user,NOW())";
		$program_id = $db->query($sql,array(
										":category_id"	=>	$category_id,
										":title"		=>	$title,
										":description"	=>	$description,
										":objectives"   =>  $objectives,
										":create_user"  =>  $create_user
									  )
								);


		if($module_ctr > 0){
			$sql = "INSERT INTO program_module(program_code,module_name,create_user,date_created) 
					VALUES(:program_code,:module_name,:create_user,NOW())";
			foreach($modules as $module_name){
				$db->query($sql,array(
									":program_code" => $program_id,
									":module_name"  => $module_name,
									":create_user"  => $create_user
								)
						  );
			}
		}
		return $program_id;
	}

	public function getCategory($id,$conn){
		$stmt = $conn->prepare("SELECT category_name FROM program_category WHERE program_category_id = :id");
		$stmt->bindParam(":id",$id,PDO::PARAM_INT);
		$stmt->execute();
		$data = $stmt->fetch();
		return $data['category_name'];
	}

	public function countModules($id,$conn){
		$stmt = $conn->prepare("SELECT COUNT(*) as no_of_modules FROM program_module WHERE program_code = :id");
		$stmt->bindParam(":id",$id,PDO::PARAM_INT);
		$stmt->execute();
		$data = $stmt->fetch();
		return $data['no_of_modules'];
	}

	public function getPrequisites($id){
		$conn = new Connection();
		$output = "<div class='checkbox checkbox-primary'>
                        <input type='checkbox' class='toggle_check'/>
                        <label>Check / Uncheck All</label>
                   	</div>";
		$output .= "<ul class='list-group'>";
		
		$stmt = $conn->prepare("SELECT program_prereq_code FROM program_prereq WHERE program_code = :id");
		$stmt->bindParam(":id",$id,PDO::PARAM_INT);
		$stmt->execute();
		$prequisites = $stmt->fetchAll(PDO::FETCH_COLUMN,0);

		$get_programs = $conn->prepare("SELECT program_code,title FROM program WHERE program_code <> :id ORDER BY title ASC");
		$get_programs->bindParam(":id",$id,PDO::PARAM_INT);
		$get_programs->execute();

		while($row = $get_programs->fetch(PDO::FETCH_ASSOC)){
			$program_code = $row['program_code'];
			$title = $row['title'];
			$output .= "<li class='list-group-item itm_prereq'>
			  				<div class='checkbox checkbox-primary'>
                        		<input type='checkbox' value='$program_code' class='cb_prereq_opts' ";
                        if(in_array($program_code,$prequisites)){
                        	$output .= "checked = true ";
                        }

            $output .= "/>
                        		<label>$title</label>
                    		</div>
                    	</li>";
		}

		$output .= "</ul>";
		$conn->closeConnection();

		return $output;
	}

	public function deleteProgram($program_code,$user){
		$db = Database::getInstance();

		$sql = "UPDATE program SET delete_user = :delete_user,
								   date_deleted = NOW()
				WHERE program_code = :program_code";
		$db->query($sql,array(":program_code"=>$program_code,":delete_user"=>$user));

	/*	$delete_material_files = $conn->prepare("SELECT * FROM program_materials WHERE program_code = :id");
		$delete_material_files->bindParam(":id",$this->program_code,PDO::PARAM_INT);
		$delete_material_files->execute();
		while($material = $delete_material_files->fetch(PDO::FETCH_ASSOC)){
			unlink("../file_storage/" . $material['file_dest']);
		}

		$delete_material_info = $conn->prepare("DELETE FROM program_materials WHERE program_code = :id");
		$delete_material_info->bindParam(":id",$this->program_code,PDO::PARAM_INT);
		$delete_material_info->execute();

		$delete_module = $conn->prepare("DELETE FROM program_module WHERE program_code = :id");
		$delete_module->bindParam(":id",$this->program_code,PDO::PARAM_INT);
		$delete_module->execute();

		$delete_prereq = $conn->prepare("DELETE FROM program_prereq WHERE program_code = :id");
		$delete_prereq->bindParam(":id",$this->program_code,PDO::PARAM_INT);
		$delete_prereq->execute();

		$conn->closeConnection();*/

	}

	public function savePreReqs(){
		$conn =  new Connection();

		$clear_prereqs = $conn->prepare("DELETE FROM program_prereq WHERE program_code = :program_code");
		$clear_prereqs->bindParam(":program_code",$this->program_code,PDO::PARAM_INT);
		$clear_prereqs->execute();
		
		if($this->pre_reqs != ""){
			$list_of_prereqs = explode(";",$this->pre_reqs);
			foreach($list_of_prereqs as $pre_req){
				$insert_data = $conn->prepare("INSERT INTO program_prereq(program_code,program_prereq_code) VALUES(:program_code,:pre_req_code)");
				$insert_data->bindParam(":program_code",$this->program_code,PDO::PARAM_INT);
				$insert_data->bindParam(":pre_req_code",$pre_req,PDO::PARAM_INT);
				$insert_data->execute();
			}
			
		}

		$conn->closeConnection(); 
	}

	public function getModules($id){
		$conn = new Connection();
		$output = "";
		$stmt = $conn->prepare("SELECT module_name,module_id FROM program_module WHERE program_code = :id");
		$stmt->bindParam(":id",$id,PDO::PARAM_INT);
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$module_id = $row['module_id'];
			$name = $row['module_name'];
			$output .= "<tr>";
				$output .= "<td>" . $name . "</td>";
				$output .= "<td><div class='btn-group'>
						   <button type='button' class='btn btn-info btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
						    Action <span class='caret'></span>
						    </button>
						  <ul class='dropdown-menu dropdown-menu-right'>
						    <li><a href='#' class='btn_edit' data-id='$module_id' data-name='$name'><i class='fa fa-edit fa-1x'></i> Edit</a></li>
						    <li><a href='#' class='btn_delete' data-id='$module_id' data-name='$name'><i class='fa fa-remove fa-1x'></i> Delete</a></li>

						  </ul>
						</div></td>";
			
			$output .= "</tr>";
		}
		$conn->closeConnection();
		return $output;
	}

	public function deleteModule($id){
		$db = Database::getInstance();
		$sql = "DELETE FROM program_module WHERE module_id = :id";
		$db->query($sql,array(":id"=>$id));
	}

	public function updateModule($module_id,$module_name,$update_user){
		$db = Database::getInstance();
		$sql = "UPDATE program_module SET module_name = :module_name, 
										  update_user = :update_user,
										  date_updated = NOW()
			   WHERE module_id = :module_id";
		$db->query($sql,array(
							":module_name"=>$module_name,
							":update_user" => $update_user,
							":module_id" => $module_id
						)
				   );
	}

	public function addModule($program_code,$module_name,$create_user){
		$db = Database::getInstance();
		$sql = "INSERT INTO program_module(program_code,module_name,create_user,date_created) 
				VALUES(:program_code,:module_name,:create_user,NOW())";
		$db->query($sql,array(
							":program_code"=>$program_code,
							":module_name"=>$module_name,
							":create_user"=>$create_user
						)
				   );
	}

	public function getProgramDetails($program_code){
		$db = Database::getInstance();
		$sql = "SELECT a.program_code,
					   a.program_category_id,
					   a.title,
					   a.description,
					   a.objectives,
					   b.category_name 
				FROM program a LEFT JOIN program_category b 
						ON a.program_category_id = b.program_category_id 
				WHERE a.program_code = :id 
				LIMIT 1";
		$result = $db->query($sql,array(":id"=>$program_code));
		$data = (object)$result[0];
		return $data;
	}


	public function updateProgram($program_code,$category,$title,$description,$objectives,$user){
		$db = Database::getInstance();
		$sql = "UPDATE program SET program_category_id = :category,
								   title = :title, 
								   description = :description, 
								   objectives = :objectives, 
								   update_user = :update_user,
								   date_updated = NOW()
				WHERE program_code = :program_code";
		$db->query($sql,array(
							":category" => $category,
							":title" => $title,
							":description" => $description,
							":objectives" => $objectives,
							":update_user" => $user,
							":program_code" => $program_code
						)
				  );
	}

	public function addMaterial($program_code,$filename,$new_file_name,$create_user){
		$db = Database::getInstance();
	    $sql = "INSERT INTO program_materials(program_code,filename,file_dest,create_user,date_created) 
	    		VALUES(:program_code,:filename,:file_dest,:create_user,NOW())";
        $db->query($sql,array(
        					":program_code" => $program_code,
        					":filename" => $filename,
        					":file_dest" => $new_file_name,
        					":create_user" => $create_user
        				)
        		  );
	}

	public function getMaterials($program_code){
		$conn = new Connection();
		$stmt = $conn->prepare("SELECT a.`material_id`,a.`file_dest`,a.`filename`,CONCAT(b.`last_name`,', ',b.`first_name`,' ', LEFT(b.`middle_name`,1),'.') uploaded_by,a.`last_user_create` FROM program_materials a INNER JOIN ipc_central.`personal_information_tab` b ON a.`uploaded_by` = b.`employee_id` WHERE a.program_code = :code");
		$stmt->bindParam(":code",$program_code,PDO::PARAM_INT);
		$stmt->execute();
		$output = "";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$id = $row['material_id'];
			$file_dest = $row['file_dest'];
			$file_name = $row['filename'];
			$uploaded_by = $row['uploaded_by'];
			$date_uploaded = $row['last_user_create'];
			$output .= "<tr>";
			$output .= "<td>" .$file_name. "</td>";
			$output .= "<td>" .$uploaded_by. "</td>";
			$output .= "<td>" .$date_uploaded. "</td>";
			$output .= "<td>" ."<a href='file_storage/$file_dest' target='_blank' class='btn btn-primary btn-sm'><i class='fa fa-eye fa-1x'></i> View</a>". "</td>";
			$output .= "<td>" ."<a href='file_storage/$file_dest' class='btn btn-success btn-sm' download><i class='fa fa-download fa-1x'></i> Download</a>". "</td>";
			$output .= "<td>" ."<a href='#' data-id='$id' data-name='$file_name' data-destination='$file_dest' class='btn btn-danger btn-sm btn_delete'><i class='fa fa-trash fa-1x'></i> Delete</a>". "</td>";
			$output .= "</tr>";
		}

		return $output;
	}

	public function deleteMaterial($id,$file_dest){
		$db = Database::getInstance();
		unlink("../file_storage/" . $file_dest);
		$sql = "DELETE FROM program_materials WHERE id = :id";
		$db->query($sql,array(":id"=>$id));
	}

	public function countProgramModules($program_code){
		$conn = new Connection();
		$stmt = $conn->prepare("SELECT COUNT(module_id) as ids FROM program_module WHERE program_code = :program_code");
		$stmt->bindParam(":program_code",$program_code,PDO::PARAM_INT);
		$stmt->execute();
		$data = $stmt->fetch();
		return $data['ids'];
	}

	public function getDateToday(){
		$now = new DateTime();
		$now->setTimezone(new DateTimeZone('Asia/Taipei'));
		$today = $now->format('Y-m-d H:i:s');
		return $today;
	}

	public function getProgramsExcept($program_code){
		$output = "";
		$conn = new Connection();
		$get_category = $conn->prepare("SELECT category_name,program_category_id FROM program_category");
		$get_category->execute();
		while($category = $get_category->fetch(PDO::FETCH_ASSOC)){
			$id = $category['program_category_id'];
			$output .= "<optgroup label='".$category['category_name']."'>";
			$get_programs = $conn->prepare("SELECT * FROM program WHERE program_category_id = :id AND program_code <> :program_code");
			$get_programs->bindParam(":id",$id,PDO::PARAM_INT);
			$get_programs->bindParam(":program_code",$program_code,PDO::PARAM_INT);
			$get_programs->execute();
			while($programs = $get_programs->fetch(PDO::FETCH_ASSOC)){
				$prog_id = $programs['program_code'];
				$name = $programs['title'];
				$output .= "<option value='".$prog_id."'>$name</option>";
			}

			$output .= "</optgroup>";
		}
		$conn->closeConnection();
		return $output;
	}

	public function createTrainingProgram($program_id,$trainor_id,$venue,$start_date,$end_date,$user){
		$conn = new Connection();

		$today = $conn->getDateToday();

		$stmt = $conn->prepare("INSERT INTO training_programs(program_id,trainor_id,venue,start_date,end_date,create_user,date_created) VALUES(:program_id,:trainor_id,:venue,:start_date,:end_date,:create_user,:date_created)");
		$stmt->bindParam(":program_id",$program_id,PDO::PARAM_INT);
		$stmt->bindParam(":trainor_id",$trainor_id,PDO::PARAM_INT);
		$stmt->bindParam(":venue",$venue,PDO::PARAM_STR);
		$stmt->bindParam(":start_date",$start_date,PDO::PARAM_STR);
		$stmt->bindParam(":end_date",$end_date,PDO::PARAM_STR);
		$stmt->bindParam(":create_user",$user,PDO::PARAM_STR);
		$stmt->bindParam(":date_created",$today,PDO::PARAM_STR);
		$stmt->execute();
		$id = $conn->lastInsertId();
		$conn->closeConnection();
		return $id;
	}

	public function getTrainingPrograms(){
		$conn = new Connection();
		$output = "";
		$stmt = $conn->prepare("SELECT  t.`first_name`,t.`middle_name`,t.`last_name`,t.`name_extension`,p.`title`,tp.`start_date`,tp.`end_date`,tp.`venue`,tp.`training_program_id`,ns.suffix
						FROM (((training_programs AS tp INNER JOIN program AS p ON tp.`program_id` = p.`program_code`) 
							INNER JOIN trainor AS t ON t.`trainor_id` = tp.`trainor_id`)
							LEFT JOIN name_suffix ns ON t.name_extension = ns.id)
							ORDER BY tp.`date_created` ASC");
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$enc_tp_id = $conn->encryptor("encrypt",$row['training_program_id']);
			$output .= "<tr>";
			$output .= "<td>".$row['title']."</td>";	
			$output .= "<td>" .$conn->transformName1($row['first_name'],$row['middle_name'],$row['last_name'],$row['suffix'],$conn) . "</td>";
			$output .= "<td>".$row['venue']."</td>";
			$output .= "<td>".$conn->format_date_only($row['start_date'])."</td>";
			$output .= "<td>".$conn->format_date_only($row['end_date'])."</td>";
			$output .= "<td>
						<div class='btn-group'>
						   <button type='button' class='btn btn-info btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
						    Action <span class='caret'></span>
						    </button>
						  <ul class='dropdown-menu dropdown-menu-right'>
						    <li><a href='training_program_attendees.php?d=$enc_tp_id'><i class='fa fa-users fa-1x'></i> View Trainees</a></li>
						    <li><a href='add_training_program_attendees.php?d=$enc_tp_id'><i class='fa fa-user-plus fa-1x'></i> Add Trainees</a></li>
						    <li><a href='training_attendance.php?d=$enc_tp_id'><i class='fa fa-clock-o fa-1x'></i> Attendance</a></li>
						    <li><a href='view_tp_exams.php?d=$enc_tp_id'><i class='fa fa-file-text fa-1x'></i> Examinations</a></li>
						    <li role='separator' class='divider'></li>
						    <li><a href='update_training_program.php?d=$enc_tp_id'><i class='fa fa-edit fa-1x'></i> Edit</a></li>
						    <li><a href='#' class='btn_delete' data-id='".$row['training_program_id']."'><i class='fa fa-trash fa-1x'></i> Delete</a></li>
						  </ul>
						</div>

			</td>";
			$output .= "</tr>";
		}
		$conn->closeConnection();
		return $output;
	}

	
	
	function getIntersection($a1,$a2,$b1,$b2){
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

	public function checkSchedule($trainee_code,$tp_id,$conn){
		$selected_tp = $this->getTrainingProgramInfo($tp_id);
		$start_date = $selected_tp['start_date'];
		$end_date = $selected_tp['end_date'];
		$daterange1 = array($start_date, $end_date);
		$ctr = 0;
	
		$trainings_assigned = $conn->prepare("SELECT training_program_id FROM training_program_attendees WHERE trainee_id = :trainee_id AND training_program_id <> :tp_id");
		$trainings_assigned->bindParam(":trainee_id",$trainee_code,PDO::PARAM_INT);
		$trainings_assigned->bindParam(":tp_id",$tp_id,PDO::PARAM_INT);
		$trainings_assigned->execute();
		while($row = $trainings_assigned->fetch(PDO::FETCH_ASSOC)){
			$program_info = $this->getTrainingProgramInfo($row['training_program_id']);
			$program_start_date = $program_info['start_date'];
			$program_end_date = $program_info['end_date'];
			$intersection = $this->getIntersection($start_date,$end_date,$program_start_date,$program_end_date);
			if($intersection !== false){
				$ctr++;
			} 
		}
		
		return $ctr;
	}

	public function getListOfTrainees($trainee,$tp_id){
		$conn = new Connection();
		$output = "";

		$stmt = $conn->query("SELECT tm.trainee_code,tm.first_name,tm.middle_name,tm.last_name,tm.dealer_id,tm.dealer_category,tm.picture,
									 ns.suffix,
									 jp.job_description 
									FROM ((trainees_masterfile AS tm INNER JOIN job_position AS jp ON tm.`job_position` = jp.`job_id`)
											LEFT JOIN name_suffix ns ON tm.name_suffix_id = ns.id)
									WHERE tm.isDeleted IS NULL
									ORDER BY tm.last_name ASC, tm.first_name ASC");
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$id = $row['trainee_code'];

			$isExist = $this->checkTraineeExistence($id,$tp_id);
			
			if(!$isExist){	
				
					$name = $conn->transformName1($row['first_name'],$row['middle_name'],$row['last_name'],$row['suffix'],$conn);
					if($row['dealer_category'] == "main"){
						$trainee_details = $trainee->getDealerName($row['dealer_id'],"dealer_main","dealer_main_name","dealer_main_id",$conn);
					}
					else {
						$trainee_details = $trainee->getDealerName($row['dealer_id'],"dealer_satellite","dealer_satellite_name","dealer_satellite_id",$conn);
					}	
					$trainee_code = $trainee->transformCode($row['trainee_code']);
					$enc_tc = $this->encryptor("encrypt",$id);

				$conflict_ctr = $this->checkSchedule($id,$tp_id,$conn);
				if($conflict_ctr == 0){

					$output .= "<tr>";

						$output .= "<td>".$trainee_details['abbrev'] . "-" . $trainee_code. "</td>";
						$output .= "<td>".$name."</td>";
						$output .= "<td>".$trainee_details['name']."</td>";
						$output .= "<td>".$row['job_description']."</td>";
						$output .= "<td><button type='button' class='btn btn-primary btn-sm btn_add_trainee' data-trainee_id='".$id."' data-tp_id='".$tp_id."'><i class='fa fa-user-plus'></i> Add</button></td>";
					$output .= '</tr>';
				}
				
			}
		}
	
		$conn->closeConnection();
		return $output;
	}


	public function getTrainingProgramAttendees($trainee,$tp_id,$program_code){
		$conn = new Connection();
		$output = "";
	
		$stmt = $conn->prepare("SELECT tm.trainee_code,tm.first_name,tm.middle_name,tm.last_name,tm.dealer_id,tm.dealer_category,tm.picture,
									   jp.job_description,
									   ns.suffix
								FROM (((training_program_attendees AS tpa INNER JOIN trainees_masterfile AS tm ON tpa.`trainee_id` = tm.`trainee_code`) 
										INNER JOIN job_position AS jp ON tm.`job_position` = jp.`job_id`)
										LEFT JOIN name_suffix ns ON ns.id = tm.name_suffix_id)
										WHERE tpa.`training_program_id` = :tp_id AND tm.isDeleted IS NULL");
		$stmt->bindParam(":tp_id",$tp_id,PDO::PARAM_INT);
		
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

			$name = $conn->transformName1($row['first_name'],$row['middle_name'],$row['last_name'],$row['suffix'],$conn);
			$id = $row['trainee_code'];
			
			if($row['dealer_category'] == "main"){
				$dealer_name = $trainee->getDealerName($row['dealer_id'],"dealer_main","dealer_main_name","dealer_main_id",$conn);
			}
			else {
				$dealer_name = $trainee->getDealerName($row['dealer_id'],"dealer_satellite","dealer_satellite_name","dealer_satellite_id",$conn);
			}	
			
			$trainee_code = $trainee->transformCode($row['trainee_code']);    		
    		$module_workshop_data = $trainee->getEvaluationWorkshop($tp_id,$trainee_code);
			$attendance_data = $trainee->getEvaluationAttendance($tp_id,$trainee_code);
			$product_knowledge_data = $trainee->getEvaluationProductKnowledgeExam($tp_id,$trainee_code);
			$final_written_data = $trainee->getEvaluationWrittenExam($tp_id,$trainee_code);
			$total_grade = $module_workshop_data['grade'] + $attendance_data['grade'] + $product_knowledge_data['grade'] + $final_written_data['grade'];
			$status = $trainee->getGradeStatus($total_grade);
            $module_count = $trainee->countModules($program_code,$conn);
            $grade_status = $trainee->checkEvaluationStatus($tp_id,$trainee_code,$module_count,$total_grade);
			$enc_tp_id = $conn->encryptor("encrypt",$tp_id);
			$enc_tc = $conn->encryptor("encrypt",$id);
			$output .= "<tr>";

				$output .= "<td>".$dealer_name['abbrev'] . "-". $trainee_code."</td>";
				$output .= "<td>".$name."</td>";
				$output .= "<td>".$dealer_name['name']."</td>";
				$output .= "<td>".$row['job_description']."</td>";
				//$output .= "<td>".$grade_status."</td>";
				$output .= "<td>
						<div class='btn-group'>
						  <button type='button' class='btn btn-primary btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
						    Action <span class='caret'></span>
						  </button>
						  <ul class='dropdown-menu dropdown-menu-right'>
						    <li><a href='evaluate_modules_workshops.php?d=$enc_tp_id&tc=$enc_tc'>Evaluate Modules and Workshop</a></li>
						 
						    <li><a href='general_assessment.php?d=$enc_tp_id&tc=$enc_tc'>General Assessment</a></li>
						    <li><a href='manage_exams.php?d=$enc_tp_id&tc=$enc_tc'>Manage Exams</a></li>
						    <li class='divider'></li>
						    <li><a href='evaluation_summary.php?d=$enc_tp_id&tc=$enc_tc'>Record Summary</a></li>
						
						    <li><a href='#' data-tp_id='".$tp_id."' data-trainee_id='".$id."' class='btn_remove_trainee'>Remove</a></li>
						  </ul>
						</div></td>";
			$output .= '</tr>';
			//   <li><a href='evaluate_product_knowledge.php?d=$enc_tp_id&tc=$enc_tc'>Evaluate Product Knowledge Exam</a></li>
				//		    <li><a href='evaluate_written_exam.php?d=$enc_tp_id&tc=$enc_tc'>Evaluate Final Written Exam</a></li>
			
			//     <li><a href='certification.php?d=$enc_tp_id&tc=$enc_tc'>Print Certificate</a></li>
		}
		$conn->closeConnection();
		return $output;
	}

	public function isTimeIn($tp_id,$trainee_code,$module_id){
		$conn = new Connection();
		$isExist = false;
		$date_today = $conn->getDateOnlyToday();
		$stmt = $conn->prepare("SELECT COUNT(att_id) total 
								FROM attendance 
								WHERE tp_id = :tp_id AND trainee_id = :trainee_id AND DATE(time_in) = :date AND module_id = :module_id");
		$stmt->bindParam(":tp_id",$tp_id,PDO::PARAM_INT);
		$stmt->bindParam(":trainee_id",$trainee_code,PDO::PARAM_INT);
		$stmt->bindParam(":module_id",$module_id,PDO::PARAM_INT);
		$stmt->bindParam(":date",$date_today,PDO::PARAM_STR);
		$stmt->execute();
		$data = $stmt->fetch();
		if($data['total'] > 0){
			$isExist = true;
		}
		else {
			$isExist = false;
		}

		$conn->closeConnection();
		return $data['total'];
	}

	public function getTrainingProgramAttendeesOption($trainee,$tp_id,$module_id){
		$conn = new Connection();
		
		$output = "<option value=''>Select Trainee</option>";
		$stmt = $conn->prepare("SELECT tm.trainee_code,tm.first_name,tm.middle_name,tm.last_name,tm.dealer_id,tm.dealer_category,tm.picture,
									   jp.job_description,
									   ns.suffix
								FROM (((training_program_attendees tpa 
										INNER JOIN trainees_masterfile tm ON tpa.`trainee_id` = tm.`trainee_code`) 
										INNER JOIN job_position jp ON tm.`job_position` = jp.`job_id`)
										LEFT JOIN name_suffix ns ON ns.id = tm.name_suffix_id)
										WHERE tpa.`training_program_id` = :tp_id AND tm.isDeleted IS NULL");
		
		$stmt->bindParam(":tp_id",$tp_id,PDO::PARAM_INT);
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$isExist = $this->isTimeIn($tp_id,$row['trainee_code'],$module_id);
			if(!$isExist){
				$name = $conn->transformName1($row['first_name'],$row['middle_name'],$row['last_name'],$row['suffix'],$conn);
				$id = $row['trainee_code'];
				
				if($row['dealer_category'] == "main"){
					$dealer_name = $trainee->getDealerName($row['dealer_id'],"dealer_main","dealer_main_name","dealer_main_id",$conn);
				}
				else {
					$dealer_name = $trainee->getDealerName($row['dealer_id'],"dealer_satellite","dealer_satellite_name","dealer_satellite_id",$conn);
				}	
				
				$trainee_code = $dealer_name['abbrev'] . "-". $trainee->transformCode($row['trainee_code']);    		
	    		$dealer = $dealer_name['name'];
	    		$job_description = $row['job_description'];

				$output .= "<option value='".$id."' data-job='".$job_description."' data-dealer='".$dealer."' data-trainee_code='".$trainee_code."'>" . $name  . "</option>";
			}
	
		}

		$conn->closeConnection();
		return $output;
	}

	public function getTrainingProgramDetails($id){
		$conn = new Connection();
		$output = "";
		$stmt = $conn->prepare("SELECT  t.first_name,t.middle_name,t.last_name,
										p.title,tp.start_date,tp.end_date,tp.venue,
										tp.training_program_id,tp.program_id,
										ns.suffix
								FROM (((training_programs AS tp INNER JOIN program AS p ON tp.program_id = p.program_code) 
										INNER JOIN trainor AS t ON t.trainor_id = tp.trainor_id)
										LEFT JOIN name_suffix ns ON ns.id = t.name_extension)
									WHERE tp.training_program_id = :tp_id");
		$stmt->bindParam(":tp_id",$id,PDO::PARAM_INT);
		$stmt->execute();
		$data = $stmt->fetch();

		$conn->closeConnection();
		return $data;
	}

	public function getTrainingProgramInfo($id){
		$conn = new Connection();
		$output = "";
		$stmt = $conn->prepare("SELECT program_id,venue,trainor_id,start_date,end_date FROM training_programs WHERE training_program_id = :tp_id");
		$stmt->bindParam(":tp_id",$id,PDO::PARAM_INT);
		$stmt->execute();
		$data = $stmt->fetch();
		$conn->closeConnection();
		return $data;
	}

	public function addAttendee($trainee_id,$tp_id,$program_id,$user){
		$conn = new Connection();

		$today = $conn->getDateToday();
		$module_ending_exam = null;
		$module_ending_evaluation = null;
		$participation = null;
		$time_in = 0;
		$score = null;

		// insert on the attendees
		$stmt = $conn->prepare("INSERT INTO training_program_attendees(training_program_id,trainee_id,create_user,date_created) VALUES(:tp_id,:trainee_id,:create_user,:date_created)");
		$stmt->bindParam(":tp_id",$tp_id,PDO::PARAM_INT);
		$stmt->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$stmt->bindParam(":create_user",$user,PDO::PARAM_STR);
		$stmt->bindParam(":date_created",$today,PDO::PARAM_STR);
		$stmt->execute();

		// here

		//LOOP THROUGH ALL THE MODULES OF A SPECIFIC PROGRAM CODE
		$program_modules = $conn->prepare("SELECT module_id FROM program_module WHERE program_code = :code");
		$program_modules->bindParam(":code",$program_id,PDO::PARAM_INT);
		$program_modules->execute();
		while($mods = $program_modules->fetch(PDO::FETCH_ASSOC)){

			// INSERT BLANK GRADES FOR MODULE WORKSHOP
			$module_id = $mods['module_id'];
			$ins_mod_grade = $conn->prepare("INSERT INTO workshop(attendance_id,module_id,trainee_id,participation,module_ending_exam,module_ending_evaluation,last_user_create) VALUES(:att_id,:mod_id,:trainee_id,:part,:mee,:mev,:last_user_create)");
			$ins_mod_grade->bindParam(":att_id",$tp_id,PDO::PARAM_INT);
			$ins_mod_grade->bindParam(":mod_id",$module_id,PDO::PARAM_INT);
			$ins_mod_grade->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
			$ins_mod_grade->bindParam(":part",$participation,PDO::PARAM_INT);
			$ins_mod_grade->bindParam(":mee",$module_ending_exam,PDO::PARAM_INT);
			$ins_mod_grade->bindParam(":mev",$module_evaluation_exam,PDO::PARAM_INT);
			$ins_mod_grade->bindParam(":last_user_create",$today,PDO::PARAM_STR);
			$ins_mod_grade->execute();

			// INSERT BLANK GRADES FOR ATTENDANCE
			$ins_att = $conn->prepare("INSERT INTO attendance(module_id,attendance_id,trainee_id,time_in,score,last_user_create) VALUES(:module_id,:attendance_id,:trainee_id,:time_in,:score,:last_user_create)");
			$ins_att->bindParam(":module_id",$module_id,PDO::PARAM_INT);
			$ins_att->bindParam(":attendance_id",$tp_id,PDO::PARAM_INT);
			$ins_att->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
			$ins_att->bindParam(":time_in",$time_in,PDO::PARAM_STR);
			$ins_att->bindParam(":score",$score,PDO::PARAM_INT);
			$ins_att->bindParam(":last_user_create",$today,PDO::PARAM_STR);
			$ins_att->execute();
		}
		
		$conn->closeConnection();
		
	}

	public function getTraineeProgramAttendeeDetails($training_program_id,$trainee_id){
		$conn = new Connection();

		$stmt = $conn->prepare("SELECT * FROM training_program_attendees WHERE training_program_id = :tp_id AND trainee_id = :t_id");
		$stmt->bindParam(":tp_id",$training_program_id,PDO::PARAM_INT);
		$stmt->bindParam(":t_id",$trainee_id,PDO::PARAM_INT);
		$stmt->execute();
		$data = $stmt->fetch();
		$conn->closeConnection();
		return $data;
	}

	public function removeAttendee($training_program_id,$trainee_id){
		$conn = new Connection();

		// delete from training_program_attendees
		$delete_tpa = $conn->prepare("DELETE FROM training_program_attendees WHERE training_program_id = :training_program_id AND trainee_id = :trainee_id");
		$delete_tpa->bindParam(":training_program_id",$training_program_id,PDO::PARAM_INT);
		$delete_tpa->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$delete_tpa->execute();

		// delete from  workshop
		$delete_workshop = $conn->prepare("DELETE FROM workshop WHERE attendance_id = :training_program_id AND trainee_id = :trainee_id");
		$delete_workshop->bindParam(":training_program_id",$training_program_id,PDO::PARAM_INT);
		$delete_workshop->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$delete_workshop->execute();

		// delete from attendance
		$delete_attendance = $conn->prepare("DELETE FROM attendance WHERE attendance_id = :training_program_id AND trainee_id = :trainee_id");
		$delete_attendance->bindParam(":training_program_id",$training_program_id,PDO::PARAM_INT);
		$delete_attendance->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$delete_attendance->execute();

		// delete from final written exam
		$delete_fwe = $conn->prepare("DELETE FROM final_written_exam WHERE attendance_id = :training_program_id AND trainee_id = :trainee_id");
		$delete_fwe->bindParam(":training_program_id",$training_program_id,PDO::PARAM_INT);
		$delete_fwe->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$delete_fwe->execute();

		// delete from product knowledge exam
		$delete_pke = $conn->prepare("DELETE FROM product_knowledge_exam WHERE attendance_id = :training_program_id AND trainee_id = :trainee_id");
		$delete_pke->bindParam(":training_program_id",$training_program_id,PDO::PARAM_INT);
		$delete_pke->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$delete_pke->execute();

		$conn->closeConnection();
	}

	public function deleteTrainingProgram($training_program_id){
		$conn = new Connection();
	
		// delete program
		$update_program = $conn->prepare("DELETE FROM training_programs WHERE training_program_id = :training_program_id");
		$update_program->bindParam(":training_program_id",$training_program_id,PDO::PARAM_INT);
		$update_program->execute();

		// delete training attendees
		$del_trainees = $conn->prepare("DELETE FROM training_program_attendees WHERE training_program_id = :training_program_id");
		$del_trainees->bindParam(":training_program_id",$training_program_id,PDO::PARAM_INT);
		$del_trainees->execute();

		// delete training attendance
		$del_att = $conn->prepare("DELETE FROM attendance WHERE attendance_id = :training_program_id");
		$del_att->bindParam(":training_program_id",$training_program_id,PDO::PARAM_INT);
		$del_att->execute();

		// delete written exam
		$del_fwe = $conn->prepare("DELETE FROM final_written_exam WHERE attendance_id = :training_program_id");
		$del_fwe->bindParam(":training_program_id",$training_program_id,PDO::PARAM_INT);
		$del_fwe->execute();

		// delete pke 
		$del_pke = $conn->prepare("DELETE FROM product_knowledge_exam WHERE attendance_id = :training_program_id");
		$del_pke->bindParam(":training_program_id",$training_program_id,PDO::PARAM_INT);
		$del_pke->execute();
		

		// delete workshop
		$delete_workshop = $conn->prepare("DELETE FROM workshop WHERE attendance_id = :training_program_id");
		$delete_workshop->bindParam(":training_program_id",$training_program_id,PDO::PARAM_INT);
		$delete_workshop->execute();

		$conn->closeConnection();
	}



	public function getAttendance($tp_id,$trainee){
		$conn = new Connection();
		$output = "";
		$stmt = $conn->prepare("SELECT tm.trainee_code,tm.first_name,tm.middle_name,tm.last_name,tm.dealer_id,tm.dealer_category,tm.picture,
							   jp.job_description,
							   ns.suffix,
							   att.time_in,att.att_id,att.module_id,pm.module_name
						FROM ((((attendance att INNER JOIN trainees_masterfile tm ON att.`trainee_id` = tm.`trainee_code`) 
								INNER JOIN job_position jp ON tm.`job_position` = jp.`job_id`)
								LEFT JOIN name_suffix ns ON ns.id = tm.name_suffix_id)
								LEFT JOIN program_module pm ON pm.module_id = att.module_id)
								WHERE att.`tp_id` = :tp_id");
		$stmt->bindParam(":tp_id",$tp_id,PDO::PARAM_INT);
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

			$name = $conn->transformName1($row['first_name'],$row['middle_name'],$row['last_name'],$row['suffix'],$conn);
			$id = $row['trainee_code'];
			
			if($row['dealer_category'] == "main"){
				$dealer_name = $trainee->getDealerName($row['dealer_id'],"dealer_main","dealer_main_name","dealer_main_id",$conn);
			}
			else {
				$dealer_name = $trainee->getDealerName($row['dealer_id'],"dealer_satellite","dealer_satellite_name","dealer_satellite_id",$conn);
			}	
			
			$trainee_code = $dealer_name['abbrev'] . "-". $trainee->transformCode($row['trainee_code']);    		
    		$dealer = $dealer_name['name'];
    		$job_description = $row['job_description'];
    		$time_in = $conn->format_date($row['time_in']);
			$att_id = $row['att_id'];
    		$output .= "<tr>";
    			$output .= "<td>" . $trainee_code .  "</td>";
    			$output .= "<td>" . $name .  "</td>";
    			$output .= "<td>" . $dealer .  "</td>";
    			$output .= "<td>" . $job_description .  "</td>";
    			$output .= "<td>" . $row['module_name'] .  "</td>";
    			$output .= "<td>" . $time_in .  "</td>";
    			$output .= "<td><button type='button' class='btn btn-danger btn-sm btn_remove' data-id='".$att_id."'><i class='fa fa-trash fa-1x'></i> Remove</td>";
    		$output .= "</tr>";
		}

		$conn->closeConnection();
		return $output;
	}

	

	public function getModuleOption($id){
		$conn = new Connection();	
		$output = "";
		$stmt = $conn->prepare("SELECT module_id,module_name FROM program_module WHERE program_code = :id ORDER BY module_name ASC");	
		$stmt->bindParam(":id",$id,PDO::PARAM_INT);
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$module_id = $row['module_id'];
			$name = $row['module_name'];
			$output .= "<option value='".$module_id."'>" . $name . "</option>";
		}
		$conn->closeConnection();
		return $output;
	}

	public function createExam($tp_id,$program_id,$module_id,$exam,$passing_score,$user){
		$db = Database::getInstance();
		$sql = "INSERT INTO tp_exam(tp_id,program_id,module_id,exam,passing_score,create_user,date_created) 
				VALUES(:tp_id,:program_id,:module_id,:exam,:passing_score,:create_user,NOW())";
		$result = $db->query($sql,array(
								  	":tp_id" => $tp_id,
								  	":program_id" => $program_id,
								  	":module_id" => $module_id,
								  	":exam" => $exam,
								  	":create_user" => $user,
								  	":passing_score" => $passing_score
								  )
							);
	}

	public function isExamTaken($trainee_id,$tp_id,$exam_id){
		$conn = new Connection();
		$stmt = $conn->prepare("SELECT COUNT(id) total FROM trainee_exam_taken WHERE exam_id = :exam_id AND trainee_id = :trainee_id AND tp_id = :tp_id");
		$stmt->bindParam(":exam_id",$exam_id,PDO::PARAM_INT);
		$stmt->bindParam(":tp_id",$tp_id,PDO::PARAM_INT);
		$stmt->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$stmt->execute();
		$data = $stmt->fetch();
		if($data['total']>0){
			return true;
		}
		else {
			return false;
		}
	
	}

	public function getTraineeExams($trainee_id,$tp_id){
		$conn = new Connection();
		$output = "";
		$stmt = $conn->prepare("SELECT tet.id,tet.trainee_id,tet.tp_id,tet.exam_id,te.exam,te.module_id,pm.module_name,DATE_FORMAT(tet.date_created,'%M %d, %Y at %h:%i %p') date_added 
			FROM ((trainee_exam_taken tet INNER JOIN tp_exam te ON tet.`exam_id` = te.`exam_id`)
			INNER JOIN program_module pm ON te.`module_id` = pm.`module_id`)
		WHERE tet.trainee_id = :trainee_id AND tet.tp_id = :tp_id");
		$stmt->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$stmt->bindParam(":tp_id",$tp_id,PDO::PARAM_INT);
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$enc_tp_id = $conn->encryptor("encrypt",$row['tp_id']);
			$enc_exam_id = $conn->encryptor("encrypt",$row['exam_id']);
			$enc_tc = $conn->encryptor("encrypt",$row['trainee_id']);
			$exam_result = $this->getTraineeExamScore($trainee_id,$row['exam_id']);
			$output .= "<tr>";
				$output .= "<td>" . $row['exam'] . "</td>";
				$output .= "<td>" . $row['module_name'] . "</td>";
				$output .= "<td>" .$exam_result[0] . "</td>";
				$output .= "<td>" .$exam_result[1] . "</td>";
				$output .= "<td>" . $row['date_added'] . "</td>";
				$output .= "<td>
					<div class='btn-group'>
					   <button type='button' class='btn btn-info btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
					    Action <span class='caret'></span>
					    </button>
					  <ul class='dropdown-menu dropdown-menu-right'>
				      		<li><a href='exam_set_answer.php?d=$enc_tp_id&e=$enc_exam_id&t=$enc_tc'><i class='fa fa-file-text fa-1x'></i> Set answers</a></li>
				      		<li><a href='#'><i class='fa fa-trash fa-1x'></i> Remove</a></li>
					  </ul>
					</div>
				</td>";
			$output .= "</tr>";
		}
		$conn->closeConnection();
		return $output;
	}

	public function countAnswerPerItem($choice_id){
		$ctr = 0;
		$conn = new Connection();
		$stmt = $conn->prepare("SELECT a.id,b.first_name,
					CASE 
						WHEN b.middle_name = NULL THEN ''
						ELSE CONCAT(LEFT(b.middle_name,1),'. ')
					END AS middle_name,
					b.last_name,
					CASE WHEN c.`suffix` = NULL THEN ''
						ELSE CONCAT(',',c.`suffix`)
					END AS suffix
					FROM ((trainee_exam_answers a INNER JOIN trainees_masterfile b ON a.`trainee_id` = b.`trainee_code`)
					LEFT JOIN name_suffix c ON b.`name_suffix_id` = c.`id`) WHERE a.choice_id = :choice_id");
		$stmt->bindParam(":choice_id",$choice_id,PDO::PARAM_INT);
		$stmt->execute();
		$list = "";
		$ctr = $stmt->rowCount();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$list .= "<li>" . $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] . "" . $row['suffix'] . "</li>";
		}
	
		$data = array($ctr,$list);
		$conn->closeConnection();
		return $data; 
	}


	public function 	getItemAnalysis($exam_id,$tp_id,$total_examinees){
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
			$correct_list = "";
			$incorrect_list = "";
			$correct_ctr = 0;
			$incorrect_ctr = 0;
			$choice_ctr = 0;
			$choices = "";
			$get_choices = $conn->prepare("SELECT choice_id,choice FROM tp_exam_choices WHERE item_id = :item_id ORDER BY choice_id ASC");
			$get_choices->bindParam(":item_id",$item_id,PDO::PARAM_INT);
			$get_choices->execute();
			while($choice_list = $get_choices->fetch(PDO::FETCH_ASSOC)){
				$choice_id = $choice_list['choice_id'];
				$choice_name = $choice_list['choice'];
				$answer_ctr = $this->countAnswerPerItem($choice_id);
				$trainee_list = $answer_ctr[1];

				$choices .= "<ul>";
				if($choice_id == $correct_answer){
					$choices .= "<li class='choice_data' data-content='<ol>$trainee_list</ol>' data-choice='$choice_name'><em style='color:red;'>$choice_name - ".$answer_ctr[0]."</em></li>";
					$correct_ctr += $answer_ctr[0];
					$correct_list .= $trainee_list;
				}
				else {
					$choices .= "<li class='choice_data' data-content='<ol>$trainee_list</ol>' data-choice='$choice_name'>$choice_name - ".$answer_ctr[0]."</li>";
					$incorrect_ctr+=$answer_ctr[0];	
					$incorrect_list .= $trainee_list;
                }
               	$choices .= "</ul>";
               	$choice_ctr++;
			}
			$ex_q = $questions['question'];
			$output .= "<div class='exam_item'>";
			$output .= "<p class='exam_question'>" .$index . ". " . $questions['question'] . "</p>";
           	$output .= "<ol type='a' style='list-style-type:none;'>" . $choices . "</ol>";  
           	$output .= "<span class='label label-success flag_data' data-action='correct' data-title='Correct Examinee/s for Question Number $index' data-q='$ex_q' data-content='<ol>$correct_list</ol>'>Correct : $correct_ctr</span><br/>";
           	$output .= "<span class='label label-danger flag_data' data-action='incorrect' data-title='Incorrect Examinee/s for Question Number $index' data-q='$ex_q' data-content='<ol>$incorrect_list</ol>'>Incorrect : ". ($incorrect_ctr) ."</span>";
			$output .= "</div><br/>";

			$index++;
		}

		$conn->closeConnection();
		return $output;

	}


	public function setTraineeExamAnswer($trainee_id,$item_id,$choice_id,$user){
		$conn = new Connection();
		
		$isAnswered = $conn->prepare("SELECT id FROM trainee_exam_answers WHERE trainee_id = :trainee_id AND item_id = :item_id");
		$isAnswered->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
		$isAnswered->bindParam(":item_id",$item_id,PDO::PARAM_INT);
		$isAnswered->execute();
		$count_rows = $isAnswered->rowCount();
		if($count_rows > 0){
			$update_ans = $conn->prepare("UPDATE trainee_exam_answers SET choice_id = :choice,update_user = :user, date_updated = NOW() WHERE trainee_id = :trainee_id AND item_id = :item_id");
			$update_ans->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
			$update_ans->bindParam(":item_id",$item_id,PDO::PARAM_INT);
			$update_ans->bindParam(":choice",$choice_id,PDO::PARAM_INT);
			$update_ans->bindParam(":user",$user,PDO::PARAM_INT);
			$update_ans->execute();
		}
		else {
			$ins_ans = $conn->prepare("INSERT INTO trainee_exam_answers(trainee_id,item_id,choice_id,create_user,date_created) VALUES(:trainee_id,:item_id,:choice_id,:user,NOW())");
			$ins_ans->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
			$ins_ans->bindParam(":item_id",$item_id,PDO::PARAM_INT);
			$ins_ans->bindParam(":choice_id",$choice_id,PDO::PARAM_INT);
			$ins_ans->bindParam(":user",$user,PDO::PARAM_INT);
			$ins_ans->execute();
		}

		
		$conn->closeConnection();	
	}

	public function getScoreRemarks($score,$total_items,$passing_rate,$exam_id,$trainee_id){
		$conn = new Connection();
		$get_exam_items = $conn->prepare("SELECT item_id,question FROM tp_exam_items WHERE exam_id = :exam_id");
		$get_exam_items->bindParam(":exam_id",$exam_id,PDO::PARAM_INT);
		$get_exam_items->execute();
		$items_answered_ctr = 0;
		$item_no = 1;
		$unanswered = "<ul>";
		while($row = $get_exam_items->fetch(PDO::FETCH_ASSOC)){
			$item_id = $row['item_id'];
			$count_exam = $conn->prepare("SELECT id FROM trainee_exam_answers WHERE item_id = :item_id AND trainee_id = :trainee_id");
			$count_exam->bindParam(":item_id",$item_id,PDO::PARAM_INT);
			$count_exam->bindParam(":trainee_id",$trainee_id,PDO::PARAM_INT);
			$count_exam->execute();
			if($count_exam->rowCount() > 0){
				$items_answered_ctr++;
			}
			else {
				$unanswered .= "<li>" . $item_no . ". ". $row['question'] ."</li>";
			}
			$item_no++;
		}

		$unanswered .= "</ul>";
		$average = ($score / $total_items) * 100;
		$remarks = "";
		if($items_answered_ctr != $total_items){
			$remarks = "<a href='#' class='view_unanswered' data-content='$unanswered'>Incomplete answer</a></div>";
		}
		else {
			if($average >= $passing_rate){
				$remarks = "Passed";
			}
			else {
				$remarks = "Failed";
			}
		}

		$conn->closeConnection();

		return $remarks;
	}

	public function deleteExam($exam_id){
		$conn = new Connection();

		// delete exam
		$del_exam = $conn->prepare("DELETE FROM tp_exam WHERE exam_id = :id");
		$del_exam->bindParam(":id",$exam_id,PDO::PARAM_INT);
		$del_exam->execute();

		// get items
		$get_items = $conn->prepare("SELECT item_id FROM tp_exam_items WHERE exam_id = :id");
		$get_items->bindParam(":id",$exam_id,PDO::PARAM_INT);
		$get_items->execute();

		while($row = $get_items->fetch(PDO::FETCH_ASSOC)){
			
			// delete choices
			$item_id = $row['item_id'];
			$del_choices = $conn->prepare("DELETE FROM tp_exam_choices WHERE item_id = :item_id");
			$del_choices->bindParam(":item_id",$item_id,PDO::PARAM_INT);
			$del_choices->execute();

			// delete answers
			$del_answers = $conn->prepare("DELETE FROM trainee_exam_answers WHERE item_id = :item_id");
			$del_answers->bindParam(":item_id",$item_id,PDO::PARAM_INT);
			$del_answers->execute();

		}

		// delete items
		$del_items = $conn->prepare("DELETE FROM tp_exam_items WHERE exam_id = :id");
		$del_items->bindParam(":id",$exam_id,PDO::PARAM_INT);
		$del_items->execute();

		// delete trainee exam taken
		$del_exam_taken = $conn->prepare("DELETE FROM trainee_exam_taken WHERE exam_id = :id");
		$del_exam_taken->bindParam(":id",$exam_id,PDO::PARAM_INT);
		$del_exam_taken->execute();

		

		$conn->closeConnection();

	}

	public function countExaminees($exam_id){
		$conn = new Connection();
		$stmt = $conn->prepare("SELECT id FROM trainee_exam_taken WHERE exam_id = :exam_id");
		$stmt->bindParam(":exam_id",$exam_id,PDO::PARAM_INT);
		$stmt->execute();
		$ctr = $stmt->rowCount();
		$examinees_list = "";
		$list = "<ol>";
		if($ctr > 0){
			$get_examinees = $conn->prepare("SELECT a.id,b.`first_name`,
				CASE 
					WHEN b.middle_name = NULL THEN ''
					ELSE CONCAT(LEFT(b.middle_name,1),'. ')
				END AS middle_name,
				b.last_name,
				CASE WHEN c.`suffix` = NULL THEN ''
					ELSE CONCAT(',',c.`suffix`)
				END AS suffix
				FROM ((trainee_exam_taken a INNER JOIN trainees_masterfile b ON a.`trainee_id` = b.`trainee_code`)
						LEFT JOIN name_suffix c ON b.`name_suffix_id` = c.`id`)
						WHERE exam_id = :exam_id");
			$get_examinees->bindParam(":exam_id",$exam_id,PDO::PARAM_INT);
			$get_examinees->execute();
			while($row = $get_examinees->fetch(PDO::FETCH_ASSOC)){
				$name =  $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] . "" . $row['suffix'];
				$list .=  "<li>" . $name. "</li>";
			}
			$list .= "</ol>";
			$examinees_list = "<a href='#' data-content='$list' class='view_examinees_list'>$ctr</a>";
		}
		else {
			$examinees_list = "$ctr";
		}

		$conn->closeConnection();
		return $examinees_list;
	}


	public function generateExamForWord($exam_id){
		$conn = new Connection();
		$output = "";
		$get_items = $conn->prepare("SELECT item_id,exam_id,question,choice_id FROM tp_exam_items WHERE exam_id = :exam_id ORDER BY item_id ASC");
		$get_items->bindParam(":exam_id",$exam_id,PDO::PARAM_INT);
		$get_items->execute();
		$index = 1;
		$radio_ctr = 1;
		while($questions = $get_items->fetch(PDO::FETCH_ASSOC)){
			$item_id = $questions['item_id'];
			//$correct_answer = $questions['choice_id'];
			//$trainee_answer = $this->getTraineeAnswer($trainee_id,$item_id);
			$choices = "";
			$get_choices = $conn->prepare("SELECT choice_id,choice FROM tp_exam_choices WHERE item_id = :item_id ORDER BY choice_id ASC");
			$get_choices->bindParam(":item_id",$item_id,PDO::PARAM_INT);
			$get_choices->execute();
			while($choice_list = $get_choices->fetch(PDO::FETCH_ASSOC)){
				$choice_id = $choice_list['choice_id'];
				$choice_name = $choice_list['choice'];
				//$isTraineeAnswer = ($trainee_answer == $choice_id) ? "checked" : "";
				$choices .= "<p>$choice_name</p>";
			}
	
			$output .= "<div>";
			$output .= "<p style='font-weight:bold;'>" .$index . ". " . $questions['question'] . "</p>";
           	$output .= '<div style="margin-left:20px;">' . $choices . "</div>";  
			$output .= "</div>";
			$index++;
		}


		$conn->closeConnection();
		return $output;
	}

	public function getTrainingProgramsOption(){
		$conn = new Connection();

		$stmt = $conn->prepare("SELECT a.`training_program_id`,YEAR(a.`start_date`) sdate,b.`title` FROM training_programs a INNER JOIN program b ON a.`program_id` = b.`program_code` ORDER BY a.end_date DESC");
		$stmt->execute();

		$output = "";

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$tp_id = $row['training_program_id'];
			$sdate = $row['sdate'];
			$title = $row['title'];
			$output .= "<option value='".$tp_id."'>" . $sdate . " " . $title . "</option>";
		}

		$conn->closeConnection();
		return $output;
	}

	public function addQualification($tp_id,$status_id,$months,$programs,$jobs){
		$conn = new Connection();
		$tpq_id = 0;
		if($months!=0){
			$ins_q = $conn->prepare("INSERT INTO tp_qualification(tp_id,status_id,months) VALUES(:tp_id,:status_id,:months)");
			$ins_q->bindParam(":tp_id",$tp_id,PDO::PARAM_INT);
			$ins_q->bindParam(":status_id",$status_id,PDO::PARAM_INT);
			$ins_q->bindParam(":months",$months,PDO::PARAM_INT);
			$ins_q->execute();
			$tpq_id = $conn->lastInsertId();
		}
		else {
			$ins_q = $conn->prepare("INSERT INTO tp_qualification(tp_id,status_id) VALUES(:tp_id,:status_id)");
			$ins_q->bindParam(":tp_id",$tp_id,PDO::PARAM_INT);
			$ins_q->bindParam(":status_id",$status_id,PDO::PARAM_INT);
			$ins_q->execute();
			$tpq_id = $conn->lastInsertId();
		}

		foreach($programs as $pg){
			$ins_prog = $conn->prepare("INSERT INTO tpq_programs(tpq_id,tp_id) VALUES(:tpq_id,:tp_id)");
			$ins_prog->bindParam(":tpq_id",$tpq_id,PDO::PARAM_INT);
			$ins_prog->bindParam(":tp_id",$pg,PDO::PARAM_INT);
			$ins_prog->execute();
		}

		foreach($jobs as $jb){
			$ins_prog = $conn->prepare("INSERT INTO tpq_jobs(tpq_id,job_id) VALUES(:tpq_id,:job_id)");
			$ins_prog->bindParam(":tpq_id",$tpq_id,PDO::PARAM_INT);
			$ins_prog->bindParam(":job_id",$jb,PDO::PARAM_INT);
			$ins_prog->execute();
		}

		$conn->closeConnection();
	}

	public function getAddedTrainees($trainee,$tp_id){
		$conn = new Connection();
		$output = "";
	
		$stmt = $conn->prepare("SELECT tm.trainee_code,tm.first_name,tm.middle_name,tm.last_name,tm.dealer_id,tm.dealer_category,tm.picture,
									   jp.job_description,
									   ns.suffix
								FROM (((training_program_attendees AS tpa INNER JOIN trainees_masterfile AS tm ON tpa.`trainee_id` = tm.`trainee_code`) 
										INNER JOIN job_position AS jp ON tm.`job_position` = jp.`job_id`)
										LEFT JOIN name_suffix ns ON ns.id = tm.name_suffix_id)
										WHERE tpa.`training_program_id` = :tp_id AND tm.isDeleted IS NULL");
		$stmt->bindParam(":tp_id",$tp_id,PDO::PARAM_INT);
		
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

			$name = $conn->transformName1($row['first_name'],$row['middle_name'],$row['last_name'],$row['suffix'],$conn);
			$id = $row['trainee_code'];
			
			if($row['dealer_category'] == "main"){
				$dealer_name = $trainee->getDealerName($row['dealer_id'],"dealer_main","dealer_main_name","dealer_main_id",$conn);
			}
			else {
				$dealer_name = $trainee->getDealerName($row['dealer_id'],"dealer_satellite","dealer_satellite_name","dealer_satellite_id",$conn);
			}	
			$trainee_code = $trainee->transformCode($row['trainee_code']);    		
    		$output .= "<li class=\"list-group-item\" style=\"padding:2px 2px 2px 20px;cursor:pointer;\">(". $dealer_name['abbrev'] . "-". $trainee_code . ") ".$name."</li>";
	
			
		}
		$ctr = $stmt->rowCount();
		$data = array($output,$ctr);
		$conn->closeConnection();
		return $data;
	}

	public function getProgramCategoryList(){
		$db = Database::getInstance();
		$sql = "SELECT program_category_id,category_name 
				FROM program_category
				";
		$result = $db->query($sql,false);
		return $result;
	}

	public function addProgramCategory($program_category){
		$db = Database::getInstance();
		$sql = "INSERT INTO program_category(category_name) VALUES(:category_name)";
		$result = $db->query($sql,array(":category_name"=>$program_category));
		return $result;
	}

	public function deleteProgramCategory($id){
		$db = Database::getInstance();
		$sql = "DELETE FROM program_category WHERE program_category_id = :id";
		$db->query($sql,array(":id"=>$id));
	}

	public function getProgramsListByCategory($category_id){
		$db = Database::getInstance();
		$sql = "SELECT program_code,
					   title
				FROM program
				WHERE program_category_id = :program_category_id
				ORDER BY title ASC";
		$result = $db->query($sql,array(
									":program_category_id" => $category_id
								  )
							);
		return $result;
	}

	public function getProgramModulesList($program_id){
		$db = Database::getInstance();
		$sql = "SELECT module_id,
					   module_name
				FROM program_module
				WHERE program_code = :program_id";
		$result = $db->query($sql,array(":program_id"=>$program_id));
		return $result;
	}
}

?>