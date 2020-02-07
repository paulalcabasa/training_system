<?php
	include("../initialize.php");
	$trainingprogram = new TrainingProgram();
	$trainingprogram->updateTrainingProgramInfo(
		$post->training_program_id,
		$post->trainor_id,
		$post->venue,
		$post->start_date,
		$post->end_date,
		$user_data->employee_id
	);
	echo "Successfully updated training program details.";
?>