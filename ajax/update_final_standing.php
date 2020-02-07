<?php

include("../initialize.php");
$tp = new TrainingProgram();
$exam->updateFinalStanding(
	$post->attendee_id,
	$post->final_standing
);
echo "Successfully updated.";
?>