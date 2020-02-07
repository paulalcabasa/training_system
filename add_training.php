<?php
	require_once("initialize.php");
    require_once("includes/user_access.php");
    $enc_tc = $_GET['d'];
    $id = $trainee->encryptor("decrypt",$_GET['d']);
    $name = $trainee->encryptor("decrypt",$_GET['n']);
    require_once("includes/header_files.php");
?>


<div id="container">
	


	<div class="page-wrapper">
		
		<h1>Add Training</h1>
		<hr/>
	  <div class="panel panel-primary">  <!-- start of panel -->
      <div class="panel-heading">Training Record Form - add training to <strong><?php echo $name;?></strong></div> <!-- start of panel heading -->
    	<div class="panel-body"> <!-- start of panel body -->
            <div class="col-md-7">
            <form class="form-horizontal" role="form">
                <input type="hidden" id="trainee_code" name="trainee_code" value="<?php echo $id;?>"/>
                <div class="form-group ">
                    <label class="control-label col-md-3">Program</label>
                    <div class="col-md-9">
                        <select class='form-control input-sm' id="cbo_program_code">
                            <?php echo $program->getProgramOption();?>
                        </select>
                      
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
                        <input type="text" class="form-control input-sm col-sm-9" id="txt_venue" name="txt_venue" placeholder="Venue"/>
                        <span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
                        <p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter the venue</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="txt_start_date" class="control-label col-md-3">Start Date</label>
                    <div class="col-md-9">
                    <div class='input-group date' id="txt_start_date">
                        <input type='text'  name="txt_start_date" class="form-control input-sm" placeholder="Start Date"/>
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
                        <input type='text'  name="txt_end_date" class="form-control input-sm" placeholder="End Date"/>
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
         <a href="view_trainings.php?d=<?php echo $enc_tc;?>"  class="btn btn-success btn-sm">Back</a>
          <div class="clearfix"></div>
      </div> <!-- end of panel footer -->
    </div> <!-- end of panel -->

	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->

<?php 
    include("panels/information_dialog.php");
    include("includes/footer.php");
    include("includes/js_files.php");
?>




<script>
$(document).ready(function(){
//   	 $('[data-toggle="tooltip"]').tooltip();   
  
  $("#cbo_program_code").select2({
      dropdownAutoWidth : true, 
      width             : "100%"
  });

  $("#txt_conducted").select2({
      dropdownAutoWidth : true, 
      width             : "100%"
  });

  // initialize datetimepicker
    $("#txt_start_date,#txt_end_date").datetimepicker({
      format:"YYYY-MM-DD",
    });
    

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
                url:"php_processors/proc_add_training.php",
                data:{
                    trainee_code    : trainee_code,
                    program_code    : program_code,
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

});
</script>

</body>
</html>