<?php
require_once("../initialize.php");
$dealer = new Dealer();

$dealer->updateDealer(
	$post->dealer_id,
	$post->dealer_code,
	$post->dealer_name,
	$post->dealer_abbrev,
	$user_data->employee_id
);
