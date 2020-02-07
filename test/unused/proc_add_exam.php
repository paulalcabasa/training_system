<?php
	
	include("../initialize.php");

	$program->createExam($_POST['tp_id'],$_POST['program_id'],$_POST['module_id'],$_POST['exam'],$_POST['passing_score'],$_SESSION['user_data']['employee_id']);
	echo "Exam successfully created. You can now add questions to the exam.";
?>