<?php
	
	include("../initialize.php");
	$trainor->setName($_POST['first_name'],$_POST['middle_name'],$_POST['last_name'],$_POST['name_ext']);
	$id = $trainor->addTrainor($_SESSION['user_data']['employee_id']);
	echo $id;
?>