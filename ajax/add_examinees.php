<?php
require_once("../initialize.php");
$post = (object)$_POST;
$user_data = (object)$_SESSION['user_data'];
$exam = new Exam();
$selected_examinees = $post->selected_attendees;
foreach($selected_examinees as $examinee){
	$examinee_details = explode(';',$examinee);
	$exam->addExaminee($examinee_details[0],$post->exam_id,$user_data->employee_id,$post->tp_id,$examinee_details[1]);
}