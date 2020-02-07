<?php
	
	include("../initialize.php");
	$program->setProgramCode($_POST['program_code']);
	$program->setCategory($_POST['category']);
	$program->setTitle($_POST['title']);
	$program->setDescription($_POST['description']);
	$program->setObjectives($_POST['objectives']);
	$row_count =  $program->updateProgram();
	if($row_count > 0){
		echo "Program updated.";
	}
?>