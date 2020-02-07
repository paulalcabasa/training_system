<?php
require_once("initialize.php");
require_once("includes/user_access.php");
$dealer = new Dealer();
$encryption = new Encryption();
$enc_id = $get->d;
$dec_id = $encryption->decrypt($enc_id);
$dealer_group_details = $dealer->getDealerGroupDetails($dec_id);
$dealers_list = $dealer->getDealersByGroup($dec_id);
require_once("includes/header_files.php");
  
?>


<div id="container">
	<div class="page-wrapper">
		
		<h1>Dealers</h1>
		<hr/>
		<div class="panel panel-primary">

			<div class="panel-heading text-center">Dealers of <span id='gname'><?php echo $dealer_group_details->dealer_group_name;?></span> dealer group</div>

			<div class="panel-body">
				<table class="display text-center table table-bordered table-striped" cellspacing="0" width="100%"  id="tbl_dealer_data">
					<thead>
						<tr>
                            <th class="text-center" ></th>
							<th class="text-center" style="width:20%;">Dealer Code</th>
							<th class="text-center" style="width:40%;">Dealer</th>
                            <th class="text-center" style="width:30%;">Abbreviation</th>
							<th class="text-center" style="width:10%;">Action</th>
						</tr>
					</thead>
            <tbody>
                <?php
                    foreach($dealers_list as $d){
                        $d = (object)$d;
                        $enc_dealer_id = $encryption->encrypt($d->id);
                ?>

                    
                    <tr>
                        <td></td>
                        <td>
                            <span class='dealer_code' title='Click to edit'><?php echo $d->dealer_code; ?></span>
                            <div class='input-group' style='display:none;'>
                                <input type='text' style='text-align:center;' class='form-control input-md' value='<?php echo $d->dealer_code; ?>' />
                                <span class='input-group-addon' style='background-color:#ffffff;border-left:none;display:none;'><img src='../../../img/ajax-loader.gif' /></span>
                                <span class='input-group-btn'>
                                    <button type='button' class='btn btn-primary btn-md btn_edit' data-id='<?php echo $d->id;?>' data-action='Dealer Code'><i class='fa fa-save fa-1x'></i></button> 
                                </span>
                            </div>
                        </td>
                        <td>
                            <span class='dealer_name' title='Click to edit'><?php echo $d->dealer_name; ?></span>
                            <div class='input-group' style='display:none;'>
                                <input type='text' style='text-align:center;border-right:none;' class='form-control input-md' value='<?php echo $d->dealer_name; ?>' />
                                <span class='input-group-addon' style='background-color:#ffffff;border-left:none;display:none;'><img src='../../../img/ajax-loader.gif' /></span>
                                <span class='input-group-btn'>
                                    <button type='button' class='btn btn-primary btn-md btn_edit' data-id='<?php echo $d->id;?>' data-action='Dealer Name'><i class='fa fa-save fa-1x'></i></button> 
                                </span>
                            </div>
                        </td>
                        <td>
                            <span class='dealer_abbrev' title='Click to edit'><?php echo $d->dealer_abbrev; ?></span>
                            <div class='input-group' style='display:none;'>
                                <input type='text' style='text-align:center;border-right:none;' class='form-control input-md' value='<?php echo $d->dealer_abbrev; ?>' />
                                <span class='input-group-addon' style='background-color:#ffffff;border-left:none;display:none;'><img src='../../../img/ajax-loader.gif' /></span>
                                <span class='input-group-btn'>
                                    <button type='button' class='btn btn-primary btn-md btn_edit' data-id='<?php echo $d->id; ?>' data-action='Dealer Abbrev'><i class='fa fa-save fa-1x'></i></button>   
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class='btn-group'>
                              <button type='button' class='btn btn-info btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                Action <span class='caret'></span>
                              </button>

                              <ul class='dropdown-menu dropdown-menu-right'>
                                  <li><a href='manage_satellites.php?d=<?php echo $enc_dealer_id;?>'>View Satellites</a></li>
                                  <!-- <li><a href='#' data-id='<?php echo $d->id;?>' class='btn_delete'>Delete</a></li> -->
                              </ul>
                            </div>
                        </td>
                        
                  </tr>
                <?php 
                    }
                ?>
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
        <h4 class="modal-title">Add Dealer</h4>
      </div>
      <div class="modal-body">

			<div class="alert alert-success fade in" style="display:none;" id="add_notif">
			    <button type="button" class="close" id="btn_hide">&times;</button>
				<span></span>
			</div>

      		<form class="form-horizontal">	
      			<input type="hidden" id="dealer_group_id" value="<?php echo $dec_id;?>"/>
      			<div class="form-group">
					<label for="txt_dealer_code" class="control-label col-sm-3">Dealer Code</label>
					<div class="col-sm-9">
						<input type="text" class="form-control input-sm col-sm-9" id="txt_dealer_code" name="txt_dealer_code" placeholder="Dealer Code"/>
						<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
						<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter dealer id</p>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_dealer" class="control-label col-sm-3">Dealer Name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control input-sm col-sm-9" id="txt_dealer" name="txt_dealer" placeholder="Dealer Name"/>
						<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
						<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter dealer name</p>
					</div>
				</div>

        <div class="form-group">
          <label for="txt_abbrev" class="control-label col-sm-3">Abbreviation</label>
          <div class="col-sm-9">
            <input type="text" class="form-control input-sm col-sm-9" id="txt_abbrev" name="txt_abbrev" placeholder="Dealer Abbreviation"/>
            <span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
            <p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter dealer abbreviation</p>
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
    $(".dealer_code,.dealer_name,.dealer_abbrev").each(function(){
        $(this).next().hide();
        $(this).show();
    });
}

$(document).ready(function(){
    var dealer_id = 0;
	var table = $("#tbl_dealer_data").DataTable({
        "columnDefs": [ 
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
        ]
    });

	var isAdd = false;
	$("#btn_save").click(function(){
        $.ajax({
            type:"POST",
            url:"ajax/add_dealer.php",
            data :{
                dealer_type_id     : 1, // means MAIN Dealer
                dealer_parent_id   : "", // no parent because this is a main dealer
                dealer_code 	   : $("#txt_dealer_code").val(),
                dealer_name 	   : $("#txt_dealer").val(),
                dealer_group_id    : $("#dealer_group_id").val(),
                gname			   : $("#gname").text(),
                dealer_abbrev      : $("#txt_abbrev").val()
            },
            success:function(response){
                /*$("#add_notif span").html(response);
                $("#add_notif").show("slow");
                isAdd = true;*/
                location.reload();
            }
        });
    });

    $("#dialog_add").on("hidden.bs.modal",function(){
    	if(isAdd){
    		location.reload();
    	}
    });

     $("body").on("dblclick",".dealer_code,.dealer_name,.dealer_abbrev",function(){
        resetRow();
        $(this).next().show();
        $(this).hide();
    });

    $("table th").click(function(){
       resetRow();
    });


     $("body").on("click",".btn_edit",function(){
     	var action = $(this).data("action");
     	var dealer_code = "";
     	var dealer_name = "";
        var dealer_abbrev = "";
        dealer_id  = $(this).data("id");
     	var ajax_load = $(this).parent().prev();
     	element = $(this);
     	if(action == "Dealer Code"){
     		dealer_code = $(this).parent().prev().prev().val();
     		dealer_name = $(this).parent().parent().parent().next().children().find("input").val();
        dealer_abbrev = $(this).parent().parent().parent().next().next().children().find("input").val();

     	} else if(action == "Dealer Name"){
     		dealer_name = $(this).parent().prev().prev().val();
     		dealer_code = $(this).parent().parent().parent().prev().children().find("input").val();
        dealer_abbrev = $(this).parent().parent().parent().next().children().find("input").val();
     	} else if (action == "Dealer Abbrev"){
        dealer_abbrev = $(this).parent().prev().prev().val();
        dealer_name = $(this).parent().parent().parent().prev().children().find("input").val();
        dealer_code = $(this).parent().parent().parent().prev().prev().children().find("input").val();
      }

      ajax_load.show();

        if(dealer_code != "" && dealer_name != "" && dealer_abbrev != ""){
            $.ajax({
                type:"POST",
                url:"ajax/update_dealer.php",
                data : {
                    dealer_id     : dealer_id,
                    dealer_name   : dealer_name,
                    dealer_code   : dealer_code,
                    dealer_abbrev : dealer_abbrev
                },
                success:function(response) {
                  	if(action == "Dealer Code"){
                  		element.parent().parent().prev().text(dealer_code);
                  	}
                  	else if(action == "Dealer Name") {
                  		element.parent().parent().prev().text(dealer_name);
                  	} 
                    else if (action == "Dealer Abbrev"){
                      element.parent().parent().prev().text(dealer_abbrev);
                    }
                    ajax_load.hide();
                    resetRow();
                }
            });
        }
        else {
            ajax_load.hide();
            alert("Please enter a value for the " + action);
        }
        
    });
	
	 $("body").on("click",".btn_delete",function(){
        element = $(this);
        dealer_id = $(this).data("id");
        $("#dialog_title").html("<i class='fa fa-warning fa-1x' style='color:#f1ab30;'></i> Confirmation");
        $("#dialog_content").html("Are you sure to delete <strong>" + $(this).parent().prev().prev().children("span:first").text() + "</strong> from <strong>"+$("#gname").text()+"</strong> dealer group? All associated satellites would also be deleted upon the completion of this operation.");
        $("#dialog_box").modal("show");
    });


    $("#dialog_btn_confirm").click(function(){
        $("#dialog_content").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
        $(this).hide("slow");
        $.ajax({
            type:"POST",
            url:"php_processors/proc_delete_dealer_main.php",
            data:{
                id : dealer_id
            },
            success:function(response){
                $("#dialog_content").html(response);
                table.rows(element.parents('tr')).remove().draw();
            }
        });
    });
    
    $("#dialog_box").on("hidden.bs.modal",function(){
        $("#dialog_btn_confirm").show();
    });

     $("#navigation-top").children("li:nth-child(4)").addClass("active");
});
</script>

</body>
</html>