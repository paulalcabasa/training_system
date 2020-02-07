<?php
	include("../initialize.php");
	$trainingprogram = new TrainingProgram();
	$trainingprogram->addTPMCriteria($post->module_id,$post->criteria,$post->percentage,$user_data->employee_id);
	echo $post->criteria ." has been successfully added as a grading criteria.";
?>