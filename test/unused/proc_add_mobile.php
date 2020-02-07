<?php
	include("../initialize.php");
	echo $trainee->addMobile($_POST['trainee_id'],$_POST['mobile_no']);
?>