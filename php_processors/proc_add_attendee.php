<?php
	include("../initialize.php");
	$program->addAttendee($_POST['trainee_id'],$_POST['tp_id'],$_POST['program_id'],$_SESSION['user_data']['employee_id']);
	echo "Successfully added!";
?>