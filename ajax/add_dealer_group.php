<?php
	include("../initialize.php");
	$dealer = new Dealer();
	$dealer->addDealerGroup($post->dealer_group_name,$user_data->employee_id);
	echo "Successfully added " . $post->dealer_group_name . " to the dealer groups.";
?>