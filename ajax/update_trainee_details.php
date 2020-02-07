<?php
	
	include("../initialize.php");
	$trainee = new Trainee();
	
	$trainee->updateTrainee(
		$post->trainee_code,
		$post->txt_fname,
		$post->txt_mname,
		$post->txt_lname,
		$post->cbo_suffix,
		$post->txt_date_of_birth,
		$post->cbo_civil_status,
		$post->gender,
		$post->cbo_education,
		$post->txt_dealer_name,
		$post->cbo_job_position,
		$post->cbo_emp_status,
		$post->txt_date_hired,
		$post->txt_office,
		$post->cbo_province,
		$post->cbo_municipality,
		$post->txt_street_addr,
		$user_data->employee_id,
		$post->txt_nickname,
		$post->txt_email
	);