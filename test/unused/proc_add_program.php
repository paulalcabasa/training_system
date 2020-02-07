<?php

	include("../initialize.php");
	
	$program->setCategory($_POST['category']);
	$program->setTitle($_POST['txt_title']);
	$program->setDescription($_POST['description']);
	$program->setObjectives($_POST['objectives']);
	$program->setModule($_POST['modules']);
	$msg = "";

	$files = $conn->diverse_array($_FILES['files']);

	if($files[0]['name'] != ""){
	
	    $desired_dir="../file_storage";
	    //$extensions = array("pdf");
	    
        
        foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
	        $file_name = $_FILES['files']['name'][$key];
	        $file_size =$_FILES['files']['size'][$key];
	        $file_tmp =$_FILES['files']['tmp_name'][$key];
	        $file_type=$_FILES['files']['type'][$key];  
	        if($file_size > 750000000){
	          $msg .= "<li><strong>". $file_name . "</strong> is too large.</li>";
	        }   

	        $file_ext = explode(".",$file_name);
	        $file_ext = end($file_ext);
	        $new_file_name = "file_" . time() . $key . ".". $file_ext;

	        /*if(!in_array($file_ext,$extensions)){
	           $msg .= "<li><strong>" . $file_name . "</strong> is not an accepted file format.</li>";
	        }*/
	    }
        
        if($msg==""){
        	$msg = "<strong>" . $_POST['txt_title'] . "</strong> has been added.";
        	$msg .= "<ol>File uploads:";
            $program_code = $program->addProgram();
            // script for uploading the file
            foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
                $file_name = $_FILES['files']['name'][$key];
                $file_size =$_FILES['files']['size'][$key];
                $file_tmp =$_FILES['files']['tmp_name'][$key];
                $file_type=$_FILES['files']['type'][$key];  
           
                $file_ext = explode(".",$file_name);
                $file_ext = end($file_ext);
                $new_file_name = "file_" . time() . $key . ".". $file_ext;
              	
                if(move_uploaded_file($file_tmp,$desired_dir . "/".$new_file_name)){ 
                	$program->addMaterial($program_code,$file_name,$new_file_name,$_SESSION['user_data']['employee_id']);
                	$msg .= "<li><strong>" .$file_name. "</strong> has been uploaded.</li>";
            	}
            }

            $msg .= "</ol>";
        } else {
            $msg .= "<span>Failed adding the program due to the following errors : </span><ul>" . $msg . "</ul><br/><strong>Note:</strong> Only pdf files are accepted.";
        }
    } else {
        $program_code = $program->addProgram();
        $msg .= "<strong>".$_POST['txt_title'] . "</strong> has been added.";
    }
	  
  	echo $msg;

?>