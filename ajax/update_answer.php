<?php
	
	include("../initialize.php");
	$exam = new Exam();
	$exam->setQuestionAnswer($post->item_id,$post->choice_id,$user_data->employee_id);
	echo "Answer successfully changed to ";
?>