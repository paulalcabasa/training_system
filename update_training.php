<?php
	
	require_once("initialize.php");
    require_once("includes/user_access.php");
    $id = $trainee->encryptor("decrypt",$_GET['d']);
    $name = $trainee->encryptor("decrypt",$_GET['n']);
    $training_details = $trainee->getTrainingDetails($id);
    $title = $trainee->encryptor("decrypt",$_GET['t']);
    $program_opts = $program->getProgramsExcept($training_details['program_code']);
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
    <!-- custom style for IPC TRAINING DB -->
    <link rel="stylesheet" type="text/css" href="<?php echo SYS_TRAINING_STYLE;?>" />
    <!-- title -->
    <title>Training Information Entry | Centralized IPC Database</title>


</head>
<body>

<!-- navigation top panel included -->
<?php include("includes/menu.php");?>

<div id="container">
	


	<div class="page-wrapper">
		
		<h1>Add Training</h1>
		<hr/>
	  <div class="panel panel-primary">  <!-- start of panel -->
      <div class="panel-heading">Training Record Form - update training record for <strong><?php echo $name;?></strong></div> <!-- start of panel heading -->
    	<div class="panel-body"> <!-- start of panel body -->
            <div class="col-md-7">
            <form class="form-horizontal" role="form">
                <input type="hidden" id="attendance_id" value="<?php echo $training_details['attendance_id']?>">
                <input type="hidden" id="trainee_code" value="<?php echo $training_details['trainee_code']?>">
                 <input type="hidden" id="temp_program_code" value="<?php echo $training_details['program_code']?>">
                <div class="form-group ">
                    <label class="control-label col-md-3">Program</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="form-control input-sm" id="prog_title_frm"><?php echo $title;?></span>
                            <span class="input-group-btn">
                                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#dialog_change_program">Change</a>
                            </span>
                        </div>
                        <small class="help-block" style="margin-bottom:0;">
                            <strong>Note:</strong> Changing the program would remove all associated attendance, modules and workshops.
                        </small>
                    </div>
                </div>
               

                <div class="form-group">
                    <label for="txt_conducted" class="control-label col-sm-3">Conducted by</label>
                    <div class="col-sm-9">
                        <select class="form-control input-sm" id="txt_conducted" name="txt_conducted">
                            <?php echo $trainor->getTrainorOption();?>
                        </select>
                    </div>
                </div>

                 <div class="form-group">
                    <label for="txt_venue" class="control-label col-sm-3">Venue</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm col-sm-9" id="txt_venue" name="txt_venue" placeholder="Venue" value="<?php echo $training_details['venue'];?>"/>
                        <span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
                        <p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter the venue</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="txt_start_date" class="control-label col-md-3">Start Date</label>
                    <div class="col-md-9">
                    <div class='input-group date' id="txt_start_date">
                        <input type='text'  name="txt_start_date" class="form-control input-sm" placeholder="Start Date" value="<?php echo $training_details['start_date'];?>"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    <p class="help-block custom-help" style="display:none;"><strong>*</strong> Please select start date</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="txt_end_date" class="control-label col-md-3">End Date</label>
                    <div class="col-md-9">
                    <div class='input-group date' id="txt_end_date">
                        <input type='text'  name="txt_end_date" class="form-control input-sm" placeholder="End Date" value="<?php echo $training_details['end_date'];?>"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    <p class="help-block custom-help" style="display:none;"><strong>*</strong> Please select end date</p>
                    </div>
                </div>       
            </form>
            </div>
      </div> <!-- end of panel body -->
      <div class="panel-footer"> <!-- start of panel footer -->
         
         <button type="button" class="btn btn-primary btn-sm" id="btn_save">Save</button>
         <a href="view_trainings.php?d=<?php echo $_GET['tc'];?>"  class="btn btn-success btn-sm">Back</a>
          <div class="clearfix"></div>
      </div> <!-- end of panel footer -->
    </div> <!-- end of panel -->

	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->

<!-- information dialog -->
<?php include("panels/information_dialog.php"); ?>

<!-- change of program form -->
<div class="modal fade" id="dialog_change_program">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="dialog_title">Change of Program</h4>
      </div>
      <div class="modal-body" >
            <p class="alert alert-info" id="change_notif" style="display:none;"></p>
            <form class="form-horizontal text-left">
                
                <div class="form-group">
                    <label class="control-label col-md-1">From</label>
                    <div class="col-sm-11">
                        <span class="form-control input-md" id="prog_title"><?php echo $title;?></span>
                    </div>
                </div>
              
                 <div class="form-group">
                    <label class="control-label col-md-1">To</label>
                    <div class="col-md-11">
                        <select class='form-control input-sm' id="new_program">
                            <?php echo $program_opts; ?>
                        </select>
                    </div>
                </div>

            </form>
            <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-success btn-sm" id="btn_change_program_save">Yes</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
       

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<input type="hidden" id="cond_by" value="<?php echo $training_details['conducted_by'];?>" />
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
<!-- common functions -->
<script src="<?php echo COMMON_FUNCTIONS;?>"></script>

<script>
$(document).ready(function(){
//   	 $('[data-toggle="tooltip"]').tooltip();   
  
  $("#cbo_program_code,#new_program").select2({
      dropdownAutoWidth : true, 
      width             : "100%"
  });

  // initialize datetimepicker
    $("#txt_start_date,#txt_end_date").datetimepicker({
      format:"YYYY-MM-DD",
    });
    
    $("#txt_conducted").val($("#cond_by").val());

    validate_input("#txt_conducted");
    validate_input("#txt_venue");



    $("#txt_start_date").on("dp.change",function(){
        validate_date("#txt_start_date");
    });

    $("#txt_end_date").on("dp.change",function(){
        validate_date("#txt_end_date");
    });

    $("#btn_save").click(function(){
        var isError = false;    

        if($("#txt_conducted").val() == ""){
            mark_error_input("#txt_conducted");
            isError = true;
        } 
        if($("#txt_venue").val() == ""){
            mark_error_input("#txt_venue");
            isError = true;
        } 

        if(validate_date("#txt_start_date")){
            isError = true;
        }

        if(validate_date("#txt_end_date")){
            isError = true;
        }

        if(!isError){
            var trainee_code = $("#trainee_code").val();
            var program_code = $("#cbo_program_code").val();

            $.ajax({
                type:"POST",
                url:"php_processors/proc_update_training.php",
                data:{
                    attendance_id   : $("#attendance_id").val(),
                    trainee_code    : $("#trainee_code").val(),
                    conducted_by    : $("#txt_conducted").val(),
                    venue           : $("#txt_venue").val(),
                    start_date      : $("#txt_start_date").data('date'),
                    end_date        : $("#txt_end_date").data('date')
                },
                success:function(response){
                    $("#dialog_info_title").text("Information");
                    $("#dialog_info_content").html(response);
                    $("#dialog_info").modal("show");
                }
            });
            
        }

    });
    
    $("#btn_change_program_save").click(function(){
        var attendance_id = $("#attendance_id").val();
        var new_program = $("#new_program").val();
        var title = $("#new_program option:selected").text();
        $.ajax({
            type:"POST",
            data:{
                attendance_id : attendance_id,
                program_code   : new_program
            },
            url:"php_processors/proc_change_program.php",
            success:function(response){
                $("#temp_program_code").val(new_program);
                $("#prog_title,#prog_title_frm").text(title);
                $("#change_notif").text(response).show("slow");
                $("#btn_change_program_save").hide("slow");
            }
        });
        
    });

    $('#dialog_change_program').on('hidden.bs.modal', function () {
        $("#btn_change_program_save").show(); 
        $("#change_notif").hide();
    });
    
});
</script>

</body>
</html>