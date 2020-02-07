<?php

require_once("../initialize.php");
$evaluation = new Evaluation();


$evaluation->deactivateCompetency($post->competency_id,$user_data->employee_id);