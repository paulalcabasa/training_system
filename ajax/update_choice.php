<?php
	
include("../initialize.php");
$exam = new Exam();
$exam->updateChoice($post->choice_id,$post->choice);
echo "Choice was changed to <strong>" . $post->choice . "</strong>.";
?>