
<?php
	include("../initialize.php");
	
	$trainee->addNameSuffix($_POST['name_suffix']);

	echo "<strong>" . $_POST['name_suffix'] . "</strong> has been added.";
?>