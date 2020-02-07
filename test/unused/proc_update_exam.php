<?php
	
	include("../initialize.php");
	$exam = new Exam();
	$exam->updateExam($_POST['exam_id'],$_POST['module_id'],$_POST['exam'],$_POST['passing_score'],$_SESSION['user_data']['employee_id']);
	echo "Exam successfully updated.";
?>