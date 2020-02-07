<?php
	include("../initialize.php");
	$job->addJobCategory($_POST['category']);
	echo "Successfully added " . $_POST['category'] . ".";
?>