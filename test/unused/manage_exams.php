<?php

    require_once("initialize.php");
    require_once("includes/user_access.php");
    $trainee = new Trainee();
    $conn = new Connection();
    $program = new Program();
  // encrypted variables
  $dec_tp_id = $conn->encryptor("decrypt",$_GET['d']);
  $dec_tc = $conn->encryptor("decrypt",$_GET['tc']);
  $training_program_details = $program->getTrainingProgramDetails($dec_tp_id);
  
  $name_details = $trainee->getTraineeName($dec_tc);
  $name = $conn->transformName1($name_details['first_name'],$name_details['middle_name'],$name_details['last_name'],$name_details['suffix'],$conn);
  $title = $training_program_details['title'];

  require_once("includes/header_files.php");
?>

<div id="container">
    <div class="page-wrapper">
        
        <h1>Training Program Exam</h1>
        <hr/>
      <div class="panel panel-primary">  <!-- start of panel -->
      <div class="panel-heading">
          Exam records of <strong><?php echo $name;?></strong> for <em><?php echo $title; ?></em>
      </div> <!-- start of panel heading -->
        <div class="panel-body"> <!-- start of panel body -->
            
            <div class="alert alert-danger alert-dismissible" role="alert" style="display:none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <span id="lbl"></span>
            </div>

            <form class="form-inline">
                <div class="form-group">
                    <label class="control-label">Exam</label>
                    <select class="form-control" id="cbo_exam" style="width:500px;">
                        <option value="">Select exam</option>
                        <?php echo $program->getExamOption($dec_tp_id,$dec_tc);?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-sm" id="btn_add_exam"><i class="fa fa-plus-circle fa-1x"></i> Add Exam</button>
                </div>
            </form>
            <hr/>
            <table class="display responsive nowrap text-center table table-bordered table-striped" cellspacing="0" width="100%" id="tbl_data">
                <thead>
                    <tr>
                        <th>Exam</th>
                        <th>Module</th>
                        <th>Score</th>
                        <th>Remarks</th>
                        <th>Date Added</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $program->getTraineeExams($dec_tc,$dec_tp_id);?>
                </tbody>
            </table>
           
        </div> <!-- end of panel body -->
      <div class="panel-footer"> <!-- start of panel footer -->
          
      </div> <!-- end of panel footer -->
    </div> <!-- end of panel -->

    </div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->

<!-- page variable storage -->
<input type="hidden" id="txt_tc" value="<?php echo $dec_tc?>" />
<input type="hidden" id="txt_tp_id" value="<?php echo $dec_tp_id;?>" />
<?php 
    include('panels/information_dialog.php');
    include('includes/footer.php');
    include('includes/js_files.php');
?>



<script>
$(document).ready(function(){
 //   $("#cbo_exam").select2();
    var table = $("#tbl_data").DataTable();
    var exam_id = 0;
    $("#btn_add_exam").click(function(){
        exam_id = $("#cbo_exam").val();
        if(exam_id!=""){
            $("#lbl").parent().removeClass("alert-danger");
            $("#lbl").parent().addClass("alert-info");
            $("#lbl").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
            $("#lbl").parent().show();

            $.ajax({
                type:"POST",
                data:{
                    tp_id           : $("#txt_tp_id").val(),
                    trainee_id    : $("#txt_tc").val(),
                    exam_id         : exam_id
                },
                url:"php_processors/proc_add_trainee_exam.php",
                success:function(response){
                    location.reload();
                }
            });
        }
        else {
            $("#lbl").html("Please select an <strong>exam</strong>.");
            $("#lbl").parent().show();
        }
    });

    $("body").on("click",".view_unanswered",function(){
        var content = $(this).data("content");
        $("#dialog_info_title").html("Unanswered Questions");
        $("#dialog_info_content").html(content);
        $("#dialog_info").modal("show");
    });

});
</script>

</body>
</html>