<?php
require_once("initialize.php");
require_once("includes/user_access.php");
require_once("includes/header_files.php");
$program = new Program();
$program_category_list = $program->getProgramCategoryList();

?>


<div id="container">
	<div class="page-wrapper">
		
	<h1>Programs</h1>
		<hr/>
        <div class="row">
            <div class="col-md-4">
                <div class="well">
                    <fieldset>
                        <legend>Program Category</legend>
                        <ul class="list-group" style="max-height:500px;overflow-y:auto;">
                        <?php
                            foreach($program_category_list as $program_category){
                                $program_category = (object)$program_category;
                        ?>
                            <li class="list-group-item"><a href="#" class="btn_delete_program_category" data-id="<?php echo $program_category->program_category_id;?>" style="margin-right:1em;"><i class="fa fa-trash fa-1x"></i></a><?php echo $program_category->category_name; ?></li>
                        <?php 
                            }
                        ?>
                        </ul>
                        <div class="input-group">
                            <input class="form-control" placeholder="Add program category" id="txt_program_category" type="text">
                                <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" id="btn_add_program_category">Add</button>
                        </span>
                    </div>
                    </fieldset>
                </div>
            </div>

            <div class="col-md-8">
        		<div class="panel panel-primary">
                    <div class="panel-heading text-center">Programs</div>
                    <div class="panel-body">
                    		<table class="display responsive nowrap text-center table table-bordered table-striped" cellspacing="0" width="100%" id="tbl_program_data">
                    			<thead>
                    				<tr>
                    					<th>Title</th>
                    					<th>Category</th>
                    					<th>Action</th>					
                    				</tr>
                    			</thead>

                    			<tbody>
                    			
                    			</tbody>
                    		</table>
                    </div>
                    <div class="panel-footer">
                        <a href="add_program.php" class="btn btn-primary btn-sm">Add Program</a>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>  
        </div>
	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->


<!-- dialogs -->

<!-- pre-requisite dialog -->
<div class="modal fade" id="dialog_prereq">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body" id="pre_req_choices" style="overflow-y:auto;">
      		
  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" id="btn_save_prereqs">Save changes</button>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        
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
$(document).ready(function(){
   
   var program_code = 0
   var element;
   var title = "";
    var tbl_program_data = $("#tbl_program_data").DataTable({
        "processing": true,
        "serverSide": true,
        "autoWidth":false,
        "ajax":"ajax/dt_get_programs_list.php",
    });

   $("#navigation-top").children("li:nth-child(4)").addClass("active");

   $("body").on("click",".btn_delete",function(e){
   		program_code = $(this).attr("data-id");
   		element = $(this);
   		title = $(this).attr("data-title");
   		$("#dialog_title").text("Confirmation dialog");
   		$("#dialog_content").html("Are you sure to delete <strong>" + title + "</strong> along with its associated files?");
   		$("#dialog_box").modal('show');
   });

   $("#dialog_btn_confirm").click(function(e){
   		$("#dialog_content").text("Please wait...");
      $("#dialog_btn_confirm").hide("slow");
   		$.ajax({
   			type:"POST",
   			data:{id:program_code},
   			url:"ajax/delete_program.php",
   			success:function(response){
   				//$("#dialog_content").html(response);
                $("#dialog_box").modal('hide');
   				tbl_program_data.draw();
   			}
   		});
   });


   $('#dialog_box').on('hidden.bs.modal', function () {
        $("#dialog_btn_confirm").show();
    });

   $("body").on("click",".btn_delete_program_category",function(){
        var id = $(this).data("id");
        $.ajax({
            type:"POST",
            data:{
                id : id
            },
            url:"ajax/delete_program_category.php",
            success:function(response){
                location.reload();
            }
        });
   });

    $("#btn_add_program_category").click(function(){
        if($("#txt_program_category").val()!=""){
            $.ajax({
                type:"POST",
                data:{
                    program_category : $("#txt_program_category").val()
                },
                url:"ajax/add_program_category.php",
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