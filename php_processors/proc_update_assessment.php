
<?php

	include("../initialize.php");
	$trainee->updateGeneralAssessment($_POST['attendance_id'],$_POST['trainee_id'],$_POST['content']);
	echo "Successfully updated assessment.";
?>