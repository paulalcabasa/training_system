<?php
	require_once("initialize.php");
	require_once("includes/user_access.php");
	require_once("includes/header_files.php"); 
	
	$program = new Program();
	$program_category_list = $program->getProgramCategoryList();
 ?>


<div id="container">
	<div class="page-wrapper">
		
		<h1>New Program</h1>
		<hr/>
		<form role="form" class="form-horizontal" enctype="multipart/form-data" id="frm_program_info" name="frm_program_info"> <!-- start of form-->
			<div class="panel panel-info"> <!-- start of panel -->
				<div class="panel-body"> <!-- start of body -->
					
					
						<div class="col-md-7"> <!-- start of left side -->
						
							<div class="form-group">
								<label class="control-label col-md-3">Program Category</label>
								<div class="col-md-9">
									<select class="form-control input-sm" id="category" name="category">
									<?php
										foreach($program_category_list as $program_category){
											$program_category = (object)$program_category;
									?>
										<option value="<?php echo $program_category->program_category_id;?>"><?php echo $program_category->category_name;?></option>
									<?php 
										}
									?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Program Title</label>
								<div class="col-md-9">
									<input type="text" class="form-control input-sm" placeholder="Program Title" id="txt_title" name="txt_title"/>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Description</label>
								<div class="col-md-9">
									<div id="txt_description" name="txt_description"></div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Objectives</label>
								<div class="col-md-9">
									<div id="txt_objectives" name="txt_objectives"></div>
								</div>
							</div>

						</div> <!-- end of left side -->

						<div class="col-md-5"> <!-- start of right side -->

							<div class="form-group">
								<label class="control-label col-md-3">Modules</label>
								<div class="col-md-9">
									<div class="input-group">
										<input type="text" class="form-control input-sm" id="txt_component"/>
										<span class="input-group-btn">
											<button type="button" class="btn btn-primary btn-sm" id="btn_add_component">Add</button>
										</span>
									</div>

									<div style="height:150px;overflow-y:auto;">
										<ul class="list-group" id="list_of_components">
										</ul>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Presentation Materials</label>
								<div class="col-md-9">
									<input type="file" name="files[]" id="files" multiple />
								</div>
							</div>

						</div> <!-- end of left side -->

						<div class="row">
							<div class="form-group">
								<div class="col-md-9 col-md-offset-3">
								
							</div>
						</div>
				</div> <!-- end of panel-body-->

				<div class="panel-footer">
					<button type="button" class="btn btn-primary pull-right" id="btn_save"><i class="fa fa-save fa-1x"></i> Save</button>
					<div class="clearfix"></div>
				</div>

			</div> <!-- end of panel main -->

		</form> <!-- end of form -->

	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->

<?php 
	include("panels/information_dialog.php");
	include("includes/footer.php");
	include("includes/js_files.php");
?>


<script>
$(document).ready(function(){
   	
   	$("#category").select2();

	$("#txt_description,#txt_objectives").summernote({
		height: 100,                 // set editor height
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

	$("#btn_add_component").click(function(){
		new_item = $("#txt_component").val();
		$("#list_of_components").append("<li class='list-group-item' data-toggle='tooltip'><span class='itm_component'>" + new_item + "</span><button type='button' class='btn btn-danger btn-xs pull-right btn_remove'>Remove</button></li>");
		$("#txt_component").val("").focus();
	});

	$("body").on("click",".btn_remove",function(){
		$(this).parent().remove();
	});


	$("#btn_save").click(function(e){
		var category = $("#category").val();
		var title = $("#txt_title").val();
		var description = $("#txt_description").code();
		var objectives = $("#txt_objectives").code();
		var components = [];
		var ctr = 0;
		var formData = new FormData($("#frm_program_info")[0]);
		formData.append("description",description);
		formData.append("objectives",objectives);
		$(".itm_component").each(function(){
			formData.append("modules[]",$(this).text());
			ctr++;
		});
		formData.append("module_ctr",ctr);
		var msg = "<ul><strong>Please note that: </strong>";
		$("#dialog_info_title").text("Information");
		$("#dialog_info_content").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
		$("#dialog_info").modal("show");
	
		$.ajax({
			type:"POST",
			url:"ajax/add_program.php",
			data:formData,
			cache: false,
    		contentType: false,
    		processData: false,
			success:function(response){
				
				$("#dialog_info_content").html("<ul>" + response + "</ul>");        
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