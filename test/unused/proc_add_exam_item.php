<?php
	
	include("../initialize.php");

	$question_id = $program->addExamQuestion($_POST['exam_id'],$_POST['question'],$_SESSION['user_data']['employee_id']);
	$choices = json_decode($_POST['choices'],true);
	foreach ($choices as $key => $data) { // This will search in the 2 jsons
		$isCorrect = $data['isCorrect'];
		$choice_name = $data['choice'];
		$choice_id = $program->addQuestionChoices($question_id,$choice_name);
		if($isCorrect){
			$program->setQuestionAnswer($question_id,$choice_id,$_SESSION['user_data']['employee_id']);
		}
	}
	$program->addQuestionChoices($question_id,"No answer");
	echo "Question successfully added.";
?>