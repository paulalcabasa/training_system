<?php
	
	include("../initialize.php");

	$dealer->setDealerGroupId($_POST['dealer_group_id']);
	$dealer->setDealerMainName($_POST['dealer_name']);
	$dealer->setDealerCode($_POST['dealer_code']);
	$dealer->setDealerAbbrev($_POST['dealer_abbrev']);
	$msg = $dealer->addDealerMain($_SESSION['user_data']['employee_id']);
	if($msg > 0 ){
		echo "<strong>" . $_POST['dealer_name'] . "</strong> was successfully added from the dealer list under <strong>" . $_POST['gname'] . "</strong> dealer group.";
	}
	else {
		echo $msg;
	}
?>