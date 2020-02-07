<?php

require_once("../initialize.php");
$trainor = new Trainor();

echo json_encode($trainor->getTrainorDetails($post->trainor_id));