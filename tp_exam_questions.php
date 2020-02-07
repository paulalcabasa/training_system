<?php
	require_once("initialize.php");
	$program = new Program();
    $trainingprogram = new TrainingProgram();
    $encryption = new Encryption();
    $exam = new Exam();
	$tp_id = $encryption->decrypt($get->d);
	$exam_id = $encryption->decrypt($get->e);
	$program_details = $trainingprogram->getTrainingProgramDetails($tp_id);
	$exam_details = $exam->getExamDetails($exam_id);
	include("includes/header_files.php");
?>
<div id="container">
	<div class="page-wrapper">
		<h1>Training Program Examinations</h1>
		<hr/>
		<div class="row">
			<div class="col-md-4">
				<div class="well">
                    <fieldset>
                        <legend style="font-size:12pt;">Training Program Details</legend>
                    </fieldset>
                    <div class="row">
                        <p class="col-md-12">
                            <span class="text-bold">Training Program ID</span><br/>
                            <span><?php echo $program_details->tp_id;?></span>
                        </p>
                        <p class="col-md-12">
                            <span class="text-bold">Program Title</span><br/>
                            <span><?php echo $program_details->title;?></span>
                        </p>
                        <p class="col-md-12">
                            <span class="text-bold">Trainor</span><br/>
                            <span><?php echo $program_details->trainor_name;?></span>
                        </p>
                        <p class="col-md-12">
                            <span class="text-bold">Venue</span><br/>
                            <span><?php echo $program_details->venue;?></span>
                        </p>
                        <p class="col-md-12">
                            <span class="text-bold">Date</span><br/>
                            <span><?php echo "From " . Format::format_readable_date_only($program_details->start_date) . " to " . Format::format_readable_date_only($program_details->end_date);?></span>
                        </p>
                        <div class="clearfix"></div>
                    </div>
            	</div>
            	<div class="well">
                    <fieldset>
                        <legend style="font-size:12pt;">Examination Details</legend>
                    </fieldset>
                    <div class="row">
                        <p class="col-md-12">
                            <span class="text-bold">Module</span><br/>
                            <span><?php echo $exam_details->module_name;?></span>
                        </p>
                        <p class="col-md-12">
                            <span class="text-bold">Exam</span><br/>
                            <span><?php echo $exam_details->exam;?></span>
                        </p>
                         <p class="col-md-12">
                            <span class="text-bold">Passing Score</span><br/>
                            <span><?php echo $exam_details->passing_score;?>%</span>
                        </p>
                        <div class="clearfix"></div>
                    </div>
            	</div>
			</div>
			<div class="col-md-8">
				<div class="panel panel-primary">  <!-- start of panel -->
					<div class="panel-heading">Questionnaire</div> <!-- start of panel heading -->	
					<div class="panel-body"> <!-- start of panel body -->
						<table class="display text-center table table-bordered table-striped" width="100%" id="tbl_exam_questions_data">
							<thead>
								<tr>
									<th>No.</th>
									<th>Question</th>
									<th>Answer</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>

					</div> <!-- end of panel body -->
					<div class="panel-footer">
						<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-backdrop="static" data-target="#dialog_add_question">Add Question</button>
					</div>
				</div> <!-- end of panel -->
			</div>
		</div>
		<div class="clearfix"></div>
	</div> <!-- end of page content wrapper -->
</div> <!-- end of wrapper -->


<!-- dialog for adding an exam -->
<div class="modal fade" tabindex="-1" role="dialog" id="dialog_add_question">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header"><!-- header  -->
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Add Question</h4>
	  </div> <!-- end of header -->
	  <div class="modal-body"><!-- body -->
		  <p class="bg-danger" id="notif" style="padding:.5em;display:none;"></p>
			<form>
				<div class="form-group">
					<label>Question</label>
					<textarea class="form-control" id="txt_question"></textarea>
				</div>
				<p style="font-weight:bold;">Choices : </p>
				<ol  type="a" id="choice_list" >
					<?php
						for($i=1;$i<=4;$i++){
					?>
					<li>
						<div class="form-group">
							<div class="input-group">
								<input type="text" class="form-control choice_txt"/>
								<span class="input-group-addon">
									<input type="radio" name="q_choices" class="q_choices"/>
								</span>
								 <span class="input-group-btn">
									<button class="btn btn-danger btn_remove_choice" type="button"><i class="fa fa-trash fa-1x"></i></button>
								</span>
							</div>
						</div> 
					</li>
				 	<?php
				 		}
				 	?>
				 </ol>
			</form>
			<div class="clearfix"></div>
	  </div>
	  <div class="modal-footer"><!-- footer -->
		 <button type="button" class="btn btn-success btn-sm" id="btn_add_choice">Add a choice</button>
		 <button type="button" class="btn btn-danger btn-sm" id="btn_clear">Clear</button>
		 <button type="button" class="btn btn-primary btn-sm" id="btn_save">Save</button>
	  </div>
	</div>
  </div>
</div>

<!-- dialog for changing the question -->
<div class="modal fade" tabindex="-1" role="dialog" id="dialog_update_question">
  <div class="modal-dialog">
	<div class="modal-content">
		<!-- header  -->
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Update Question</h4>
	  </div>
	  <!-- body -->
	  <div class="modal-body">
			<p class="bg-danger" id="edit_notif" style="padding:.5em;display:none;"></p>
			<form>
				<div class="form-group">
					<label>Question</label>
					<textarea class="form-control" id="txt_update_question"></textarea>
				</div>
			</form>
			
	  </div>
	  <!-- footer -->
	  <div class="modal-footer">
		 <button type="button" class="btn btn-primary btn-sm" id="btn_update_question">Save Changes</button>
	  </div>


	</div>
  </div>
</div>

<!-- dialog for changing the choices -->
<div class="modal fade" tabindex="-1" role="dialog" id="dialog_update_choices">
  <div class="modal-dialog">
	<div class="modal-content">
		<!-- header  -->
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Update Choices</h4>
	  </div>
	  <!-- body -->
	  <div class="modal-body">
			<div class="alert alert-info alert-dismissible" id='edit_choice_notif' role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class='info'></span>
			</div>
	  		
			<ol type="a" id="update_choice_list"></ol>
	  </div>
	  <!-- footer -->
	  <div class="modal-footer">
		 <button type="button" class="btn btn-success btn-sm" id="btn_new_choice_add">Add a choice</button>
	  </div>
	</div>
  </div>
</div>

<!-- global variables -->
<input type="hidden" value="<?php echo $exam_id?>" id="txt_exam_id"/>
<?php 
	include("panels/confirm_dialog.php"); 
	include("panels/information_dialog.php"); 
	include("includes/footer.php");
	include("includes/js_files.php");
?>

<script>
$(document).ready(function(){
	var exam_id = $("#txt_exam_id").val();
	$('[data-toggle="popover"]').popover();
  	var tbl_exam_questions_data = $("#tbl_exam_questions_data").DataTable({
	  	"processing": true,
	    "serverSide": true,
	    "autoWidth":false,
	    "ajax":"ajax/dt_get_exam_questions.php?exam_id=" + exam_id,
	    "paging":   true,
  		"columnDefs": [
    		{ "width": "5%", "targets": 0 },
    		{ "width": "50%", "targets": 1 },
    		{ "width": "25%", "targets": 2 },
    		{ "width": "5%", "targets": 3 }
  		]
  	});
	var isSubmit = false;
	var exam_id = $("#txt_exam_id").val();
	var item_id = 0;
	$("#navigation-top").children("li:nth-child(3)").addClass("active");

	$("body").on("click",".btn_remove_choice",function(){
		$(this).parent().parent().parent().parent().remove();
	});

	$("#btn_add_choice").click(function(){
		new_choice = "";
		new_choice += "<li><div class='form-group'><div class='input-group'>";
		new_choice += "<input type='text' class='form-control choice_txt'/>";
		new_choice += "<span class='input-group-addon'><input type='radio' name='q_choices' class='q_choices'/></span>";
		new_choice += "<span class='input-group-btn'><button class='btn btn-danger btn_remove_choice' type='button'><i class='fa fa-trash fa-1x'></i></button></span></div></div></li>";
		$("#choice_list").append(new_choice);
	});

	$("#btn_clear").click(function(){
		$("#txt_question").val("");
		$(".choice_txt").val("");
		$(".q_choices").prop("checked","");
		$("#notif").html("").hide();
		$("#notif").removeClass("bg-primary");
		$("#notif").removeClass("bg-success");
		$("#notif").addClass("bg-danger");
	});

	$("#btn_save").click(function(){
		var question = $("#txt_question").val();
		var choices = [];
		var errorCtr = 0;
		if(question==""){
			$("#notif").html("Please enter the question.").show();
			errorCtr++;
		}
		else {
			var index = 0;
			var correctCtr = 0;
			$("#choice_list .choice_txt").each(function(){
				if($(this).val()!=""){
					var isCorrect = $(this).siblings().find(".q_choices").prop("checked");
					choices[index] = {"choice" : $(this).val(),"isCorrect" : isCorrect};
					index++;
					isError = false;
					if(isCorrect){
						correctCtr++;
					}
				}
				else {
					$("#notif").html("Please do not leave blank choices.").show();
					isError = true;
				}
			});
			if(correctCtr == 0){
				$("#notif").html("Please select the correct answer.").show();
				errorCtr++;
			}
			if(errorCtr == 0){
				$("#btn_clear,#btn_add_choice,#btn_save").hide();
				$("#notif").html("Please wait... <img src='../../../img/ajax-loader.gif'/>").show();
				$("#notif").addClass("bg-primary");
				$("#notif").removeClass("bg-danger");
				choices = JSON.stringify(choices);
				$.ajax({
					type:"POST",
					data:{
						exam_id  : exam_id,
						question : question,
						choices  : choices
					},
					url:"ajax/add_exam_item.php",
					success:function(response){
						tbl_exam_questions_data.draw();
						$("#notif").removeClass("bg-primary");
						$("#notif").addClass("bg-success");
						$("#notif").html(response).show();
						$("#btn_clear,#btn_add_choice,#btn_save").show();
						setTimeout(function(){
							$("#notif").html("").hide();
							$("#notif").removeClass("bg-primary");
							$("#notif").removeClass("bg-success");
							$("#notif").addClass("bg-danger");
						},5000);
						isSubmit = true;
					}
				});
			}
		}
	});

	$("body").on("change",".cbo_answer",function(){
		$("#dialog_info_title").html("Change Answer");
		$("#dialog_info_content").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
		$("#dialog_info").modal({backdrop:'static'});
		var item_id = $(this).find("option:selected").data("item_id");
		var answer_text = $(this).find("option:selected").text();
		var new_answer = $(this).val();
		$.ajax({
			type:"POST",
			data:{
				item_id    : item_id,
				choice_id : new_answer
			},
			url:"ajax/update_answer.php",
			success:function(response){
				$("#dialog_info_content").html(response + " <strong>" + answer_text +"</strong>.");
			}
		});
	});

	$("body").on("click",".btn_pop_update",function(){
		item_id = $(this).data("id");
		$("#edit_notif").hide();
		$("#txt_update_question").val($(this).data("question"));
		$("#dialog_update_question").modal("show");
	});

	$("#btn_update_question").click(function(){
		if($("#txt_update_question").val()=="") {
			$("#edit_notif").html("Please enter the question.").show();
		}
		else {
			$("#edit_notif").html("Please wait... <img src='../../../img/ajax-loader.gif'/>").show();
			$("#edit_notif").removeClass("bg-danger");
			$("#edit_notif").addClass("bg-primary");
			$.ajax({
				type:"POST",
				data:{
					item_id : item_id,
					question : $("#txt_update_question").val()
				},
				url:"ajax/update_question.php",
				success:function(response){
					$("#edit_notif").html(response).show();
					$("#edit_notif").removeClass("bg-primary");
					$("#edit_notif").addClass("bg-success");
					tbl_exam_questions_data.draw();
				}
			});
		}
	});

	$("body").on("click",".btn_pop_choice",function(){
		$("#dialog_update_choices").modal("show");
		item_id = $(this).data("item_id");
		$.ajax({
			type:"POST",
			data:{
				item_id : item_id
			},
			url:"ajax/get_exam_choices.php",
			success:function(response){
				$("#edit_choice_notif").hide();
				$("#update_choice_list").html(response);
			}
		});
		
	});

	$("body").on("click",".btn_update_choice",function(){
		var choice_id = $(this).data("id");
		var choice = $(this).parent().siblings(".update_choice_txt").val();
		$("#edit_choice_notif span[class=info]").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
		$("#edit_choice_notif").show();

		$.ajax({
			type:"POST",
			data:{
				choice_id : choice_id,
				choice : choice
			},
			url:"ajax/update_choice.php",
			success:function(response){
				$("#edit_choice_notif span[class=info]").html(response);
				isSubmit = true;
			}
		});
	});

	$("body").on("click",".btn_delete_choice",function(){
		var element = $(this);
		var choice_id = $(this).data("id");
		var choice = $(this).parent().siblings(".update_choice_txt").val();
		$("#edit_choice_notif span[class=info]").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
		$("#edit_choice_notif").show();

		$.ajax({
			type:"POST",
			data:{
				choice_id : choice_id,
				choice : choice
			},
			url:"ajax/delete_choice.php",
			success:function(response){
				element.parent().parent().parent().parent().remove();
				$("#edit_choice_notif span[class=info]").html(response);
			}
		});
	});

	$("#btn_new_choice_add").click(function(){
		$("#edit_choice_notif span[class=info]").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
		$.ajax({
			type:"POST",
			data:{
				item_id : item_id
			},
			url:"ajax/add_new_choice.php",
			success:function(response){
				$("#edit_choice_notif span[class=info]").html("<strong>New choice</strong> has been added.");
				$("#edit_choice_notif").show();
				$("#update_choice_list").append(response);
			
			}
		});
	});

});
</script>

</body>
</html>