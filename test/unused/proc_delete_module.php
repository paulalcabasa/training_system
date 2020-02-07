<?php
	
	include("../initialize.php");

	$program->deleteModule($_POST['id']);

	echo "Module Successfully Deleted.";
?>