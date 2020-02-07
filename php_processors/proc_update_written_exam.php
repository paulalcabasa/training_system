<?php
	
	include("../initialize.php");
	$trainee->updateWrittenExam($_POST['exam_id'],$_POST['exam'],$_POST['score']);
	echo "Successfully updated exam.";
?>