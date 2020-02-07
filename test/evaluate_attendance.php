<?php
	require_once("initialize.php");
  require_once("includes/user_access.php");

  // encrypted variables
  $dec_tp_id = $conn->encryptor("decrypt",$_GET['d']);
  $dec_tc = $conn->encryptor("decrypt",$_GET['tc']);
  $training_program_details = $program->getTrainingProgramDetails($dec_tp_id);

  
  $name_details = $trainee->getTraineeName($dec_tc);
  $name = $conn->transformName1($name_details['first_name'],$name_details['middle_name'],$name_details['last_name'],$name_details['name_extension'],$conn);
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
    <title>Training Attendance Entry | Centralized IPC Database</title>

</head>
<body>

<!-- navigation top panel included -->
<?php include("includes/menu.php");?>

<div id="container">
	<div class="page-wrapper">
		
		<h1>Attendance</h1>
		<hr/>
	  <div class="panel panel-primary">  <!-- start of panel -->
      <div class="panel-heading">
          Attendance of <strong> <?php echo $name;?> </strong> for <em> <?php echo $title;?> </em>
      </div> <!-- start of panel heading -->
    	<div class="panel-body"> <!-- start of panel body -->
        <table class="display responsive nowrap text-center" cellspacing="0" width="100%" id="tbl_attendance"> <!-- start of table -->
    			<thead>
    				<tr>
    					<th class="text-center" style="width:60%;">Module</th>
    					<th class="text-center" style="width:20%;">Time In</th>
    					<th class="text-center" style="width:20%;">Score</th>
    				</tr>
    			</thead>
                
    			<tbody>
    			       <?php echo $trainee->getAttendance($dec_tp_id,$dec_tc);?>
    			</tbody>

    		</table>
      </div> <!-- end of panel body -->
      <div class="panel-footer"> <!-- start of panel footer -->
           <a href="training_program_attendees.php?d=<?php echo $_GET['d'];?>" class="btn btn-success btn-sm">Back</a>

          <div class="clearfix"></div>
      </div> <!-- end of panel footer -->
    </div> <!-- end of panel -->

	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->




<input type="hidden" id="attendance_id" value="<?php echo $dec_tp_id;?>" />
<input type="hidden" id="trainee_id" value="<?php echo $dec_tc;?>"/>
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

 
  var att_id = 0;
  var table = $("#tbl_attendance").DataTable();
  var attendance_id = $("#attendance_id").val();
  var trainee_id = $("#trainee_id").val();

  $(".txt_time_in").datetimepicker({
    format:"LT"
  });
    
  $('.txt_time_in').on('dp.change', function (ev) {
      
      var time_in = moment($(this).data("date"), ["h:mm A"]).format("HH:mm:ss");
      att_id = $(this).data("att_id");
      var score = $(this).parent().next().find("input:first").val();
      
      $.ajax({
          type:"POST",
          data:{
              att_id        : att_id,
              attendance_id : attendance_id,
              trainee_id    : trainee_id,
              time_in       : time_in,
              score         : score
          },
          url:"php_processors/proc_update_attendance.php",
          success:function(response){
              //console.log(response);
          }
      });
  });
  
   $('.txt_score').on('input', function (ev) {
      var score = $(this).val();
      if(score <= 100){
          var time_in = moment($(this).parent().prev().find("div").data("date"), ["h:mm A"]).format("HH:mm:ss");
          att_id = $(this).data("att_id");
          $.ajax({
              type:"POST",
              data:{
                  att_id        : att_id,
                  attendance_id : attendance_id,
                  trainee_id    : trainee_id,
                  time_in       : time_in,
                  score         : score
              },
              url:"php_processors/proc_update_attendance.php",
              success:function(response){
                  //console.log(response);
             }
          });
      } else {
          alert("Please enter a value that is not greater than 100.");
          $(this).val(0);
      }
  });
    
     $('body').on('input',".txt_score", function() {
        var sanitized = $(this).val().replace(/[^0-9]/g, '');
        $(this).val(sanitized);
    });
    
    
});
</script>

</body>
</html>