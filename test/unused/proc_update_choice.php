<?php
	
	include("../initialize.php");

	$program->updateChoice($_POST['choice_id'],$_POST['choice']);
	echo "Choice was changed to <strong>" . $_POST['choice'] . "</strong>.";
?>