<?php
	include("../initialize.php");
	$trainee = new Trainee();
	$trainee->deleteMobile($post->id);
	