<?php 
	require_once("initialize.php"); 
  	require_once("includes/user_access.php");
  	require_once("includes/header_files.php");
  	$job = new Job();
  	
?>


<div id="container">
	<div class="page-wrapper">
		
		<h1>Departments</h1>
		<hr/>
		<div class="panel panel-primary">

			<div class="panel-heading text-center">Departments</div>

			<div class="panel-body">
				
				<table class="display  nowrap text-center table table-bordered table-striped" cellspacing="0" width="100%"  id="tbl_job_cat_data">
					<thead>
						<tr>
							<th class="text-center">Department</th>
							
							<th class="text-center">Action</th>
						</tr>
					</thead>
                    <tbody>
                     	<?php echo $job->getJobCategory();?>
                    </tbody>
					
				</table>
			</div>

			<div class="panel-footer">
				<a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#dialog_add"><i class="fa fa-user-plus fa-1x"></i> Add New</a>
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
        <h4 class="modal-title">Add Department</h4>
      </div>
      <div class="modal-body">

			<div class="alert alert-success fade in" style="display:none;" id="add_notif">
			    <button type="button" class="close" id="btn_hide">&times;</button>
				<span></span>
			</div>

      		<form class="form-horizontal">	
      	
				<div class="form-group">
					<label for="txt_category" class="control-label col-sm-3">Department Name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control input-sm col-sm-9" id="txt_category" name="txt_category" placeholder="Department Name"/>
						<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
						<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter department name</p>
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


<?php 
	include("panels/confirm_dialog.php"); 
	include("includes/footer.php");
	include("includes/js_files.php");
?>



<script>
	function resetRow(){
	  // hide all not edited but clicked rows
	    $(".j_cat").each(function(){
	        $(this).next().hide();
	        $(this).show();
	    });
	}

	$(document).ready(function(){
	    $("#navigation-top").children("li:nth-child(4)").addClass("active");
		var table = $("#tbl_job_cat_data").DataTable();
		var category_name = "";
		var isAdd = false;
		var element;
		var id;
		$("#btn_save").click(function(){
			category_name = $("#txt_category").val();
			
			$.ajax({
				type:"POST",
				data:{
					category : category_name
				},
				url:"ajax/add_job_category.php",
				success:function(response){
					location.reload();
				}
			});
		});

		$("body").on("dblclick",".j_cat",function(){
			resetRow();
			$(this).next().show();
			$(this).hide();
		});

		$("body").on("click",".btn_edit",function(){
  			var cat_id = $(this).data("id");
  			category_name = $(this).parent().prev().prev().val();
  			element = $(this);
  			var ajax_load = $(this).parent().prev();
  			ajax_load.show();
  			if(category_name != ""){
	            $.ajax({
	                type:"POST",
	                url:"ajax/update_job_category.php",
	                data : {
	                	id 	 : cat_id,
	                	name : category_name
	                },
	                success:function(response) {
	                	element.parent().parent().prev().text(category_name);
	                    ajax_load.hide();
	                    resetRow();
	                }
	            });
        	} else {
        		alert("Please enter category name.");
        		ajax_load.hide();
        	}
        });

		$("#dialog_add").on("hidden.bs.modal",function(){
			if(isAdd){
				location.reload();
			}
		});


		$("body").on("click",".btn_delete",function(){
	        element = $(this);
	        id = $(this).data("id");
	        $("#dialog_title").html("<i class='fa fa-warning fa-1x' style='color:#f1ab30;'></i> Confirmation");
	        $("#dialog_content").html("Are you sure to delete <strong>" + element.parent().prev().prev().find("span:first").text() + "</strong>? All associated jobs would also be deleted.");
	        $("#dialog_box").modal("show");
	    });

	    $("#dialog_btn_confirm").click(function(){
	        $("#dialog_content").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
	        $(this).hide("slow");
	        $.ajax({
	            type:"POST",
	            url:"ajax/delete_category.php",
	            data:{
	                id : id
	            },
	            success:function(response){
	                //$("#dialog_content").html(response);
	                //table.rows(element.parents('tr')).remove().draw();
	            	location.reload();
	            }
	        });
	    });

	    $("#dialog_box").on("hidden.bs.modal",function(){
	    	$("#dialog_btn_confirm").show();
	    });


	});
</script>

</body>
</html>