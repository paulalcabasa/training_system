<?php
require_once("../initialize.php");
$dealer = new Dealer();
$dealer_parent_id = NULL;
if($post->dealer_parent_id != ""){
	$dealer_parent_id = $post->dealer_parent_id;
}
$dealer->addDealer(
	$post->dealer_type_id,
	$dealer_parent_id,
	$post->dealer_group_id,
	$post->dealer_code,
	$post->dealer_name,
	$post->dealer_abbrev,
	$user_data->employee_id
);
