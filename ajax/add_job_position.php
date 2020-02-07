<?php
	
	include("../initialize.php");
	$job = new Job();
	$job->addJob($post->job_category,$post->job_position);

?>