<?php
	
	include("../initialize.php");

	$program->deleteExam($_POST['exam_id']);
	echo "Exam successfully deleted.";
?>