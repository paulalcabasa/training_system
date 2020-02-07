<?php

require_once("../initialize.php");
$evaluation = new Evaluation();

$evaluation_details = $evaluation->getParticipantEvaluationDetails($post->participant_id,$post->tp_id,$post->competency_id);
if(!empty($evaluation_details)){
	$evaluation->updateParticipantEvaluation(
		$post->participant_id,
		$post->tp_id,
		$post->competency_id,
		$post->rating_id,
		$user_data->employee_id
	);
}
else {
	$evaluation->addParticipantEvaluation(
		$post->participant_id,
		$post->tp_id,
		$post->competency_id,
		$post->rating_id,
		$user_data->employee_id
	);
}