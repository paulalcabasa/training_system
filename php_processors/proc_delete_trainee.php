<?php
	include("../initialize.php");

	$trainee->deleteTrainee($_POST['id'],$_POST['picture'],$_SESSION['user_data']['employee_id']);
	echo "Account successfully deleted.";

?>