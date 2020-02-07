<?php

require_once("../initialize.php");
$evaluation = new Evaluation();


$evaluation->updateRatingDescription($post->rating_id,$post->description,$user_data->employee_id);