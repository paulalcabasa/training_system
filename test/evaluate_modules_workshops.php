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
    <title>Training Evaluation Entry | Centralized IPC Database</title>
</head>
<body>

<!-- navigation top panel included -->
<?php include("includes/menu.php");?>

<div id="container">
	<div class="page-wrapper">
		
		<h1>Modules and Workshop Evaluation</h1>
		<hr/>
	  <div class="panel panel-primary">  <!-- start of panel -->
      <div class="panel-heading">
          <p>Modules and Workshop of 
              <strong><?php echo $name; ?></strong> at
              <i><?php echo $title; ?></i>
          </p>
      </div> <!-- start of panel heading -->
    	<div class="panel-body"> <!-- start of panel body -->
        <table class="display responsive nowrap text-center" cellspacing="0" width="100%" id="tbl_mods_works_data"> <!-- start of table -->
    			<thead>
    				<tr>
    					<th class="text-center">Module Name</th>
    					<th class="text-center">Participation</th>
    					<th class="text-center">Module-ending Exam</th>
    					<th class="text-center">Module-ending Evaluation</th>
    					<th class="text-center">Total</th>
              <th class="text-center">Date Created</th>
              <th class="text-center">Date Updated</th>
            
    				</tr>
    			</thead>

    			<tbody>
    			       <?php echo $trainee->getModuleGrade($dec_tp_id,$dec_tc);?>
    			</tbody>

    		</table>
      </div> <!-- end of panel body -->
      <div class="panel-footer"> <!-- start of panel footer -->

          <a href="training_program_attendees.php?d=<?php echo $_GET['d'];?>" class="btn btn-success btn-sm">Back</a>
          <!--<button type="button" data-toggle="modal" data-target="#dialog_add_module" class="btn btn-primary btn-sm">Add Record</a>-->
          <div class="clearfix"></div>
      </div> <!-- end of panel footer -->
    </div> <!-- end of panel -->

	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->




<input type="hidden" value="<?php echo $dec_tc;?>" id="txt_trainee_code"/>
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
<!-- masked input -->
<script src="<?php echo MASKED_INPUT_JS;?>"></script>

<script>
$(document).ready(function(){
  var trainee_id = $("#txt_trainee_code").val();
  var table = $("#tbl_mods_works_data").DataTable();
  var workshop_id = 0;
  var attendance_id = 0;
  var element;

    $("body").on("input",".txt_participation",function(){
        if($(this).val() <= 100){
            workshop_id = $(this).data("workshop_id");
            attendance_id = $(this).data("attendance_id");

            var participation = $(this).val();
            var mod_end_exam = ( $(this).parent().next().children("input:first").val() != "") ? $(this).parent().next().children("input:first").val() : 0 ;
            var mod_end_eva = ( $(this).parent().next().next().children("input:first").val() != "" ) ? $(this).parent().next().next().children("input:first").val() : 0;
            element = $(this);
           
            var average = (parseInt(participation) + parseInt(mod_end_exam) + parseInt(mod_end_eva) ) / 3;
           

            $.ajax({
              type:"POST",
              data:{
                  attendance_id : attendance_id,
                  workshop_id   : workshop_id,
                  trainee_id    : trainee_id,
                  participation : participation,
                  mod_end_exam  : mod_end_exam,
                  mod_end_eva   : mod_end_eva
              },
              url:"php_processors/proc_update_mod_grade.php",
              success:function(response){
                  element.parent().next().next().next().text(average.toFixed(2));
                  element.parent().next().next().next().next().next().text(response);
              }
            });
        } else {
          alert("Please enter a grade that is not greater than 100");
          $(this).val(0);
        }
    });

    $("body").on("input",".txt_mee",function(){
        if($(this).val() <= 100){
          workshop_id = $(this).data("workshop_id");
          attendance_id = $(this).data("attendance_id");
          var mod_end_exam = $(this).val();
          var participation = ( $(this).parent().prev().children("input:first").val() != "") ? $(this).parent().prev().children("input:first").val() : 0 ;
          var mod_end_eva = ( $(this).parent().next().children("input:first").val() != "" ) ? $(this).parent().next().children("input:first").val() : 0;
          element = $(this);
         
          var average = (parseInt(participation) + parseInt(mod_end_exam) + parseInt(mod_end_eva) ) / 3;
         
          $.ajax({
            type:"POST",
            data:{
                attendance_id : attendance_id,
                workshop_id   : workshop_id,
                trainee_id    : trainee_id,
                participation : participation,
                mod_end_exam  : mod_end_exam,
                mod_end_eva   : mod_end_eva
            },
            url:"php_processors/proc_update_mod_grade.php",
            success:function(response){
                element.parent().next().next().text(average.toFixed(2));
                element.parent().next().next().next().next().text(response);
            } 
          });
        } else {
           alert("Please enter a grade that is not greater than 100");
           $(this).val(0);
        }
    });

     $("body").on("input",".txt_mev",function(){
        if($(this).val() <= 100){
          workshop_id = $(this).data("workshop_id");
          attendance_id = $(this).data("attendance_id");
          var mod_end_eva = $(this).val();
          var participation = ( $(this).parent().prev().prev().children("input:first").val() != "") ? $(this).parent().prev().prev().children("input:first").val() : 0 ;
          var mod_end_exam = ( $(this).parent().prev().children("input:first").val() != "" ) ? $(this).parent().prev().children("input:first").val() : 0;
          element = $(this);
         
          var average = (parseInt(participation) + parseInt(mod_end_exam) + parseInt(mod_end_eva) ) / 3;
         
          $.ajax({
            type:"POST",
            data:{
                attendance_id : attendance_id,
                workshop_id   : workshop_id,
                trainee_id    : trainee_id,
                participation : participation,
                mod_end_exam  : mod_end_exam,
                mod_end_eva   : mod_end_eva
            },
            url:"php_processors/proc_update_mod_grade.php",
            success:function(response){
                element.parent().next().text(average.toFixed(2));
                element.parent().next().next().next().text(response);
            }
          });
         } else {
           alert("Please enter a grade that is not greater than 100");
           $(this).val(0);
        }
    });
  

    $('body').on('input',".txt_participation,.txt_mee,.txt_mev", function() {
        var sanitized = $(this).val().replace(/[^0-9]/g, '');
        $(this).val(sanitized);
    });

});
</script>

</body>
</html>