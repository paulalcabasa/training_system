<?php
	
	include("../initialize.php");
	$job = new Job();
	$job->updateJobPosition($post->id,$post->job);
