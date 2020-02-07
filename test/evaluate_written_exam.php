<?php

	require_once("initialize.php");
  require_once("includes/user_access.php");

  // encrypted variables
  $dec_tp_id = $conn->encryptor("decrypt",$_GET['d']);
  $dec_tc = $conn->encryptor("decrypt",$_GET['tc']);
  $training_program_details = $program->getTrainingProgramDetails($dec_tp_id);
  
  $name_details = $trainee->getTraineeName($dec_tc);
  $name = $conn->transformName1($name_details['first_name'],$name_details['middle_name'],$name_details['last_name'],$name_details['suffix'],$conn);
  $title = $training_program_details['title'];
  
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
    <!-- title -->
    <title>Training Written Exam Entry | Centralized IPC Database</title>
</head>
<body>

<!-- navigation top panel included -->
<?php include("includes/menu.php");?>

<div id="container">
	<div class="page-wrapper">
		
		<h1>Final Written Exam</h1>
		<hr/>
	  <div class="panel panel-primary">  <!-- start of panel -->
      <div class="panel-heading">
          Final Written Exam Records of <strong><?php echo $name;?></strong> for <em><?php echo $title;?></em>
      </div> <!-- start of panel heading -->
    	<div class="panel-body"> <!-- start of panel body -->
        <table class="display responsive nowrap text-center" cellspacing="0" width="100%" id="tbl_exam_data"> <!-- start of table -->
    			<thead>
    				<tr>
    					<th class="text-center">Exam</th>
    					<th class="text-center">Score</th>
              <th class="text-center">Edit</th>
    					<th class="text-center">Delete</th>
    				</tr>
    			</thead>

    			<tbody>
    			     <?php echo $trainee->getWrittenExam($dec_tp_id,$dec_tc);?>
    			</tbody>

    		</table>
      </div> <!-- end of panel body -->
      <div class="panel-footer"> <!-- start of panel footer -->
          
          <button type="button" data-toggle="modal" data-target="#dialog_add_exam" class="btn btn-primary btn-sm">Add Record</button>
         <a href="training_program_attendees.php?d=<?php echo $_GET['d'];?>" class="btn btn-success btn-sm">Back</a>
          <div class="clearfix"></div>
      </div> <!-- end of panel footer -->
    </div> <!-- end of panel -->

	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->

<!-- confirmation dialog -->
<?php include("panels/confirm_dialog.php");?>

<!-- dialog for adding attendance -->
<div class="modal fade" id="dialog_add_exam">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Written Exam</h4>
      </div>
      <div class="modal-body">
          <p class="alert alert-info" id="add_notif" style="display:none;"></p>
          <form class="form-horizontal" role="form" id="frm_exam">

              <input type="hidden" name="attendance_id" id="attendance_id" value="<?php echo $dec_tp_id;?>"/>
              <input type="hidden" name="trainee_id" id="trainee_id" value="<?php echo $dec_tc;?>"/>
         
              <div class="form-group">
                  <label for="txt_exam" class="control-label col-sm-3">Exam</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control input-sm" id="txt_exam" name="txt_exam" placeholder="Exam"/>
                      <span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
                      <p class="help-block custom-help" style="display:none;"><strong>*</strong> </p>
                  </div>
              </div>

              <div class="form-group">
                  <label for="txt_score" class="control-label col-sm-3">Score</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control input-sm" id="txt_score" name="txt_score" placeholder="Score" maxlength="3"/>
                      <span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
                      <p class="help-block custom-help" style="display:none;"><strong>*</strong> </p>
                  </div>
              </div>

          </form>

           <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-sm" id="btn_save_grade">Save</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- dialog for adding attendance -->
<div class="modal fade" id="dialog_edit_exam">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update Written Exam</h4>
      </div>
      <div class="modal-body">
          <p class="alert alert-info" id="edit_notif" style="display:none;"></p>
          <form class="form-horizontal" role="form" id="frm_edit_exam">

              <div class="form-group">
                  <label for="txt_exam" class="control-label col-sm-3">Exam</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control input-sm" id="txt_edit_exam" name="txt_edit_exam" placeholder="Exam"/>
                      <span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
                      <p class="help-block custom-help" style="display:none;"><strong>*</strong> </p>
                  </div>
              </div>

              <div class="form-group">
                  <label for="txt_score" class="control-label col-sm-3">Score</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control input-sm" id="txt_edit_score" name="txt_edit_score" placeholder="Score" maxlength="3"/>
                      <span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
                      <p class="help-block custom-help" style="display:none;"><strong>*</strong> </p>
                  </div>
              </div>

          </form>

           <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-sm" id="btn_save_changes">Save</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


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

    var table = $("#tbl_exam_data").DataTable();
    var element;
    var attendance_id = $("#attendance_id").val();
    var trainee_id = $("#trainee_id").val();
    var exam_id = 0;
    $("#btn_save_grade").click(function(){
        if(parseInt($("#txt_score").val()) <= 100){
            $.ajax({
                type:"POST",
                url:"php_processors/proc_add_written_exam.php",
                data:{
                    attendance_id : attendance_id,
                    trainee_id    : trainee_id,
                    exam          : $("#txt_exam").val(),
                    score         : $("#txt_score").val()
                },
                success:function(response){
                   $("#add_notif").html(response).show("slow");
                }
            });
        } else {
            $("#add_notif").html("Please enter a value that is not greater than 100.").show("slow");
        }
    });
    
    $("#dialog_add_exam,#dialog_box,#dialog_edit_exam").on("hidden.bs.modal",function(){
        location.reload();
    });

    $("body").on("click",".btn_delete",function(){
        element = $(this);
        exam_id = $(this).attr("data-exam_id"); 
        $("#dialog_title").text("Confirmation");
        $("#dialog_content").html("Are you sure?");
        $("#dialog_box").modal("show");
    });

    $("#dialog_btn_confirm").click(function(){
        $("#dialog_content").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
        $.ajax({
            type:"POST",
            data:{
                exam : exam_id
            },
            url:"php_processors/proc_delete_written_exam.php",
            success:function(response){
              $("#dialog_content").html(response);
            }
        });
    });

    $("body").on("click",".btn_edit",function(){
        exam_id = $(this).attr("data-exam_id");
        $("#txt_edit_exam").val($(this).attr("data-exam"));
        $("#txt_edit_score").val($(this).attr("data-score"));
        $("#dialog_edit_exam").modal("show");
    });

    $("#btn_save_changes").click(function(){
        if($("#txt_edit_score").val() <= 100){
            $.ajax({
                type:"POST",
                url:"php_processors/proc_update_written_exam.php",
                data:{
                    exam_id : exam_id,
                    exam    : $("#txt_edit_exam").val(),
                    score   : $("#txt_edit_score").val()
                },
                success:function(response){
                   $("#edit_notif").html(response).show("slow");
                }
            });
        }
        else {
             $("#edit_notif").html("Please enter a value that is not greater than 100.").show("slow");
        }    
    });
    
    $('#txt_score,#txt_edit_score').on('input', function() {
        var sanitized = $(this).val().replace(/[^0-9]/g, '');
        $(this).val(sanitized);
    });
});
</script>

</body>
</html>