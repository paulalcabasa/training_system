<?php
	
	include("../initialize.php");

	$trainee->updateModuleGrade($_POST['workshop_id'],$_POST['attendance_id'],$_POST['trainee_id'],$_POST['participation'],$_POST['mod_end_exam'],$_POST['mod_end_eva']);

	echo $conn->getDateToday();
?>