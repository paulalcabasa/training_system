<?php
	require_once("initialize.php");
    require_once("includes/user_access.php");
    $encryption = new Encryption();
    $program = new Program();
    $conn = new Connection();
    $trainee = new Trainee();
    $trainingprogram = new TrainingProgram();
    $tp_id = $encryption->decrypt($get->d);
    $program_details = $trainingprogram->getTrainingProgramDetails($tp_id);
    include("includes/header_files.php");
?>

<div id="container">	
	<div class="page-wrapper">
		<h1>Training Program Attendees</h1>
		<br/>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body">
                        <div class="row">
                            <span class="col-md-2 text-bold"><abbr title="Training Program">TP</abbr> No. : </span>
                            <span class="col-md-10"><?php echo $program_details->tp_id; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-md-2 text-bold">Program Title : </span>
                            <span class="col-md-10"><?php echo $program_details->title; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-md-2 text-bold">Trainor : </span>
                            <span class="col-md-10"><?php echo $program_details->trainor_name; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-md-2 text-bold">Venue : </span>
                            <span class="col-md-10"><?php echo $program_details->venue; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-md-2 text-bold">Start date : </span>
                            <span class="col-md-10"><?php echo Format::format_date2($program_details->start_date); ?></span>
                        </div>
                         <div class="row">
                            <span class="col-md-2 text-bold">End date : </span>
                            <span class="col-md-10"><?php echo Format::format_date2($program_details->end_date); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-4">
                <div class="box box-default" style="min-height:300px;">
                    <div class="box-header">
                        <i class="glyphicon glyphicon-user"></i>
                        <h3 class="box-title">Trainees</h3>
                    </div>
                    <div class="box-body">
                   
                        <table class="table table-striped table-condensed table-hover" id="tbl_attendees_list" >
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                      <div class="checkbox checkbox-danger"> 
                                            <input type="checkbox" id="cb_checkall" class="styled styled-primary" />
                                             <label></label>
                                        </div> 
                                    </th>
                                    <th class="no-sort">Trainee ID</th>
                                    <th class="no-sort">Name</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php
                                $trainees_list = $trainee->getTraineesList();
                                foreach($trainees_list as $t){
                                    $t = (object)$t;
                                    $isExistCtr = $trainingprogram->checkTraineeExistenceForTrainingProgram($t->trainee_code,$tp_id);
                                    $conflict_ctr = 0;
                                    if($isExistCtr != 1){  
                                       $conflict_ctr = $trainingprogram->checkSchedule($t->trainee_code,$tp_id,$conn);
                                       if($conflict_ctr == 0) {
                            ?>
                                            <tr class="pointer_hover">
                                                <td>
                                                  <div class="checkbox checkbox-danger"> 
                                                        <input  type="checkbox" value="<?php echo $t->trainee_code; ?>" class="cb_attendee styled styled-danger">
                                                        <label></label>
                                                    </div>
                                                </td>
                                                <td class="row_select_trainee"><?php echo $t->trainee_id;?></td>
                                                <td class="row_select_trainee"><?php echo $t->trainee_name;?></td>
                                            </tr>
                            <?php
                                        }
                                     }
                                }
                            ?>
                            </tbody>
                        </table>
                        
                    </div>
                    
                    <div class="box-footer">
                    <button type="button" class="btn btn-primary pull-right btn-sm" id="btn_add_selected">Add selected <span class="badge">0</span></button>
                    </div>
                </div>

          </div>

            <div class="col-md-8">
        	  <div class="box box-danger">  <!-- start of panel -->
                <div class="box-header">
                    <i class="fa fa-users"></i>
                    <h3 class="box-title">Training Program Trainees</h3>
                </div>
                <div class="box-body"> <!-- start of panel body -->
                    <table class="display responsive nowrap text-center table table-bordered table-striped" id="tbl_trainees_list">
                        <thead>
                            <tr>
                                <th>Trainee ID</th>
                                <th>Trainee</th>
                                <th>Dealer Name</th>
                                <th>Job Position</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div> <!-- end of panel body -->
                </div> <!-- end of panel -->
            </div>
        </div>
	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->
<input type="hidden" value="<?php echo $tp_id; ?>" id="tp_id"/>
<?php 
    include("panels/information_dialog.php");
    include("panels/confirm_dialog.php");
    include("includes/footer.php"); 
    include("includes/js_files.php");
?>
<script>

function countSelected(){
    var ctr = 0;
    $(".cb_attendee").each(function(ev){
        if($(this).is(":checked")){
            ctr++;
        }
    });
    $("#btn_add_selected span").text(ctr);
}

$(document).ready(function(){

    $("#navigation-top").children("li:nth-child(3)").addClass("active");
    var tp_id = $("#tp_id").val();

    var tbl_attendees_list = $("#tbl_attendees_list").DataTable( {
        "scrollY":        "300px",
        "scrollCollapse": true,
        "paging":         false,
        "ordering": false,
        "info":     false,
        "dom": '<lf<t>ip>'
    });

    var tbl_trainees_list = $('#tbl_trainees_list').DataTable({
        "processing": true,
        "serverSide": true,
        "autoWidth":false,
        "ajax":"ajax/dt_attendees_list.php?tp_id="+tp_id,
        "paging":   false,
        "ordering": true
    });

    $(".cb_attendee").change(function(){
        countSelected();
    });

    $("#cb_checkall").click(function(){
        if($(this).is(":checked")){
            $(".cb_attendee").prop("checked","true");
        }
        else {
            $(".cb_attendee").removeAttr("checked");
        }
        countSelected();
    });

    $("body").on("click",".row_select_trainee",function(){
        var child_cb = $(this).parent().children().find(".cb_attendee");
        if(child_cb.is(":checked")){
            child_cb.removeAttr("checked");
        }
        else {
            child_cb.prop("checked","true");
        }
        countSelected();
    });

     $("#btn_add_selected").click(function(){
        var selected_attendees = [];
        var index = 0;
    
        $(".cb_attendee").each(function(){
            if($(this).is(":checked")){
                selected_attendees[index] = $(this).val();
                index++;
            }
        });

        if(index != 0){
            $.blockUI({ 
                message: '<h1>Processing... <img src="../../../img/ajax-loader.gif" height="30"/></h1>' 
            });
          
            $.ajax({
                type:"POST",
                data:{
                    tp_id : tp_id,
                    selected_attendees : selected_attendees
                },
                url:"ajax/add_trainee_in_trainingprogram.php",
                success:function(response){
                    //alert(response);
                    location.reload();
                }
            });
        }
    });

});
</script>

</body>
</html>