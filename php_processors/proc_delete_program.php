<?php
	
	include("../initialize.php");
	
	$program->setProgramCode($_POST['id']);
	$program->deleteProgram();

	
	echo "Program Successfully Deleted.";
?>