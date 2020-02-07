<?php
	include("../initialize.php");
	 $program->changeTrainingProgram($_POST['training_program_id'],$_POST['new_program']);
	 echo "Successfully changed program. All trainees had also been removed.";
?>