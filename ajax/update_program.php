<?php
	
	include("../initialize.php");
	$program = new Program();
	$program->updateProgram(
		$post->program_code,
		$post->category,
		$post->title,
		$post->description,
		$post->objectives,
		$user_data->employee_id
	);
	
?>