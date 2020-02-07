
<?php
	include("../initialize.php");
	$data = $trainor->getTrainorInfo($_POST['trainor_id']);
	$info = array("first_name"=>$data['first_name'],"middle_name"=>$data['middle_name'],"last_name"=>$data['last_name'],"name_ext"=>$data['name_extension']);
	echo json_encode($info);
?>