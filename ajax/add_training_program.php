<?php
	
	include("../initialize.php");
	$post = (object)$_POST;
	$user_data = (object)$_SESSION['user_data'];
	$trainingprogram = new TrainingProgram();
	$program = new Program();
	$modules_list = $program->getProgramModulesList($post->program_id);

	$trainingprogram->createTrainingProgram(
		$post->program_id,
		$post->trainor_id,
		$post->venue,
		$post->start_date,
		$post->end_date,
		$user_data->employee_id,
		$modules_list
	);

	echo "Successfully created training program!";
?>