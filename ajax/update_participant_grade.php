<?php
require_once("../initialize.php");
$evaluation = new Evaluation();
$evaluation->updateParticipantGrade(
	$post->tpa_tpm_grade_id,
	$post->grade
);