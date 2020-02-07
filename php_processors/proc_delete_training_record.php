<?php
	
	include("../initialize.php");
	$program->deleteTrainingProgram($_POST['training_program_id']);
	echo "Training program has been deleted.";


?>