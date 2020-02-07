<?php
include("../initialize.php");
$exam = new Exam();
$question_id = $exam->addExamQuestion(
	$post->exam_id,
	$post->question,
	$user_data->employee_id
);
$choices = json_decode($post->choices,true);
foreach ($choices as $key => $data) { // This will search in the 2 jsons
	$data = (object)$data;
	$isCorrect = $data->isCorrect;
	$choice_name = $data->choice;
	$choice_id = $exam->addQuestionChoices($question_id,$choice_name);
	if($isCorrect){
		$exam->setQuestionAnswer($question_id,$choice_id,$user_data->employee_id);
	}
}
$exam->addQuestionChoices($question_id,"No answer");
echo "Question successfully added.";
?>