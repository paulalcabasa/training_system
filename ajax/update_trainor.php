<?php
require_once("../initialize.php");
$trainor = new Trainor();
$trainor->updateTrainor(
	$post->trainor_id,
	$post->fname,
	$post->mname,
	$post->lname,
	$post->name_ext,
	$post->trainor_source_id,
	$user_data->employee_id
);