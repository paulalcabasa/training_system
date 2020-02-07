<?php
	
	include("../initialize.php");
	
	$program = new Program();
	$program->deleteProgram($post->id,$user_data->employee_id);

	
?>