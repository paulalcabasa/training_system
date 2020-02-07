<?php
	include("../initialize.php");
	echo $trainee->getHistory($_POST['trainee_id'],$_POST['category']);
	 
?>