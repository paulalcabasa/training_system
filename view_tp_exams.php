<?php
	require_once("initialize.php");
    $program = new Program();
    $trainingprogram = new TrainingProgram();
    $encryption = new Encryption();
    $exam = new Exam();
    $dec_tp_id = $encryption->decrypt($get->d);
    $program_details = $trainingprogram->getTrainingProgramDetails($dec_tp_id);
    $module_list = $trainingprogram->getTrainingProgramModule($dec_tp_id);
    require_once("includes/header_files.php");
?>
<div id="container">
	<div class="page-wrapper">
		<h1>Training Program Examinations</h1>
		<br/>
        <div class="row"> <!--  start of row -->
            <div class="col-md-4"> <!-- start of left side -->
                <div class="box box-default">
                    <div class="box-header">
                        <i class="fa fa-file-text"></i>
                        <h3 class="box-title">Training Program Details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <p class="col-md-12">
                                <span class="text-bold">Training Program ID</span><br/>
                                <span><?php echo $program_details->tp_id;?></span>
                            </p>
                            <p class="col-md-12">
                                <span class="text-bold">Program Title</span><br/>
                                <span><?php echo $program_details->title;?></span>
                            </p>
                            <p class="col-md-12">
                                <span class="text-bold">Trainor</span><br/>
                                <span><?php echo $program_details->trainor_name;?></span>
                            </p>
                            <p class="col-md-12">
                                <span class="text-bold">Venue</span><br/>
                                <span><?php echo $program_details->venue;?></span>
                            </p>
                            <p class="col-md-12">
                                <span class="text-bold">Date</span><br/>
                                <span><?php echo "From " . Format::format_readable_date_only($program_details->start_date) . " to " . Format::format_readable_date_only($program_details->end_date);?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div> <!-- end of left side -->
            <div class="col-md-8"> <!-- start of right side -->
                <div class="box box-danger">  <!-- start of panel -->
                    <div class="box-header">
                        <i class="fa fa-file-text"></i>
                        <h3 class="box-title">Training Program Examinations</h3>
                    </div>
                    <div class="box-body"> <!-- start of panel body -->
                        <table class="display responsive nowrap text-center table table-bordered table-striped" id="tbl_data" width="100%">
                            <thead>
                                <tr>
                                    <th>Exam</th>
                                    <th>Module</th>
                                    <th>Passing Score</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php
                            $exams_list = $exam->getExams($dec_tp_id);
                            foreach($exams_list as $e){
                                $e = (object)$e;
                                $enc_exam_id = $encryption->encrypt($e->exam_id);
                                $enc_tp_id = $encryption->encrypt($e->tp_id);
                        ?>
                                <tr>
                                    <td><?php echo $e->exam; ?></td>
                                    <td><?php echo $e->module_name; ?></td>
                                    <td><?php echo $e->passing_score; ?>%</td>
                                    <td>
                                        <div class='btn-group'>
                                            <button type='button' class='btn btn-info btn-xs dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                            Action <span class='caret'></span>
                                            </button>
                                            <ul class='dropdown-menu dropdown-menu-right'>
                                                <li><a href='<?php echo "item_analysis.php?d=".$enc_tp_id."&"."e=".$enc_exam_id; ?>'><i class="fa fa-line-chart"></i> Item Analysis</a></li>
                                                <li><a href='<?php echo "exp_exam_word.php?d=$enc_exam_id"; ?>'><i class="fa fa-file-word-o"></i> Export Questionnaire as Word (.docx)</a></li>
                                                <li><a href='<?php echo "print_answer_key.php?d=$enc_exam_id";?>'><i class="fa fa-key"></i> Print Answer Key</a></li>
                                                <li><a href='<?php echo "view_examinees.php?d=$enc_exam_id&tp_id=$enc_tp_id";?>'><i class="glyphicon glyphicon-user"></i> Examinees</a></li>
                                                <li class='divider'></li>
                                                <li><a href='<?php echo "tp_exam_questions.php?d=$enc_tp_id&e=$enc_exam_id"; ?>'><i class='fa fa-file-text-o fa-1x'></i> Questions</a></li>
                                                <li><a href='#' class='btn_edit' data-module_id='<?php echo $e->module_id; ?>' data-passing_score='<?php echo $e->passing_score; ?>' data-exam='<?php echo $e->exam; ?>' data-id='<?php echo $e->exam_id; ?>'><i class='fa fa-edit fa-1x'></i> Edit</a></li>
                                                <li><a href='#' class='btn_delete' data-id='<?php echo $e->exam_id; ?>'><i class='fa fa-trash fa-1x'></i> Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                        <?php 
                            }
                        ?>
                            </tbody>
                        </table>
                    </div> <!-- end of panel body -->
                    <div class="box-footer">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#dialog_add_exam"><i class='fa fa-plus-circle fa-1x'></i> Create Exam</button>
                    </div>
                </div> <!-- end of panel --> 
            </div>
        </div>
	</div> <!-- end of page content wrapper -->
</div> <!-- end of wrapper -->

<!-- dialog for adding an exam -->
<div class="modal fade"  role="dialog" id="dialog_add_exam">
  <div class="modal-dialog">
    <div class="modal-content"><!-- header  -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Examination</h4>
      </div>
      <div class="modal-body">
            <p class="bg-danger" id="notif" style="padding:.5em;display:none;"></p>
            <form>
                <div class="form-group">
                    <label>Module</label>
                    <select class="form-control" id="cbo_module">
                        <option value="">Select Module</option>
                    <?php
                        foreach($module_list as $module){
                            $module = (object)$module;
                    ?>
                        <option value="<?php echo $module->id;?>"><?php echo $module->module_name;?></option>
                    <?php
                        }
                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Exam Label</label>
                    <input type="text" class="form-control" placeholder="Exam" id="txt_exam"/>
                </div>
                <div class="form-group">
                    <label>Passing score</label>
                    <div class="input-group" style="width:25%;">
                        <input type="text" class="form-control" placeholder="Percentage" maxlength="3" id="txt_exam_passing_score" aria-describedby="basic-addon1"/>
                        <span class="input-group-addon" id="basic-addon1">%</span>
                    </div>
                </div>
            </form>
            <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" id="btn_save">Save</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- dialog for adding an exam -->
<div class="modal fade" role="dialog" id="dialog_edit_exam">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Examination</h4>
      </div>
      <div class="modal-body">
            <p class="bg-danger" id="edit_notif" style="padding:.5em;display:none;"></p>
            <form>
                <div class="form-group">
                    <label>Module</label>
                    <select class="form-control input-sm" id="update_cbo_module">
                        <option value="">Select Module</option>
                    <?php
                        foreach($module_list as $module){
                            $module = (object)$module;
                    ?>
                        <option value="<?php echo $module->id;?>"><?php echo $module->module_name;?></option>
                    <?php
                        }
                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Exam Label</label>
                    <input type="text" class="form-control" placeholder="Exam" id="update_txt_exam"/>
                </div>
                <div class="form-group">
                    <label>Passing score</label>
                    <div class="input-group" style="width:20%;">
                        <input type="text" class="form-control input-sm" placeholder="Percentage" maxlength="3" id="update_txt_exam_passing_score" aria-describedby="basic-addon1"/>
                        <span class="input-group-addon" id="basic-addon1">%</span>
                    </div>
                </div>
            </form>
            <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" id="btn_update">Save</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php
    include("panels/confirm_dialog.php");
    include("includes/footer.php"); 
    include("includes/js_files.php");
?>
<!-- GLOBAL VARIABLES -->
<input type="hidden" value="<?php echo $program_details->training_program_id;?>" id="txt_tp_id" />
<input type="hidden" value="<?php echo $program_details->program_id;?>" id="txt_program_id" />

<script>

$(document).ready(function(){
  var tbl_exams_list = $("#tbl_data").DataTable();
  $("#navigation-top").children("li:nth-child(3)").addClass("active");
  var isSubmit = false;
  var exam_id = 0;
  var tp_id = $("#txt_tp_id").val();
  var program_id = $("#txt_program_id").val();
  $("#cbo_module").select2({
    "width":"100%"
  });

  $("#update_cbo_module").select2({
    "width":"100%"
  });
  

  $("#btn_save").click(function(){
        var module_id = $("#cbo_module").val();
        var exam = $("#txt_exam").val();
        var passing_score = $("#txt_exam_passing_score").val();
        if(module_id == ""){
            $("#notif").html("Please select a module.");
            $("#notif").show();
        }
        else if(exam == ""){
            $("#notif").html("Please enter the exam title.");
            $("#notif").show();
        }
        else {
            $("#notif").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
            $("#notif").addClass("bg-primary");
            $("#notif").removeClass("bg-danger");
         
            $.ajax({
                type:"POST",
                url:"ajax/add_exam.php",
                data:{
                    tp_id           : tp_id,
                    program_id      : program_id,
                    module_id       : module_id,
                    exam            : exam,
                    passing_score   : passing_score
                },
                success:function(response){
                    $("#notif").addClass("bg-success");
                    $("#notif").removeClass("bg-primary");
                    $("#notif").removeClass("bg-bg-danger");
                    $("#notif").html(response);
                    $("#notif").show();
                    isSubmit = true;
                }
            });
        }
    });


    $("#dialog_add_exam,#dialog_edit_exam,#dialog_box").on("hidden.bs.modal",function(){
        if(isSubmit){
            location.reload();
        }
    });

    $("body").on("click",".btn_edit",function(){
        var module_id = $(this).data("module_id");
        var exam = $(this).data("exam");
        exam_id = $(this).data("id");

        $("#update_cbo_module").select2("val",module_id);
        $("#update_txt_exam").val(exam);
        $("#update_txt_exam_passing_score").val($(this).data("passing_score"));
        $("#dialog_edit_exam").modal("show");
    });

     $("#btn_update").click(function(){
        var module_id = $("#update_cbo_module").val();
        var exam = $("#update_txt_exam").val();
        var passing_score = $("#update_txt_exam_passing_score").val();
        if(module_id == ""){
            $("#edit_notif").html("Please select a module.");
            $("#edit_notif").show();
        }
        else if(exam == ""){
            $("#edit_notif").html("Please enter the exam title.");
            $("#edit_notif").show();
        }
        else {
            $("#edit_notif").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
            $("#edit_notif").addClass("bg-primary");
            $("#edit_notif").removeClass("bg-danger");
         
            $.ajax({
                type:"POST",
                url:"ajax/update_exam.php",
                data:{
                    exam_id       : exam_id,
                    module_id     : module_id,
                    exam          : exam,
                    passing_score : passing_score
                },
                success:function(response){
                    location.reload();
                    /*$("#edit_notif").addClass("bg-success");
                    $("#edit_notif").removeClass("bg-primary");
                    $("#edit_notif").removeClass("bg-bg-danger");
                    $("#edit_notif").html(response);
                    $("#edit_notif").show();
                    isSubmit = true;*/
                }
            });
        }
    });
    
    $("body").on("click",".btn_delete",function(){
        exam_id = $(this).data("id");
        $("#dialog_content").html("Are you sure? All information associated to this exam will also be deleted.");
        $("#dialog_box").modal("show");
    });

    $("#dialog_btn_confirm").click(function(){
        $("#dialog_content").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
        $("#dialog_btn_confirm").hide();
        $.ajax({
            type:"POST",
            data:{
                exam_id : exam_id
            },
            url:"php_processors/proc_delete_exam.php",
            success:function(response){
                $("#dialog_content").html(response);
                isSubmit = true;
            }
        });
    });

    $("#txt_exam_passing_score").on("input",function(event){
           var e = event || window.event;  
           var key = e.keyCode || e.which; 

           if (key < 48 || key > 57) { 
             if(key == 8 || key == 46){} //allow backspace and delete                                   
             else {
                   if (e.preventDefault) e.preventDefault(); 
                   e.returnValue = false; 
             }
           }
    });
});
</script>

</body>
</html>