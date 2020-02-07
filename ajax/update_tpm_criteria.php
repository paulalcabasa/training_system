<?php

require_once("../initialize.php");

$trainingprogram = new TrainingProgram();

$trainingprogram->updateTPMCriteria(
	$post->criteria_id,
	$post->criteria,
	$post->percentage,
	$user_data->employee_id
);