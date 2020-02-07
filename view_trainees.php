<?php 
  require_once("initialize.php");
  require_once("includes/user_access.php");
  include("includes/header_files.php");
  $trainee = new Trainee();
  $dealer = new Dealer();
  $list_of_dealer = $dealer->getDealersListWithCountOfTrainees();
  $trainee_count = 0;
?> 
<style>

.dataTables_scrollBody {
  min-height:425px;
}
</style>
<div id="container">
	
	<div class="page-wrapper">
	
		<h1>Trainees
        <a href="add_trainee.php" class="btn btn-primary btn-sm pull-right"><i class="fa fa-user-plus fa-1x"></i> New Trainee</a>
        </h1>
   
	   
       <br/>
    <div class="row">
      <div class="col-md-3">
        <div class="box box-default">
            <div class="box-header">
                <i class="fa fa-object-group"></i>
                <h3 class="box-title">IPC Dealer Network</h3>
            </div>
            <div class="box-body">
                <ul class="list-group" style="max-height:500px;overflow-y:auto;">
                   <li class="list-group-item dealer_network_item"><span>All</span> <span class="badge">0</span></li>
                <?php
                    foreach($list_of_dealer as $d){
                        $d = (object)$d;
                ?>
                    <li class="list-group-item dealer_network_item"><span><?php echo $d->dealer_name;?></span> <span class="badge"><?php echo $d->trainee_count;?></span></li>
                <?php
                    }
                ?>
                </ul>
            </div>
        </div>
      </div>

      <div class="col-md-9">
  	    <div class="box box-danger" >
            <div class="box-header">
                <i class="fa fa-users"></i>
                <h3 class="box-title">IPC Trainees</h3>
            </div>
            <div class="box-body">

        		<table class="display table table-striped table-bordered text-center" cellspacing="0" width="100%"  id="tbl_trainee_data">
        			<thead>
        				<tr>
        					<th class="text-center" style="width:5%;">Picture</th>
        					<th class="text-center" style="width:20%;">Trainee ID</th>
        					<th class="text-center" style="width:25%;">Name</th>
        					<th class="text-center" style="width:20%;">Dealer</th>
                            <th class="text-center" style="width:20%;">Job Position</th>
        					<th class="text-center" style="width:5%;">Action</th>
        				</tr>
        			</thead>

        			<tbody style="min-height:500px;"></tbody>
        		</table>
            </div>
         
          </div>
      </div>
    </div>
    

	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->

<?php include("panels/confirm_dialog.php"); ?>
<?php include("includes/footer.php") ?>
<!-- javascript includes -->
<?php include("includes/js_files.php"); ?>

<script>
$(document).ready(function(){

  var id = "";
 
  var element = "";

  var tbl_trainee_data =  $("#tbl_trainee_data").DataTable({
    "processing": true,
    "serverSide": true,
    "autoWidth":false,
    "ajax":"ajax/dt_get_trainees.php",
    //"scrollY": "800px",
    //"scrollCollapse": true,
    "paging":   true,
    "ordering": true,
      "order": [[ 2, "desc" ]]
  });

   $("body").on("click",".btn_delete",function(e){
   		id = $(this).attr("data-id");
   		name = $(this).attr("data-name");
   		$("#dialog_title").text("Confirmation");
   		$("#dialog_content").html("<p>Are you sure to delete the information of <strong>" + name + "</strong>? All associated records would also be deleted upon the completion of this operation.")
   		$("#dialog_box").modal("show");
   		element = $(this);
   });

   $("#dialog_btn_confirm").click(function(){
   		$("#dialog_content").html("<p>Please wait while deleting account...</p>");
   		$.ajax({
   			type:"POST",
   			url:"ajax/delete_trainee.php",
   			data:{
   				id :id
   			},
   			success:function(response){
          if(response == "success"){
            tbl_trainee_data.draw();
            $("#dialog_box").modal("hide");
          }
          else {
            alert("ERROR DT2:" + response);
          }
   			}
   		});
   });

    $('.trn_pic').fancybox();
    
    $("#navigation-top").children("li:nth-child(2)").addClass("active");

    $("body").on("click",".dealer_network_item",function(){
        var search = "";
        if($(this).children("span:first").text() == "All"){
          search = "";
        }
        else {
          search = $(this).children("span:first").text();
        }
        tbl_trainee_data.search(search).draw();
    });



    /* count all trainees and set ALL in IPC Dealer Network count */
    var total_trainees = 0;
    $(".dealer_network_item").each(function(){
       var total = $(this).children("span:last").text();
       total_trainees += parseInt(total);
    });

    $(".dealer_network_item:first-child").children("span:last").text(total_trainees);
});
</script>

</body>
</html>