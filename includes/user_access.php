<?php 
	
	require_once("../../../classes/class.main_conn.php");
	require_once("../../../classes/class.employee_masterfile.php");
	$dbconn = New Main_Conn();
	$employee_masterfile = new Employee_Masterfile();
	
	$user_access = $employee_masterfile->getUserAccess($_SESSION['user_data']['employee_id'],SYSTEM_ID);
	if($user_access['user_type'] != "Administrator" && $user_access['user_type'] != "SuperUser" && $user_access['user_type'] != "Regular"){
		header("location:../../../main_home.php");
	}
	

?>