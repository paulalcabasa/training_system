<?php
	include("../initialize.php");	
	$dealer->setDealerSatelliteCode($_POST['dealer_code']);
	$dealer->setDealerSatelliteName($_POST['dealer_name']);
	$dealer->setDealerSatAbbrev($_POST['dealer_abbrev']);
	$dealer->setDealerMainId($_POST['dealer_main_id']);
	$msg = $dealer->addSatellite($_SESSION['user_data']['employee_id']);
	if($msg > 0 ){
		echo "" . $_POST['dealer_name'] . " was successfully added from the dealer group list.";
	}
	else {
		echo $msg;
	}
?>