<?php
	require_once("initialize.php");
    require_once("includes/user_access.php");
    require_once("includes/header_files.php");
    $conn = new Connection();
    $trainor = new Trainor();
    $trainee = new Trainee();
    $trainor_sources = $trainor->getTrainorSources();
    $list_of_name_suffixes = $trainee->getNameSuffixesList();
?>

<div id="container">
	<div class="page-wrapper">
		
		<h1>Trainors</h1>
		<hr/>
		<div class="row">
			<div class="col-md-4">
				<div class="well well-sm">
					<h4>Source</h4>
					<hr/>

					<ul class="list-group" style="min-height:300px;max-height:300px;overflow-y:auto;">
					<?php
						foreach($trainor_sources as $source){
							$source = (object)$source;	
					?>
						<li class='list-group-item'>
							<!-- <a href="#" style="margin-right:1em;"><i class="fa fa-trash fa-1x"></i></a> -->
							<?php echo $source->source_name;?> 
						</li>
					<?php
						}
					?>
					</ul>

					<div class="input-group">
						<input type="text" class="form-control" placeholder="Add new source..." id="txt_source">
							<span class="input-group-btn">
						<button class="btn btn-primary" type="button" id="btn_add_source">Add</button>
						</span>
					</div><!-- /input-group -->

					<div class="clearfix"></div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="panel panel-primary">

					<div class="panel-heading text-center">Trainors</div>

					<div class="panel-body">
						<table class="display responsive nowrap text-center table table-bordered table-striped" cellspacing="0" width="100%"  id="tbl_trainors_list">
							<thead>
								<tr>
									<th class="text-center">Name</th>
									<th class="text-center">Source</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>

							<tbody>
								
							</tbody>
						</table>
					</div>

					<div class="panel-footer">
						<a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#dialog_add"><i class="fa fa-user-plus fa-1x"></i> Add New</a>
					</div>
				</div>
			</div>

		</div>
	</div> <!-- end of page content wrapper -->
</div> <!-- end of wrapper -->

<!-- add trainor dialog -->
<div class="modal fade" id="dialog_add">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add trainor</h4>
      </div>
      <div class="modal-body">

			<div class="alert alert-success fade in" style="display:none;" id="add_notif">
			    <button type="button" class="close" id="btn_hide">&times;</button>
				<span></span>
			</div>

      		<form class="form-horizontal" id="frm_add_trainor">	
      			
				<div class="form-group">
					<label for="txt_fname" class="control-label col-sm-3">First Name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control input-sm col-sm-9" id="txt_fname" name="txt_fname" placeholder="First Name"/>
						<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
						<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter first name</p>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_mname" class="control-label col-sm-3 ">Middle Name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control input-sm" id="txt_mname" name="txt_mname" placeholder="Middle Name"/>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_lname" class="control-label col-sm-3">Last Name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control input-sm" id="txt_lname" name="txt_lname" placeholder="Last Name"/>
						<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
						<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter last name</p>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_name_ext" class="control-label col-sm-3">Name Extension</label>
					<div class="col-sm-9">
						<select class='form-control input-sm' id="cbo_suffix" name="cbo_suffix">
								<option value=''>Select Suffix</option>
						<?php
							foreach($list_of_name_suffixes as $suffix){
								$suffix = (object)$suffix;
						?>
							<option value="<?php echo $suffix->id; ?>"><?php echo $suffix->suffix; ?></option>
						<?php
							}
						?>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_name_ext" class="control-label col-sm-3">Source</label>
					<div class="col-sm-9">
						<select class='form-control input-sm' id="sel_source_name" name="sel_source_name">
						<?php
							foreach($trainor_sources as $source){
								$source = (object)$source;	
						?>
							<option value="<?php echo $source->id;?>"><?php echo $source->source_name;?></option>
						<?php
							}
						?>
						</select>
					</div>
				</div>

      		</form>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-primary btn-sm" id="btn_save">Save</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- add trainor dialog -->
<div class="modal fade" id="dialog_edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update trainor information</h4>
      </div>
      <div class="modal-body">

			<div class="alert alert-success fade in" style="display:none;" id="edit_notif">
			    <button type="button" class="close" id="btn_edit_hide">&times;</button>
				<span></span>
			</div>

      		<form class="form-horizontal" id="frm_edit_trainor">	
      			
				<div class="form-group">
					<label for="txt_edit_fname" class="control-label col-sm-3">First Name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control input-sm col-sm-9" id="txt_edit_fname" name="txt_edit_fname" placeholder="First Name"/>
						<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
						<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter first name</p>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_edit_mname" class="control-label col-sm-3 ">Middle Name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control input-sm" id="txt_edit_mname" name="txt_edit_mname" placeholder="Middle Name"/>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_edit_lname" class="control-label col-sm-3">Last Name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control input-sm" id="txt_edit_lname" name="txt_edit_lname" placeholder="Last Name"/>
						<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
						<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter last name</p>
					</div>
				</div>

				<div class="form-group">
					<label for="cbo_update_suffix" class="control-label col-sm-3">Name Extension</label>
					<div class="col-sm-9">
						<select class='form-control input-sm' id="cbo_update_suffix" name="cbo_update_suffix">
								<option value=''>Select Suffix</option>
						<?php
							foreach($list_of_name_suffixes as $suffix){
								$suffix = (object)$suffix;
						?>
							<option value="<?php echo $suffix->id; ?>"><?php echo $suffix->suffix; ?></option>
						<?php
							}
						?>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_name_ext" class="control-label col-sm-3">Source</label>
					<div class="col-sm-9">
						<select class='form-control input-sm' id="update_sel_source_name" name="update_sel_source_name">
						<?php
							foreach($trainor_sources as $source){
								$source = (object)$source;	
						?>
							<option value="<?php echo $source->id;?>"><?php echo $source->source_name;?></option>
						<?php
							}
						?>
						</select>
					</div>
				</div>

				


      		</form>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-primary btn-sm" id="btn_update">Save</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php include("panels/confirm_dialog.php");

 include("includes/footer.php");
 include("includes/js_files.php"); ?>


<script>
$(document).ready(function(){
	//var table = $("#tbl_trainor_data").DataTable();

	var tbl_trainors_list = $('#tbl_trainors_list').DataTable({
	      "processing": true,
	      "serverSide": true,
	      "autoWidth":false,
	      "ajax":"ajax/dt_trainors_list.php"
	});

	var isAdd = false;
	var isUpdate = false;
	var element;
	var trainor_id = 0;
	var name = "";
	var new_name = "";
	validate_input("#txt_fname");
	validate_input("#txt_lname");
	validate_input("#txt_edit_fname");
	validate_input("#txt_edit_lname");
	$("#navigation-top").children("li:nth-child(4)").addClass("active");
	$("#btn_save").click(function(){
		isError = false;
		
		if($("#txt_fname").val() == ""){
			mark_error_input("#txt_fname");
			isError = true;
		}

		if($("#txt_lname").val() == ""){
			mark_error_input("#txt_lname");
			isError = true;
		}

		if(!isError){
			$.ajax({
				type:"POST",
				url:"ajax/add_trainor.php",
				data:{
					first_name : $("#txt_fname").val(),
					middle_name : $("#txt_mname").val(),
					last_name : $("#txt_lname").val(),
					name_ext : $("#cbo_suffix").val(),
					source_id : $("#sel_source_name").val()
				},
				success:function(response) {
					name_extens = "";
					if($("#cbo_suffix").val()!=""){
						name_extens = $("#cbo_suffix option:selected").text();
					}
					name = transformName("#txt_fname", "#txt_mname", "#txt_lname", name_extens);
					$("#add_notif span").html(name + " has been successfully added as a <em>Trainor</em>.");
					$("#add_notif").show("slow");
					$("#frm_add_trainor input").val("");
					$("#sel_source_name,#cbo_suffix").val("");
					tbl_trainors_list.draw();
				}
			});
		}

	});

	$("#btn_hide").click(function(){
		$(this).parent().hide("slow");
	});

	$("#dialog_add").on("hidden.bs.modal",function(){
		if(isAdd){
			location.reload();
		}
	});


	$("#dialog_edit").on("hidden.bs.modal",function(){
		if(isUpdate){
			location.reload();
		}
	});

	$("body").on("click",".btn_delete",function(){
		element = $(this);
		trainor_id = $(this).attr("data-id");
		name = $(this).data('name');
		$("#dialog_title").html("<i class='fa fa-warning fa-1x' style='color:#e9bf2d;'></i> Confirmation");
		$("#dialog_content").html("Are you sure to delete <strong>" + $(this).data('name') + "</strong> from the list of trainors?");
		$("#dialog_box").modal("show");
	});

	$("#dialog_btn_confirm").click(function(){
		$("#dialog_content").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
		$.ajax({
			type:"POST",
			data:{
				trainor_id : trainor_id
			},
			url:"php_processors/proc_delete_trainor.php",
			success:function(response){
				$("#dialog_btn_confirm").hide("slow");
				$("#dialog_content").html("<strong>" + name + "</strong>" + " has been deleted from the list of trainors.");
				table.row(element.parents('tr')).remove().draw();
			}
		});
	});

	$("#dialog_box").on("hidden.bs.modal",function(){
		$("#dialog_btn_confirm").show();
	});

	$("body").on("click",".btn_edit",function(){
		trainor_id = $(this).data("id");
		//name = $(this).data("name");
		$.ajax({
			type:"POST",
			url:"ajax/get_trainor_info.php",
			data:{
				trainor_id : trainor_id
			},
			success:function(response){
				var data = JSON.parse($.trim(response));
				$("#txt_edit_fname").val(data.first_name);
				$("#txt_edit_mname").val(data.middle_name);
				$("#txt_edit_lname").val(data.last_name);
				$("#cbo_update_suffix").val(data.name_extension);
				$("#update_sel_source_name").val(data.trainor_source_id);
				$("#dialog_edit").modal("show");	
			}
		});
	});

	$("#btn_update").click(function(){
		isError = false;
		
		if($("#txt_edit_fname").val() == ""){
			mark_error_input("#txt_edit_fname");
			isError = true;
		}

		if($("#txt_edit_lname").val() == ""){
			mark_error_input("#txt_edit_lname");
			isError = true;
		}

		if(!isError){
			
			$.ajax({
				type:"POST",
				url:"ajax/update_trainor.php",
				data:{
					trainor_id : trainor_id,
					fname : $("#txt_edit_fname").val(),
					mname : $("#txt_edit_mname").val(),
					lname : $("#txt_edit_lname").val(),
					name_ext : $("#cbo_update_suffix").val(),
					trainor_source_id : $("#update_sel_source_name").val()
				},
				success:function(response){
					tbl_trainors_list.draw();
					$("#dialog_edit").modal("hide");
				}
			});
		}
	});

	
	$("#btn_add_source").click(function(){
		if($("#txt_source").val()!=""){
			$.ajax({
				type:"POST",
				data:{
					source_name : $("#txt_source").val()
				},
				url:"ajax/add_trainor_source.php",
				success:function(response){
					location.reload();
				}
			});
		}
	});
});
</script>

</body>
</html>