<?php

	include("../initialize.php");
	$program = new Program();
	$program->addModule($post->program_code,$post->name,$user_data->employee_id);	
