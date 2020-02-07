<?php
	include("../initialize.php");

	$trainee->updateProductKnowledge($_POST['exam_id'],$_POST['exam'],$_POST['score']);
	echo "Successfully updated exam.";
?>