<?php

require_once("../initialize.php");

$trainee = new Trainee();
$trainee->deleteTrainee($post->id,$user_data->employee_id);
echo "success";