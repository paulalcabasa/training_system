<?php
	
	include("../initialize.php");

	$program->addTraineeExam($_POST['trainee_id'],$_POST['tp_id'],$_POST['exam_id'],$_SESSION['user_data']['employee_id']);
	echo "added";
?>