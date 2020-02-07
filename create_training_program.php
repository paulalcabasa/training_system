<?php
	require_once("initialize.php");
    require_once("includes/user_access.php");
    require_once("includes/header_files.php");
    $conn = new Connection();
    $program = new Program();
    $trainor = new Trainor();
    $trainee = new Trainee();
    $job = new Job();
    $program_category_list = $program->getProgramCategoryList();
    $trainors_list = $trainor->getTrainorList();
  
?>

<div id="container">
	<div class="page-wrapper">
      <h1>Create Training Program</h1>
      <br/>
	  <div class="box box-danger">  <!-- start of panel -->
        <div class="box-header">
            <i class="fa fa-file-text"></i>
            <h3 class="box-title">Training Programs</h3>
        </div>
    	<div class="box-body"> <!-- start of panel body -->
            <div class="col-md-6">
                <form class="form-horizontal" role="form">
                  
                    <div class="form-group ">
                        <label class="control-label col-md-3">Program</label>
                        <div class="col-md-9">
                            <select class='form-control input-sm' id="cbo_program_code">
                            <?php
                            foreach($program_category_list as $category){
                                $category = (object)$category;
                                $programs_list = $program->getProgramsListByCategory($category->program_category_id);
                            ?>  
                                <optgroup label="<?php echo $category->category_name; ?>">
                                <?php
                                    foreach($programs_list as $p){
                                        $p = (object)$p;
                                ?>
                                        <option value="<?php echo $p->program_code;?>"><?php echo $p->title;?></option>
                                <?php
                                    }
                                ?>
                                </optgroup>
                            <?php 
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txt_conducted" class="control-label col-sm-3">Conducted by</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm" id="txt_conducted" name="txt_conducted">
                            <?php
                                foreach($trainors_list as $t){
                                    $t = (object)$t;
                            ?>
                                <option value="<?php echo $t->trainor_id; ?>"><?php echo $t->trainor_name; ?></option>
                            <?php
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="txt_venue" class="control-label col-sm-3">Venue</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control col-sm-9" id="txt_venue" name="txt_venue" placeholder="Venue"/>
                            <span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
                            <p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter the venue</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txt_start_date" class="control-label col-md-3">Date</label>
                        <div class="col-md-9">
                        <div class='input-group'>
                            <input type='text'  id="txt_date_range" class="form-control" placeholder="Date"/>
                            <span class="input-group-addon">
                                <span class="fa fa-calendar fa-1x"></span>
                            </span>
                        </div>
                        <p class="help-block custom-help" style="display:none;"><strong>*</strong> Please select the date</p>
                        </div>
                    </div>
                </form>
            </div> <!-- end of left side -->
      </div> <!-- end of panel body -->
      <div class="box-footer"> <!-- start of panel footer -->
          <button type="button" class="btn btn-primary btn-sm" id="btn_save"><i class="fa fa-save fa-1x"></i> Save</button>
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

    var isCreate = false;
    var isSaved = false;
    var start_date = "";
    var end_date = ""; 
    validate_input("#txt_venue");
    $("#cbo_program_code").select2();
    $("#txt_conducted").select2();

    
    $("#btn_save").click(function(){
        isSaved = true;
        var program_id = $("#cbo_program_code").val();
        var trainor_id = $("#txt_conducted").val();
        var venue = $("#txt_venue").val();
    
        var isError = true;
        
      
        if(venue == ""){
            mark_error_input("#txt_venue");
            isError = true;
        }
        else {
            isError = false;
        }

        if(!isError){

           $("#dialog_info_content").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
            $("#dialog_info").modal({backdrop:'static'});
            $("#dialog_info_title").html("Information");
            $.ajax({
                type:"POST",
                data:{
                    program_id  : program_id,
                    trainor_id  : trainor_id,
                    venue       : venue,
                    start_date  : start_date,
                    end_date    : end_date
                   // emp_staus   : $("#cbo_emp_status").val(),
                   // months      : $("#txt_months").val(),
                   // jobs        : $("#cbo_job_position").val(),
                   // programs    : $("#cbo_tp").val()
                },
                url:"ajax/add_training_program.php",
                success:function(response){
                    window.location.href="view_training_programs.php";
                }
            });
        

        }
    });



    $("#navigation-top").children("li:nth-child(3)").addClass("active");
    
    $("#cbo_emp_status").change(function(){

        if($("option:selected",this).text() == "Probationary"){
            $(this).parent().prop("class","col-md-8");
            $("#mos_wrapper").show();
        }
        else {
            $(this).parent().parent().prop("class","col-md-9");
            $("#mos_wrapper").hide();
        }
    });


    $("#cbo_job_position,#cbo_tp").select2();

    $("#txt_date_range").daterangepicker();

    $('#txt_date_range').on('apply.daterangepicker', function(ev, picker) {
        start_date = picker.startDate.format('YYYY-MM-DD');
        end_date = picker.endDate.format('YYYY-MM-DD');
    });

    $("#txt_date_range").val("");

});
</script>

</body>
</html>