<?php
	
	include("../initialize.php");
	require_once("../../../../libs/class.upload/src/class.upload.php");

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
	$mobile = json_decode($_POST['mobile'],true);
	$dealer_details = explode(';',$_POST['txt_dealer_name']);
	$trainee->setData(
		$_POST['txt_fname'],
		$_POST['txt_mname'],
		$_POST['txt_lname'],
		$dealer_details[0],
		$dealer_details[1],
		$_POST['txt_office'],
		$_POST['cbo_job_position'],
		$_POST['txt_date_hired'],
		$_POST['txt_date_of_birth'],
		$_POST['cbo_civil_status'],
		$_POST['gender'],
		$_POST['txt_street_addr'],
		$_POST['txt_highest_educ_att'],
		$trainee_pic->file_dst_name,
		$_POST['cbo_suffix'],
		$_POST['cbo_province'],
		$_POST['cbo_municipality'],
		$_POST['cbo_emp_status']
	);

	$trainee->addTrainee($_SESSION['user_data']['employee_id'],$mobile);
	//echo $trainee->transformName1($_POST['txt_fname'],$_POST['txt_mname'],$_POST['txt_lname'],$_POST['cbo_suffix']) . " has been added!";
	echo "Trainee has been added!";
	

?>