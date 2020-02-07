<?php
	
	include("../initialize.php");

	$program->removeAttendee($_POST['training_program_id'],$_POST['trainee_id']);
	echo "success";
?>