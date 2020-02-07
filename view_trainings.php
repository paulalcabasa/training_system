<?php

  require_once("initialize.php");
  require_once("includes/user_access.php");

  if(isset($_GET['d'])){
      $id = $trainee->encryptor("decrypt",$_GET['d']);
      $details = $trainee->getTraineeName($id);

      $name = $trainee->transformName1($details['first_name'],$details['middle_name'],$details['last_name'],$details['suffix'],$conn);
      $enc_trainee_code = $_GET['d'];
      $enc_name = $trainee->encryptor("encrypt",$name);
      $trainee_info = $trainee->getTraineeInfo($id);
      if($trainee_info['dealer_category'] == "main"){
        $dealer = $trainee->getDealerName($trainee_info['dealer_id'],"dealer_main","dealer_main_name","dealer_main_id",$conn);
      }
      else {
        $dealer = $trainee->getDealerName($trainee_info['dealer_id'],"dealer_satellite","dealer_satellite_name","dealer_satellite_id",$conn);
      }
  }

?>

<?php include("includes/header_files.php");?>

<div id="container">
	<div class="page-wrapper">
		
		<h1>Training Record</h1>
		<hr/>
	  <div class="panel panel-primary">  <!-- start of panel -->
      <div class="panel-heading">
          <span>Trainings attended by <strong><?php echo $name; ?> </strong><span> |
          <span>Dealer : <strong><?php echo $dealer['name']; ?></strong></span> |
          <span>Job Position : <strong><?php echo $job->getJobDescription($trainee_info['job_position']);?></strong></span>
      </div> <!-- start of panel heading -->
    	<div class="panel-body"> <!-- start of panel body -->
        <table class="display responsive nowrap text-center table table-bordered table-striped" cellspacing="0" width="100%" id="tbl_training_data"> <!-- start of table -->
    			<thead>
    				<tr>
    					<th class="text-center">Title</th>
    					<th class="text-center">Conducted By</th>
    					<th class="text-center">Venue</th>
    					<th class="text-center">Start Date</th>
    					<th class="text-center">End Date</th>
              <th class="text-center">Status</th>
              
    				</tr>
    			</thead>

    			<tbody>
    			       <?php echo $trainee->getTrainingList($id);?>
    			</tbody>

    		</table>
      </div> <!-- end of panel body -->
      <div class="panel-footer"> <!-- start of panel footer -->

          <a href="view_trainees.php" class="btn btn-success btn-sm"><i class='fa fa-reply fa-1x'></i> Back</a>
          <div class="clearfix"></div>
      </div> <!-- end of panel footer -->
    </div> <!-- end of panel -->

	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->

<span class="invisible" id="d"><?php echo $id?></span>
<span class="invisible" id="n"><?php echo $name;?></span>

<?php 
  include("panels/confirm_dialog.php");
  include("includes/footer.php");
  include("includes/js_files.php"); 
?>

<script>
$(document).ready(function(){
//   	 $('[data-toggle="tooltip"]').tooltip();   
  var table =  $("#tbl_training_data").DataTable();
  var attendance_id = 0;
  var trainee_code = 0;
  var program_code = 0;
  var element;



  $("body").on("click",".btn_delete",function(){
      element = $(this);
      attendance_id = $(this).attr("data-id");
      trainee_code = $(this).attr("data-traineeCode");
      program_code=  $(this).attr('data-programCode');
      title = $(this).attr("data-title");
      name = $("#n").text();
      msg = "<p>Are you sure to delete <strong>" + title + 
            "</strong> from the trainings of <strong>"+name+"</strong>? Deleting this would also remove associated records such as workshops, attendance and exams. Click <i>Yes</i> to contiue and <i>Close</i> to cancel.</p>";
      $("#dialog_content").html(msg);
      $("#dialog_box").modal("show");
  });
  
  $("#dialog_btn_confirm").click(function(){
      $("#dialog_content").html("Please wait... <img src='../../../img/ajax-loader.gif' />");
      $("#dialog_btn_confirm").hide("slow");
      $.ajax({
          type:"POST",
          url:"php_processors/proc_delete_training_record.php",
          data:{
              attendance_id : attendance_id,
              trainee_code  : trainee_code,
              program_code  : program_code
          },
          success:function(response){
               $("#dialog_content").html("Training record deleted.");
               table.row(element.parents('tr')).remove().draw();
          }
      });
  });

   $('#dialog_box').on('hidden.bs.modal', function () {
        $("#dialog_btn_confirm").show();
    });
  
   $('[data-toggle="popover"]').popover(); 
   
    $("#navigation-top").children("li:nth-child(2)").addClass("active");
});
</script>

</body>
</html>