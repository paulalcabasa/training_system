<?php
	include("../initialize.php");
	$exam = new Exam();
	$exam->setTraineeExamAnswer(
		$post->trainee_exam_taken_id,
		$post->item_id,
		$post->choice_id,
		$user_data->employee_id
	);
	$questions_list = $exam->getExamQuestionsList($post->exam_id);
	$data = array(
		"score" => $exam->getTraineeExamScore($post->trainee_exam_taken_id,$questions_list),
		"total_answers" => count($exam->getTraineeExamAnswers($post->trainee_exam_taken_id))
	);
	echo json_encode($data);