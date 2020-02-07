<?php
	include("../initialize.php");
	$dealer = new Dealer();
	$dealer->deleteDealerGroup($post->dealer_group_id,$user_data->employee_id);
?>