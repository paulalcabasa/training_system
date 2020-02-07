<?php

require_once("../initialize.php");
$evaluation = new Evaluation();

$evaluation->addRating($post->rating,$user_data->employee_id);