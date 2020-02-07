
<?php
	include("../initialize.php");
	
	echo $program->getTrainingProgramAttendeesOption($trainee,$_POST['tp_id'],$_POST['module_id']);
?>