<?php 
  require_once("initialize.php");
  require_once("includes/user_access.php");
  include("includes/header_files.php");
  $trainee = new Trainee();
  $dealer = new Dealer();
  $encryption = new Encryption();
  $trainee_id = $encryption->decrypt($get->d);
  $trainee_details = $trainee->getTraineeDetails($trainee_id);
  $trainee_pic = $trainee_details->picture != "" ? $trainee_details->picture : "anonymous.png";
  $other_trainees_for_dealer = $trainee->getRandomTraineePerDealer($trainee_details->dealer_id,$trainee_details->trainee_code);

?>
<style>
.glyphicon {  margin-bottom: 10px;margin-right: 10px;}

small {
display: block;
line-height: 1.428571429;
color: #999;
}
</style>
<div id="container">
	
	<div class="page-wrapper">
    	<h1>Profile</h1>
        <br/>
          <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-8" style="padding:0;">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <img src="trainee_pics/<?php echo $trainee_pic;?>" alt="" class="img-rounded img-responsive" />
                                </div>
                                <div class="col-sm-6 col-md-8">
                                    <h2>
                                       <?php 
                                            echo $trainee_details->first_name . " " . $trainee_details->middle_name . " " . $trainee_details->last_name;
                                            if($trainee_details->suffix != ""){
                                                echo ",".$trainee_details->suffix;
                                            }
                                            if($trainee_details->nickname != ""){
                                                echo " (" . $trainee_details->nickname . ")";
                                            }
                                        ?>
                                    </h2>
                                    <br/>
                                    <p class="profile-attribute">
                                        <span class="profile-icon">
                                            <i class="fa fa-briefcase fa-1x"></i>
                                        </span>
                                        <span class="profile-content"> 
                                            <?php echo $trainee_details->job_description . " at " . $trainee_details->dealer_name . " dealership";?>
                                        </span>
                                    </p>
                                    <p class="profile-attribute">
                                        <span class="profile-icon">
                                            <i class="fa fa-home fa-1x" style="color:#ccc;"></i> 
                                        </span>
                                        <span class="profile-content"> 
                                            Lives in  <?php echo $trainee_details->street_address . ", " . $trainee_details->municipality_name . ", " . $trainee_details->province_name; ?>
                                        </span>
                                    </p>
                                    <p class="profile-attribute">
                                        <span class="profile-icon">
                                            <i class="fa fa-birthday-cake fa-1x" style="color:#ccc;"></i>
                                        </span>
                                        <span class="profile-content"> 
                                            Born on 
                                            <?php echo Format::format_date2($trainee_details->date_of_birth) . " and " . 
                                                    Format::timeAgo(strtotime($trainee_details->date_of_birth)) . " old"; ?>
                                        </span>
                                    </p>
                                    <p class="profile-attribute">
                                        <span class="profile-icon" style="margin-right:.6em;">
                                            <i class="fa fa-<?php echo strtolower($trainee_details->gender_description);?> fa-1x" style="color:#ccc;" ></i>
                                        </span>
                                        <span class="profile-content"> 
                                            <?php echo $trainee_details->gender_description;?>
                                        </span>
                                    </p>
                                    <p class="profile-attribute">
                                        <span class="profile-icon">
                                            <i class="fa fa-heart fa-1x"  ></i>
                                        </span>
                                        <span class="profile-content"> 
                                            <?php echo $trainee_details->c_status;?>
                                        </span>
                                    </p>
                                    <p class="profile-attribute">
                                        <span class="profile-icon">
                                            <i class="fa fa-certificate fa-1x" ></i>
                                        </span>
                                        <span class="profile-content"> 
                                            <?php echo $trainee_details->education_desc;?>
                                        </span>
                                    </p>
                                    <p class="profile-attribute">
                                        <span class="profile-icon">
                                            <i class="fa fa-envelope fa-1x"></i>
                                        </span>
                                        <span class="profile-content"> 
                                            <?php echo $trainee_details->email;?>
                                        </span>
                                    </p>    
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                  
                    <div class="box box-danger">
                        <div class="box-header">
                            <i class="fa fa-file-text"></i>
                            <h3 class="box-title">TRAININGS ATTENDED</h3>
                        </div>
                        <div class="box-body">  
                             <table class="table">
                                <thead>
                                    <tr>
                                        <th>Title of Training</th>
                                        <th>Trainor</th>
                                        <th>Venue</th>
                                        <th>Date</th>
                                        <th>Remarks</th>
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for($i = 1;$i<=20;$i++){ ?>
                                    <tr>
                                        <td>Isuzu Service Advisor Training (ISAT) Basic</td>
                                        <td>Dave Andrew Ebina</td>
                                        <td>IPC Training Center</td>
                                        <td>March 1, 2016 - March 3, 2016</td>
                                        <td>Passed</td>
                                        <td>87.5%</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-4 col-md-4" style="padding-right:0;">
                    <div class="box box-default">
                        <div class="box-header">
                            <i class="glyphicon glyphicon-user"></i>
                            <h3 class="box-title">OTHER TRAINEES FROM <?php echo strtoupper($trainee_details->dealer_name);?></h3>
                        </div>
                        <div class="box-body"> 
                            <div class='list-group gallery'>
                            <?php
                            if(!empty($other_trainees_for_dealer)){    
                                foreach($other_trainees_for_dealer as $other){
                                    $other = (object)$other;
                                    $trainee_pic = $other->picture != "" ? $other->picture : "anonymous.png";
                                    $enc_id = $encryption->encrypt($other->trainee_code);
                            ?>
                            
                                <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
                                    <a href="view_trainee_profile.php?d=<?php echo $enc_id;?>">
                                        <img class="img-responsive" alt="" src="trainee_pics/<?php echo $trainee_pic;?>" />
                                        <div  class="text-right" style="background-color:#000;width:100%;opacity:0.5;margin-top:-1.2em;margin-right:1px;">
                                            <small style="color:#fff;"><?php echo $other->first_name;?></small>
                                        </div> <!-- text-right / end -->
                                    </a>
                                    <Br/>
                                </div> <!-- col-6 / end -->
                           

                            <?php
                                }
                            }
                            else {
                            ?>
                                <p class='text-muted text-center'>No other trainees were found.</p>
                            <?php    
                            }
                            ?>
                            </div> <!-- list-group / end -->
                            <br/><br/>
                            <div class="clearfix"></div> 
                        </div>
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

    $("#navigation-top").children("li:nth-child(2)").addClass("active");

});
</script>

</body>
</html>