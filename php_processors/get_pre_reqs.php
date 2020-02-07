<?php
	include("../initialize.php");
	$data = $program->getPrequisites($_POST['id']);
	echo $data;
?>