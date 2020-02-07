<?php
	include("initialize.php");
	$trainee = new Trainee();
	$encryption = new Encryption();
	$phzipcode = new Phzipcode();
	$job = new Job();
	$dealer = new Dealer();
	$civilstatus = new CivilStatus();
	$trainee_code = $encryption->decrypt($get->d);
	$details = $trainee->getTraineeDetails($trainee_code);
	$list_of_education = $trainee->getEducationList();
	$list_of_employment_status = $trainee->getEmploymentStatusList();
	$list_of_dealers = $dealer->getDealersList();
	$list_of_provinces = $phzipcode->getProvincesList();
	$list_of_civil_status = $civilstatus->getCivilStatusList();
	$list_of_name_suffixes = $trainee->getNameSuffixesList();
	$trainee_pic = ($details->picture != "" ? $details->picture : "anonymous.png");
	$list_of_municipality = $phzipcode->getMunicipalitiesList($details->province_id);
	$list_of_mobile_no = $trainee->getMobileList($trainee_code);

	include("includes/header_files.php");
?>

<div id="container">
	
	<div class="page-wrapper">	
		
		<h1>Trainee Information</h1>
		<br/>

		<form role="form" class="form-horizontal" id="frm_trainee_info" enctype="multipart/form-data" method="post" name="frm_trainee_info">
		<input type="hidden" name="trainee_code" id="trainee_code" value="<?php echo $trainee_code;?>"/>

		<div class="nav-tabs-custom" style="min-height:500px;">
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" id="btn_personal" class="active">
				<a href="#panel-trainee-info" aria-controls="trainee" role="tab" data-toggle="tab">Personal Information</a>
			</li>

			<li role="presentation" id="btn_job">
				<a href="#panel-job-details" aria-controls="job details" role="tab" data-toggle="tab">Job and Education</a>
			</li>

			<li role="presentation" id="btn_contact">
				<a href="#panel-contact" aria-controls="trainings" role="tab" data-toggle="tab">Contact Number and Address</a>
			</li>

			<li role="presentation" id="btn_dealership_history">
				<a href="#panel-dealership_history" aria-controls="dealership" role="tab" data-toggle="tab">Dealership History</a>
			</li>

			<li role="presentation" id="btn_job_position_history">
				<a href="#panel-job_position_history" aria-controls="job position" role="tab" data-toggle="tab">Job Position History</a>
			</li>

		
		</ul>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="panel-trainee-info">
	
			<div class="col-md-6"> <!-- left side -->
				<br/>
				<div class="form-group">
					<label for="txt_fname" class="control-label col-sm-3">First Name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control   col-sm-9" id="txt_fname" name="txt_fname" placeholder="First Name" value="<?php echo $details->first_name;?>"/>
						<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
						<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter first name</p>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_mname" class="control-label col-sm-3 ">Middle Name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control  " id="txt_mname" name="txt_mname" placeholder="Middle Name" value="<?php echo $details->middle_name;?>"/>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_lname" class="control-label col-sm-3">Last Name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control  " id="txt_lname" name="txt_lname" placeholder="Last Name" value="<?php echo $details->last_name;?>"/>
						<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
						<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter last name</p>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_nickname" class="control-label col-sm-3">Nickname</label>
					<div class="col-sm-9">
						<input type="text" class="form-control  " id="txt_nickname" name="txt_nickname" placeholder="Nickname" value="<?php echo $details->nickname;?>"/>
						<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
						<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter last name</p>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_name_extension" class="control-label col-sm-3">Suffix</label>
					<div class="col-sm-9">
						<select class='form-control  ' id="cbo_suffix" name="cbo_suffix">
							<option value=''>Select Suffix</option>
						<?php
							foreach($list_of_name_suffixes as $suffix){
								$suffix = (object)$suffix;
								$is_selected = ($suffix->id == $details->name_suffix_id) ? "selected" : "";
						?>
							<option value="<?php echo $suffix->id; ?>" <?php echo $is_selected;?> ><?php echo $suffix->suffix; ?></option>
						<?php
							}
						?>
						</select>
						<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please select name suffix</p>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_date_of_birth" class="control-label col-sm-3">Date of Birth</label>
					<div class="col-sm-9">
		                <div class='input-group date' id="txt_date_of_birth">
		                    <input type='text'  name="txt_date_of_birth" class="form-control  " placeholder="Date of Birth" value="<?php echo $details->date_of_birth;?>"/>
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </div>
		                <p class="help-block custom-help" style="display:none;"><strong>*</strong> Please select date of birth</p>
	                </div>
         	   </div>

         	   	<div class="form-group">
					<label for="txt_age" class="control-label col-sm-3">Age</label>
					<div class="col-sm-9">
						<input type="text" class="form-control  " id="txt_age" name="txt_age" disabled="disabled"/>
					</div>
				</div>

				<div class="form-group">
					<label for="txt_mname" class="control-label col-sm-3">Civil Status</label>
					<div class="col-sm-9">
						<select class="form-control  " name="cbo_civil_status" id="cbo_civil_status">
							<option value="">Select civil status</option>
				 		<?php
				 			foreach($list_of_civil_status as $status){
				 				$status = (object)$status;
				 				$is_selected = ($status->id == $details->employment_status_id) ? "selected" : "";
				 		?>
				 			<option value="<?php echo $status->id;?>" <?php echo $is_selected;?> ><?php echo $status->status;?></option>
				 		<?php
				 			}
				 		?>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3">Gender</label>
					<div class="col-sm-9">
						<label class="checkbox-inline">
							<input type="radio" id="rdo_male" value="0" name="gender" <?php if($details->gender == 0){ echo "checked"; }?> /> Male
						</label>
						<label class="checkbox-inline">
							<input type="radio" id="rdo_female" value="1" name="gender" <?php if($details->gender == 1){ echo "checked"; }?>/> Female
						</label>
					</div>		
				</div>
				
				<div class="form-group">
					<button type="button" class="btn btn-primary btn-sm pull-right" id="btn_next_1"><i class='fa fa-save fa-1x'></i> Save Changes</button>
				</div>
			
			</div> <!-- end of left side -->
			
			<div class="col-md-6">
				<br/>
				<div class="form-group">			
					<span class='col-sm-3'></span>
					<div class="col-md-9">
						<input type="hidden" value="<?php echo $trainee_pic;?>" id="old_pic" name="old_pic"/>
						<img src="trainee_pics/<?php echo $trainee_pic;?>" width='250' height='250' id='img_prev' class='img img-reponsive img-rounded'/>
						<br/>
						  <span class="btn btn-primary btn-file" style="width:51%;margin-top:-4.2em;opacity:.8;">
				       Change Image <input type="file" id="txt_pic" name="txt_pic" />
					</div>
				</div>

				
			</div>
		</div> <!-- end of first tab -->
			
			<div role="tabpanel" id="panel-job-details" class="tab-pane fade"> <!-- start of second tab -->
				<br/>

				<div class="col-md-6"> <!-- start of left side -->

					<div class="form-group">
						<label for="txt_highest_educ_att" class="control-label col-lg-3">Education</label>
						<div class="col-lg-9">
						
							<select class="form-control  " id="cbo_education" name="cbo_education">
							<?php
								foreach($list_of_education as $education){
									$education = (object)$education;
									$is_selected = ($education->id == $details->education_id) ? "selected" : "";
							?>
								<option value="<?php echo $education->id;?>" <?php echo $is_selected;?> ><?php echo $education->education_desc; ?></option>
							<?php
								}
							?>
							</select>	
						</div>
					</div>

					<div class="form-group">
						<label for="txt_dealer_name" class="control-label col-sm-3">Dealer</label>
						<div class="col-sm-9">
								<select class="form-control" id="txt_dealer_name" name="txt_dealer_name">
									<?php
										foreach($list_of_dealers as $d){
											$d = (object)$d;
											$is_selected = ($d->id == $details->dealer_id) ? "selected" : "";
									?>
										<option value="<?php echo $d->id;?>" <?php echo $is_selected;?> ><?php echo $d->dealer_name; ?></option>
									<?php
										}
									?>
								</select>
							
						</div>
					</div>

					<div class="form-group">
						<label for="cbo_job_position" class="control-label col-sm-3">Job Position</label>
						<div class="col-sm-9">
							
								<input type="hidden" id="txt_current_job" value="<?php echo $details->job_position_id; ?>"/>
								<select class="form-control" id="cbo_job_position" name="cbo_job_position">
									<?php echo $job->getJobPositionOption();?>
								</select>
							
						</div>
					</div>

					<div class="form-group">
						<label for="cbo_emp_status" class="control-label col-sm-3">Employment Status</label>
						<div class="col-sm-9">
							<select class="form-control  " id="cbo_emp_status" name="cbo_emp_status">
								
								<?php
								foreach($list_of_employment_status as $status){
									$status = (object)$status;
									$is_selected = ($status->id == $details->employment_status_id) ? "selected" : "";
							?>
								<option value="<?php echo $status->id;?>" <?php echo $is_selected;?> ><?php echo $status->description; ?></option>
							<?php
								}
							?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="txt_date_hired" class="control-label col-sm-3">Date Hired</label>
						<div class="col-sm-9">
			                <div class='input-group date' id="txt_date_hired">
			                    <input type='text' class="form-control  " name="txt_date_hired"  placeholder="Date Hired" value="<?php echo $details->date_hired; ?>" />
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                </div>
			                 <p class="help-block custom-help" style="display:none;"><strong>*</strong> Please select date of birth</p>
		                </div>
	         	   </div>

					<div class="form-group">
						<label for="txt_length_of_service" class="control-label col-sm-3">Length of Service</label>
						<div class="col-sm-9">
							<input type="hidden" id="txt_cur_date" value="<?php echo date('Y-m-d');?>"/>
							<input type="text" class="form-control" id="txt_length_of_service" name="txt_length_of_service" disabled="disabled"/>
						</div>
					</div>

					

					<div class="form-group">
						<div class="pull-right">
							<button type="button" class="btn btn-primary btn-sm" id="btn_job_next"><i class='fa fa-save fa-1x'></i> Save Changes</button>
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
								<input type="text" class="form-control  " id="txt_mobile" name="txt_mobile" placeholder="(XXXX) XXX-XXXX" />
								<span class="input-group-btn">
									<button class="btn btn-primary" type="button" title='Click to add a mobile number' id='btn_add_mobile_no'>Add</button>
								</span>
							</div>
							<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter mobile number</p>
							<div style="height:100px;overflow-y:auto;">
								<ul class="list-group" id="list_of_mobile_no">
								<?php
									foreach($list_of_mobile_no as $mobile) {	
										$mobile = (object)$mobile;
								?>
									<li class='list-group-item' style='padding:.2em .2em .2em .5em;'>
									<span class='mbl_no'><?php echo $mobile->mobile_no;?></span>
									<button type='button' data-id='<?php echo $mobile->id;?>' class='btn btn-danger btn-xs pull-right btn_remove_mobile' title='Click to remove the mobile no.'><i class='fa fa-trash fa-1x'></i> Remove</button><div class='clearfix'></div>
									</li>
								<?php 
									}
								?>
								</ul>
							</div>
						</div>
					</div>


					<div class="form-group">
						<label for="txt_office" class="control-label col-sm-3">Telephone No.</label>
						<div class="col-sm-9">
							<input type="text" class="form-control  " id="txt_office" name="txt_office" placeholder="(XXX) XXX-XXXX" value="<?php echo $details->telephone_no;?>" />
							<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
							<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter telephone number</p>
						</div>
					</div>

					<div class="form-group">
						<label for="txt_email" class="control-label col-sm-3">Email</label>
						<div class="col-sm-9">
							<input type="email" class="form-control  " id="txt_email" name="txt_email" value="<?php echo $details->email;?>" placeholder="Email address"/>
							<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
							<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter email address</p>
						</div>
					</div>


				</div> <!-- end of left side -->

				<div class="col-md-6"> <!-- start of right side -->
					<div class="form-group">
						<label for="cbo_province" class="control-label col-sm-3">Province</label>
						<div class="col-sm-9">
						 	<select id="cbo_province" name="cbo_province" class='form-control'>
						 		<option value="">Select province</option>
					 		<?php
					 			foreach($list_of_provinces as $province){
					 				$province = (object)$province;
					 				$is_selected = ($province->id == $details->province_id) ? "selected" : "";
					 		?>
					 			<option value="<?php echo $province->id;?>" <?php echo $is_selected;?> ><?php echo $province->province_name;?></option>
					 		<?php
					 			}
					 		?>
						 	</select>
						 	<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
							<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please select a province</p>

						</div>
					</div>

					<div class="form-group">
						<label for="cbo_municipality" class="control-label col-sm-3">Municipality</label>
						<div class="col-sm-9">
							<select id="cbo_municipality" name="cbo_municipality" class='form-control'>
							<?php
								foreach($list_of_municipality as $municipality){
									$municipality = (object)$municipality;
									$is_selected = ($municipality->id == $details->municipality_id) ? "selected" : "";
							?><option value='<?php echo $municipality->id;?>' <?php echo $is_selected;?> data-zip_code='<?php echo $municipality->zip_code;?>'><?php echo $municipality->municipality_name; ?></option>
							<?php 
								}	
							?>
							</select>
							<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
							<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please select a municipality</p>
						</div>
					</div>

					<div class="form-group">
						<label for="txt_home" class="control-label col-sm-3">Zip Code</label>
						<div class="col-sm-9">
							<input type='text' id='txt_zip_code' class='form-control' disabled="disabled" value="<?php echo $details->zip_code;?>"/>
						</div>
					</div>

					<div class="form-group">
						<label for="txt_home" class="control-label col-sm-3">Home / Present Address</label>
						<div class="col-sm-9">
							<input type="text" id="txt_street_addr" name="txt_street_addr" class='form-control' placeholder="Street Address" value="<?php echo $details->street_address;?>"/>
							<span class="glyphicon glyphicon-remove form-control-feedback" style="display:none;" aria-hidden="true"></span>
							<p class="help-block custom-help" style="display:none;"><strong>*</strong> Please enter home / present address</p>
						</div>
					</div>

					<div class="form-group">
						<div class="pull-right">
							
							<button type="button" class="btn btn-primary btn-sm" id="btn_contact_next"><i class='fa fa-save fa-1x'></i> Save Changes</button>
						</div>
					</div>
				</div> <!-- end of right side -->

			</div> <!-- end of third tab -->


			<div role="tabpanel" id="panel-dealership_history" class="tab-pane fade"> <!-- start of fourth tab -->
				<br/>
				<div class="row">
					<div class="col-md-3">
						<div class="well">
							<fieldset>
								<legend style="font-size:12pt;">Current Dealer</legend>
								<p>
									<span class="text-bold">Dealer</span><br/>
									<span class="" id="lbl_dealer_name"><?php echo $details->dealer_name?></span>
								</p>
								<p>
									<span class="text-bold">Job Position</span><br/>
									<span class="" id="lbl_job_desc"><?php echo $details->job_description;?></span>
								</p>
								<p>
									<span class=" text-bold">Employment Status</span><br/>
									<span class="" id="lbl_emp_status"><?php echo $details->employment_status;?></span>
								</p>
								<p>
									<span class="text-bold">Date Hired</span><br/>
									<span class="" id="lbl_date_hired"><?php echo $details->date_hired; ?></span>
								</p>
							</fieldset>
						
						</div>
					</div>
					<div class="col-md-9">
						<table class="table display table-condensed table-striped" id="tbl_dealership_history">
							<thead>	
								<tr>
									<th>Dealer</th>
									<th>Job Position</th>
									<th>Employment Status</th>
									<th>Date Hired</th>
									<th>Date Updated</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>

			</div> <!-- end of fourth tab -->

			<div role="tabpanel" id="panel-job_position_history" class="tab-pane fade"> <!-- start of fourth tab -->
				<br/>
				
				<div class="row">
					<div class="col-md-3">
						<div class="well">
							<fieldset>
								<legend style="font-size:12pt;">Current Job Position</legend>
								<p>
									<span class="text-bold">Job Position</span><br/>
									<span class="" id="job_lbl_job_desc"><?php echo $details->job_description?></span>
								</p>
								<p>
									<span class="text-bold">Dealer</span><br/>
									<span class="" id="job_lbl_dealer_name"><?php echo $details->dealer_name;?></span>
								</p>
								<p>
									<span class=" text-bold">Employment Status</span><br/>
									<span class="" id="job_lbl_emp_status"><?php echo $details->employment_status;?></span>
								</p>
								<p>
									<span class="text-bold">Date Hired</span><br/>
									<span class="" id="job_lbl_date_hired"><?php echo $details->date_hired; ?></span>
								</p>
							</fieldset>
						
						</div>
					</div>
					<div class="col-md-9">
						<table class="table display table-condensed table-striped" id="tbl_job_position_history">
							<thead>	
								<tr>	
									<th>Job Position</th>
									<th>Dealer</th>
									<th>Employment Status</th>
									<th>Date Hired</th>
									<th>Date Updated</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>


			</div> <!-- end of fourth tab -->

			<div class="clearfix"></div>
		</div> <!-- end of panel body -->
	
	

</div>
		</form>  <!-- end of form --> 


	</div> <!-- end of page-wrapper -->
</div> <!-- end of container -->


<!-- dialog box -->
<div class="modal fade" id="dialog_confirm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <p id="dialog_content"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btn_redirect">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- change password modal -->

<div class="modal fade" id="dialog_change_pass">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Change Password</h4>
      </div>
      <div class="modal-body">
      	<p class="alert alert-info" id="change_pass_notif" style="display:none;"></p>
		<form style="padding: 20px;">
			<div class="form-group">
				<fieldset>
					New Password
					<input type="password" id="txt_new_password" class="form-control  " />
					<br />
					Confirm Password
					<input type="password" id="txt_conf_password" class="form-control  " />
				</fieldset>
			</div>
		</form>
      </div>
      <div class="modal-footer">
       
        <button type="button" class="btn btn-primary btn-sm" id="btn_save_password">Save changes</button>
         <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php  
	include("panels/information_dialog.php");
	include("includes/footer.php");
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
			return false;
		}
		else {
			mark_error_input(id);
			return true;
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
	$("#lbl_bday").text($("#txt_date_of_birth").data('date'));
	$("#lbl_age").text($("#txt_age").val());
	$("#lbl_civil_status").text($("#cbo_civil_status").val());
	$("#lbl_gender").text(gender);
	$("#lbl_dealer_name").text($("#txt_dealer_name option:selected").text());
	$("#lbl_job").text($("#cbo_job_position option:selected").text());
	$("#lbl_date_hired").text($("#txt_date_hired").data('date'));
	$("#lbl_length_of_service").text($("#txt_length_of_service").val());
	$("#lbl_mobile").text($("#txt_mobile").val());
	$("#lbl_office").text($("#txt_office").val());
	$("#lbl_home").text($("#txt_home").val());
	$("#lbl_hea").text($("#txt_highest_educ_att").val());
	
	/*$("#lbl_dept").text($("#txt_department").val());*/
}

function save_data(information_section){
	var formData = new FormData($("#frm_trainee_info")[0]);
	
	$.ajax({
		type:"POST",
		url:"ajax/update_trainee_details.php",
		data: formData,
		cache: false,
		contentType: false,
		processData: false,
		success:function(response){
			$("#dialog_info_title").text("Information");
			$("#dialog_info_content").html("Successfully saved changes on <strong>"+information_section+"</strong>.");
			$("#dialog_info").modal("show");
		}
	});
}

$(document).ready(function(){


	validate_select("#cbo_province");
	validate_select("#cbo_municipality");
	validate_input("#txt_street_addr");
	
	//$("#cbo_department").val($("#txt_current_department").val());
	
	/// remove key event for text box
	remove_key_event("#txt_date_of_birth");
	remove_key_event("#txt_date_hired");

	// initialize datetimepicker
    $('#txt_date_of_birth').datetimepicker({
    	format:"YYYY-MM-DD"
    });
  	var date = new Date();
            var currentMonth = date.getMonth();
            var currentDate = date.getDate();
            var currentYear = date.getFullYear();
  	 $('#txt_date_hired').datetimepicker({
    	format:"YYYY-MM-DD",
    	 maxDate: new Date(currentYear, currentMonth, currentDate)
    });

	var m1 = moment($("#txt_date_hired").data("date")).format('M/D/YYYY');
    var m2 = moment().format('M/D/YYYY');
    var diff = moment.preciseDiff(m1, m2);
    $("#txt_length_of_service").val(diff);
  	// function to compute age e.g Birthdate Length of Service
    computeDPYear("#txt_date_of_birth","#txt_age","years old");
   // computeDPYear("#txt_date_hired","#txt_length_of_service","years");

    initializeDpYear("#txt_date_of_birth input","#txt_age","years old");
    //initializeDpYear("#txt_date_hired input","#txt_length_of_service","years");
    // function to add a trainee
 	



	validate_input("#txt_fname");
	validate_input("#txt_lname");
	//validate_input("#txt_department");
	validate_input("#txt_mobile");
	validate_input("#txt_office");


	$("#txt_date_of_birth").on("dp.change",function(){
		validate_date("#txt_date_of_birth");
	});

	$("#txt_date_hired").on("dp.change",function(){
		validate_date("#txt_date_hired");
		var m1 = moment($("#txt_date_hired").data("date")).format('M/D/YYYY');
	    var m2 = moment().format('M/D/YYYY');
	    var diff = moment.preciseDiff(m1, m2);
	  	$("#txt_length_of_service").val(diff);
	});

	$("#btn_next_1").click(function(e){
	    isError = false;
	
		if($("#txt_fname").val() == ""){
			mark_error_input("#txt_fname");
			isError = true;
		}
		if($("#txt_lname").val() == ""){
			mark_error_input("#txt_lname");
			isError = true;
		}

		if(validate_date("#txt_date_of_birth")){
			isError = true;
		}
		
		if(validate_input("#txt_fname")){
			isError = true;
		}

		if(validate_input("#txt_lname")){
			isError = true;
		}

		if(!isError){
			save_data("Personal Information");
		}

	});

	$("#btn_job_prev").click(function(e){
		activate_tab("#panel-trainee-info","#btn_personal","#btn_job");
	});

	$("#btn_job_next").click(function(e){
		isError = false;

		/*if($("#txt_department").val() == ""){
			mark_error_input("#txt_department");
			isError = true;
		}*/

		if(validate_date("#txt_date_hired")){
			isError = true;
		}

		if(!isError){
			save_data("Job Details");
		}

	});

	$("#btn_contact_prev").click(function(e){
		activate_tab("#panel-job-details","#btn_job","#btn_contact");
	});
	
	$("#txt_home").on("input",function(e){
		validate_textarea("#txt_home");
	});

	$("#btn_contact_next").click(function(e){
		isError = false;

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
			save_data("Contact Number and Address");
		}

	});

	validate_input("#txt_highest_educ_att");
	

	$("#btn_educ_next").click(function(e){
		isError = false;

		if($("#txt_highest_educ_att").val() == ""){
			mark_error_input("#txt_highest_educ_att");
			isError = true;
		}

		if(!isError){
			save_data("Education");
		}
	});

	$("#btn_educ_prev").click(function(e){
		activate_tab("#panel-contact","#btn_contact","#btn_educ");
	});

	$("#btn_verify_prev").click(function(e){
		activate_tab("#panel-education","#btn_educ","#btn_verify");
	});

	$("#btn_redirect").click(function(e){
		window.location.href = "view_trainees.php";
	});

/*

	$("#btn_toggle_pwd").click(function(){
		if($(this).text() == "Show"){
			$("#txt_old_pwd").attr("type","text");
			$(this).text("Hide");
		} else {
			$("#txt_old_pwd").attr("type","password");
			$(this).text("Show");
		}
	});*/

	//$('#txt_new_password').pwstrength(options);

	/*$("#btn_save_password").click(function(){
		msg = "<ul>";
		isError = false;
		if($("#txt_new_password").val() == ""){
			msg += "<li>Please enter new password.</li>";
			isError = true;
		}
		if($("#txt_conf_password").val() == ""){
			msg += "<li>Please enter confirm password</li>";
			isError = true;
		}
		if($("#txt_new_password").val() != $("#txt_conf_password").val()){
			msg += "<li>Passwords does not match.</li>";
			isError = true;
		}

		if(!isError){
			$.ajax({
				type:"POST",
				url:"php_processors/proc_change_pass.php",
				data:{
					trainee_code : $("#trainee_code").val(),
					new_password : $("#txt_new_password").val()
				},
				success:function(response){
					$("#change_pass_notif").html(response).show();
					$("#txt_old_pwd").val($("#txt_new_password").val());
					
				}	
			})
		}
		else {
			$("#change_pass_notif").html(msg);
			$("#change_pass_notif").show();
		}
	});*/

	/*$('#dialog_change_pass').on('hidden.bs.modal', function () {
		$("#txt_new_password,#txt_conf_password").val("");
		$("#change_pass_notif").hide();
    });*/


	$("#txt_pic").change(function(){
		var formData = new FormData($("#frm_trainee_info")[0]);
		$("#img_prev").attr("src","images/pic_loader.gif");
    	$.ajax({
    		type:"POST",
    		url:"ajax/update_trainee_pic.php",
    		data: formData,
    		cache: false,
    		contentType: false,
    		processData: false,
    		success:function(response){

    			var data = JSON.parse(response);
    			$("#img_prev").attr("src","trainee_pics/" + data.picture);
    			$("#old_pic").val(data.picture);
				$("#txt_pic").val("");
    		}
    	});
	});


	$("#txt_mobile").mask("(9999) 999-9999",{placeholder:"(XXXX) XXX-XXXX"});
	$("#txt_office").mask("(999) 999-9999",{placeholder:"(XXX) XXX-XXXX"});


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
			$.ajax({
				type:"POST",
				data:{
					trainee_id : $("#trainee_code").val(),
					mobile_no  : $("#txt_mobile").val()
				},
				url:"ajax/add_mobile.php",
				success:function(response){
					var new_mobile_no = "";
					new_mobile_no += "<li class='list-group-item' style='padding:.2em .2em .2em .5em;'>";
					new_mobile_no += "<span class='mbl_no'>"+$("#txt_mobile").val()+"</span>";
					new_mobile_no += "<button type='button' data-id='"+response+"' class='btn btn-danger btn-xs pull-right btn_remove_mobile' title='Click to remove the mobile no.'><i class='fa fa-trash fa-1x'></i> Remove</button><div class='clearfix'></div></li>";
					$("#txt_mobile").val("");
					$("#list_of_mobile_no").append(new_mobile_no);
				}
			});
		} else {
			$("#dialog_info_title").html("Information");
			$("#dialog_info_content").html("Please enter a valid phone number.");
			$("#dialog_info").modal("show");
		}
	});

	$("body").on("click",".btn_remove_mobile",function(){
		var element = $(this);
		var id = element.data("id");
		
		$.ajax({
			type:"POST",
			data:{
				id : id
			},
			url:"ajax/delete_mobile_no.php",
			success:function(response){
				element.parent().fadeOut(500);
			}
		});

	});


	

	$("#dialog_info").children(0).addClass("modal-lg");

	
	
	$("#txt_dealer_name").change(function(){
		$("#cbo_emp_status").val(1);
		$("#txt_date_hired").children("input:first").val($("#txt_cur_date").val());
		var m1 = moment($("#txt_cur_date").val()).format('M/D/YYYY');
	    var m2 = moment().format('M/D/YYYY');
	    var diff = moment.preciseDiff(m1, m2);
	    $("#txt_length_of_service").val(diff);
	});

	$("#navigation-top").children("li:nth-child(2)").addClass("active");

	$("#cbo_job_position").val($("#txt_current_job").val());

	$("#cbo_suffix").select2({ width: '100%' });
	$("#cbo_civil_status").select2({ width: '100%' });
	$("#cbo_education").select2({ width: '100%' });
	$("#txt_dealer_name").select2({ width: '100%' });
	$("#cbo_job_position").select2({ width: '100%' });
	$("#cbo_emp_status").select2({ width: '100%' });
	$("#cbo_province").select2({width: '100%'});
	$("#cbo_municipality").select2({width: '100%'});

	$("#btn_dealership_history").click(function(){
		$("#lbl_dealer_name").text($("#txt_dealer_name option:selected").text());
		$("#lbl_job_desc").text($("#cbo_job_position option:selected").text());
		if($("#txt_date_hired").data('date') != undefined){
			$("#lbl_date_hired").text(moment($("#txt_date_hired").data('date')).format('MMMM D, YYYY'));
		}
		
		$("#lbl_emp_status").text($("#cbo_emp_status option:selected").text());
		$("#tbl_dealership_history tbody").html("<tr><td colspan='5' align='center'><i class='fa fa-spinner fa-pulse fa-4x'></i></td></tr>");
		$.ajax({
			type:"POST",
			data:{
				trainee_code : $("#trainee_code").val()
			},
			url:"ajax/get_dealership_history.php",
			success:function(response){
				$("#tbl_dealership_history tbody").html(response);
			}
		});
	});


	$("#btn_job_position_history").click(function(){
		$("#job_lbl_dealer_name").text($("#txt_dealer_name option:selected").text());
		$("#job_lbl_job_desc").text($("#cbo_job_position option:selected").text());
		if($("#txt_date_hired").data('date') != undefined){
			$("#job_lbl_date_hired").text(moment($("#txt_date_hired").data('date')).format('MMMM D, YYYY'));
		}
		$("#job_lbl_emp_status").text($("#cbo_emp_status option:selected").text());
		$("#tbl_job_position_history tbody").html("<tr><td colspan='5' align='center'><i class='fa fa-spinner fa-pulse fa-4x'></i></td></tr>");
		$.ajax({
			type:"POST",
			data:{
				trainee_code : $("#trainee_code").val()
			},
			url:"ajax/get_job_position_history.php",
			success:function(response){
				$("#tbl_job_position_history tbody").html(response);
			}
		});
	});

});
</script>

</body>
</html>