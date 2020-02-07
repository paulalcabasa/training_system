<?php
	include("initialize.php");
	require_once("includes/user_access.php");
	include("includes/header_files.php");
?>


<div id="container">
	
	<div class="page-wrapper">	
		
		<h1>New Trainee</h1>
		<hr/>				
		<form role="form" class="form-horizontal" id="frm_trainee_info" method="post" name="frm_trainee_info" enctype="multipart/form-data">
		
	
		<div class="panel">
		<div class="panel-heading">

		</div>
		<div class="panel-body">
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" id="btn_personal" class="active">
				<a href="#panel-trainee-info" aria-controls="trainee" role="tab" data-toggle="tab">Personal Information</a>
			</li>

			<li role="presentation" class="disabled" id="btn_job">
				<a href="#panel-job-details" aria-controls="job details" role="tab" data-toggle="">Job Details and Education</a>
			</li>

			<li role="presentation" class="disabled" id="btn_contact">
				<a href="#panel-contact" aria-controls="trainings" role="tab" data-toggle="">Contact Number and Address</a>
			</li>



			<li role="presentation" class="disabled" id="btn_verify">
				<a href="#panel-verify" id='btn_populate_info' aria-controls="trainings" role="tab" data-toggle="">Verify and Save</a>
			</li>
		</ul>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="panel-trainee-info">
	

			<div class="col-md-6"> <!-- left side -->
				<br/>

				<div class="form-group">			
					<span class='col-sm-3'></span>
					<div class="col-md-9" id="img_prev_wrapper">
						<img src="../../../img/anonymous.png" width='150' height='150' id='img_prev' class='img-reponsive img-rounded'/>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_pic" class="control-label col-sm-3">Picture</label>
					<div class="col-sm-9">
					    <span class="btn btn-primary btn-sm  btn-sm btn-file" style="width:30%;">
       Select Image <input type="file" id="txt_pic" name="txt_pic" onchange="PreviewImage('txt_pic','img_prev')"  />
    </span>
						
					</div>
				</div>

				<div class="form-group">
					<label for="txt_fname" class="control-label col-sm-3">First Name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control input-sm col-sm-9" maxlength="45" id="txt_fname" name="txt_fname" placeholder="First Name"/>
						<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
						<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter first name</p>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_mname" class="control-label col-sm-3 ">Middle Name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control input-sm" id="txt_mname" maxlength="45" name="txt_mname" placeholder="Middle Name"/>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_lname" class="control-label col-sm-3">Last Name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control input-sm" id="txt_lname" maxlength="45" name="txt_lname" placeholder="Last Name"/>
						<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
						<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter last name</p>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_name_extension" class="control-label col-sm-3">Suffix</label>
					<div class="col-sm-9">
						<select class='form-control input-sm' id="cbo_suffix" name="cbo_suffix">
							<option value=''>Select Suffix</option>
							<?php echo $trainee->getNameSuffixes();?>
						</select>
						<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please select name suffix</p>
					</div>
				</div>

			
			</div> <!-- end of left side -->
			
			<div class="col-md-6">
			<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
				<div class="form-group">
					<label for="txt_date_of_birth" class="control-label col-sm-3">Date of Birth</label>
					<div class="col-sm-9">
		                <div class='input-group date' id="txt_date_of_birth">
		                    <input type='text'  name="txt_date_of_birth" class="form-control input-sm" placeholder="Date of Birth"/>
		                    <span class="input-group-addon">
		                        <i class="fa fa-calendar fa-1x"></i>
		                    </span>
		                </div>
		                <p class="help-block custom-help" style="display:none;"><strong>*</strong> Please select date of birth</p>
	                </div>
         	   </div>

         	   	<div class="form-group">
					<label for="txt_age" class="control-label col-sm-3">Age</label>
					<div class="col-sm-9">
						<input type="text" class="form-control input-sm" id="txt_age" name="txt_age" disabled="disabled"/>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_mname" class="control-label col-sm-3">Civil Status</label>
					<div class="col-sm-9">
						<select class="form-control input-sm" name="cbo_civil_status" id="cbo_civil_status">
							<option value="single">Single</option>
							<option value="married">Married</option>
							<option value="windowed">Widowed</option>
							<option value="separated">Separated</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3">Gender</label>
					<div class="col-sm-9">
						<label class="checkbox-inline">
							<input type="radio" id="rdo_male" value="0" name="gender" checked="checked"/> Male
						</label>
						<label class="checkbox-inline">
							<input type="radio" id="rdo_female" value="1" name="gender"/> Female
						</label>
					</div>		
				</div>
				
				<div class="form-group">
					<button type="button" class="btn btn-primary btn-sm pull-right" id="btn_next_1"><i class='fa fa-hand-o-right fa-1x'></i> Next</button>
				</div>
			</div>
		</div> <!-- end of first tab -->
			

			<div role="tabpanel" id="panel-job-details" class="tab-pane fade"> <!-- start of second tab -->
				<br/>

				<div class="col-md-6"> <!-- start of left side -->

					<div class="form-group">
						<label for="txt_highest_educ_att" class="control-label col-lg-3">Education</label>
						<div class="col-lg-9">
							<select class="form-control input-sm" id="txt_highest_educ_att" name="txt_highest_educ_att">
								<?php echo $trainee->getEducation();?>
							</select>
						
							
						</div>
					</div>

					<div class="form-group">
						<label for="txt_dealer_name" class="control-label col-sm-3">Dealer Name</label>
						<div class="col-sm-9">
							<select class="form-control input-sm" id="txt_dealer_name" name="txt_dealer_name">
									<?php echo $trainee->createDealerOption(); ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="cbo_job_position" class="control-label col-sm-3">Job Position</label>
						<div class="col-sm-9">
							<select class="form-control input-sm" id="cbo_job_position" name="cbo_job_position">
								<?php echo $job->getJobPositionOption(); ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="cbo_emp_status" class="control-label col-sm-3">Employment Status</label>
						<div class="col-sm-9">
							<select class="form-control input-sm" id="cbo_emp_status" name="cbo_emp_status">
								<?php echo $trainee->getEmploymentStatusOption(); ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="txt_date_hired" class="control-label col-sm-3">Date Hired</label>
						<div class="col-sm-9">
							<div class='input-group date' id="txt_date_hired">
								<input type='text' class="form-control input-sm" name="txt_date_hired" placeholder="Date Hired" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please select date hired</p>
		            	</div>
	         	   </div>
	         	   
					<div class="form-group">
						<label for="txt_length_of_service" class="control-label col-sm-3">Length of Service</label>
						<div class="col-sm-9">
							<input type="text" class="form-control input-sm" id="txt_length_of_service" name="txt_length_of_service" disabled="disabled"/>
						</div>
					</div>

				

					<div class="form-group">
						<div class="pull-right">
							<button type="button" class="btn btn-success btn-sm" id="btn_job_prev"><i class='fa fa-hand-o-left fa-1x'></i> Previous</button>
							<button type="button" class="btn btn-primary btn-sm" id="btn_job_next"><i class='fa fa-hand-o-right fa-1x'></i> Next</button>
						</div>
					</div>

				</div> <!-- end of left side -->
			</div> <!-- end of second tab -->

			<div role="tabpanel" id="panel-contact" class="tab-pane fade"> <!-- start of third tab -->
				<br/>
				<div class="col-md-6"> <!-- start of left side -->

					<div class="form-group">
						<label for="txt_mobile" class="control-label col-sm-3">Mobile No.</label>
						<div class="col-sm-9">
							<div class="input-group">
								<input type="text" class="form-control input-sm" id="txt_mobile" name="txt_mobile" placeholder="(XXXX) XXX-XXXX" />
								<span class="input-group-btn">
									<button class="btn btn-primary btn-sm" type="button" title='Click to add a mobile number' id='btn_add_mobile_no'>Add</button>
								</span>
							</div>
							<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter mobile number</p>
							<div style="height:100px;overflow-y:auto;">
								<ul class="list-group" id="list_of_mobile_no">
									
								</ul>
							</div>
						</div>
					</div>


					<div class="form-group">
						<label for="txt_office" class="control-label col-sm-3">Telephone No.</label>
						<div class="col-sm-9">
							<input type="text" class="form-control input-sm" id="txt_office" name="txt_office" placeholder="(XXX) XXX-XXXX" />
							<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
							<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter telephone number</p>
						</div>
					</div>

				

				</div> <!-- end of left side -->

				<div class="col-md-6"> <!-- start of right side -->
					<div class="form-group">
						<label for="cbo_province" class="control-label col-sm-3">Province</label>
						<div class="col-sm-9">
						 	<select id="cbo_province" name="cbo_province" class='form-control'>
						 		<?php echo $phzipcode->getProvincesOption();?>
						 	</select>
						 	<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
							<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please select a province</p>

						</div>
					</div>

					<div class="form-group">
						<label for="cbo_municipality" class="control-label col-sm-3">Municipality</label>
						<div class="col-sm-9">
							<select id="cbo_municipality" name="cbo_municipality" class='form-control'></select>
							<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
							<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please select a municipality</p>
						</div>
					</div>

					<div class="form-group">
						<label for="txt_home" class="control-label col-sm-3">Zip Code</label>
						<div class="col-sm-9">
							<input type='text' id='txt_zip_code' class='form-control' disabled="disabled"/>
						</div>
					</div>

					<div class="form-group">
						<label for="txt_home" class="control-label col-sm-3">Home / Present Address</label>
						<div class="col-sm-9">
							<input type="text" id="txt_street_addr" name="txt_street_addr" class='form-control' placeholder="Home or Present Address"/>
							<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
							<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter home / present address</p>
						</div>
					</div>

					<div class="form-group">
						<div class="pull-right">
							<button type="button" class="btn btn-success btn-sm" id="btn_contact_prev"><i class='fa fa-hand-o-left fa-1x'></i> Previous</button>
							<button type="button" class="btn btn-primary btn-sm" id="btn_contact_next"><i class='fa fa-hand-o-right fa-1x'></i> Next</button>
						</div>
					</div>
				</div> <!-- end of right side -->

			</div> <!-- end of third tab -->
		
			
			<div role="tabpanel" id="panel-verify" class="tab-pane fade"> <!-- start of fifth tab -->
				<br/>
				<div class="col-md-6"> <!-- start of left side -->
					
					<h3>Personal Information</h3>
					<hr/>
					<blockquote>
					<table style="width:70%;">
						<tr>
							<td id="lbl_pic"></td>
							<td valign="top">
								<table>
									<tr>
										<td width='150'>First Name</td>
										<td><span id="lbl_fname"></span></td>
									</tr>
									<tr>
										<td width='150'>Middle Name</td>
										<td><span id="lbl_mname"></span></td>
									</tr>
									<tr>
										<td width='150'>Last Name</td>
										<td><span id="lbl_lname"></span></td>
									</tr>
									<tr>
										<td width='150'>Suffix</td>
										<td><span id="lbl_suffix"></span></td>
									</tr>
									<tr>
										<td width='150'>Date of Birth</td>
										<td><span id="lbl_bday"></span></td>
									</tr>
									<tr>
										<td width='150'>Age: </td>
										<td><span id="lbl_age"></span></td>
									</tr>

									<tr>
										<td width='150'>Civil Status: </td>
										<td><span id="lbl_civil_status" class="capitalize"></span></td>
									</tr>

									<tr>
										<td width='150'>Gender: </td>
										<td><span id="lbl_gender"></span></td>
									</tr>
								</table>
							</td>
						</tr>
						</table>
					</blockquote>

					<h3>Job Details and Education</h3>
					<hr/>
					<blockquote>
						<table>
							<tr>
								<td width='150'>Education </td>
								<td><span id="lbl_education"></span></td>
							</tr>
							<tr>
								<td width='150'>Dealer Name: </td>
								<td><span id="lbl_dealer_name"></span></td>
							</tr>
							<tr>
								<td width='150'>Job Position: </td>
								<td><span id="lbl_job"></span></td>
							</tr>
				
							<tr>
								<td width='150'>Date Hired: </td>
								<td><span id="lbl_date_hired"></span></td>
							</tr>
							<tr>
								<td width='150'>Length of Service: </td>
								<td><span id="lbl_length_of_service"></span></td>
							</tr>

							<tr>
								<td width='150'>Employment Status</td>
								<td><span id="lbl_emp_status"></span></td>
							</tr>
							
						</table>
					</blockquote>

				</div>

				<div class="col-md-6">
					<h3>Contact Number and Address</h3>
					<hr/>
					<blockquote>
						<table>
							<tr>
								<td width='150' valign="top">Mobile No. </td>
								<td><ol id="mobile_list"></ol></td>
							</tr>
							<tr>
								<td width='150'>Telephone No. </td>
								<td><span id="lbl_office"></span></td>
							</tr>
							<tr>
								<td width='150'>Province </td>
								<td><span id="lbl_province"></span></td>
							</tr>
							<tr>
								<td width='150'>Municipality </td>
								<td><span id="lbl_municipality"></span></td>
							</tr>
							<tr>
								<td width='150'>Zip Code </td>
								<td><span id="lbl_zip_code"></span></td>
							</tr>
							<tr>
								<td width='150'>Street Address </td>
								<td><span id="lbl_street"></span></td>
							</tr>
						</table>
					</blockquote>

					


					<div class="form-group">
						<div class="col-lg-10 col-lg-offset-2">
							<div class="pull-right">
							<button type="button" class="btn btn-success btn-sm" id="btn_verify_prev"><i class='fa fa-hand-o-left fa-1x'></i> Previous</button>
							<button type="button" class="btn btn-primary btn-sm" id="btn_save" name="btn_save"><i class="fa fa-save fa-1x"></i> Save</button>
							</div>
						</div>
					</div>

				</div> <!-- end of right side -->

			</div> <!-- end of fifth tab -->
		
		</div> <!-- end of panel body -->

			</div> <!-- end of panel -->

		</form>  <!-- end of form --> 


	</div> <!-- end of page-wrapper -->
</div> <!-- end of container -->

<?php include("panels/information_dialog.php"); ?>

<!-- dialog box -->
<div class="modal fade" id="dialog_confirm">
  <div class="modal-dialog">
    <div class="modal-content">
    	  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Information</h4>
      </div>
      <div class="modal-body">
        <p id="dialog_content"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-sm" id="btn_redirect">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php 
	
	include("includes/js_files.php"); 
?>


<script>

// function to mark errors in text box
function mark_error_input(id){
	$(id).parent().parent().addClass("has-error");
	$(id).parent().parent().addClass("has-feedback");
	$(id).next().removeClass("glyphicon-ok");
	$(id).next().addClass("glyphicon-remove");
	$(id).next().show("slow");
	$(id).next().next().show("slow");	
}

// function to mark success in text box
function mark_success_input(id){
	$(id).parent().parent().removeClass("has-error");
	$(id).parent().parent().addClass("has-success");
	$(id).parent().parent().addClass("has-feedback");
	$(id).next().show("slow");
	$(id).next().removeClass("glyphicon-remove");
	$(id).next().addClass("glyphicon-ok");
	$(id).next().next().hide("slow");
}

// function to mark errors in text box
function mark_error_select(id){
	$(id).parent().parent().addClass("has-error");
	$(id).parent().parent().addClass("has-feedback");
	$(id).next().next().show("slow");
}

// function to mark success in text box
function mark_success_select(id){
	$(id).parent().parent().removeClass("has-error");
	$(id).parent().parent().addClass("has-success");
	$(id).parent().parent().addClass("has-feedback");
	$(id).next().next().hide("slow");
}

// function for validation select tags
function validate_select(id){
	$(id).on("change",function(){
		if($(this).val()!=""){

			mark_success_select(id);
		}
		else {
			mark_error_select(id);
		}
	});
}

// function to validate input upon typing
function validate_input(id){
	$(id).on("input",function(){
		if($(this).val()!=""){

			mark_success_input(id);
		}
		else {
			mark_error_input(id);
		}
	});
}

// function to validate dates
function validate_date(id){
	if($(id).data('date') == undefined){
		$(id).parent().parent().addClass("has-error");
		$(id).next().show("slow");
		return true;
	} else {
		$(id).parent().parent().removeClass("has-error");
		$(id).parent().parent().addClass("has-success");
		$(id).next().hide("slow");
		return false;
	}
}

function validate_textarea(id){
	if($(id).val() == ""){
		$(id).parent().parent().addClass("has-error");
		$(id).next().show("slow");
		return true;
	} else {
		$(id).parent().parent().removeClass("has-error");
		$(id).parent().parent().addClass("has-success");
		$(id).next().hide("slow");
		return false;
	}
}

// function for activating tabs and disabling buttons
function activate_tab(tab_id,button1,button2){
	$('[href='+tab_id+']').tab('show'); 
	$(button1).removeClass("disabled");
	$(button1+" a").attr("data-toggle","tab");

	$(button2).removeClass("active");
	$(button2).addClass("disabled");
	$(button2 +" a").attr("data-toggle","");
}

function copy_info(){

	var gender = $("#rdo_male").is(":checked") ? "Male" : "Female";
	$("#lbl_fname").text($("#txt_fname").val());
	$("#lbl_mname").text($("#txt_mname").val());
	$("#lbl_lname").text($("#txt_lname").val());
	$("#lbl_bday").text( moment($("#txt_date_of_birth").data("date"), 'YYYY-MM-DD').format('MMMM D, YYYY'));
	$("#lbl_age").text($("#txt_age").val());
	$("#lbl_civil_status").text($("#cbo_civil_status").val());
	$("#lbl_gender").text(gender);
	$("#lbl_dealer_name").text($("#txt_dealer_name option:selected").text());
	$("#lbl_job").text($("#cbo_job_position option:selected").text());
	$("#lbl_date_hired").text( moment($("#txt_date_hired").data("date"), 'YYYY-MM-DD').format('MMMM D, YYYY'));
	$("#lbl_length_of_service").text($("#txt_length_of_service").val());
	$("#lbl_pic").html($("#img_prev_wrapper").html());
	$("#lbl_office").text($("#txt_office").val());
	$("#lbl_education").text($("#txt_highest_educ_att option:selected").text());
	$("#lbl_province").text($("#cbo_province option:selected").text());
	$("#lbl_zip_code").text($("#txt_zip_code").val());
	$("#lbl_municipality").text($("#cbo_municipality option:selected").text());
	$("#lbl_street").text($("#txt_street_addr").val());
	$("#lbl_emp_status").text($("#cbo_emp_status option:selected").text());
	$("#lbl_suffix").text($("#cbo_suffix option:selected").text());
	$("#mobile_list").html();
	$("#list_of_mobile_no li .mbl_no").each(function(){
		$("#mobile_list").append("<li>" + $(this).text() + "</li>");
	});
}


$(document).ready(function(){
	$("#navigation-top").children("li:nth-child(2)").addClass("active");
	


	// globals
 	var isError = false;
 	var date = new Date();
    var currentMonth = date.getMonth();
    var currentDate = date.getDate();
    var currentYear = date.getFullYear();

	/// remove key event for text box
	remove_key_event("#txt_date_of_birth");
	remove_key_event("#txt_date_hired");

	// initialize datetimepicker
    $('#txt_date_of_birth').datetimepicker({
    	format:"YYYY-MM-DD",
    	useCurrent : false
    });

  	 $('#txt_date_hired').datetimepicker({
  	 	useCurrent : false,
    	format:"YYYY-MM-DD",
    	maxDate: new Date(currentYear, currentMonth, currentDate)
    });

  	 // date validations
  	$("#txt_date_of_birth").on('dp.change', function (e) {
    	// $("#txt_date_hired").data("DateTimePicker").minDate(e.date); 
		  //validate_date("#txt_date_of_birth");
		/*var m1 = moment($(this).data("date")).format('M/D/YYYY');
	    var m2 = moment().format('M/D/YYYY');
	    var diff = moment.preciseDiff(m1, m2);
	    $("#txt_age").val(diff + " old.");*/
 	});

	$("#txt_date_hired").on("dp.change",function(){
		validate_date("#txt_date_hired");
  		var m1 = moment($(this).data("date")).format('M/D/YYYY');
	    var m2 = moment().format('M/D/YYYY');
	    var diff = moment.preciseDiff(m1, m2);
	    $("#txt_length_of_service").val(diff);

			
	});

		
 	
  	// function to compute age e.g Birthdate Length of Service
    computeDPYear("#txt_date_of_birth","#txt_age","years old");
   // computeDPYear("#txt_date_hired","#txt_length_of_service","years");

    // textfield validations
    validate_input("#txt_fname");
	validate_input("#txt_lname");
	validate_input("#txt_office");
	validate_select("#cbo_province");
	validate_select("#cbo_municipality");
    // function to add a trainee
    $("#btn_save").click(function(e){
    	var mobile_list = [];
    	var index = 0;
    	$("#list_of_mobile_no li .mbl_no").each(function(){
    		mobile_list[index] = $(this).text();
    		index++;
    	});
    	mobile_list = JSON.stringify(mobile_list);

    	var formData = new FormData($("#frm_trainee_info")[0]);
    	formData.append("mobile",mobile_list);
    	$("#dialog_content").html("Please wait... <img src='../../../img/ajax-loader.gif'/>");
    	$("#dialog_confirm").modal({
    		backdrop:'static'
    	});
    	$.ajax({
    		type:"POST",
    		url:"php_processors/proc_add_trainee.php",
    		data: formData,
    		cache: false,
    		contentType: false,
    		processData: false,
    		success:function(response){
    			$("#dialog_content").text(response);
    		
    		}
    	});

    	e.preventDefault();
    });

	// personal infor tab
	$("#btn_next_1").click(function(e){
	    isError = false;
		
		isError = validate_date("#txt_date_of_birth");
		if($.trim($("#txt_fname").val()) == ""){
			mark_error_input("#txt_fname");
			isError = true;
		}
		if($("#txt_lname").val() == ""){
			mark_error_input("#txt_lname");
			isError = true;
		}
		if(!isError){
			activate_tab("#panel-job-details","#btn_job","#btn_personal");
		}
	});

	// job details tab
	$("#btn_job_prev").click(function(e){
		activate_tab("#panel-trainee-info","#btn_personal","#btn_job");
	});

	$("#btn_job_next").click(function(e){
		isError = false;

		isError = validate_date("#txt_date_hired");

		if(!isError){
			activate_tab("#panel-contact","#btn_contact","#btn_job");
		}

	});


	// contact tab
	$("#btn_contact_prev").click(function(e){
		activate_tab("#panel-job-details","#btn_job","#btn_contact");
	});
	
	validate_input("#txt_street_addr");
	$("#btn_contact_next").click(function(e){
		isError = false;

		var list_of_mobile_no = $("#list_of_mobile_no").children().length;

		if(list_of_mobile_no > 0 ){
			isError = false;

		} else {
			isError = true;
			alert("Please add atleast one mobile no.");
		}

		if($("#txt_office").val() == ""){
			mark_error_input("#txt_office");
			isError = true;
		}

		if($("#txt_street_addr").val() == ""){
			mark_error_input("#txt_street_addr");
			isError = true;
		}

		if($("#cbo_province").val() == ""){
			mark_error_select("#cbo_province");
			isError = true;
		}

		if($("#cbo_municipality").val() == ""){
			mark_error_select("#cbo_municipality");
			isError = true;
		}

		if(!isError){
			activate_tab("#panel-verify","#btn_verify","#btn_contact");
			copy_info();
		}
	});
	

	$("#btn_verify_prev").click(function(e){
		activate_tab("#panel-contact","#btn_educ","#btn_verify");
	});

	$("#btn_redirect").click(function(e){
		window.location.href = "view_trainees.php";
	});

	$("#txt_mobile").mask("(9999) 999-9999",{placeholder:"(XXXX) XXX-XXXX"});
	$("#txt_office").mask("(999) 999-9999",{placeholder:"(XXX) XXX-XXXX"});

	$("#txt_office").on("change",function(){
		if($(this).val()!=""){
			mark_success_input("#txt_office");
		}
		else {
			mark_error_input("#txt_office");
		}
	});

	$("#dialog_confirm").on("hidden.bs.modal",function(){
		window.location.href="view_trainees.php";
	});

	$("#cbo_province").change(function(){
		$("#cbo_municipality").val("");
		$("#txt_zip_code").val("");
		$.ajax({
			type:"POST",
			data:{
				id : $("#cbo_province").val()
			},
			url:"php_processors/proc_get_municipality.php",
			success:function(response){
				$("#cbo_municipality").html(response);
			}
		});
	});

	$("#cbo_municipality").change(function(){
		$("#txt_zip_code").val($("#cbo_municipality option:selected").data("zip_code"));
	});

	$("#btn_add_mobile_no").click(function(){
		if($("#txt_mobile").val()!=""){
			var new_mobile_no = "";
			new_mobile_no += "<li class='list-group-item' style='padding:.2em .2em .2em .5em;'>";
			new_mobile_no += "<span class='mbl_no'>"+$("#txt_mobile").val()+"</span>";
			new_mobile_no += "<button type='button' class='btn btn-danger btn-xs pull-right btn_remove_mobile' title='Click to remove the mobile no.'><i class='fa fa-trash fa-1x'></i> Remove</button><div class='clearfix'></div></li>";
			$("#list_of_mobile_no").append(new_mobile_no);
			$("#txt_mobile").val("");
			$("#txt_mobile").focus();

		} else {
			$("#dialog_info_title").html("Information");
			$("#dialog_info_content").html("Please enter a valid phone number.");
			$("#dialog_info").modal("show");
		}
	});

	$("body").on("click",".btn_remove_mobile",function(){
		$(this).parent().remove();
	});
});
</script>

</body>
</html>