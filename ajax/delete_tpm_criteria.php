<?php
	include("../initialize.php");
	$trainingprogram = new TrainingProgram();
	$trainingprogram->deleteTPMCriteria($post->criteria_id,$user_data->employee_id);
?>