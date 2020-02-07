<?php
	include("../initialize.php");
	$job->updateJobCategory($_POST['id'],$_POST['name']);
	echo "Successfully added " . $_POST['name'] . ".";
?>