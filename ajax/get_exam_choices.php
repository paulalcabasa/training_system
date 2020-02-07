<?php
include("../initialize.php");
$exam = new Exam();
$choice_list = $exam->getQuestionChoicesList($post->item_id);
	//echo $program->getChoicesUpdate($_POST['item_id']);
foreach($choice_list as $choice){
	$choice = (object)$choice;
?>
	<li>
		<div class='form-group'>
			<div class='input-group'>
				<input type='text' class='form-control update_choice_txt' value='<?php echo $choice->choice;?>'/>
				<span class='input-group-btn'>
					<button class='btn btn-primary btn_update_choice' type='button' data-id='<?php echo $choice->choice_id;?>'><i class='fa fa-save fa-1x'></i></button>
					<button class='btn btn-danger btn_delete_choice' type='button' data-id='<?php echo $choice->choice_id;?>'><i class='fa fa-trash fa-1x'></i></button>
				</span>
			</div>
		</div> 
	</li>
<?php
}
?>