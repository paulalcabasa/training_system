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
$table = 'v_trainees_list';
 
// Table's primary key
$primaryKey = 'trainee_code';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

$columns = array(
     array(
        'db' => 'picture', 
        'dt' => 0,
        'formatter' => function($d, $row){
            $row = (object)$row;
            $pic = ($d == "" ? "anonymous.png" : $d);
            return '<a href="trainee_pics/'.$pic.'" class="trn_pic" title="'.$row->trainee_name.'" rel="gallery"><img src="trainee_pics/'.$pic.'" class="img-responsive img-thumbnail" height="50" width="50"></a>';
        }
    ),
     array('db' => 'trainee_id', 'dt' => 1),
     array('db' => 'trainee_name', 'dt' => 2),
     array('db' => 'dealer_name', 'dt' => 3),
     array('db' => 'job_description', 'dt' => 4),
     array(
        'db' => 'trainee_code',
        'dt' => 5,
        'formatter' => function($d, $row){
            global $encryption;
            $row = (object)$row;
            $enc_trainee_id = $encryption->encrypt($d);
            $value = "<div class='btn-group'>
                           <button type='button' class='btn btn-info btn-xs dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            Action <span class='caret'></span>
                            </button>
                          <ul class='dropdown-menu dropdown-menu-right'>
                            <li><a href='view_trainee_profile.php?d=$enc_trainee_id'><i class='fa fa-file-text fa-1x'></i> View Profile</a></li>
                            <li role='separator' class='divider'></li>
                            <li><a href='update_trainee.php?d=$enc_trainee_id'><i class='fa fa-edit fa-1x'></i> Edit</a></li>
                            <li><a href='#' class='btn_delete' data-id='".$d."' data-name='".$row->trainee_name."'><i class='fa fa-trash fa-1x'></i> Delete</a></li>
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


$arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns);


//$arr["data"] = Format::utf8ize($arr["data"]);

echo json_encode($arr);

