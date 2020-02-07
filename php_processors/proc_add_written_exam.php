<?php
	
	include("../initialize.php");
	$trainee->addWrittenExam($_POST['attendance_id'],$_POST['trainee_id'],$_POST['exam'],$_POST['score']);
	echo "Successfully added exam.";
?>