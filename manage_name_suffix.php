<?php
	require_once("initialize.php");
  require_once("includes/user_access.php");
  require_once("includes/header_files.php");
  $trainee = new Trainee();
?>


<div id="container">
	<div class="page-wrapper">
		
		<h1>Name Suffix</h1>
		<hr/>
		<div class="panel panel-primary">

			<div class="panel-heading text-center">Name Suffixes</div>

			<div class="panel-body">
				<table class="display  nowrap text-center table table-bordered table-striped" cellspacing="0" width="100%"  id="tbl_data">
					<thead>
						<tr>
							<th class="text-center">Name Suffix</th>
							<th class="text-center">Delete</th>
          	
						</tr>
					</thead>
                    <tbody>
                        <?php echo $trainee->getSuffixList();?>
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
        <h4 class="modal-title">Add Suffix</h4>
      </div>
      <div class="modal-body">

        <div class="alert alert-success fade in" style="display:none;" id="add_notif">
            <button type="button" class="close" id="btn_hide">&times;</button>
            <span></span>
        </div>

      	<form class="form-horizontal">	
      		
      			

          <div class="form-group">
          	<label for="txt_dealer" class="control-label col-sm-3">Name Suffix</label>
          	<div class="col-sm-9">
          		<input type="text" class="form-control input-sm col-sm-9" id="txt_name_suffix" name="txt_name_suffix" placeholder="Name suffix"/>
          		<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
          		<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter name suffix</p>
          	</div>
          </div>

     
      		</form>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-primary btn-sm" id="btn_save">Save</button>
        <button type="button" class="btn btn-info btn-sm" data-dismiss="modal">Close</button>
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
    $(".name_suffix").each(function(){
        $(this).next().hide();
        $(this).show();
    });
}
$(document).ready(function(){
  $("#tbl_data").DataTable();
  var isSubmit = false;
  var element;
  var suffix_id = 0;
  $("#navigation-top").children("li:nth-child(4)").addClass("active");
  validate_input("#txt_name_suffix");
  $("#btn_save").click(function(){
     if($("#txt_name_suffix").val() == ""){
        mark_error_input("#txt_name_suffix");
     }
     else {

        $.ajax({
          type:"POST",
          data:{
            name_suffix:$("#txt_name_suffix").val()
          },
          url:"ajax/add_suffix.php",
          success:function(response){
            location.reload();
          }
        });
     }
  });


  $("#dialog_add").on("hidden.bs.modal",function(){
    if(isSubmit){
        location.reload();
    }
  });


    $("body").on("dblclick",".name_suffix",function(){

        resetRow();
        $(this).next().show();
        $(this).hide();
    });


    $("body").on("click",".btn_edit",function(){

        var ajax_load = $(this).parent().prev();
        var new_suffix = $(this).parent().prev().prev();
        var id = $(this).data("id");

        if(new_suffix.val()!=""){
            ajax_load.show();
            $.ajax({
                type:"POST",
                data:{
                    new_suffix : new_suffix.val(),
                    id : id
                },
                url:"ajax/update_suffix.php",
                success:function(response){
                    ajax_load.hide();
                    new_suffix.parent().prev().html(new_suffix.val());
                    new_suffix.parent().hide(); 
                    new_suffix.parent().prev().show();
                }
            });
        }
       
    });

    $("body").on("click",".btn_delete",function(){
        suffix_id = $(this).data("id");
        element = $(this);
        $("#dialog_title").html("<i class='fa fa-warning fa-1x' style='color:#f1ab30;'></i> Confirmation");
        $("#dialog_content").html("Are you sure ?");
        $("#dialog_box").modal("show");
    });


    $("#dialog_btn_confirm").click(function(){
        $.ajax({
            type:"POST",
            data:{
                id : suffix_id
            },
            url:"ajax/delete_suffix.php",
            success:function(response){
                location.reload();
            }
        });
    });
   
    
});
</script>

</body>
</html>