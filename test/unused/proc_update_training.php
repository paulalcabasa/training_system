<?php
	include("../initialize.php");
	$program->updateTrainingProgramInfo($_POST['training_program_id'],$_POST['trainor_id'],$_POST['venue'],$_POST['start_date'],$_POST['end_date'],$_SESSION['user_data']['employee_id']);
	echo "Successfully updated training program details.";
?>