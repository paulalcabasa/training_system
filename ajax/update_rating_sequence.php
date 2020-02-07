<?php

require_once("../initialize.php");
$evaluation = new Evaluation();

$evaluation->updateRatingSequence($post->rating_list,$user_data->employee_id);