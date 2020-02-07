<?php
	
	include("../initialize.php");
	$program = new Program();
	$program->updateModule($post->id,$post->name,$user_data->employee_id);	
	
?>