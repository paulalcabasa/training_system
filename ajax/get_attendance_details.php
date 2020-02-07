<?php
include("../initialize.php");
$attendance = new Attendance();

$data = $attendance->getAttendanceDetailsById($post->id);
echo json_encode($data);