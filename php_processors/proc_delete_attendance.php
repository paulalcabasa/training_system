<?php
	
	include("../initialize.php");

	$trainee->deleteAttendance($_POST['att_id']);
	echo $trainee->getAttendanceOption($_POST['attendance_id'],$_POST['program_code']);
?>