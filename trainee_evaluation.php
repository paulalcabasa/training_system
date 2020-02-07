<?php
	require_once("initialize.php");
    include("includes/header_files.php");
    $encryption = new Encryption();
    $trainee = new Trainee();
    $trainingprogram = new TrainingProgram();
    $exam = new Exam();
    $evaluation = new Evaluation();
    $tp_id = $encryption->decrypt($get->tp_id);
    $participant_id = $encryption->decrypt($get->t);
    $participant_data = $trainingprogram->getTraineeParticipantDetails($tp_id,$participant_id);
    $trainee_details = $trainee->getTraineeDetails($participant_data->trainee_id);
    $program_details = $trainingprogram->getTrainingProgramDetails($tp_id);
    $tp_modules_list = $trainingprogram->getTrainingProgramModule($tp_id);
    $modules_list = $trainingprogram->getTrainingProgramModule($tp_id);
    $competency_list = $evaluation->getCompetencyList(); 
    $ratings_list = $evaluation->getRatingsList();
    $evaluation_details_all = $evaluation->getParticipantEvaluationDetailsAll($participant_id,$tp_id);
?>
<div id="container">	
	<div class="page-wrapper">
		<h1>Participant's Grade Breakdown and Trainers Assessment</h1>
		<br/>
        <div class="row">
            <div class="col-md-5">
                 <div class="box box-default">
                    <div class="box-header">
                        <i class="fa fa-file-text"></i>
                        <h3 class="box-title">Training Program Details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <span class="col-md-3 text-bold"><abbr title="Training Program">TP</abbr> No. : </span>
                            <span class="col-md-9"><?php echo $program_details->tp_id; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-md-3 text-bold">Program Title : </span>
                            <span class="col-md-9"><?php echo $program_details->title; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-md-3 text-bold">Trainor : </span>
                            <span class="col-md-9"><?php echo $program_details->trainor_name; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-md-3 text-bold">Venue : </span>
                            <span class="col-md-9"><?php echo $program_details->venue; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-md-3 text-bold">Start date : </span>
                            <span class="col-md-9"><?php echo Format::format_date2($program_details->start_date); ?></span>
                        </div>
                         <div class="row">
                            <span class="col-md-3 text-bold">End date : </span>
                            <span class="col-md-9"><?php echo Format::format_date2($program_details->end_date); ?></span>
                        </div>
                    </div>
                    <!-- <div class="box-footer"></div> -->
                </div>
            </div>
            <div class="col-md-5">
                <div class="box box-default">
                    <div class="box-header">
                        <i class="glyphicon glyphicon-user"></i>
                        <h3 class="box-title">Participant Details</h3>
                    </div>
                    <div class="box-body">  
                        <div class="row">
                            <span class="col-md-3 text-bold">Trainee ID : </span>
                            <span class="col-md-9"><?php echo $trainee_details->trainee_id; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-md-3 text-bold">Name : </span>
                            <span class="col-md-9"><?php echo $trainee_details->trainee_name; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-md-3 text-bold">Dealer : </span>
                            <span class="col-md-9"><?php echo $trainee_details->dealer_name; ?></span>
                        </div>
                         <div class="row">
                            <span class="col-md-3 text-bold">Job Description : </span>
                            <span class="col-md-9"><?php echo $trainee_details->job_description; ?></span>
                        </div>
                    </div>
                    <!-- <div class="box-footer"></div> -->
                </div>
            </div>
             <div class="col-md-2">
                <div class="box box-default">
                    <div class="box-header">
                        <i class="glyphicon glyphicon-user"></i>
                        <h3 class="box-title">Final Standing</h3>
                    </div>
                    <div class="box-body text-center" id="lbl_final_standing">  
                        
                    </div>
                   <div class="box-footer">
                        <div class="radio radio-danger" style="margin-top:0;margin-bottom:0;">
                            <input type="radio" class="rdo_final_standing" name="rdo_final_standing" value="passed"/>
                            <label class="lbl_rdo_final_standing">Passed</label>
                        </div>
                        <div class="radio radio-danger" style="margin-top:0;margin-bottom:0;">
                            <input type="radio" class="rdo_final_standing" name="rdo_final_standing" value="failed"/>
                            <label class="lbl_rdo_final_standing">Failed</label>
                        </div>
                          <div class="radio radio-danger" style="margin-top:0;margin-bottom:0;">
                            <input type="radio" class="rdo_final_standing" name="rdo_final_standing" value="conditional pass"/>
                            <label class="lbl_rdo_final_standing">Conditional Pass</label>
                        </div>
                   </div>
                </div>

            </div>
        </div>

        <div class="row">
             <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right" role="tablist">
                    <?php
                        $ctr = 1;
                        $module_count = count($modules_list);
                        $current_module = 0;
                        foreach($modules_list as $module){
                            $module = (object)$module; 
                            $current_module = $module->id;

                    ?>
                        <li role="presentation" class="<?php echo ($ctr == $module_count ? 'active' : ''); ?> tab_link_module" data-module_id="<?php echo $module->id;?>">
                            <a href="#main_exam_details_tab" aria-controls="tab<?php echo $module->id;?>" role="tab" data-toggle="tab">
                                <?php echo $module->module_name; ?>
                            </a>
                        </li>
                    <?php
                            $ctr++;
                        }
                    ?>
                        <li class="pull-left header"><i class="fa fa-th"></i> Examination Results Summary</li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="main_exam_details_tab">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
        if(!empty($tp_modules_list)){
            $ctr = 1;
            foreach($tp_modules_list as $module){
                $module = (object)$module;
                $tpm_grading_criteria_list = $trainingprogram->getTPMCriteriaList($module->id);
                if($ctr == 1){
                    echo '<div class="row">';
                }
        ?>
            <div class="col-md-4">
                <div class="box box-default" style="min-height:300px;">
                    <div class="box-header">
                        <i class="fa fa-file-text"></i>
                        <h3 class="box-title"><?php echo $module->module_name;?></h3>
                    </div>
                    <div class="box-body">           
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Criteria</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $total = 0;
                                if(!empty($tpm_grading_criteria_list)){
                                    foreach($tpm_grading_criteria_list as $criteria){
                                        $criteria = (object)$criteria;
                                        $tpa_tpm_grade_details = $evaluation->getGradeByParticipant($criteria->id,$participant_id);
                                        
                            ?>
                                    <tr>
                                        <td><?php echo $criteria->criteria_name;?></td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control txt_tpa_tpm_grade" 
                                                    data-tpa_tpm_grade_id="<?php echo $tpa_tpm_grade_details->id;?>" 
                                                    placeholder="<?php echo $criteria->criteria_name; ?>" 
                                                    value="<?php echo $tpa_tpm_grade_details->grade;?>"/>
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                    $total += $tpa_tpm_grade_details->grade;
                                    }
                                }
                                else {
                            ?>
                                    <tr>
                                        <td colspan="3">No criteria available</td>
                                    </tr>
                            <?php
                                }
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th colspan="2"><?php echo $total;?>%</th>
                                </tr>
                                <tr>
                                    <th>Passing Score</th>
                                    <th colspan="2" data-passing_score="<?php echo $module->passing_score;?>"><?php echo $module->passing_score;?>%</th>
                                </tr>
                                <tr>
                                    <th>Remarks</th>
                                    <th colspan="2"><?php echo $total >= $module->passing_score ? 
                                                        "<span class='label label-success'>Passed</span>" : 
                                                        "<span class='label label-danger'>Failed</span>";
                                                    ?>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        <?php
                if($ctr == 3){
                    echo "</div>";
                    $ctr = 1;
                }
                $ctr++;
            }
        }
        else {
        ?>
            <div class="row">
                <div class="col-md-12">
                    <p class="alert alert-danger">No modules available.</p>
                </div>
            </div>
            <div class="clearfix"></div>
        <?php } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary" style="min-height:300px;">
                    <div class="box-header">
                        <i class="glyphicon glyphicon-user"></i>
                        <h3 class="box-title">Trainee Evaluation Form</h3>
                    </div>
                    <div class="box-body">  
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%;">No.</th>
                                    <th class="text-center">Competency</th>
                                    <th class="text-center" colspan="<?php echo count($ratings_list);?>">Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $competency_ctr = 1;
                                foreach($competency_list as $competency){
                                    $competency = (object)$competency;
                            ?>
                                <tr >
                                    <td><?php echo $competency_ctr;?></td>
                                    <td data-id="<?php echo $competency->id;?>"><?php echo $competency->competency;?></td>
                            <?php
                                    foreach($ratings_list as $rating){
                                        $rating = (object)$rating;
                                        $competency_id = $competency->id;
                                        $rating_id = $rating->id;
                                        $is_checked = "";
                                        foreach($evaluation_details_all as $ev){
                                            $ev = (object)$ev;
                                            if($ev->competency_id == $competency_id && $ev->rating_id == $rating_id){
                                                $is_checked = "checked";
                                                break;
                                            }
                                        }
                            ?>
                                    <td>
                                        <div class="checkbox checkbox-danger" style="margin-top:0;margin-bottom:0;">
                                            <input type="radio" 
                                                class="styled styled-danger rdo_evaluation_competency_rating" 
                                                name="rdoGroup<?php echo $competency_ctr;?>" 
                                                value="<?php echo $rating->id;?>"
                                                data-competency_id="<?php echo $competency->id;?>"
                                                <?php echo $is_checked; ?>/>
                                            <label class="lbl_ratings"><?php echo $rating->rating;?></label>
                                        </div>
                                    </td>
                            <?php
                                    }
                            ?>
                                </tr>
                            <?php
                                    $competency_ctr++;
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
	</div> <!-- end of page content wrapper -->
</div> <!-- end of wrapper -->
<br/>
<input type="hidden" value="<?php echo $participant_id;?>" id="txt_participant_id"/>
<input type="hidden" value="<?php echo $current_module;?>" id="txt_current_module_id"/>
<input type="hidden" value="<?php echo $tp_id;?>" id="txt_tp_id"/>
<?php 
    include("panels/information_dialog.php"); 
    include("panels/confirm_dialog.php"); 
    include("includes/footer.php");
    include("includes/js_files.php");
?>
<script>
function loadExamDetails(module_id,participant_id){
    $("#main_exam_details_tab").html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw margin-bottom"></i><span class="sr-only">Loading...</span>');
    $.ajax({
        type:"POST",
        data:{
            module_id : module_id,
            participant_id : participant_id
        },
        url:"ajax/get_trainee_evaluation_exam_details.php",
        success:function(response){
            $("#main_exam_details_tab").html(response);
        }
    });
}
$(document).ready(function(){
    var participant_id = $("#txt_participant_id").val();
    var current_module_id = $("#txt_current_module_id").val();
    var tp_id = $("#txt_tp_id").val();

    loadExamDetails(current_module_id,participant_id);
    $(".tab_link_module").click(function(){
        var module_id = $(this).data("module_id");
        loadExamDetails(module_id,participant_id)
    });

    $(".lbl_ratings").click(function(){    
        var rating_id = $(this).prev().val();
        var competency_id = $(this).prev().data("competency_id");
        
        if($(this).prev().is(":checked")){
            $(this).prev().prop("checked",false);
        }
        else{
            $(this).prev().prop("checked",true);
        }

        $.ajax({
            type:"POST",
            data:{
                rating_id : rating_id,
                competency_id : competency_id,
                participant_id : participant_id,
                tp_id : tp_id
            },
            url:"ajax/add_update_trainee_evaluation.php",
            success:function(response){
             
            }
        });
  
    });

    $(".txt_tpa_tpm_grade").on("input",function(){
        var tpa_tpm_grade_id = $(this).data("tpa_tpm_grade_id");
        var grade = $(this).val();
        var elem = $(this);
        var tbl_elements = elem.parent().parent().parent().parent().parent();
        var grades = tbl_elements.children(".txt_tpa_tpm_grade");
        var total = 0;
        $.ajax({
            type:"POST",
            data:{
                tpa_tpm_grade_id : tpa_tpm_grade_id,
                grade            : grade
            },
            url:"ajax/update_participant_grade.php",
            success:function(response){
                var passing_score = tbl_elements.parent().children().find("tfoot tr:nth-child(2) th:nth-child(2)").data("passing_score");
                tbl_elements.children().find("input").each(function(){
                    total += parseInt($(this).val());
                });
                tbl_elements.parent().children().find("tfoot tr:nth-child(1) th:nth-child(2)").text(total + "%");
                if(total >= passing_score){
                    tbl_elements.parent().children().find("tfoot tr:nth-child(3) th:nth-child(2)").html("<span class='label label-success'>Passed</span>");                             
                }
                else {
                       tbl_elements.parent().children().find("tfoot tr:nth-child(3) th:nth-child(2)").html("<span class='label label-danger'>Failed</span>");
                }
            }
        });
    });

   $(".rdo_final_standing").change(function(){
       if($(this).val() == 'passed'){
            $("#lbl_final_standing").html('<h3 class="label label-success" style="font-size:12pt;" >PASSED</h3>');
       }
       else if($(this).val() == 'failed'){
           $("#lbl_final_standing").html('<h3 class="label label-danger" style="font-size:12pt;" >FAILED</h3>');
       }
       else if($(this).val() == 'conditional pass'){
           $("#lbl_final_standing").html('<h3 class="label label-warning" style="font-size:12pt;" >CONDITIONAL PASS</h3>');
       }
       var final_standing = $(this).val();
      /*   $.ajax({
            type:"POST",
            data:{
                attendee_id : $("#txt_participant_id").val(),
                final_standing     : final_standing
            },
            url:"ajax/update_final_standing.php",
            success:function(response){
               alert(response);
            }
        }); */
   });


});
</script>
</body>
</html>