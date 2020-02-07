<?php
	require_once("initialize.php");
    require_once("includes/user_access.php");
    require_once("includes/header_files.php");
    $dealer =  new Dealer();

?>


<div id="container">
	<div class="page-wrapper">
		
		<h1>IPC Dealer Network</h1>
		<hr/>
        <div class="row">
            <div class="col-md-5">
        		<div class="panel panel-primary">
        			<div class="panel-heading text-center">Dealer Groups</div>
        			<div class="panel-body">
        				<table class="display  nowrap text-center table table-bordered table-striped" cellspacing="0" width="100%"  id="tbl_dealer_group_data">
        					<thead>
        						<tr>
        							<th class="text-center">Group Name</th>
        							<th class="text-center">Action</th>
        						</tr>
        					</thead>
                            <tbody>
                                <?php echo $dealer->getDealerGroup();?>
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
        <h4 class="modal-title">Add Dealer Group</h4>
      </div>
      <div class="modal-body">

			<div class="alert alert-success fade in" style="display:none;" id="add_notif">
			    <button type="button" class="close" id="btn_hide">&times;</button>
				<span></span>
			</div>

      		<form class="form-horizontal">	
      			
				<div class="form-group">
					<label for="txt_gname" class="control-label col-sm-3">Group Name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control input-sm col-sm-9" id="txt_gname" name="txt_gname" placeholder="Group Name"/>
						<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
						<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter group name</p>
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
    $(".d_gname").each(function(){
        $(this).next().hide();
        $(this).show();
    });
}
$(document).ready(function(){
    var dealer_group_id = 0;
    var element;
    var isAdd = false;
    var table = $("#tbl_dealer_group_data").DataTable({
        "paging" : false
    });
    $("#navigation-top").children("li:nth-child(4)").addClass("active");
    $("#btn_save").click(function(){
        $.ajax({
            type:"POST",
            url:"ajax/add_dealer_group.php",
            data :{
                dealer_group_name : $("#txt_gname").val()
            },
            success:function(response){
                $("#add_notif span").html(response);
                $("#add_notif").show("slow");
                isAdd = true;
             //   location.reload();
            }
        });
    });

    $("#dialog_add").on("hidden.bs.modal",function(){
        if(isAdd){
            location.reload();
        }
    });

    $("body").on("dblclick",".d_gname",function(){
        resetRow();
        $(this).next().show();
        $(this).hide();
    });

    $("body").on("click",".btn_edit",function(){
        element = $(this);
        dealer_group_id  = $(this).data("id");
        var name = $(this).parent().prev().prev().val();
        var ajax_load = $(this).parent().prev();
        ajax_load.show();
        if(name != ""){
            $.ajax({
                type:"POST",
                url:"ajax/update_dealer_group.php",
                data : {
                    dealer_group_id   : dealer_group_id,
                    dealer_group_name : name
                },
                success:function(response) {
                    element.parent().parent().prev().text(name);
                    element.parent().prev().prev().val(name);
                    ajax_load.hide();
                    resetRow();
                }
            });
        }
        else {
             ajax_load.hide();
            alert("Please enter a value for the group name.");
        }
        
    });

    $("table th").click(function(){
       resetRow();
    });

    $("body").on("click",".btn_delete",function(){
        element = $(this);
        dealer_group_id = $(this).data("id");
        $("#dialog_title").html("<i class='fa fa-warning fa-1x' style='color:#f1ab30;'></i> Confirmation");
        $("#dialog_content").html("Are you sure to delete <strong>" + $(this).data("gname") + "</strong> from the dealer groups? All associated dealers would lost their dealer group upon the completion of this operation, Do you wish to continue?");
        $("#dialog_box").modal("show");
    });
    
    $("#dialog_btn_confirm").click(function(){
        $("#dialog_content").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
        $(this).hide("slow");
        $.ajax({
            type:"POST",
            url:"ajax/delete_dealer_group.php",
            data:{
                dealer_group_id : dealer_group_id
            },
            success:function(response){
               location.reload();
                /*$("#dialog_content").html(response);
                table.rows(element.parents('tr')).remove().draw();*/
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