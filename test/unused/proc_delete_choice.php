<?php
	
	include("../initialize.php");

	$program->deleteChoice($_POST['choice_id']);
	echo "<strong>" . $_POST['choice'] . "</strong> was successfully deleted.";
?>