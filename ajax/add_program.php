<?php

include("../initialize.php");
$program = new Program();

$msg = "";

$files = Format::diverse_array($_FILES['files']);


if($files[0]['name'] != ""){

    $desired_dir="../file_storage";
    //$extensions = array("pdf");
    
    // check for errors
    $errorCtr = 0;
    foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
        $file_name = $_FILES['files']['name'][$key];
        $file_size =$_FILES['files']['size'][$key];
        $file_tmp =$_FILES['files']['tmp_name'][$key];
        $file_type=$_FILES['files']['type'][$key];  
        if($file_size > 750000000){
          $msg .= "<li><strong>". $file_name . "</strong> is too large.</li>";
        	$errorCtr++;
        }   
    }
    
    if($errorCtr == 0){
    	$msg = "<strong>" . $post->txt_title . "</strong> has been added.";
    	$msg .= "<ol>File uploads:";
        $program_code = $program->addProgram(
        	$post->category,
        	$post->txt_title,
        	$post->description,
        	$post->objectives,
        	$post->modules,
        	$post->module_ctr,
        	$user_data->employee_id
        );
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
            	$program->addMaterial($program_code,$file_name,$new_file_name,$user_data->employee_id);
            	$msg .= "<li><strong>" .$file_name. "</strong> has been uploaded.</li>";
        	}
        }

        $msg .= "</ol>";

        echo $msg;
    } else {
       echo "<span>Failed adding the program due to the following errors : </span><ul>" . $msg . "</ul><br/><strong>Note:</strong> Only pdf files are accepted.";
    }
} else {
    $program->addProgram(
        	$post->category,
        	$post->txt_title,
        	$post->description,
        	$post->objectives,
        	$post->modules,
        	$post->module_ctr,
        	$user_data->employee_id
    );
    echo "<strong>".$post->txt_title . "</strong> has been added.";
}
  