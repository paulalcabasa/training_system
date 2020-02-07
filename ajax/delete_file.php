<?php
	
	include("../initialize.php");
	$program = new Program();
	$program->deleteMaterial($post->id,$post->file_dest);

?>