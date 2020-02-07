<?php


require_once("../initialize.php");
 if(isset($_FILES['files'])){
    $desired_dir="../file_storage";
    //$extensions = array("pdf");
    $msg = "";
     
    // check for errors in the file
    foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
        $file_name = $_FILES['files']['name'][$key];
        $file_size =$_FILES['files']['size'][$key];
        $file_tmp =$_FILES['files']['tmp_name'][$key];
        $file_type=$_FILES['files']['type'][$key];  
        if($file_size > 750000000){
            $msg .= '<li><strong>'.$file_name.'</strong> is too large.</li>';
        }   

        $file_ext = explode(".",$file_name);
        $file_ext = end($file_ext);
        $new_file_name = "file_" . time() . $key . ".". $file_ext;

        /*if(!in_array($file_ext,$extensions)){
          $msg .=  '<li><strong>' . $file_name . '</strong> is not an accepted file format.</li>';
        }*/
    }
     
    if($msg == ""){
        foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
            $file_name = $_FILES['files']['name'][$key];
            $file_size =$_FILES['files']['size'][$key];
            $file_tmp =$_FILES['files']['tmp_name'][$key];
            $file_type=$_FILES['files']['type'][$key];  

            $file_ext = explode(".",$file_name);
            $file_ext = end($file_ext);
            $new_file_name = "file_" . time() . $key . ".". $file_ext;

            if(move_uploaded_file($file_tmp,$desired_dir . "/".$new_file_name)){ 
                $program->addMaterial($_POST['program_code'],$file_name,$new_file_name,$_SESSION['user_data']['employee_id']);
                $msg .= "<li><strong>" .$file_name. "</strong> was successfully uploaded.</li>";
            }
            else {
                $msg .= "<li>Failed uploading <strong>" . $file_name . "</strong>.";
            }
        }
      
    } else {
        $msg .= "<span>Failed uploading files due to the following errors : </span><ul>" . $msg . "</ul>";
      
    }
     
    echo $msg;
        
}
  
?>