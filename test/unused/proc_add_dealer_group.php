<?php

	include("../initialize.php");

	$dealer->setDealerGroupName($_POST['dealer_group_name']);
	$msg = $dealer->addDealerGroup($_SESSION['user_data']['employee_id']);
	if($msg > 0 ){
		echo "<strong>" . $_POST['dealer_group_name'] . "</strong> was successfully added from the dealer group list.";
	}
	else {
		echo $msg;
	}


?>