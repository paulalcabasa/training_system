<?php
	
	include("../initialize.php");

	$dealer->setDealerSatelliteId($_POST['id']);
	$msg = $dealer->deleteSatellite();
	if($msg > 0){
		echo "Dealer successfully deleted!";
	}
	else {
		echo $msg;
	}
?>