<?php

	include("../initialize.php");
	$attendance = new Attendance();
	$attendance->addAttendance(
		$post->tp_id,
		$post->module_id,
		$post->selected_trainees,
		$post->attendance_date,
		$user_data->employee_id
	);

?>