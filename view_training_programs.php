<?php
	require_once("initialize.php");
  require_once("includes/user_access.php");
  include("includes/header_files.php");
  $program = new Program();
?>

<div id="container">
	<div class="page-wrapper">
		
		<h1>Training Programs</h1>
		<br/>
	  <div class="box box-danger">  <!-- start of panel -->
       <div class="box-header">
          <i class="glyphicon glyphicon-list-alt"></i>
          <h3 class="box-title">List of Training Programs</h3>
          <a href="create_training_program.php" class="btn btn-primary btn-sm pull-right"><i class='fa fa-plus-circle fa-1x'></i> Create</a>
        </div>
        <div class="box-body"> <!-- start of panel body -->
            <table class="table display responsive nowrap table-bordered table-striped" id="tbl_training_programs" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><abbr title="Training Program">TP</abbr> No.</th>
                        <th>Program</th>
                        <th>Trainor</th>
                        <th>Venue</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Action</th>
                        <th>Program Id</th>
                    </tr>
                </thead>
                <tbody>
               
                </tbody>
            </table>
        </div> <!-- end of panel body -->
    </div> <!-- end of panel -->
	</div> <!-- end of page content wrapper -->
</div> <!-- end of wrapper -->

<?php 
    include("panels/confirm_dialog.php");
    include("includes/footer.php"); 
    include("includes/js_files.php");
?>

<script>
$(document).ready(function(){

  $("#sel_samp").select2();
  var tbl_training_programs = $('#tbl_training_programs').DataTable({
      "processing": true,
      "serverSide": true,
      "autoWidth":false,
      "ajax":"ajax/dt_get_training_programs.php",
      "columnDefs": [
            {
                "targets": [ 7 ],
                "visible": false,
                "searchable": false
            }
      ]

  });


  $("#single-append-text").select2();
  $("#navigation-top").children("li:nth-child(3)").addClass("active");

});

</script>

</body>
</html>