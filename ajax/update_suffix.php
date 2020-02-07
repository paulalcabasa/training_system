<?php
	include("../initialize.php");
	$trainee = new Trainee();
	$trainee->updateSuffix($post->id,$post->new_suffix);
?>