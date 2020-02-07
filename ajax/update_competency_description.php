<?php

require_once("../initialize.php");
$evaluation = new Evaluation();


$evaluation->updateCompetencyDescription($post->competency_id,$post->description,$user_data->employee_id);