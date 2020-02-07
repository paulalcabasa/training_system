<?php
	include("../initialize.php");
	$attendance = new Attendance();
	$attendance->updateAttendance(
		$post->attendance_id,
		$post->attendance_date,
		$user_data->employee_id
	);
?>