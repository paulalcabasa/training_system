<?php
	include("../initialize.php");
	$job = new Job();
	$job->deleteJobCategory($post->id);

?>