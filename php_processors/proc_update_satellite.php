<?php

	include("../initialize.php");

	
	$dealer->setDealerSatelliteCode($_POST['dealer_code']);
	$dealer->setDealerSatelliteName($_POST['dealer_name']);
	$dealer->setDealerSatelliteId($_POST['id']);
	$dealer->setDealerSatAbbrev($_POST['dealer_abbrev']);
	$msg = $dealer->updateDealerSatellite($_SESSION['user_data']['employee_id']);
	if($msg > 0 ){
		echo "<strong>" . $_POST['dealer_name'] . "</strong> was successfully added from the dealer group list.";
	}
	else {
		echo $msg;
	}
?>