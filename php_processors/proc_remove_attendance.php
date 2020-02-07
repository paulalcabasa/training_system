<?php

	include("../initialize.php");

	$program->removeAttendance($_POST['id']);
	echo "Attendance successfully deleted.";
?>