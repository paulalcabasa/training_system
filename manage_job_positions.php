<?php
	
	require_once("initialize.php");
    require_once("includes/user_access.php");
    $conn = new Connection();
	$job = new Job();
	$encryption = new Encryption();
	$enc_id = $get->d;
	$enc_name = $get->n;
	$dec_id = $encryption->decrypt($enc_id);
	$dec_name = $encryption->decrypt($enc_name);
	
	require_once("includes/header_files.php");
?>


<div id="container">
	<div class="page-wrapper">
		
		<h1>Job Position</h1>
		<hr/>
		<div class="panel panel-primary">

			<div class="panel-heading text-center">Job positions under <span id='dname' style="font-weight:bold;"><?php echo $dec_name;?></span></div>

			<div class="panel-body">
				<table class="display  nowrap text-center table table-bordered table-striped" cellspacing="0" width="100%"  id="tbl_satellite_data">
					<thead>
						<tr>
							<th class="text-center">Job Position</th>
							<th class="text-center">Delete</th>
						</tr>
					</thead>
                    <tbody>
                     	<?php echo $job->getJobPosition($dec_id); ?>
                    </tbody>
					
				</table>
			</div>

			<div class="panel-footer">
				<a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#dialog_add"><i class="fa fa-user-plus fa-1x"></i> Add New</a>
				<a href="manage_job_category.php" class="btn btn-success btn-sm">Back</a>
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
        <h4 class="modal-title">Add Job Position</h4>
      </div>
      <div class="modal-body">

			<div class="alert alert-success fade in" style="display:none;" id="add_notif">
			    <button type="button" class="close" id="btn_hide">&times;</button>
				<span></span>
			</div>

      		<form class="form-horizontal">	
      			<input type="hidden" id="txt_job_category" value="<?php echo $dec_id;?>"/>
      			
				<div class="form-group">
					<label for="txt_job_position" class="control-label col-sm-3">Job Position</label>
					<div class="col-sm-9">
						<input type="text" class="form-control input-sm col-sm-9" id="txt_job_position" name="txt_job_position" placeholder="Job Position"/>
						<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
						<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter job position</p>
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
    $(".j_pos").each(function(){
        $(this).next().hide();
        $(this).show();
    });
}

$(document).ready(function(){
    $("#navigation-top").children("li:nth-child(4)").addClass("active");
	var table = $("#tbl_satellite_data").DataTable();
	var isAdd = false;
	var job_category = $("#txt_job_category").val();
	var job_position = "";
	var job_id = "";
	$("body").on("dblclick",".j_pos",function(){
		resetRow();
		$(this).next().show();
		$(this).hide();
	});

	$("#btn_save").click(function(){

		$.ajax({
			type:"POST",
			url:"ajax/add_job_position.php",
			data:{
				job_category : job_category,
				job_position : $("#txt_job_position").val()
			},
			success:function(response){
				location.reload();
			}
		});
	});

	$("#dialog_add").on("hidden.bs.modal",function(){
		if(isAdd){
			location.reload();
		}
	});

	$("body").on("click",".btn_edit",function(){
		job_id = $(this).data("id");
		job_position = $(this).parent().prev().prev().val();
		element = $(this);
		var ajax_load = $(this).parent().prev();
		ajax_load.show();


		if(job_position != ""){
			$.ajax({
				type:"POST",
				url:"ajax/update_job_position.php",
				data : {
					id 	 : job_id,
					job : job_position
				},
				success:function(response) {
					element.parent().parent().prev().text(job_position);
					ajax_load.hide();
					resetRow();
				}
			});
		} else {
			alert("Please enter category name.");
			ajax_load.hide();
		}
	});

	$("body").on("click",".btn_delete",function(){
	    element = $(this);
	    id = $(this).data("id");
	    $("#dialog_title").html("<i class='fa fa-warning fa-1x' style='color:#f1ab30;'></i> Confirmation");
	    $("#dialog_content").html("Are you sure to delete <strong>" + element.parent().prev().find("span:first").text() + "</strong>?");
	    $("#dialog_box").modal("show");
	});

    $("#dialog_btn_confirm").click(function(){
        $("#dialog_content").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
        $(this).hide("slow");
        $.ajax({
            type:"POST",
            url:"ajax/delete_job.php",
            data:{
                id : id
            },
            success:function(response){
            
               $("#dialog_box").modal("hide");
                table.rows(element.parents('tr')).remove().draw();
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