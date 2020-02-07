<?php
	include("../initialize.php");
	$job->deleteJobCategory($_POST['id']);
	echo "Successfully deleted.";
?>