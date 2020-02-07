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


// DB table to use
$table = 'v_training_programs';
 
// Table's primary key
$primaryKey = 'training_program_id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

$columns = array(
     array('db' => 'tp_id', 'dt' => 0),
     array('db' => 'title', 'dt' => 1),
     array('db' => 'trainor_name', 'dt' => 2),
     array('db' => 'venue', 'dt' => 3),
     array(
        'db' => 'start_date',
        'dt' => 4,
        'formatter' => function($d, $row){
            return Format::format_date2($d);
        }
    ),
    array(
        'db' => 'end_date',
        'dt' => 5,
        'formatter' => function($d, $row){
            return Format::format_date2($d);
        }
    ),
     array(
        'db' => 'training_program_id',
        'dt' => 6,
        'formatter' => function($d, $row){
            global $encryption;
            $row = (object)$row;

            $enc_tp_id = $encryption->encrypt($d);
            $enc_program_id = $encryption->encrypt($row->program_id);
            $value = "<div class='btn-group'>
                           <button type='button' class='btn btn-info btn-xs dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            Action <span class='caret'></span>
                            </button>
                          <ul class='dropdown-menu dropdown-menu-right'>
                            <li><a href='training_program_grading_criteria.php?d=$enc_tp_id'><i class='fa fa-percent fa-1x'></i> Grading Criteria</a></li>
                            <li><a href='view_tp_exams.php?d=$enc_tp_id'><i class='fa fa-file-text fa-1x'></i> Examinations</a></li>
                            <li><a href='training_program_attendees.php?d=$enc_tp_id'><i class='fa fa-users fa-1x'></i> Trainees</a></li>
                            <li><a href='training_attendance.php?d=$enc_tp_id'><i class='fa fa-clock-o fa-1x'></i> Attendance</a></li>
                           
                            <li><a href='view_materials.php?d=$enc_program_id'><i class='fa fa-briefcase fa-1x'></i> Materials</a></li>
                            <li role='separator' class='divider'></li>
                            <li><a href='update_training_program.php?d=$enc_tp_id'><i class='fa fa-edit fa-1x'></i> Edit</a></li>
                            <li><a href='#' class='btn_delete' data-id='".$d."'><i class='fa fa-trash fa-1x'></i> Delete</a></li>
                          </ul>
                        </div>";
            return $value;
        }
    ),
    array('db' => 'program_id','dt' => 7)
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


$arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns);


//$arr["data"] = Format::utf8ize($arr["data"]);

echo json_encode($arr);

