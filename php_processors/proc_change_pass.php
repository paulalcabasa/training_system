<?php
	
	include("../initialize.php");
	$enc_password = $trainee->encryptor("encrypt",$_POST['new_password']);
	$trainee->updateTraineePassword($_POST['trainee_code'],$enc_password);
	echo "Successfully changed password.";
?>