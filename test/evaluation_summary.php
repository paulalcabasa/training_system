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

  $module_workshop_data = $trainee->getEvaluationWorkshop($dec_tp_id,$dec_tc);
  $attendance_data = $trainee->getEvaluationAttendance($dec_tp_id,$dec_tc);
  $product_knowledge_data = $trainee->getEvaluationProductKnowledgeExam($dec_tp_id,$dec_tc);
  $final_written_data = $trainee->getEvaluationWrittenExam($dec_tp_id,$dec_tc);

  $total_grade = $module_workshop_data['grade'] + $attendance_data['grade'] + $product_knowledge_data['grade'] + $final_written_data['grade'];
  $status = $trainee->getGradeStatus($total_grade);


 // $trainee_details = $trainee->getTraineeInfo($dec_tc);

  //$tcode = $trainee->transformCode($dec_tc);
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
		
		<h1>Training Evaluation</h1>
		<hr/>
	  <div class="panel panel-primary">  <!-- start of panel -->

      <div class="panel-heading">
         Summary of records for <strong><?php echo $name; ?></strong> at <i><?php echo $title;?></i>.
      </div> <!-- start of panel heading -->
    	<div class="panel-body"> <!-- start of panel body -->
      
        <div class="row">
          <div class="table-responsive col-md-5"> <!-- start of final grade -->
              <b>Final Grade</b>
              <blockquote style="font-size:11pt;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Component</th>
                            <th>Weight</th>
                            <th>Score</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Modules and Workshop</td>
                            <td>50%</td>
                            <td><?php echo $module_workshop_data['grade'];?></td>
                        </tr>
                         <tr>
                            <td>Attendance</td>
                            <td>10%</td>
                            <td><?php echo $attendance_data['grade'];?></td>
                        </tr>
                        
                         <tr>
                            <td>Product Knowledge Exam</td>
                            <td>10%</td>
                            <td><?php echo $product_knowledge_data['grade'];?></td>
                        </tr>
                         <tr>
                            <td>Final Written Exam</td>
                            <td>30%</td>
                            <td><?php echo $final_written_data['grade'];?></td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr>
                          <td colspan="2" align="right"><strong>Total :</strong></td>
                          <td><?php echo $total_grade;?></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="right"><strong>Final Status :</strong></td>
                          <td><?php echo $status;?></td>
                        </tr>
                    </tfoot>
                </table>
              </blockquote>
          </div> <!-- end of final grade -->
      </div>   

      <strong>Breakdown of Final Grade / Component</strong><br/>


      <blockquote style="font-size:11pt;"> <!-- module and workshop -->
      <div class="row">
        <div class="table-responsive col-md-8">
          <p>I. Module and Workshop</p>
          <?php echo $module_workshop_data['breakdown']; ?>
      </div>  
      </blockquote> <!-- end of module and workshop -->


      <blockquote style="font-size:11pt;"> <!-- module and workshop -->
        <div class="row">
          <div class="table-responsive col-md-6">
            <p>II. Attendance</p>
            <?php echo $attendance_data['breakdown']?>
          </div>
        </div>  
      </blockquote> <!-- end of module and workshop -->

      <blockquote style="font-size:11pt;"> <!-- module and workshop -->
        <div class="row">
          <div class="table-responsive col-md-4">
            <p>III. Product Knowledge Exam</p>
            <?php echo $product_knowledge_data['breakdown'];?>
          </div>
        </div>  
      </blockquote> <!-- end of module and workshop -->

      <blockquote style="font-size:11pt;"> <!-- module and workshop -->
        <div class="row">
          <div class="table-responsive col-md-4">
            <p>IV. Final Written Exam</p>
            <?php echo $final_written_data['breakdown'];?>
          </div>
        </div>  
      </blockquote> <!-- end of module and workshop -->

      <strong>General Assessment</strong><br/>
      <blockquote style="font-size:11pt;"> <!-- module and workshop -->
        <div class="row">
          <div class="col-md-8">
           
            <div style="text-indent:4em;text-align:justify;">
                <?php echo $data['general_assessment'];?>
            </div>
          </div>
        </div>  
      </blockquote> <!-- end of module and workshop -->

      </div> <!-- end of panel body -->
      <div class="panel-footer"> <!-- start of panel footer -->
          <a href="training_program_attendees.php?d=<?php echo $_GET['d'];?>" class="btn btn-success btn-sm">Back</a>
          <div class="clearfix"></div>
      </div> <!-- end of panel footer -->
    </div> <!-- end of panel -->

	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->



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

});
</script>

</body>
</html>