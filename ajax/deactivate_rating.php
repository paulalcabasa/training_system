<?php

require_once("../initialize.php");
$evaluation = new Evaluation();


$evaluation->deactivateRating($post->rating_id,$user_data->employee_id);