<?php
	
	include("../initialize.php");

	$trainee->updateAttendance($_POST['att_id'],$_POST['attendance_id'],$_POST['trainee_id'],$_POST['time_in'],$_POST['score']);
		echo "Successfully updated attendance record.";
?>