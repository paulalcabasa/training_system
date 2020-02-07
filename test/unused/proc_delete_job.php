<?php
	
	include("../initialize.php");

	$job->deleteJob($_POST['id']);
	echo "Successfully deleted job!";
?>