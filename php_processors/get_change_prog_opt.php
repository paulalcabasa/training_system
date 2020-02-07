<?php
	include("../initialize.php");
	echo $program->getProgramsExcept($_POST['program_code']);
?>