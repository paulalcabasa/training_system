<?php

	include("../initialize.php");

	echo $program->addAttendance($_POST['tp_id'],$_POST['module_id'],$_POST['trainee_id'],$_POST['time_in'],$_SESSION['user_data']['employee_id']);

?>