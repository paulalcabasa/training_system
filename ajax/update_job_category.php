<?php
	include("../initialize.php");
	$job = new Job();
	$job->updateJobCategory($post->id,$post->name);
	
?>