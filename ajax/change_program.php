<?php
	include("../initialize.php");
	$trainingprogram = new TrainingProgram();
	$exam = new Exam();
	$exams_list = $exam->getExams($post->training_program_id);
	$modules_list = $trainingprogram->getTrainingProgramModule($post->training_program_id);
	$program = new Program();
	$tpm_list = $program->getProgramModulesList($post->new_program);
	$trainingprogram->changeTrainingProgram(
		$post->training_program_id,
		$post->new_program,
		$exams_list,
		$modules_list,
		$tpm_list,
		$user_data->employee_id
	);
	 echo "Successfully changed program. All trainees had also been removed.";
?>