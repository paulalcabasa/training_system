<?php
	
	include("../initialize.php");
	$trainee->deleteWrittenExam($_POST['exam']);
	echo "Successfully deleted exam.";
?>