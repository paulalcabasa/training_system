<?php
	
	include("../initialize.php");
	
	$pic = "";
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
		$_POST['cbo_education'],
		$pic,
		$_POST['cbo_suffix'],
		$_POST['cbo_province'],
		$_POST['cbo_municipality'],
		$_POST['cbo_emp_status']
	);

	$trainee->updateTrainee($_SESSION['user_data']['employee_id'],$_POST['trainee_code']);
	

?>