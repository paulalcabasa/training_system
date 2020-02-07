<?php
require_once("initialize.php");
$encryption = new Encryption();
$program = new Program();
$program_code = $encryption->decrypt($get->d);
$program_details = $program->getProgramDetails($program_code);
require_once("includes/header_files.php");
?>

<div id="container">
	<div class="page-wrapper">
		  
      <h1>Materials</h1>
      <hr/>
      <div class="row">

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
            <div class="panel panel-primary">
                  <div class="panel-heading">Presentation materials</div>
                  <div class="panel-body"> 
                      <table class="display responsive nowrap table table-bordered table-striped" cellspacing="0" width="100%" id="tbl_files_data">
                      <thead>
                        <tr>
                          <th>Filename</th>
                          <th>Uploaded By</th>
                          <th>Date uploaded</th>
                          <th>Delete</th>
                          <th>Destination</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                  <div class="panel-footer panel-primary">
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#dialog_add_file">Add files</button>
                  </div>
              </div>
           </div>
       </div>
	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->


<div class="modal fade" id="dialog_box">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="dialog_conf_title"></h4>
      </div>
      <div class="modal-body" id="dialog_conf_content">
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-sm" id="dialog_btn_confirm">Yes</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="dialog_add_file">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="dialog_title">Add files</h4>
      </div>
      <div class="modal-body" id="dialog_content">
          <p class="alert alert-info invisible" id="notif"></p>
          <form action="" method="POST" id="frm" name="frm" enctype="multipart/form-data">
            <input type="file" name="files[]" id="files" multiple="" />
<input type="hidden" id="program_code" value="<?php echo $program_code;?>"/>
          </form>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-success btn-sm" id="btn_upload">Upload</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php 

  include("includes/footer.php");
  include("includes/js_files.php");
?>

<script>

$(document).ready(function(){
    
    $("#navigation-top").children("li:nth-child(4)").addClass("active");
    var id = "";
    var file_name = "";
    var file_dest = "";
    var element;
  
    var tbl_files_data = $("#tbl_files_data").DataTable({
        "processing": true,
        "serverSide": true,
        "autoWidth":false,
        "ajax":"ajax/dt_program_materials_list.php?program_code="+$("#program_code").val(),
        "columnDefs": [
            {
                "targets": [ 4 ],
                "visible": false,
                "searchable": false
            }
        ]
    });

    $('#dialog_add_file').on('hidden.bs.modal', function () {
        $("#notif").html("").hide();
        $("#files").val("");
        location.reload();
    });


    $("#btn_upload").click(function(){
        

        if($("#files").val() == "") {
            $("#notif").html("Please select file/s to upload.").show("slow");
        }
        else {
           $("#notif").html("Please wait...<img src='../../../img/ajax-loader.gif'/>").removeClass("invisible").show("slow");
            var formData = new FormData($("#frm")[0]);
            formData.append("program_code",$("#program_code").val());
          
           
            $.ajax({
              type:"POST",
              url:"ajax/upload_program_material_files.php",
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
              success:function(response){
                  $("#notif").html("<ol>" + response + "</ol>");  
              }

            });
        }
    });




    $("body").on("click",".btn_delete_material",function(e){
        element = $(this);
        id = $(this).attr("data-id");
        file_dest = $(this).attr("data-destination");
        file_name = $(this).attr("data-name");
        $("#dialog_conf_title").text("Confirmation");
        $("#dialog_conf_content").html("<p>Are you sure to delete <strong>"+file_name+"</strong>?");
        $("#dialog_box").modal("show");
        $("#dialog_btn_confirm").show();
    });

    $("#dialog_btn_confirm").click(function(){
        $("#dialog_conf_content").html("Please wait... <img src='../../../img/ajax-loader.gif'>");
        $("#dialog_btn_confirm").hide("slow");
        $.ajax({
            type:"POST",
            url:"ajax/delete_file.php",
            data:{
              id          : id,
              file_dest   : file_dest
            },
            success:function(response){
                $("#dialog_box").modal("hide");
                tbl_files_data.draw();
            }
        });
    });

});
</script>

</body>
</html>