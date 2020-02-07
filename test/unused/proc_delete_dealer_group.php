<?php
	
	include("../initialize.php");


	$dealer->setDealerGroupId($_POST['id']);

	$msg = $dealer->deleteDealerGroup();
	if($msg > 0 ){
		echo "Dealer successfully deleted!";
	}
	else {
		echo $msg;
	}
?>