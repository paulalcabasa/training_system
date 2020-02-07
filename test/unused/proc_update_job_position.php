<?php
	
	include("../initialize.php");

	$job->updateJobPosition($_POST['id'],$_POST['job']);
	echo "Successfully added job!";
?>