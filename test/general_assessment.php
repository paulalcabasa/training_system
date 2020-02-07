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

  $data = $program->getTraineeProgramAttendeeDetails($dec_tp_id,$dec_tc);

 
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
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="<?php echo BOOTSTRAP_CSS;?>"/>
    <!-- bootstrap date picker -->
    <link rel="stylesheet" type="text/css" href="<?php echo BS_DATEPICKER_CSS;?>" />
    <!-- font awesome -->
    <link rel="stylesheet" type="text/css" href="<?php echo FONT_AWESOME_CSS;?>" /> 
    <!-- SUMMERNOTE -->
    <link rel="stylesheet" type="text/css" href="<?php echo SUMMERNOTE_CSS;?>" />   
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
		
		<h1>General Assessment</h1>
		<hr/>
	  <div class="panel panel-primary">  <!-- start of panel -->

      <div class="panel-heading">
         Assessment for <strong><?php echo $name; ?></strong> at <i><?php echo $title;?></i>.
      </div> <!-- start of panel heading -->
    	<div class="panel-body"> <!-- start of panel body -->
          <input type="hidden" id="attendance_id" value="<?php echo $dec_tp_id;?>"/>
          <input type="hidden" id="trainee_id" value="<?php echo $dec_tc;?>"/>
          <div id="txt_assessment"><?php echo $data['general_assessment'];?></div>
      </div> <!-- end of panel body -->
      <div class="panel-footer"> <!-- start of panel footer -->
         
          <button type="button" class="btn btn-primary btn-sm" id="btn_save">Save</button>
       <!--    <a href="training_program_attendees.php?d=<?php echo $_GET['d'];?>" class="btn btn-success btn-sm">Back</a> -->
          <div class="clearfix"></div>
      </div> <!-- end of panel footer -->
    </div> <!-- end of panel -->

	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->
<input type="hidden"  value="<?php echo $_GET['d'];?>" id="txt_tp_id"/>
<!-- confirmation dialog -->
<?php include("panels/information_dialog.php");?>

<!-- Latest jquery -->
<script src="<?php echo JQUERY;?>"></script>
<!-- bootstrap jquery -->
<script src="<?php echo BOOTSTRAP_JS;?>"></script>
<!-- common functions -->
<script src="<?php echo COMMON_FUNCTIONS;?>"></script>
<!-- common functions -->
<script src="<?php echo SUMMERNOTE_JS;?>"></script>

<script>

$(document).ready(function(){
$("#txt_assessment").summernote({
    height: 250,                 // set editor height
    minHeight: null,             // set minimum height of editor
    maxHeight: null,             // set maximum height of editor
    focus: true,    
    toolbar: [
    //[groupname, [button list]]
      ['style', ['bold', 'italic', 'underline', 'clear']],
      ['font', ['strikethrough', 'superscript', 'subscript']],
      ['fontsize', ['fontsize']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']]
    ]
  });
    
  $("#btn_save").click(function(){
      $.ajax({
          type:"POST",
          data:{
              attendance_id : $("#attendance_id").val(),
              trainee_id : $("#trainee_id").val(),
              content       : $("#txt_assessment").code()
          },
          url:"php_processors/proc_update_assessment.php",
          success:function(response){

              $("#dialog_info_title").text("Information");
              $("#dialog_info_content").html(response);
              $("#dialog_info").modal("show");
          }
      });
  });

  $("#dialog_info").on("hidden.bs.modal",function(){
    window.location.href="training_program_attendees.php?d=" + $("#txt_tp_id").val();
  });
});
</script>

</body>
</html>