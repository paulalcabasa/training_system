
<?php
	
	include("../initialize.php");
	$program = new Program();
	$program->setTraineeExamAnswer($_POST['trainee_id'],$_POST['item_id'],$_POST['choice_id'],$_SESSION['user_data']['employee_id']);
	echo json_encode($program->getTraineeExamScore($_POST['trainee_id'],$_POST['exam_id']));

?>