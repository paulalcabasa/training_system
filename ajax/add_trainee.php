<?php
	
	include("../initialize.php");
	
	$trainee = new Trainee();

	$trainee_pic = new upload($_FILES['txt_pic']);
	if($trainee_pic->uploaded){
		$trainee_pic->file_new_name_body = 'trn_' . date("YmdHis");
		$trainee_pic->image_resize 		 = true;
		$trainee_pic->image_y 			 = 512;
		$trainee_pic->image_x 		     = 512;
		$trainee_pic->process("../trainee_pics/");
		if($trainee_pic->processed){
			$trainee_pic->clean();
		} else {
			echo "Error: " . $trainee_pic->error;
		}
	}

	$mobile = json_decode($post->mobile,true);

	$trainee->addTrainee(
		$post->txt_dealer_name,
		$post->txt_fname,
		$post->txt_mname,
		$post->txt_lname,
		$post->cbo_suffix,
		$post->cbo_province,
		$post->cbo_municipality,
		$post->txt_street_addr,
		$post->txt_office,
		$post->cbo_job_position,
		$post->cbo_emp_status,
		$post->txt_date_hired,
		$post->txt_date_of_birth,
		$post->cbo_civil_status,
		$post->gender,
		$post->txt_highest_educ_att,
		$trainee_pic->file_dst_name,
		$user_data->employee_id,
		$mobile,
		$post->txt_nickname,
		$post->txt_email
	);

	echo "success";
?>