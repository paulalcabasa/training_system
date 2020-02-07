<?php
require_once("../initialize.php");
$trainingprogram = new TrainingProgram();
$selected_trainees = $post->selected_attendees;
$tp_id = $post->tp_id;
$grading_criteria_list = $trainingprogram->getGradingCriteriaPerTrainingProgram($tp_id);
foreach($selected_trainees as $t){
	$tpa_id = $trainingprogram->addTraineInTrainingProgram($t,$tp_id,$user_data->employee_id);
	foreach($grading_criteria_list as $criteria){
		$criteria = (object)$criteria;
		$trainingprogram->addParticipantGradeByCriteria(
			$criteria->training_program_grading_criteria_id,
			$tpa_id,
			$user_data->employee_id
		);
	}
}