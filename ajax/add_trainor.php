<?php
require_once("../initialize.php");
$trainor = new Trainor();
$trainor->addTrainor(
	$post->first_name,
	$post->middle_name,
	$post->last_name,
	$post->name_ext,
	$post->source_id,
	$user_data->employee_id
);