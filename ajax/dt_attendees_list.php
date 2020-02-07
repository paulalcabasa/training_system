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
$get = (object)$_GET;
$tp_id = $get->tp_id;


// DB table to use
$table = 'v_attendees_list';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

$columns = array(
     array('db' => 'trainee_id', 'dt' => 0),
     array('db' => 'trainee_name', 'dt' => 1),
     array('db' => 'dealer_name', 'dt' => 2),
     array('db' => 'job_description', 'dt' => 3),
     array(
        'db' => 'id',
        'dt' => 4,
        'formatter' => function($d, $row){
            global $encryption, $tp_id;
            $enc_trainee_attendee_id = $encryption->encrypt($d);
            $enc_tp_id = $encryption->encrypt($tp_id);
            $value = "<div class='btn-group'>
                           <button type='button' class='btn btn-info btn-xs dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            Action <span class='caret'></span>
                            </button>
                          <ul class='dropdown-menu dropdown-menu-right'>
                            <li><a href='trainee_evaluation.php?t=$enc_trainee_attendee_id&tp_id=$enc_tp_id'><i class='fa fa-file-text fa-1x'></i> Evaluate</a></li>
                            <li><a href='trainee_evaluation.php'><i class='fa fa-text fa-1x'></i> Record Summary</a></li>
                          </ul>
                        </div>";
            /*
                <li><a href='view_tp_exams.php'><i class='fa fa-file-text fa-1x'></i> Examinations</a></li>
                <li><a href='training_program_attendees.php'><i class='fa fa-users fa-1x'></i> Trainees</a></li>
                <li><a href='training_attendance.php'><i class='fa fa-clock-o fa-1x'></i> Attendance</a></li>
            */
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

$where = " training_program_id = " . $tp_id;
$arr = SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where);


//$arr["data"] = Format::utf8ize($arr["data"]);

echo json_encode($arr);

