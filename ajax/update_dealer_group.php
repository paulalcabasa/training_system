<?php
	include("../initialize.php");
	$dealer = new Dealer();
	$dealer->updateDealerGroup($post->dealer_group_id,$post->dealer_group_name,$user_data->employee_id);
?>