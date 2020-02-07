<?php
	
	include("../initialize.php");
	$exam = new Exam();
	$exam->updateQuestion($post->item_id,$post->question);
	
	echo "Question successfully updated.";
?>