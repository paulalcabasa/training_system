<?php
	
	include("../initialize.php");
	$choice = "New choice";
	$choice_id = $program->addQuestionChoices($_POST['item_id'],$choice);
	$output = "";
	$output .= "<li>
		<div class='form-group'>
			<div class='input-group'>
				<input type='text' class='form-control update_choice_txt' value='$choice'/>
				<span class='input-group-btn'>
					<button class='btn btn-primary btn_update_choice' type='button' data-id='$choice_id'><i class='fa fa-save fa-1x'></i></button>
					<button class='btn btn-danger btn_delete_choice' type='button' data-id='$choice_id'><i class='fa fa-trash fa-1x'></i></button>
				</span>
			</div>
		</div> 
	</li>";
	echo $output;
?>