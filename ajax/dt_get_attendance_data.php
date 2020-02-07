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
$tp_id = $get->tp_id;
// DB table to use
$table = 'v_attendance_list';
 
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
    array('db' => 'time_in', 'dt' => 3),
    array(
        'db' => 'id',
        'dt' => 4,
        'formatter' => function($d,$row){
            $row = (object)$row;
            $value = '<a href="#" class="btn_edit_attendance" data-id="'.$d.'" style="margin-right:.5em;"><i class="fa fa-edit fa-1x"></i></a>
                      <a href="#" class="btn_remove" data-id="'.$d.'"><i class="fa fa-trash fa-1x"></i></a>';
            return $value;
        }
    ),
    array('db' => 'tpm_module_id', 'dt' => 5),
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

$where = "tp_id = " . $tp_id;
$arr = SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where);


//$arr["data"] = Format::utf8ize($arr["data"]);

echo json_encode($arr);

