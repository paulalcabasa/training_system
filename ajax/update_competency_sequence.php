<?php

require_once("../initialize.php");
$evaluation = new Evaluation();

$evaluation->updateCompetencySequence($post->competency_list,$user_data->employee_id);