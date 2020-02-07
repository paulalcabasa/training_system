<?php
	
	include("../initialize.php");

	$job->addJob($_POST['job_category'],$_POST['job_position']);
	echo "Successfully added job!";
?>