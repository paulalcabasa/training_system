<?php
	
	include("../initialize.php");
	
	$ctr = $trainee->addTraining($_POST['trainee_code'],$_POST['program_code'],$_POST['conducted_by'],$_POST['venue'],$_POST['start_date'],$_POST['end_date']);

	if($ctr > 0){
		echo "Successfully added training record.";
	}
	else {
		echo "Database error.";
	}
?>