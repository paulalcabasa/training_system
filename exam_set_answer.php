<?php
require_once("initialize.php");
require_once("includes/user_access.php");
$program = new Program();
$trainee = new Trainee();
$trainingprogram = new TrainingProgram();
$encryption = new Encryption();
$exam = new Exam();
$tp_id = $encryption->decrypt($get->d);
$trainee_exam_taken_id = $encryption->decrypt($get->t);
$trainee_exam_taken_details = $exam->getTraineeExamTakenDetails($trainee_exam_taken_id);
$exam_id = $trainee_exam_taken_details->exam_id;
$program_details = $trainingprogram->getTrainingProgramDetails($tp_id);
$questions_list = $exam->getExamQuestionsList($exam_id);
$trainee_exam_answers = $exam->getTraineeExamAnswers($trainee_exam_taken_id);
$total_items = count($questions_list);
$trainee_exam_score = $exam->getTraineeExamScore($trainee_exam_taken_id,$questions_list);
$percentage_score = ($trainee_exam_score/$total_items)*100;

$remarks = $exam->getExamRemarks(count($trainee_exam_answers),$total_items,$percentage_score,$trainee_exam_taken_details->passing_score);
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Meta Tags-->
    <meta http-equiv = "Content-Type" content = "text/html; charset=utf-8" />
    <meta name = "Description" content = "Web-Based Centralized Isuzu Philippines Corporation (IPC) Database" />
    <meta name = "Viewport" content = "width = device-width, initial-scale = 1, maximum-scale = 1" />
    <meta name = "Author" content = "John Paul Alcabasa, MIS" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ipc favicon -->
    <link rel="icon" type="image/png" href="<?php echo IPC_FAVICON;?>"/>
    <!-- select 2 css -->
    <link rel="stylesheet" type="text/css" href="<?php echo SELECT2_CSS;?>"/>
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="<?php echo BOOTSTRAP_CSS;?>"/>
    <!-- bootstrap date picker -->
    <link rel="stylesheet" type="text/css" href="<?php echo BS_DATEPICKER_CSS;?>" />
    <!-- font awesome -->
    <link rel="stylesheet" type="text/css" href="<?php echo FONT_AWESOME_CSS;?>" /> 
    <!-- data tables -->
    <link rel="stylesheet" type="text/css" href="<?php echo DATATABLES_CSS;?>" /> 
     <!-- data responsive -->
    <link rel="stylesheet" type="text/css" href="<?php echo DATATABLES_CSS_RESPONSIVE;?>" /> 
    <!-- custom style for IPC TRAINING DB -->
    <link rel="stylesheet" type="text/css" href="<?php echo SYS_TRAINING_STYLE;?>" />
    <!-- awesome checkbox -->
    <link rel="stylesheet" type="text/css" href="<?php echo AWESOME_CHECKBOX_CSS;?>" />
    <!-- title -->
    <title>Training Product Knowledge Entry | Centralized IPC Database</title>
    <style>
        .table {
            table-layout:fixed;
        }
        .table td {
          white-space: wrap;
          overflow: auto;
          text-overflow: ellipsis;
          
        }
        #dialog_info .modal-body {
            max-height: 520px;
            max-width: 900px;
            overflow-y: auto;
        } 
    </style>
</head>
<body>

<!-- navigation top panel included -->
<?php include("includes/menu.php");?>

<div id="container">
    <div class="page-wrapper">
        
        <h1>Training Program Examination - Answer Sheet</h1>
        <hr/>
        
        <div class="row">
            <div class="col-md-4">
               <div class="well">
                    <fieldset>
                        <legend style="font-size:12pt;">Training program details</legend>
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
                    </fieldset>
                </div>
                <div class="well">
                    <fieldset>
                        <legend style="font-size:12pt;">Examination details</legend>
                        <div class="row">
                            <span class="col-xs-4 text-bold">Module</span>
                            <span class="col-xs-8"><?php echo $trainee_exam_taken_details->module_name; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-xs-4 text-bold">Exam</span>
                            <span class="col-xs-8"><?php echo $trainee_exam_taken_details->exam; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-xs-4 text-bold">Passing score</span>
                            <span class="col-xs-8" ><span id="lbl_exam_passing_score"><?php echo $trainee_exam_taken_details->passing_score; ?></span>%</span>
                        </div>
                        <div class="row">
                            <span class="col-xs-4 text-bold">Total Items</span>
                            <span class="col-xs-8" id="lbl_exam_total_items"><?php echo $total_items; ?></span>
                        </div>
                    </fieldset>
                </div>
                <div class="well">
                    <fieldset>
                        <legend style="font-size:12pt;">Examinee details</legend>
                        <div class="row">
                            <span class="col-xs-4 text-bold">Name</span>
                            <span class="col-xs-8"><?php echo $trainee_exam_taken_details->trainee_name; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-xs-4 text-bold">Dealer</span>
                            <span class="col-xs-8"><?php echo $trainee_exam_taken_details->dealer_name; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-xs-4 text-bold">Score</span>
                            <span class="col-xs-8" id="lbl_score"><?php echo $trainee_exam_score . "/" . $total_items; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-xs-4 text-bold">Percentage</span>
                            <span class="col-xs-8" id="lbl_score_percentage"><?php echo Format::to_decimal($percentage_score);?>%</span>
                        </div>
                        <div class="row">
                            <span class="col-xs-4 text-bold">Remarks</span>
                            <span class="col-xs-8" id="lbl_remarks"><?php echo $remarks; ?></span>
                        </div>
                    </fieldset>
                </div>
            </div>

            <div class="col-md-8">
                <div class="panel panel-primary">  <!-- start of panel -->
                    <div class="panel-heading text-center">Answer sheet</div> <!-- start of panel heading -->
                        <div class="panel-body"> <!-- start of panel body -->
                            <div class="exam_wrapper" style="width:100%;">
                            <?php
                                $question_no = 1;
                                $radio_ctr = 1;
                                foreach($questions_list as $question){
                                    $question = (object)$question;
                                    $choice_list = $exam->getQuestionChoicesList($question->item_id);
                                    $trainee_answer = $exam->getTraineeAnswerByItem($trainee_exam_taken_id,$question->item_id);
                            ?>
                                    <div class='exam_item'>
                                        <p class='exam_question'><?php echo $question_no . ". " . $question->question; ?></p>
                                        <ol type='a' style='list-style-type:none;'>
                                <?php
                                    foreach($choice_list as $choice){
                                        $choice = (object)$choice;
                                        $isCorrectAns = $question->choice_id == $choice->choice_id ? "correct_answer_flag" : "";
                                        $isTraineeAns = $trainee_answer == $choice->choice_id ? "checked" : "";
                                ?>
                                            <li>
                                                <div class='radio'>
                                                    <input name='<?php echo 'exam_choice' . $question_no; ?>' 
                                                           data-item_id='<?php echo $question->item_id; ?>' 
                                                           class='rdo_answer' 
                                                           value='<?php echo $choice->choice_id; ?>' 
                                                           type='radio'
                                                           id='<?php echo 'rdo_choice'.$radio_ctr;?>' 
                                                           <?php echo $isTraineeAns; ?>
                                                        >
                                                    <label for='<?php echo 'rdo_choice'.$radio_ctr;?>' class='<?php echo $isCorrectAns;?>'><?php echo $choice->choice;?></label>
                                                </div>
                                            </li>
                                <?php
                                        $radio_ctr++; 
                                    }
                                ?>
                                        </ol>  
                                    </div>
                            <?php
                                    $question_no++;
                                }
                            ?>
                            </div>
                        </div>
                   
                </div> <!-- end of panel -->
            </div>
            <div class="clearfix"></div> 
        </div> 
    </div> <!-- end of page content wrapper -->
</div> <!-- end of wrapper -->

<?php include('panels/information_dialog.php');?>

<!-- page variables -->
<input type="hidden" id="txt_trainee_exam_taken_id" value="<?php echo $trainee_exam_taken_id;?>"/>
<input type="hidden" id="txt_exam_id" value="<?php echo $exam_id;?>"/>
<!-- Latest jquery -->
<script src="<?php echo JQUERY;?>"></script>
<!-- moment.js -->
<script src="<?php echo MOMENT_JS;?>"></script>
<!-- bootstrap jquery -->
<script src="<?php echo BOOTSTRAP_JS;?>"></script>
<!-- datepicker.js -->
<script src="<?php echo BS_DATEPICKER_JS?>"></script>
<!-- select 2 js -->
<script src="<?php echo SELECT2_JS;?>"></script>
<!-- data tables js -->
<script src="<?php echo DATATABLES_JS;?>"></script>
  <!-- data tables responsive -->
<script src="<?php echo DATATABLES_JS_RESPONSIVE;?>"></script>
<!-- common functions -->
<script src="<?php echo COMMON_FUNCTIONS;?>"></script>

<script>
    $(document).ready(function(){
        var passing_score = $("#lbl_exam_passing_score").text();
        var total_items = $("#lbl_exam_total_items").text();
        var trainee_exam_taken_id = $("#txt_trainee_exam_taken_id").val();
        var exam_id = $("#txt_exam_id").val();
        $("body").on("click",".rdo_answer",function(){
            var choice_id = $(this).val();
            var item_id = $(this).data("item_id");
           // $("#lbl_score,#lbl_remarks").html("<img src='../../../img/ajax-loader.gif'/>");
            $.ajax({
                type:"POST",
                data:{
                    trainee_exam_taken_id : trainee_exam_taken_id,
                    item_id               : item_id,
                    choice_id             : choice_id,
                    exam_id               : exam_id
                },
                url:"ajax/exam_set_trainee_answer.php",
                success:function(response){
                    var data = JSON.parse(response);
                    var percentage = (data.score/total_items)*100;
                    $("#lbl_score").text(data.score + "/" + total_items);
                    $("#lbl_score_percentage").text(percentage.toFixed(2)+"%");
                    if(data.total_answers == total_items){
                        if(percentage >= passing_score){
                            $("#lbl_remarks").html("<span class='label label-success'>Passed</span>"); 
                        }
                        else {
                            $("#lbl_remarks").html("<span class='label label-danger'>Failed</span>");
                        }
                    }
                    else {
                        $("#lbl_remarks").html("<span class='label label-warning'>Incomplete answer</span>");
                    }
                }
            });
        });

        /*$("body").on("click",".view_unanswered",function(){
            var content = $(this).data("content");
            $("#dialog_info_title").html("Unanswered Questions");
            $("#dialog_info_content").html(content);
            $("#dialog_info").modal("show");
        });*/
    });
</script>

</body>
</html>