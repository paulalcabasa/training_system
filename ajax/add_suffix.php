
<?php
	include("../initialize.php");
	$trainee = new Trainee();
	$trainee->addNameSuffix($post->name_suffix);