<?php
	
	include("../initialize.php");
	$trainor->updateTrainor($_POST['id'],$_POST['fname'],$_POST['mname'],$_POST['lname'],$_POST['name_ext'],$_SESSION['user_data']['employee_id']);	
	echo "success";
?>