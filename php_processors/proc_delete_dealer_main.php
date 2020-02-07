<?php
	
	include("../initialize.php");

	$dealer->setDealerMainId($_POST['id']);
	$msg = $dealer->deleteDealerMain();
	if($msg > 0 ){
		echo "Dealer successfully deleted!";
	}
	else {
		echo $msg;
	}
?>