<?php

	include("../initialize.php");
	$program->setProgramCode($_POST['program_code']);
	$program->setPreReqs($_POST['list_of_prereqs']);
	$program->savePreReqs();
	echo "Successfully saved pre-requisites!";
?>