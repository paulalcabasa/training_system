<?php
	include("../initialize.php");

	echo $trainee->addProductKnowledgeExam($_POST['attendance_id'],$_POST['exam'],$_POST['score'],$_POST['trainee_id']);
	
?>