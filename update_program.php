<?php
	require_once("initialize.php");
	$program = new Program();
    $encryption = new Encryption();
	$program_code = $encryption->decrypt($get->d);
	$program_category_list = $program->getProgramCategoryList();
	$details = $program->getProgramDetails($program_code);

	require_once("includes/header_files.php");
?>


<div id="container">
	<div class="page-wrapper">
		
		<h1>Update Program</h1>
		<hr/>
		<form role="form" class="form-horizontal" enctype="multipart/form-data" id="frm_program_info" name="frm_program_info"> <!-- start of form-->
			<input type="hidden" id="txt_program_code" name="txt_program_code" value="<?php echo $program_code; ?>"/>
			<div class="panel panel-info"> <!-- start of panel -->
				<div class="panel-body"> <!-- start of body -->
					
					
						<div class="col-md-7"> <!-- start of left side -->
						
							<div class="form-group">
								<label class="control-label col-md-3">Program Category</label>
								<div class="col-md-9">
									<select class="form-control" id="category" name="category">
									<?php
										foreach($program_category_list as $program_category){
											$program_category = (object)$program_category;
											$is_selected = $program_category->program_category_id == $details->program_category_id ? "selected" : "";
									?>

										<option value="<?php echo $program_category->program_category_id;?>" <?php echo $is_selected;?> ><?php echo $program_category->category_name;?></option>
									<?php 
										}
									?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Program Title</label>
								<div class="col-md-9">
									<input type="text" class="form-control" placeholder="Program Title" id="txt_title" name="txt_title" value="<?php echo $details->title;?>"/>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Description</label>
								<div class="col-md-9">
									<div id="txt_description" name="txt_description"><?php echo $details->description;?></div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Objectives</label>
								<div class="col-md-9">
									<div id="txt_objectives" name="txt_objectives"><?php echo $details->objectives;?></div>
								</div>
							</div>

						</div> <!-- end of left side -->

				</div> <!-- end of panel-body-->

				<div class="panel-footer">
					<button type="button" class="btn btn-primary btn-sm" id="btn_save"><i class="fa fa-save fa-1x"></i> Save changes</button>
					
				</div>

			</div> <!-- end of panel main -->

		</form> <!-- end of form -->

	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->

<!-- category id for the program -->


<?php 
	include("includes/footer.php");
	include("includes/js_files.php");
?>

<script>
$(document).ready(function(){
   	
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

  	$("#btn_save").click(function(e){
  		$.ajax({
  			type:"POST",
  			url:"ajax/update_program.php",
  			data:{
  				program_code : $("#txt_program_code").val(),
  				category 	 : $("#category").val(),
  				title    	 : $("#txt_title").val(),
  				description  : $("#txt_description").code(),
  				objectives 	 : $("#txt_objectives").code()
  			},
  			success:function(response){
  				window.location.href = "view_programs_modules.php";
  			}
  		});
  	});

  	$("#category").select2();
});
</script>

</body>
</html>