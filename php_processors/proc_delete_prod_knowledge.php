<?php
	include("../initialize.php");

	$trainee->deleteProductKnowledge($_POST['exam_id']);
	echo "Successfully deleted exam."
?>