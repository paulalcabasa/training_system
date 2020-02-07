<?php
	
	include("../initialize.php");

	$dealer->setDealerMainId($_POST['id']);
	$dealer->setDealerCode($_POST['dealer_code']);
	$dealer->setDealerMainName($_POST['dealer_name']);
	$dealer->setDealerAbbrev($_POST['dealer_abbrev']);
	$msg = $dealer->updateDealerMain($user);
	if($msg > 0 ){
		echo "Dealer successfully updated!";
	}
	else {
		echo $msg;
	}
?>