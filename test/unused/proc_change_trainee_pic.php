<?php
	
	include("../initialize.php");
	require_once("../../../../libs/class.upload/src/class.upload.php");

	$trainee_pic = new upload($_FILES['txt_pic']);
	if($trainee_pic->uploaded){
		$trainee_pic->file_new_name_body = 'trn_' . date("YmdHis");
		$trainee_pic->image_resize 		 = true;
		$trainee_pic->image_y 			 = 512;
		$trainee_pic->image_x 		     = 512;
		$trainee_pic->process("../trainee_pics/");
		if($trainee_pic->processed){
			$trainee_pic->clean();
		} else {
			echo "Error: " . $trainee_pic->error;
		}
	}

	$trainee->updateTraineePic($_POST['trainee_code'],$_POST['old_pic'],$trainee_pic->file_dst_name);
	echo "Successfully changed trainee's picture.";
?>