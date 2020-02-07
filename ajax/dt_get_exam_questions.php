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
$get = (object)$_GET;
$exam_id = $get->exam_id;

// DB table to use
$table = 'v_exam_questions';
 
// Table's primary key
$primaryKey = 'item_id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

$columns = array(
    array('db' => 'item_id','dt' => 0 ), // this is changed and used as counter  - sequential
    array('db' => 'question', 'dt' => 1),
    array(
        'db' => 'choice_id',
        'dt' => 2,
        'formatter' => function($d, $row){
            global $exam;
            $row = (object)$row;
            $choice_list = $exam->getQuestionChoicesList($row->item_id);            
            $value = "<select class='form-control cbo_answer' style='width:100%;'>";
            foreach($choice_list as $choice){
                $choice = (object)$choice;
                $value .= "<option value='".$choice->choice_id."' data-item_id='".$row->item_id."' ";
                if($choice->choice_id == $d){
                    $value .= 'selected';
                }

                $value .= '>' . $choice->choice . "</option>";

            }
            $value .= "</select>";
            return $value;
        }
     ),
    array(
        'db' => 'item_id', 
        'dt' => 3,
        'formatter' => function($d,$row){
            global $encryption;
            $row = (object)$row;
            $value = "<div class='btn-group'>
                          <button type='button' class='btn btn-info btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            Action <span class='caret'></span>
                          </button>
                          <ul class='dropdown-menu dropdown-menu-right'>
                            <li><a href='#' class='btn_pop_update' data-question='".$row->question."' data-id='".$d."'><i class='fa fa-question-circle'></i> Edit Question</a></li>
                            <li><a href='#' class='btn_pop_choice' data-item_id='".$d."'><i class='fa fa-tag'></i> Edit Choices</a></li>
                           </ul>
                        </div>";
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

$ctr = 1;
$index = 0;

/* CHANGE ITEM ID TO A SERIES COUNTER*/
foreach($arr['data'] as $data){
    $arr['data'][$index][0] = $ctr;
    $index++;
    $ctr++;
}

echo json_encode($arr);

