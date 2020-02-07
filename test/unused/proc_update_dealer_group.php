<?php
	
	include("../initialize.php");

	$dealer->setDealerGroupName($_POST['name']);
	$dealer->setDealerGroupId($_POST['id']);

	$msg = $dealer->updateDealerGroup($_SESSION['user_data']['employee_id']);
	if($msg > 0 ){
		echo "Dealer successfully updated!";
	}
	else {
		echo $msg;
	}
?>