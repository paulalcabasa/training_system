<?php
	
	include("../initialize.php");

	$program->setQuestionAnswer($_POST['item_id'],$_POST['choice_id'],$_SESSION['user_data']['employee_id']);
	
	echo "Answer successfully changed to ";
?>