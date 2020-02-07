<?php
	
	include("../initialize.php");

	$program->updateQuestion($_POST['item_id'],$_POST['question']);
	
	echo "Question successfully changed.";
?>