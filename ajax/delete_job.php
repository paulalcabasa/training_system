<?php
	
	include("../initialize.php");
	$job = new Job();
	$job->deleteJob($post->id);
	
?>