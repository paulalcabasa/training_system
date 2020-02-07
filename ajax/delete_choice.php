<?php
	
	include("../initialize.php");
	$exam = new Exam();
	$exam->deleteChoice($post->choice_id);
	echo "<strong>" . $post->choice . "</strong> was successfully deleted.";
?>