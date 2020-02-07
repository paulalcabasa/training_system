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
    $tp_modules_list = $trainingprogram->getTrainingProgramModule($tp_id);
    include("includes/header_files.php");
?>

<div id="container">
	
	<div class="page-wrapper">
		<h1>Grading Criteria</h1>
		<br/>
       
    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
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

    <?php
    if(!empty($tp_modules_list)){
        $ctr = 1;
        foreach($tp_modules_list as $module){
            $module = (object)$module;
            $tpm_grading_criteria_list = $trainingprogram->getTPMCriteriaList($module->id);
            if($ctr == 1){
                echo '<div class="row">';
            }

    ?>
        <div class="col-md-4">
            <div class="box box-default" style="min-height:300px;">
                <div class="box-header">
                    <i class="fa fa-file-text"></i>
                    <h3 class="box-title"><?php echo $module->module_name;?></h3>
                </div>
                <div class="box-body">           
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Criteria</th>
                                <th>Percentage</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $total = 0;
                            if(!empty($tpm_grading_criteria_list)){
                                foreach($tpm_grading_criteria_list as $criteria){
                                    $criteria = (object)$criteria;
                        ?>
                                <tr>
                                    <td><?php echo $criteria->criteria_name;?></td>
                                    <td><?php echo $criteria->percentage;?>%</td>
                                    <td>
                                        <a href="#" class="btn_edit" data-module_name="<?php echo $module->module_name;?>" data-criteria_id="<?php echo $criteria->id;?>" title="Click to edit" style="margin-right:1em;"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn_delete" data-criteria_id="<?php echo $criteria->id;?>" title="Click to delete"><i class="fa fa-trash"></i></a>  
                                    </td>
                                </tr>
                        <?php
                                $total += $criteria->percentage;
                                }
                            }   
                            else {
                        ?>
                                <tr>
                                    <td colspan="3">No criteria available</td>
                                </tr>
                        <?php
                            }
                        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th colspan="2"><?php echo $total;?>%</th>
                            </tr>
                            <tr>
                                <th>Passing Score</th>
                                <th>
                                    <span class='lbl_passing_score'><?php echo $module->passing_score;?>%</span>
                                    <input type='text' data-module_id='<?php echo $module->id;?>' class='form-control input-sm hidden txt_passing_score' size='3' maxlength="3" value='<?php echo $module->passing_score;?>' />
                                </th>
                                <th>
                                    <a href='#' class='btn_edit_passing_score'><i class='fa fa-edit fa-1x'></i></a>
                                    <a href='#' class='hidden btn_save_passing_score'><i class='fa fa-save fa-1x'></i></a>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                     
               
        
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary pull-right btn_add_criteria btn-sm" data-module_name="<?php echo $module->module_name;?>" data-module_id="<?php echo $module->id;?>">Add Criteria</button>
                </div>
            </div>
        </div>
    <?php
            if($ctr == 3){
                echo "</div>";
                $ctr = 1;
            }
            $ctr++;
        }
    }
    else {
    ?>
        <div class="row">
            <div class="col-md-12">
                <p class="alert alert-danger">No modules available.</p>
            </div>
        </div>
        <div class="clearfix"></div>
    <?php } ?>
	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->


<!-- change of program form -->
<div class="modal fade" id="dialog_add_criteria">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="dialog_title"></h4>
      </div>
      <div class="modal-body" >
            <p class="alert alert-info" id="add_notif" style="display:none;"></p>
            <form>
                <div class="form-group">
                    <label class="control-label">Criteria</label>
                    <input type="text" class="form-control" placeholder="Please enter the criteria..." id="txt_criteria"/>
                </div>
                
                <div class="form-group">
                    <label class="control-label">Percentage</label>
                    <input type="text" class="form-control" placeholder="Please enter the percentage..." id="txt_percentage"/>
                </div>
            </form>
            <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-success btn-sm" id="btn_save_criteria">Save</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- change of program form -->
<div class="modal fade" id="dialog_edit_criteria">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="dialog_edit_title"></h4>
      </div>
      <div class="modal-body" >
            <p class="alert alert-info" id="edit_notif" style="display:none;"></p>
            <form>
                <div class="form-group">
                    <label class="control-label">Criteria</label>
                    <input type="text" class="form-control" placeholder="Please enter the criteria..." id="txt_edit_criteria"/>
                </div>
                
                <div class="form-group">
                    <label class="control-label">Percentage</label>
                    <input type="text" class="form-control" placeholder="Please enter the percentage..." id="txt_edit_percentage"/>
                </div>
            </form>
            <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-success btn-sm" id="btn_update_criteria">Save Changes</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
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
    var module_id = 0;
    var criteria_id = 0;
    var elem;
    var criteria;
    var percentage;
    $("body").on("click",".btn_add_criteria",function(){
        module_id = $(this).data("module_id");
        $("#dialog_title").html($(this).data("module_name"));
        $("#dialog_add_criteria").modal("show");
    });

    $("#btn_save_criteria").click(function(){
        if($("#txt_criteria").val() != "" && $("#txt_percentage").val() != ""){
            $.ajax({
                type:"POST",
                data:{
                    module_id : module_id,
                    criteria : $("#txt_criteria").val(),
                    percentage : $("#txt_percentage").val()
                },
                url:"ajax/add_tpm_criteria.php",
                success:function(response){
                    $("#add_notif").html(response).show();
                }
            });
        }
    });

    $("#dialog_add_criteria").on("hidden.bs.modal",function(){
        location.reload();
    });

    $("body").on("click",".btn_edit",function(){
        elem = $(this);
        criteria = elem.parent().parent().children("td:first");
        percentage = elem.parent().parent().children("td:nth-child(2)");
        criteria_id = $(this).data("criteria_id");
        $("#txt_edit_criteria").val(criteria.text());
        $("#txt_edit_percentage").val(percentage.text().slice(0,-1));
        $("#dialog_edit_title").html($(this).data("module_name"));
        $("#dialog_edit_criteria").modal("show");
    });

    $("#btn_update_criteria").click(function(){
        if($("#txt_edit_criteria").val() != "" && $("#txt_edit_percentage").val() != ""){
            $.ajax({
                type:"POST",
                data:{
                    criteria_id   : criteria_id,
                    criteria      : $("#txt_edit_criteria").val(),
                    percentage    : $("#txt_edit_percentage").val()
                },
                url:"ajax/update_tpm_criteria.php",
                success:function(response){
                    location.reload();
                    //criteria.text($("#txt_edit_criteria").val());
                    //percentage.text($("#txt_edit_percentage").val()+"%");
                    //$("#dialog_edit_criteria").modal("hide");
                }
            });
        }
    });

    $("body").on("click",".btn_delete",function(){
        criteria_id = $(this).data("criteria_id");
        elem = $(this);
        $.ajax({
            type:"POST",
            data:{
                criteria_id : criteria_id
            },
            url:"ajax/delete_tpm_criteria.php",
            success:function(response){
                location.reload();
              // elem.parent().parent().fadeOut("1000");
            }
        });
    });

    $("body").on("click",".btn_edit_passing_score",function(){
        $(this).next().removeClass('hidden');
        $(this).addClass('hidden');
        $(this).parent().prev().children("input").removeClass('hidden');
        $(this).parent().prev().children("span:first").addClass('hidden');
    });

     $("body").on("click",".btn_save_passing_score",function(){
        var inpt = $(this).parent().prev().children("input");
        var elem = $(this);
        $.ajax({
            type:"POST",
            data:{
                passing_score : inpt.val(),
                module_id : + " " + inpt.data('module_id')
            },
            url:"ajax/update_module_passing_score.php",
            success:function(response){
                elem.prev().removeClass('hidden');
                elem.addClass('hidden');
                elem.parent().prev().children("input").addClass('hidden');
                elem.parent().prev().children("span:first").text(inpt.val() + "%");
                elem.parent().prev().children("span:first").removeClass('hidden');
            }
        });
    });


});
</script>

</body>
</html>