<?php
	include("../initialize.php");
	$trainee = new Trainee();
	echo $trainee->addMobile($post->trainee_id,$post->mobile_no);
?>