
<?php
	
	include("../initialize.php");
	

	$trainee->deleteModuleGrade($_POST['workshop_id']);
	echo $trainee->getModuleWorkshopOption($_POST['attendance_id'],$_POST['program_code']);

?>