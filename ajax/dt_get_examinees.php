<?php
 
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
require_once("../initialize.php");
$encryption = new Encryption();
$exam = new Exam();
$exam_id = $get->exam_id;
$tp_id = $get->tp_id;
$passing_score = $get->passing_score;
$total_items = $get->total_items;
$questions_list = $exam->getExamQuestionsList($exam_id);

// DB table to use
$table = 'v_examinees';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

$columns = array(
    array('db' => 'exam_no', 'dt' => 0),
    array('db' => 'trainee_id', 'dt' => 1),
    array('db' => 'trainee_name', 'dt' => 2),
    array(
        'db' => 'score',
        'dt' => 3,
        'formatter' => function($d,$row){
           // global $exam,$total_items,$questions_list;
         //   $score = $exam->getTraineeExamScore($d,$questions_list);
          //  $percentage_score = ($score/$total_items)*100;
        //    return "<strong>".$score . "/" . $total_items . "</strong> <em>(" . Format::to_decimal($percentage_score) . "%)</em>";
            return $d;
        }
     ),
    array(  
        'db' => 'id',
        'dt' => 4,
        'formatter' => function($d,$row){
            global $exam,$total_items,$passing_score,$questions_list;
            $trainee_exam_answers = $exam->getTraineeExamAnswers($d);
            $score = $exam->getTraineeExamScore($d,$questions_list);
            $percentage_score = ($score/$total_items)*100;
            $remarks = $exam->getExamRemarks(count($trainee_exam_answers),$total_items,$percentage_score,$passing_score);
            return $remarks;
        }
    ),
    array(
        'db' => 'id',
        'dt' => 5,
        'formatter' => function($d, $row){
            global $tp_id,$encryption;
            $enc_tp_id = $encryption->encrypt($tp_id);
            $enc_trainee_exam_taken_id = $encryption->encrypt($d);
            $value = "<a href='exam_set_answer.php?d=$enc_tp_id&t=$enc_trainee_exam_taken_id'>Set answer</a>";
            return $value;
        }
    )
);
 
// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => 'latropcpi',
    'db'   => 'sys_training',
    'host' => 'localhost'
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( '../classes/ssp.class.php' );

$where = "exam_id = " . $exam_id;
$arr = SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where);


//$arr["data"] = Format::utf8ize($arr["data"]);

echo json_encode($arr);

