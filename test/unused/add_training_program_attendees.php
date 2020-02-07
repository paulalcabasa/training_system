<?php
	require_once("initialize.php");
    require_once("includes/user_access.php");
    $dec_tp_id = $conn->encryptor("decrypt",$_GET['d']);
    $program_details = $program->getTrainingProgramDetails($dec_tp_id);
    $trainor =  $conn->transformName1($program_details['first_name'],$program_details['middle_name'],$program_details['last_name'],$program_details['suffix'],$conn) . "</td>";
    $added_trainees = $program->getAddedTrainees($trainee,$dec_tp_id);
    $trainees_list = $program->getListOfTrainees($trainee,$dec_tp_id);
    include("includes/header_files.php");
?>
    
<div id="container">
	
	<div class="page-wrapper">
		
		<h1>Training Programs</h1>
		<hr/>
        <div class="alert alert-info">
            <div class="col-md-6">
                <table>
                    <tr>
                        <td>Program Title</td>
                        <td> : <strong><?php echo $program_details['title'];?></strong></td>
                    </tr>
                     <tr>
                        <td>Trainor</td>
                        <td> : <strong><?php echo $trainor?></strong></td>
                    </tr>
                    <tr>
                        <td>Venue</td>
                        <td> : <strong><?php echo $program_details['venue']?></strong></td>
                    </tr>
                     <tr>
                        <td>Start Date</td>
                        <td> : <strong><?php echo $conn->format_date_only($program_details['start_date']);?></strong></td>
                    </tr>
                      <tr>
                        <td>End Date</td>
                        <td> : <strong><?php echo $conn->format_date_only($program_details['end_date']);?></strong></td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6">
                <?php if($added_trainees[1] > 0) { ?>
                <span>Added Trainees <span class="label label-primary"><?php echo $added_trainees[1];?></span></span>
                <ul class="list-group" style="height:100px;overflow-y:auto;margin-bottom:0;">
                    <?php echo $added_trainees[0];?>
                </ul>
                <?php } ?>
            </div>

        
            <div class="clearfix"></div>
        </div>
	  <div class="panel panel-primary">  <!-- start of panel -->
      <div class="panel-heading"><!-- <select style='color:#000;'><option value='all'>All</option><option value='s'>Suggested</option></select> --> Trainees</div> <!-- start of panel heading -->
    	
        <div class="panel-body"> <!-- start of panel body -->
          
            <table class="display responsive nowrap text-center table table-bordered table-striped" id="trainees_list">

                <thead>
                    <tr>
                        <th>Trainee ID</th>
                        <th>Trainee</th>
                        <th>Dealer Name</th>
                        <th>Job Position</th>
                        <th>Add</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php echo $trainees_list;?>
                </tbody>
            </table>
        </div> <!-- end of panel body -->

    
    </div> <!-- end of panel -->

	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->
<input type="hidden" value="<?php echo $program_details['program_id'];?>" id="txt_program_id"/>

<?php 
    include("panels/information_dialog.php");
    include("includes/footer.php");
    include("includes/js_files.php");
?>

<script>
$(document).ready(function(){
    $("#trainees_list").DataTable();

    $("body").on("click",".btn_add_trainee",function(){
        var trainee_id = $(this).data("trainee_id");
        var tp_id = $(this).data("tp_id");
        $("#dialog_info_title").html("Information");
        $("#dialog_info_content").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
        $("#dialog_info").modal({
            backdrop:"static",
            keyboard:false
        });
        $("#dialog_info button").hide();
        $.ajax({
            type:"POST",
            data:{
                trainee_id : trainee_id,
                tp_id      : tp_id,
                program_id : $("#txt_program_id").val()
            },
            url:"php_processors/proc_add_attendee.php",
            success:function(response){
               // $("#dialog_info_content").html(response);
                // $("#dialog_info button").show();
                location.reload();
            }
        });
    });

    $("#dialog_info").on("hidden.bs.modal",function(){
        location.reload();
    });
});
</script>

</body>
</html>