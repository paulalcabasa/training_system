<?php
	
	include("../initialize.php");


	$row_count = $program->deleteMaterial($_POST['id'],$_POST['file_dest']);
	if($row_count > 0 ){
		echo "<strong>" . $_POST['file_name'] . "</strong>" . " has been deleted.";
	}
?>