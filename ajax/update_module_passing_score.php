<?php
include("../initialize.php");
$trainingprogram = new TrainingProgram();
$trainingprogram->updateTPModulePassingScore(
	$post->module_id,
	$post->passing_score
);