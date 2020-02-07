<?php

	include("../initialize.php");
	$attendance = new Attendance();
	$attendance->deleteAttendance($post->id);

?>