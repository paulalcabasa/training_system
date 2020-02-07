<?php
	require_once("initialize.php");
    require_once("includes/user_access.php");
    $encyption = new Encryption();
    $trainingprogram = new TrainingProgram();
    $program = new Program();
    $tp_id = $encyption->decrypt($get->d);
    $program_details = $trainingprogram->getTrainingProgramDetails($tp_id);
    $trainor = new Trainor();
    $trainors_list = $trainor->getTrainorList();
    $program_category_list = $program->getProgramCategoryList();
    $trainors_list = $trainor->getTrainorList();
    require_once("includes/header_files.php");
?>
<div id="container">
	<div class="page-wrapper">
	   <h1>Update Training Program</h1>
		<br/>
	  <div class="box box-danger">  <!-- start of panel -->
        <div class="box-header">
            <i class="fa fa-file-text"></i>
            <h3 class="box-title">Update</h3>
        </div>
    	<div class="box-body"> <!-- start of panel body -->
            <div class="col-md-7">
                <form class="form-horizontal" role="form">
                    <div class="form-group ">
                        <label class="control-label col-md-3">Program</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="form-control" id="prog_title_frm"><?php echo $program_details->title;?></span>
                                <span class="input-group-btn">
                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#dialog_change_program">Change</a>
                                </span>
                            </div>
                            <small class="help-block" style="margin-bottom:0;">
                                <strong>Note:</strong> Changing the program would remove all the associated records such as Grading Criteria, Examinations, Trainees and Attendance.
                            </small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txt_conducted" class="control-label col-sm-3">Conducted by</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="txt_conducted" name="txt_conducted">
                        <?php
                            foreach($trainors_list as $t){
                                $t = (object)$t;
                                $is_selected = $t->trainor_id == $program_details->trainor_id ? "selected" : ""; 
                        ?>
                                <option value="<?php echo $t->trainor_id; ?>" <?php echo $is_selected; ?> ><?php echo $t->trainor_name; ?></option>
                        <?php
                            }
                        ?>
                            </select>
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="txt_venue" class="control-label col-sm-3">Venue</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="txt_venue" name="txt_venue" placeholder="Venue" value="<?php echo $program_details->venue;?>"/>
                            <span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
                            <p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter the venue</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txt_start_date" class="control-label col-md-3">Date</label>
                        <div class="col-md-9">
                        <div class='input-group'>
                            <input type='text'  id="txt_date_range" value="" class="form-control" placeholder="Date"/>
                            <span class="input-group-addon">
                                <span class="fa fa-calendar fa-1x"></span>
                            </span>
                        </div>
                        <p class="help-block custom-help" style="display:none;"><strong>*</strong> Please select the date</p>
                        </div>
                    </div>                
                </form>
            </div>
      </div> <!-- end of panel body -->
      <div class="box-footer"> <!-- start of panel footer -->
            <button type="button" class="btn btn-primary btn-sm" id="btn_save">Save Changes</button>
      </div> <!-- end of panel footer -->
    </div> <!-- end of panel -->
	</div> <!-- end of page content wrapper -->
</div> <!-- end of wrapper -->

<input type="hidden" id="txt_start_date" value="<?php echo $program_details->start_date;?>"/>
<input type="hidden" id="txt_end_date" value="<?php echo $program_details->end_date;?>"/>
<input type="hidden" id="txt_tp_id" value="<?php echo $tp_id;?>"/>

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
                        <span class="form-control input-md" id="prog_title"><?php echo $program_details->title;?></span>
                    </div>
                </div>
              
                 <div class="form-group">
                    <label class="control-label col-md-1">To</label>
                    <div class="col-md-11">
                        <select class='form-control input-sm' id="new_program">
                        <?php
                            foreach($program_category_list as $category){
                                $category = (object)$category;
                                $programs_list = $program->getProgramsListByCategory($category->program_category_id);

                        ?>  
                                <optgroup label="<?php echo $category->category_name; ?>">
                                <?php
                                    foreach($programs_list as $p){
                                        $p = (object)$p;
                                        if($program_details->program_id != $p->program_code){
                                ?>
                                        <option value="<?php echo $p->program_code;?>"><?php echo $p->title;?></option>
                            <?php
                                        }
                                }
                            ?>
                                </optgroup>
                        <?php 
                        }
                        ?>
                        </select>
                    </div>
                </div>

            </form>
            <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-success btn-sm" id="btn_change_program_save">OK</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
       

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php 
    include("includes/footer.php");
    include("includes/js_files.php");
?>

<script>
$(document).ready(function(){

    var training_program_id = $("#txt_tp_id").val();
    var start_date = $("#txt_start_date").val();
    var end_date = $("#txt_end_date").val();
    $("#txt_conducted").select2();
    $("#txt_date_range").daterangepicker();
    $("#txt_date_range").val(moment(start_date,"YYYY-MM-DD").format('MM/DD/YYYY') + " - " + moment(end_date,"YYYY-MM-DD").format('MM/DD/YYYY'));

    $("#new_program").select2({
        dropdownAutoWidth : true, 
        width             : "100%"
    });
    
    $("#btn_save").click(function(){ 
        var trainor = $("#txt_conducted").val();
        var venue = $("#txt_venue").val();
        $("#dialog_info_title").text("Information");
        $("#dialog_info_content").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
        $("#dialog_info").modal({
            backdrop:'static'
        });
        $.ajax({
            type:"POST",
            url:"ajax/update_tp_program.php",
            data:{
                training_program_id : training_program_id,
                trainor_id          : trainor,
                venue               : venue,
                start_date          : start_date,
                end_date            : end_date
            },
            success:function(response){
                $("#dialog_info_content").html(response);
            }
        });
    });

     $("#btn_change_program_save").click(function(){
        var new_program = $("#new_program").val();
        var title = $("#new_program option:selected").text();
        $("#change_notif").html("Please wait... <img src='../../../img/ajax-loader.gif'/>").show();
        $.ajax({
            type:"POST",
            data:{
                training_program_id : training_program_id,
                new_program         : new_program
            },
            url:"ajax/change_program.php",
            success:function(response){
                location.reload();
                //$("#change_notif").html(response);
              // $("#prog_title,#prog_title_frm").text(title);
            }
        });  
    });

    
    
     $('#txt_date_range').on('apply.daterangepicker', function(ev, picker) {
        start_date = picker.startDate.format('YYYY-MM-DD');
        end_date = picker.endDate.format('YYYY-MM-DD');
    });

});
</script>

</body>
</html>