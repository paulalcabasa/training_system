<?php
	require_once("initialize.php");
    require_once("includes/user_access.php");
    $program = new Program();
    $trainingprogram = new TrainingProgram();
    $exam = new Exam();
    $encryption = new Encryption();
    $training_program_id = $get->tp_id;
    $dec_tp_id = $encryption->decrypt($training_program_id);
    $program_details = $trainingprogram->getTrainingProgramDetails($dec_tp_id);
    $exam_id = $encryption->decrypt($get->d);
   	$exam_details = $exam->getExamDetails($exam_id);
   	$total_items = count($exam->getExamQuestionsList($exam_id));
   	$passing_score = $exam_details->passing_score;
    require_once("includes/header_files.php");
?>
<div id="container">
	<div class="page-wrapper">
		<h1>Training Program Examination</h1>
		<hr/>
		
		<div class="row">
			<div class="col-md-6">
				<div class="well" style="min-height:200px;overflow-y:auto;">
					<fieldset>
						<legend style="font-size:12pt;">Training program details</legend>
						<div class="row">
							<span class="col-xs-4 text-bold">Program Title</span>
							<span class="col-xs-8"><?php echo $program_details->title; ?></span>
						</div>
						<div class="row">
							<span class="col-xs-4 text-bold">Trainor</span>
							<span class="col-xs-8"><?php echo $program_details->trainor_name; ?></span>
						</div>
						<div class="row">
							<span class="col-xs-4 text-bold">Venue</span>
							<span class="col-xs-8"><?php echo $program_details->venue; ?></span>
						</div>
						<div class="row">
							<span class="col-xs-4 text-bold">Start date</span>
							<span class="col-xs-8"><?php echo Format::format_date($program_details->start_date); ?></span>
						</div>
						<div class="row">
							<span class="col-xs-4 text-bold">End date</span>
							<span class="col-xs-8"><?php echo Format::format_date($program_details->end_date); ?></span>
						</div>
					</fieldset>
				</div>
			</div>
			<div class="col-md-6">
				<div class="well" style="min-height:200px;overflow-y:auto;">
					<fieldset>
						<legend style="font-size:12pt;">Examination details</legend>
						<div class="row">
							<span class="col-xs-4 text-bold">Module</span>
							<span class="col-xs-8"><?php echo $exam_details->module_name; ?></span>
						</div>
						<div class="row">
							<span class="col-xs-4 text-bold">Exam</span>
							<span class="col-xs-8"><?php echo $exam_details->exam; ?></span>
						</div>
						<div class="row">
							<span class="col-xs-4 text-bold">Passing score</span>
							<span class="col-xs-8"><span id="lbl_passing_score"><?php echo $passing_score; ?></span>%</span>
						</div>
						<div class="row">
							<span class="col-xs-4 text-bold">Total Items</span>
							<span class="col-xs-8"><span id="lbl_total_items"><?php echo $total_items; ?></span></span>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="well" style="min-height:300px;">
					<fieldset>
						<legend style="font-size:12pt;">Training Program Attendees</legend>
						<table class="table display table-striped table-condensed table-hover" id="tbl_attendees_list">
							<thead>
								<tr>
									<th class="no-sort">
										<div class="checkbox checkbox-danger">
										 	<input type="checkbox" id="cb_checkall" class="styled styled-primary" />
					                        <label> </label>
					                    </div>
					                </th>
									<th class="no-sort">Trainee ID</th>
									<th class="no-sort">Name</th>
								</tr>
							</thead>

							<tbody>
							<?php
								$training_program_attendees = $trainingprogram->getTrainingProgramAttendees($dec_tp_id);

								foreach($training_program_attendees as $attendee){
									$attendee = (object)$attendee;
							?>
								<tr class="pointer_hover">
									<td>
										<div class="checkbox checkbox-danger">
					                        <input type="checkbox" value="<?php echo $attendee->trainee_id . ';' . $attendee->id; ?>" data-tpa_id="<?php echo $attendee->id;?>" class="cb_attendee styled styled-danger">
					                        <label></label>
					                    </div>
				                    </td>
									<td class="row_select_trainee"><?php echo $attendee->trainee_code?></td>
									<td class="row_select_trainee"><?php echo $attendee->trainee_name?></td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
					</fieldset>
					
					<br/>
					<button type="button" class="btn btn-primary pull-right btn-sm" id="btn_add_selected">Add selected <span class="badge">0</span></button>
					<div class="clearfix"></div>
				</div>

	  		</div>

			<div class="col-md-8">
				<div class="panel panel-primary" style="min-height:465px;">  <!-- start of panel -->
			      	<div class="panel-heading">Examinees List</div> <!-- panel heading -->
			        <div class="panel-body"> <!-- start of panel body -->
			            <table class="display responsive nowrap text-center table table-bordered table-striped" id="tbl_examinees" width="100%" cellspacing="0">
			                <thead>
			                    <tr>
			                        <th>Exam No</th>
			                        <th>Trainee ID</th>
			                        <th>Name</th>
			                        <th>Score</th>
			                        <th>Remarks</th>
			                        <th>Set Answers</th>
			                    </tr>
			                </thead>
			                <tbody>	
			               	<?php
			               		$examinees_list_detailed = $exam->getExamineesListByExamDetails($exam_id);
			               		foreach($examinees_list_detailed as $examinee){
			               			$examinee = (object)$examinee;
			               			$percentage_score = ($examinee->score / $total_items) * 100;
			               			$enc_trainee_exam_taken_id = $encryption->encrypt($examinee->id);
			               			$trainee_exam_answers = $exam->getTraineeExamAnswers($examinee->id);
	            					$remarks = $exam->getExamRemarks(
	            						count($trainee_exam_answers),
	            						$total_items,
	            						$percentage_score,
	            						$passing_score
	            					);
           
			               	?>
			               		<tr>
			               			<td><?php echo $examinee->exam_no; ?></td>
			               			<td><?php echo $examinee->trainee_id; ?></td>
			               			<td><?php echo $examinee->trainee_name; ?></td>
			               			<td><?php echo "<strong>" . $examinee->score . "/" . $total_items . "</strong> <em>(" . Format::to_decimal($percentage_score) ."%)</em>"; ?></td>
			               			<td><?php echo $remarks; ?></td>
			               			<td><a href='exam_set_answer.php?<?php echo "d=$get->tp_id&t=$enc_trainee_exam_taken_id";?>'>Set answer</a></td>
			               		</tr>
			               	<?php
			               		}
			               	?>
			                </tbody>
			            </table>
			        </div> <!-- end of panel body -->

			       <!--  <div class="panel-footer">
			            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#dialog_add_exam"><i class='fa fa-plus-circle fa-1x'></i> Create Exam</button>
			        </div> -->
			    
			    </div> <!-- end of panel -->
	  		</div>
	  		</div>

	</div> <!-- end of page content wrapper -->
</div> <!-- end of container -->

<input type="hidden" value="<?php echo $dec_tp_id; ?>" id="txt_tp_id" />
<input type="hidden" value="<?php echo $exam_id; ?>" id="txt_exam_id" />

<?php 
    include("panels/confirm_dialog.php");
    include("includes/footer.php");
    include("includes/js_files.php");
?>
<script>

function countSelected(){
	var ctr = 0;
	$(".cb_attendee").each(function(ev){
		if($(this).is(":checked")){
			ctr++;
		}
	});
	$("#btn_add_selected span").text(ctr);
}

$(document).ready(function(){
	
	var tp_id = $("#txt_tp_id").val();
	var exam_id = $("#txt_exam_id").val();
	var total_items = $("#lbl_total_items").text();
	var passing_score = $("#lbl_passing_score").text();

	var tbl_attendees_list = $("#tbl_attendees_list").DataTable( {
        "scrollY":        "300px",
        "scrollCollapse": true,
        "paging":         false,
        "ordering": false,
		"info":     false,
		 "dom": '<lf<t>ip>'
    });


    var tbl_examinees_list = $('#tbl_examinees').DataTable({
      //  "processing": true,
      //  "serverSide": true,
        "autoWidth":false,
     /*   "ajax": {
        	"url"	: "ajax/dt_get_examinees.php?exam_id="+exam_id+"&tp_id="+tp_id+"&total_items="+total_items+"&passing_score="+passing_score,
        	"type" : "get"
        },*/
        "paging":   false,
        "ordering": true,
		"info": true,
    });


    $(".cb_attendee").change(function(){
    	countSelected();
    });

    $("#cb_checkall").click(function(){
    	if($(this).is(":checked")){
    		$(".cb_attendee").prop("checked","true");
    	}
    	else {
    		$(".cb_attendee").removeAttr("checked");
    	}
    	countSelected();
    });

    $("body").on("click",".row_select_trainee",function(){
    	var child_cb = $(this).parent().children().find(".cb_attendee");
    	if(child_cb.is(":checked")){
    		child_cb.removeAttr("checked");
    	}
    	else {
    		child_cb.prop("checked","true");
    	}
    	countSelected();
    });

    $("#btn_add_selected").click(function(){
    	var selected_attendees = [];
    	var index = 0;
    
    	$(".cb_attendee").each(function(){
    		if($(this).is(":checked")){
    			selected_attendees[index] = $(this).val();
    			index++;
    		}
    	});
        if(index != 0){
			$.blockUI({ 
				message: '<h1>Processing... <img src="../../../img/ajax-loader.gif" height="30"/></h1>' 
			});
    		$.ajax({
    			type:"POST",
    			data:{
    				exam_id : exam_id,
    				tp_id   : tp_id,
    				selected_attendees : selected_attendees
    			},
    			url:"ajax/add_examinees.php",
    			success:function(response){
    				$.unblockUI({ fadeOut: 1500 }); 
                	location.reload();
    			}
    		});
    	}
    });


});

</script>
</body>
</html>