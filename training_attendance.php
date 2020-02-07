<?php
	require_once("initialize.php");
    $encryption = new Encryption();
    $trainingprogram = new TrainingProgram();
    $tp_id = $encryption->decrypt($get->d);
    $program_details = $trainingprogram->getTrainingProgramDetails($tp_id);
    $modules_list = $trainingprogram->getTrainingProgramModule($tp_id);
    include("includes/header_files.php");
?>
<style>
   .datetimepicker {z-index:-1 !important;}
</style>

<div id="container">
	
	<div class="page-wrapper">
		
		<h1>Training Program Attendance</h1>
		<br/>

 <!--        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header">
                        <i class="fa fa-file-text"></i>
                        <h3 class="box-title">Training program details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <span class="col-xs-4 text-bold">Program Title</span>
                            <span class="col-xs-8"><?php echo $program_details->title; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-xs-4 text-bold">Trainor</span>
                            <span class="col-xs-8"><?php echo $program_details->trainor_name; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-xs-4 text-bold">Venue</span>
                            <span class="col-xs-8"><?php echo $program_details->venue; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-xs-4 text-bold">Start date</span>
                            <span class="col-xs-8"><?php echo Format::format_date($program_details->start_date); ?></span>
                        </div>
                        <div class="row">
                            <span class="col-xs-4 text-bold">End date</span>
                            <span class="col-xs-8"><?php echo Format::format_date($program_details->end_date); ?></span>
                        </div>
                    </div>
                </div>
            </div>  
        </div> -->
        <div class="row">
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header">
                        <i class="fa fa-file-text"></i>
                        <h3 class="box-title">Training program details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <span class="col-xs-4 text-bold">Program Title</span>
                            <span class="col-xs-8"><?php echo $program_details->title; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-xs-4 text-bold">Trainor</span>
                            <span class="col-xs-8"><?php echo $program_details->trainor_name; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-xs-4 text-bold">Venue</span>
                            <span class="col-xs-8"><?php echo $program_details->venue; ?></span>
                        </div>
                        <div class="row">
                            <span class="col-xs-4 text-bold">Start date</span>
                            <span class="col-xs-8"><?php echo Format::format_date($program_details->start_date); ?></span>
                        </div>
                        <div class="row">
                            <span class="col-xs-4 text-bold">End date</span>
                            <span class="col-xs-8"><?php echo Format::format_date($program_details->end_date); ?></span>
                        </div>
                    </div>
                </div>
                <div class="box box-default">
                    <div class="box-header">
                        <i class="glyphicon glyphicon-user"></i>
                        <h3 class="box-title">List of Trainees</h3>
                    </div>
                    <div class="box-body">  
                        <div class="form-group">
                            <label class="col-md-3">Date</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control input-sm" id="txt_attendance_date"/>
                            </div>
                        </div>
                        <hr/>
                        <table class="table display table-striped table-condensed table-hover" id="tbl_attendees_list">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <div class="checkbox checkbox-danger">
                                            <input type="checkbox" id="cb_checkall" class="styled styled-primary" />
                                            <label> </label>
                                        </div>
                                    </th>
                                    <th class="no-sort">Trainee ID</th>
                                    <th class="no-sort">Name</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $training_program_attendees = $trainingprogram->getTrainingProgramAttendees($tp_id);
                                foreach($training_program_attendees as $attendee){
                                    $attendee = (object)$attendee;
                            ?>
                                <tr class="pointer_hover">
                                    <td>
                                        <div class="checkbox checkbox-danger">
                                            <input  type="checkbox" value="<?php echo $attendee->trainee_id; ?>" class="cb_attendee styled styled-danger">
                                            <label></label>
                                        </div>
                                    </td>
                                    <td class="row_select_trainee"><?php echo $attendee->trainee_code?></td>
                                    <td class="row_select_trainee"><?php echo $attendee->trainee_name?></td>
                                </tr>
                            <?php
                                }
                            ?>
                            </tbody>
                        </table>
                
                    
                    <br/>
                    <button type="button" class="btn btn-primary pull-right btn-sm" id="btn_add_selected">Add selected <span class="badge">0</span></button>
                  
                
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="nav-tabs-custom">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                    <?php
                        $ctr = 1;
                        foreach($modules_list as $module){
                            $module = (object)$module; 
                    ?>
                        <li role="presentation" class="<?php echo ($ctr == 1 ? 'active' : ''); ?> tab_link_module" data-module_id="<?php echo $module->id;?>">
                            <a href="#main_attendance_tab" aria-controls="tab<?php echo $module->id;?>" role="tab" data-toggle="tab">
                                <?php echo $module->module_name; ?>
                            </a>
                        </li>
                    <?php
                            $ctr++;
                        }
                    ?>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="main_attendance_tab">
                            <table class="display responsive table table-striped table-bordered" id="tbl_attendance_data">
                                <thead>
                                    <tr>
                                        <th>Trainee ID</th>
                                        <th>Name</th>
                                        <th>Dealer</th>
                                        <th>Date and Time</th>
                                        <th class="no-sort"></th>
                                        <th>Module ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>     
            </div>
        </div>
	</div> <!-- end of page content wrapper -->
</div> <!-- end of wrapper -->

<input type="hidden" value="<?php echo $tp_id;?>" id="txt_tp_id" />
<?php 
    include("panels/information_dialog.php"); 
    include("panels/confirm_dialog.php"); 
    include("includes/footer.php");
    include("includes/js_files.php");
?>

<div class="modal fade" tabindex="-1" role="dialog" id="txt_update_attendance">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update Attendance</h4>
      </div>
      <div class="modal-body">
        <form>
             <input type="hidden" disabled="disabled" id="txt_attendance_id"/>
            <div class="form-group">
                <label>Trainee ID</label>
                <input type="text" class="form-control" disabled="disabled" id="txt_trainee_id"/>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" disabled="disabled" id="txt_trainee_name"/>
            </div>
            <div class="form-group">
                <label>Dealer</label>
                <input type="text" class="form-control" disabled="disabled" id="txt_dealer_name"/>
            </div>
            <div class="form-group">
                <label>Date and Time</label>
                <div class='input-group date' id='txt_update_time_in'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn_update_attendance">Save changes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


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
function getDefaultModule(){
    var m;
    $(".tab_link_module").each(function(){
        var element = $(this);
        if($(this).hasClass("active")){
            m = $(this).data("module_id");
        }
   });
    return m;
}
function deselectAllCb(){
    $(".cb_attendee").attr("checked",false);
}
function refreshTable(tbl_attendance_data,module_id){
    tbl_attendance_data
            .columns( 5 )
            .search( module_id )
            .draw();
}
$(document).ready(function(){

   var id;
   var element = "";
   var module_id = getDefaultModule();

   var tp_id = $("#txt_tp_id").val();
  
    var tbl_attendance_data = $('#tbl_attendance_data').DataTable({
        "processing": true,
        "serverSide": true,
        "autoWidth":false,
        "ajax":"ajax/dt_get_attendance_data.php?tp_id="+tp_id,
        "paging":   false,
        "ordering": true,
        "columnDefs": [
            {
                "targets": [ 5 ],
                "visible": false,
                "searchable": true
            }
        ]
    });

    refreshTable(tbl_attendance_data,module_id);


    $("body").on("click",".btn_remove",function(){
        id = $(this).data("id");
        $("#dialog_content").html("Are you sure?");
        $("#dialog_box").modal("show");
        element = $(this);
    });

    $("#dialog_btn_confirm").click(function(){
        $(this).hide();
        $("#dialog_content").html("Please wait...<img src='../../../img/ajax-loader.gif'/>");
        $.ajax({
            type:"POST",
            url:"ajax/delete_attendance.php",
            data:{
                id : id
            },
            success:function(response){
              // $("#dialog_content").html(response);
               $("#dialog_box").modal("hide");
               refreshTable(tbl_attendance_data,module_id);
            }
        });
    });


    /* NEW CODE */
    var tbl_attendees_list = $("#tbl_attendees_list").DataTable( {
        "scrollY":        "300px",
        "scrollCollapse": true,
        "paging":         false,
        "ordering": false,
        "info":     false,
        "searching" : false
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

    $("#txt_attendance_date").datetimepicker();

    $("body").on("click",".tab_link_module",function(){
        module_id = $(this).data("module_id");
        refreshTable(tbl_attendance_data,module_id);
    });

    $("#btn_add_selected").click(function(){
        var selected_attendees = [];
        var index = 0;
        var attendance_date = moment($("#txt_attendance_date").data("date"), "MM/DD/YYYY HH:mm A").format('YYYY-MM-DD HH:mm');
        $(".cb_attendee").each(function(){
            if($(this).is(":checked")){
                selected_attendees[index] = $(this).val();
                index++;
            }
        });
      
        if(index != 0 && $("#txt_attendance_date").val()!=""){
            $.blockUI({ 
                message: '<h1>Processing... <img src="../../../img/ajax-loader.gif" height="30"/></h1>' 
            });
            $.ajax({
                type:"POST",
                data:{
                    tp_id             : tp_id,
                    module_id         : module_id,
                    attendance_date   : attendance_date,
                    selected_trainees : selected_attendees
                },
                url:"ajax/add_attendance.php",
                success:function(response){
                    $.unblockUI({ fadeOut: 1500 }); 
                    refreshTable(tbl_attendance_data,module_id);
                    deselectAllCb();
                }
            });
        }   
        else if($("#txt_attendance_date").val() == ""){
            $("#dialog_info_content").html("Please select the date of the attendance");
            $("#dialog_info_title").text("Attendance");
            $("#dialog_info").modal("show");
        }
        else if(index == 0) {
            $("#dialog_info_content").html("Please select atleast one trainee.");
            $("#dialog_info_title").text("Attendance");
            $("#dialog_info").modal("show");
        }
    });

    $("body").on("click",".btn_edit_attendance",function(){
        id = $(this).data("id");
        $.ajax({
            type:"POST",
            data:{
                id : id
            },
            url:"ajax/get_attendance_details.php",
            success:function(response){
                var data = JSON.parse(response);
                var attendance_date = moment(data.time_in, "YYYY-MM-DD HH:mm").format('MM/DD/YYYY HH:mm A');
                $("#txt_attendance_id").val(data.id);
                $("#txt_trainee_id").val(data.trainee_id);
                $("#txt_trainee_name").val(data.trainee_name);
                $("#txt_dealer_name").val(data.dealer_name);
                $("#txt_update_time_in input").val(attendance_date);
                $("#txt_update_time_in").attr("data-date",data.time_in);
                $("#txt_update_attendance").modal("show");
            }
        });
    });

    $("#txt_update_time_in").datetimepicker();

    $("#btn_update_attendance").click(function(){
        var attendance_id = $("#txt_attendance_id").val();
        var attendance_date = moment($("#txt_update_time_in").data("date"), "MM/DD/YYYY HH:mm A").format('YYYY-MM-DD HH:mm');
        $.ajax({
            type:"POST",
            data:{
                attendance_id : attendance_id,
                attendance_date : attendance_date
            },
            url:"ajax/update_attendance.php",
            success:function(response){
                refreshTable(tbl_attendance_data,module_id);
                $("#txt_update_attendance").modal("hide");
            }
        });
    });
}); 
</script>

</body>
</html>