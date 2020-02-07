<?php
require_once("initialize.php");
$program = new Program();
$encryption = new Encryption();
$exam = new Exam();
$trainingprogram = new TrainingProgram();
$tp_id = $encryption->decrypt($get->d);
$exam_id = $encryption->decrypt($get->e);
$program_details = $trainingprogram->getTrainingProgramDetails($tp_id);
$questions_list = $exam->getExamQuestionsList($exam_id);
$total_items = count($questions_list);
$exam_details = $exam->getExamDetails($exam_id);
$examinees_list = $exam->getExamineesByExam($exam_id);
$total_examinees = count($examinees_list);
$examinees_list_detailed = $exam->getExamineesListByExamDetails($exam_id);

$passed_ctr = 0;
$failed_ctr = 0;
$completed_ctr = 0;
$incomplete_ctr = 0;
$passing_rate = 0;

foreach($examinees_list_detailed as $examinee){
	$examinee = (object)$examinee;
	$percentage_score = ($examinee->score / $total_items) * 100;
	$trainee_exam_answers_count = count($exam->getTraineeExamAnswers($examinee->id));
	if($trainee_exam_answers_count == $total_items){
		if($percentage_score >= $exam_details->passing_score){
			$passed_ctr++;
		}
		else {
			$failed_ctr++;
		}
		$completed_ctr++;
	}
	else {
		$incomplete_ctr++;
	}
}

if($completed_ctr != 0){
  $passing_rate = ($passed_ctr / $completed_ctr) * 100;
}
require_once("includes/header_files.php");
?>
<div id="container">
	<div class="page-wrapper">
		<h1>Training Program Examinations</h1>
		<br/>
		<div class="row">
			<div class="col-md-4">
				<div class="box box-default">
            <div class="box-header">
              <h3 class="box-title">Training program details</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <span class="col-xs-4 text-bold">Program Title</span>
                    <span class="col-xs-8"><?php echo $program_details->title; ?></span>
                </div>
                <div class="row">
                    <span class="col-xs-4 text-bold">Trainor</span>
                    <span class="col-xs-8"><?php echo $program_details->trainor_name; ?></span>
                </div>
                <div class="row">
                    <span class="col-xs-4 text-bold">Venue</span>
                    <span class="col-xs-8"><?php echo $program_details->venue; ?></span>
                </div>
                <div class="row">
                    <span class="col-xs-4 text-bold">Start date</span>
                    <span class="col-xs-8"><?php echo Format::format_date($program_details->start_date); ?></span>
                </div>
                <div class="row">
                    <span class="col-xs-4 text-bold">End date</span>
                    <span class="col-xs-8"><?php echo Format::format_date($program_details->end_date); ?></span>
                </div>
            </div>
        </div>
        <div class="box box-default">
            <div class="box-header">
              <h3 class="box-title">Examination details</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <span class="col-xs-4 text-bold">Module</span>
                    <span class="col-xs-8"><?php echo $exam_details->module_name; ?></span>
                </div>
                <div class="row">
                    <span class="col-xs-4 text-bold">Exam</span>
                    <span class="col-xs-8"><?php echo $exam_details->exam; ?></span>
                </div>
                <div class="row">
                    <span class="col-xs-4 text-bold">Passing score</span>
                    <span class="col-xs-8" ><span id="lbl_exam_passing_score"><?php echo $exam_details->passing_score; ?></span>%</span>
                </div>
                <div class="row">
                    <span class="col-xs-4 text-bold">Total Items</span>
                    <span class="col-xs-8" id="lbl_exam_total_items"><?php echo $total_items; ?></span>
                </div>
            </div>
        </div>
        <div class="box box-default">
          <div class="box-header">
              <h3 class="box-title">Summary of Results</h3>
          </div>
          <div class="box-body">
              <div class="row">
                  <span class="col-xs-4 text-bold">Examinees</span>
                  <span class="col-xs-8"><?php echo $total_examinees; ?></span>
              </div>
               <div class="row">
                  <span class="col-xs-4 text-bold">Completed</span>
                  <span class="col-xs-8"><?php echo $completed_ctr; ?></span>
              </div>
               <div class="row">
                  <span class="col-xs-4 text-bold">Incomplete</span>
                  <span class="col-xs-8"><?php echo $incomplete_ctr; ?></span>
              </div>
              <div class="row">
                  <span class="col-xs-4 text-bold">Passed</span>
                  <span class="col-xs-8"><?php echo $passed_ctr; ?></span>
              </div>
              <div class="row">
                  <span class="col-xs-4 text-bold">Failed</span>
                  <span class="col-xs-8"><?php echo $failed_ctr; ?></span>
              </div>
               <div class="row">
                  <span class="col-xs-4 text-bold">Passing Rate</span>
                  <span class="col-xs-8"><?php echo Format::to_decimal($passing_rate); ?>%</span>
              </div>
          </div>
      </div>
      <div class="box box-default"> 
        <div class="box-header">
          <h3 class="box-title">List of Examinees</h3>
        </div>
          <div class="box-body">
              <legend style="font-size:12pt;">List of Examinees</legend>
        		<table class="table">
        			<thead>
        				<tr>
        					<th>Exam No</th>
        					<th>Trainee ID</th>
        					<th>Name</th>
        				</tr>
        			</thead>
        			<tbody>
					<?php
						foreach($examinees_list as $examinee){
							$examinee = (object)$examinee;
					?>
						<tr>
							<td><?php echo $examinee->exam_no;?></td>
							<td><?php echo $examinee->trainee_id;?></td>
							<td><?php echo $examinee->trainee_name;?></td>
						</tr>
					<?php
						}
					?>
        			</tbody>
        		</table>
          </div>
      </div>
			</div>
			
			<div class="col-md-8">
				<div class="box box-danger">  <!-- start of panel -->
          <div class="box-header">
              <h3 class="box-title">Item Analysis</h3>
          </div>
				
					<div class="box-body"> <!-- start of panel body -->
						<!-- <div class="exam_wrapper" style="width:100%;">
							<?php //echo $program->getItemAnalysis($dec_exam_id,$dec_tp_id,$total_examinees);?>

						</div> -->
						<div class="exam_wrapper" style="width:100%;">
            <?php
                $question_no = 1;
                foreach($questions_list as $question){
                    $question = (object)$question;
                    $choice_list = $exam->getQuestionChoicesList($question->item_id);
                    $correct_ctr = 0;
                	$incorrect_ctr = 0;
                	$correct_list_html = "";
                	$incorrect_list_html = "";
            ?>
                    <div class='exam_item'>
                        <p class='exam_question'><?php echo $question_no . ". " . $question->question; ?></p>
                        <ol type='a'>
                <?php
                    foreach($choice_list as $choice){
                        $choice = (object)$choice;
                        $isCorrectAns = $question->choice_id == $choice->choice_id ? "correct_answer_flag" : "";
                        $trainee_answered_list = $exam->getTraineeWhoAnsweredPerItem($question->item_id,$choice->choice_id);
                		$trainee_list_html = "";
                		$ctr_trainee_answered = count($trainee_answered_list);
                		foreach($trainee_answered_list as $trainee_list){
                			$trainee_list = (object)$trainee_list;
                			$trainee_list_html .= "<li>" . $trainee_list->trainee_name . "</li>";
                		}
                		if($question->choice_id == $choice->choice_id){ // if answer is correct
                			$correct_list_html .= $trainee_list_html;
                			$correct_ctr += $ctr_trainee_answered;
                		}
                		else { // if answer is incorrect
                			$incorrect_list_html .= $trainee_list_html;
                			$incorrect_ctr += $ctr_trainee_answered;
                		}
                ?>
                            <li class="choice_data" data-content='<?php echo "<ol>".$trainee_list_html."</ol>"; ?>' data-choice='<?php echo $choice->choice;?>'>
   								<span  class='<?php echo $isCorrectAns;?>'>
   									<?php echo $choice->choice . " - " . $ctr_trainee_answered;?>
   								</span>
                            </li>
                <?php
                      
                    }
                ?>
                        </ol>  
                       	<span class='label label-success flag_data' 
                       		  data-action='correct' 
                       		  data-title='Correct Examinee/s for Question Number <?php echo $question_no;?>' 
                       		  data-q='<?php echo $question->question;?>' 
                       		  data-content='<ol><?php echo $correct_list_html; ?></ol>'>Correct : <?php echo $correct_ctr;?></span>
                        <br/>
						<span class='label label-danger flag_data' 
							  data-action='incorrect' 
							  data-title='Incorrect Examinee/s for Question Number <?php echo $question_no;?>' 
							  data-q='<?php echo $question->question; ?>' 
							  data-content='<ol><?php echo $incorrect_list_html; ?></ol>'>Incorrect : <?php echo $incorrect_ctr;?></span>
 
                    </div>
                    <br/>
            <?php
                    $question_no++;
                }
            ?>
              </div>
					</div> <!-- end of panel body -->
					<div class="box-footer">
						<a href="print_item_analysis.php?d=<?php echo $get->e;?>" target="_blank" class="btn btn-primary pull-right">Print</a>
					</div>
				</div> <!-- end of panel -->
			</div>
			<div class="clearfix"></div>
		</div>
			
		
		

	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->




<?php 
	include("panels/confirm_dialog.php");
	include("panels/information_dialog.php");
 	include("includes/footer.php");
 	include("includes/js_files.php");
 ?>


<script>

$(document).ready(function(){

	$("body").on("click",".view_examinees_list",function(){
		var content = $(this).data("content");
		$("#dialog_info_title").html("List of Examinees");
		$("#dialog_info_content").html(content);
		$("#dialog_info").modal("show");
	});

	$("body").on("click",".choice_data",function(){
		$("#dialog_info_content").html("Please wait...");
		var content = $(this).data("content");
		var choice = $(this).data("choice");
		if(content == "<ol></ol>"){
			content = "Nobody answered <strong>" + choice + "</strong>.";
		}
		$("#dialog_info_title").html(choice);
		$("#dialog_info_content").html(content);
		$("#dialog_info").modal("show");
	});

	$("body").on("click",".flag_data",function(){
		var content = $(this).data("content");
		var title = $(this).data("title");
		var action = $(this).data("action");
	
		if(action == "correct" && content == "<ol></ol>"){
			content = "No one got the correct answer.";
		}
		else if(action == "incorrect" && content == "<ol></ol>"){
			content = "No one is wrong.";
		}
		$("#dialog_info_title").html(title);
		$("#dialog_info_content").html(content);
		$("#dialog_info").modal("show")
	});


});

</script>

</body>
</html>