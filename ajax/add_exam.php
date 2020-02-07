<?php

require_once("../initialize.php");
$exam = new Exam();

$exam->addExam(
	$post->tp_id,
	$post->program_id,
	$post->module_id,
	$post->exam,
	$post->passing_score,
	$user_data->employee_id
);

echo $post->exam . " has been successfully addded!";