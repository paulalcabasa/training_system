<?php
	
	include("../initialize.php");

	$id = $trainee->addModuleGrade($_POST['attendance_id'],$_POST['txt_module'],$_POST['txt_participation'],$_POST['txt_mod_end'],$_POST['txt_mod_eva']);
?>