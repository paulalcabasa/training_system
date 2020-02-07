<?php

require_once("../initialize.php");
$evaluation = new Evaluation();

$evaluation->addCompetency($post->competency,$user_data->employee_id);