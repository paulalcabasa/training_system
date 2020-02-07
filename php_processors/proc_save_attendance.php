<?php
	
	include("../initialize.php");

	$trainee->addAttendance($_POST['module_id'],$_POST['attendance_id'],$_POST['time_in'],$_POST['score']);
	echo "Attendance successfully added.";
?>