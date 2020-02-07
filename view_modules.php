<?php
require_once("initialize.php");
require_once("includes/user_access.php");
$program = new Program();
$encryption = new Encryption();
$program_code = $encryption->decrypt($get->d);
$program_details = $program->getProgramDetails($program_code);
require_once("includes/header_files.php");
?>

<div id="container">
	<div class="page-wrapper">
    	<h1>Program Module</h1>	
    	<hr/>
		  <div class="row" >
                <div class="col-md-4">
                    <div class="well">
                        <fieldset>
                            <legend style="font-size:12pt;">Program Details</legend>
                            <p>
                                <span class="text-bold">Title</span><br/>
                                <span class=""><?php echo $program_details->title;?></span>
                            </p>
                            <p>
                                <span class="text-bold">Category</span><br/>
                                <span class=""><?php echo $program_details->category_name;?></span>
                            </p>
                            <p>
                                <span class="text-bold">Description</span><br/>
                                <span class=""><?php echo $program_details->description;?></span>
                            </p>
                             <p>
                                <span class="text-bold">Objectives</span><br/>
                                <span class=""><?php echo $program_details->objectives;?></span>
                            </p>
                         
                        </fieldset>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="panel panel-primary"> <!-- start of panel -->
                       <div class="panel-heading">
                            Modules
                        </div>
                        <div class="panel-body"> <!-- start of panel body -->
                      		<table class="display responsive nowrap text-center table table-bordered table-striped" width="100%" id="tbl_module_data"> <!-- start of table -->
                      			<thead>
                      				<tr>
                      					<th>Module Name</th>
                      					<th>Action</th>
                      				</tr>
                      			</thead>

                      			<tbody>
                      				<?php echo $program->getModules($program_code);?>
                      			</tbody>

                      		</table> <!-- end of table -->
                        </div> <!-- end of panel body-->

                        <div class="panel-footer">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#dialog_add">Add module</button>
                            <div class="clear-fix"></div>
                        </div>
                    </div> <!-- end of panel -->
                </div>
            </div>
        </div>
	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->


<!-- dialogs -->

<!-- edit dialog -->
<div class="modal fade" id="dialog_edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="dialog_edit_title">Update Module</h4>
      </div>
      <div class="modal-body" id="dialog_edit_content">
          <form>
              <div class="form-group">
                  <label for="txt_module">Module Name</label>
                  <input type="text" class="form-control input-sm col-sm-9" id="txt_module" name="txt_module" placeholder="Module Name"/>
                  <span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
                  <p class="help-block" style="display:none;"><strong>*</strong> Please enter module name</p>
              </div>
          </form>
          <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-sm" id="btn_save">Save Changes</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- add dialog -->
<div class="modal fade" id="dialog_add">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="dialog_add_title">Add Module</h4>
      </div>
      <div class="modal-body" id="dialog_add_content">
          <form>
              <div class="form-group">
                  <label for="txt_module">Module Name</label>
                  <input type="text" class="form-control input-sm col-sm-9" id="txt_new_module" name="txt_new_module" placeholder="Module Name"/>
                  <span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
                  <p class="help-block" style="display:none;"><strong>*</strong> Please enter module name</p>
              </div>
          </form>
          <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-sm" id="btn_add_module">Add</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<input type="hidden" id="program_code" name="program_code" value="<?php echo $program_code;?>" />
<?php 
  include("panels/confirm_dialog.php");
  include("includes/js_files.php");
?>

<script>

function clearFormDialog(dialog,input){
  $(dialog).on('hidden.bs.modal', function () {
      $(input).parent().removeClass("has-success");
      $(input).parent().removeClass("has-error");
      $(input).next().hide();
      $(input).next().next().hide();
      $(input).val("");
  })
}

$(document).ready(function(){
   
  var table = $("#tbl_module_data").DataTable();
  var module_id = 0;
  var element;
  $("body").on("click",".btn_delete",function(e){
      element = $(this);
      module_id = $(this).attr("data-id");
      $("#dialog_title").text("Confirmation");
      $("#dialog_content").html("Are you sure to delete <strong>" + $(this).attr("data-name") + "</strong> ?");
      $("#dialog_box").modal("show");
  });

  $("#dialog_btn_confirm").click(function(){
      $("#dialog_content").html("Please wait... <img src='../../../img/ajax-loader.gif' />");
      $.ajax({
          type:"POST",
          data:{
              id : module_id
          },
          url:"ajax/delete_program_module.php",
          success:function(response){
            location.reload();
          }
      });
  });

  $("body").on("click",".btn_edit",function(e){
      module_id = $(this).attr("data-id");
      name = $(this).attr("data-name");
      element = $(this);
      $("#txt_module").val(name);
      $("#dialog_edit").modal("show");
  });

  clearFormDialog("#dialog_edit","#txt_module");
  clearFormDialog("#dialog_add","#txt_new_module");
  $("#btn_save").click(function(e){
      if($("#txt_module").val() == ""){
        mark_error_input_vertical("#txt_module");
      } 

      else {
        mark_success_input_vertical("#txt_module");

        $.ajax({
            type:"POST",
            url:"ajax/update_program_module.php",
            data:{
                id   :  module_id,
                name :  $("#txt_module").val()
            },
            success:function(response){
               location.reload();

            }
        });
      }
  });

  validate_input_vertical("#txt_module");

  

  $("#btn_add_module").click(function(e){
      if($("#txt_new_module").val() == ""){
        mark_error_input_vertical("#txt_new_module");
      }
      else {
        mark_success_input_vertical("#txt_new_module");
        $.ajax({
            type:"POST",
            url:"ajax/add_program_module.php",
            data:{
                program_code   :  $("#program_code").val(),
                name           :  $("#txt_new_module").val()
            },
            success:function(response){
              location.reload();
            }
        });
      }
  });

  $("#dialog_add").on("hidden.bs.modal",function(){
      location.reload();
  });
  validate_input_vertical("#txt_new_module");

  $("#navigation-top").children("li:nth-child(4)").addClass("active");

});
</script>

</body>
</html>