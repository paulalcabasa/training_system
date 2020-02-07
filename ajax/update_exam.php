<?php

include("../initialize.php");
$exam = new Exam();
$exam->updateExam(
	$post->exam_id,
	$post->module_id,
	$post->exam,
	$post->passing_score,
	$user_data->employee_id
);
echo "Exam successfully updated.";
?>