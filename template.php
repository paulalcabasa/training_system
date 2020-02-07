<?php
	require_once("initialize.php");

    include("includes/header_files.php");
?>
<style>
   .datetimepicker {z-index:-1 !important;}
</style>

<div id="container">
	
	<div class="page-wrapper">
		
		<h1>Title</h1>
		<br/>


        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="fa fa-file-text"></i>
                        <h3 class="box-title">Box Title</h3>
                    </div>
                    <div class="box-body"></div>
                    <div class="box-footer"></div>
                </div>
                <div class="box box-danger">
                    <div class="box-header">
                        <i class="glyphicon glyphicon-user"></i>
                        <h3 class="box-title">Box Title</h3>
                    </div>
                    <div class="box-body">  
                    </div>
                    <div class="box-footer"></div>
                </div>
                 <div class="box box-info">
                    <div class="box-header">
                        <i class="glyphicon glyphicon-user"></i>
                        <h3 class="box-title">Box Title</h3>
                    </div>
                    <div class="box-body">  
                    </div>
                    <div class="box-footer"></div>
                </div>
                 <div class="box box-warning">
                    <div class="box-header">
                        <i class="glyphicon glyphicon-user"></i>
                        <h3 class="box-title">Box Title</h3>
                    </div>
                    <div class="box-body">  
                    </div>
                    <div class="box-footer"></div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="box box-primary" style="min-height:500px;">
                    <div class="box-header">
                        <i class="glyphicon glyphicon-user"></i>
                        <h3 class="box-title">Box Title</h3>
                    </div>
                    <div class="box-body">  
                    </div>
                    <div class="box-footer"></div>
                </div>
            </div>
        </div>
	</div> <!-- end of page content wrapper -->
</div> <!-- end of wrapper -->

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

</script>

</body>
</html>