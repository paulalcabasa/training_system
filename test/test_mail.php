<?php
/*require_once("../../../libs/phpmailer/class.phpmailer.php");
$email = new PHPMailer();
$subject = "asdas";
$msg = "<b>asd</b>";
$email->CharSet = 'UTF-8';
$email->IsHTML(true);

$email->SMTPDebug = 1;
$email->From      = "mis-portal@isuzuphil.com";
$email->FromName  = "IPC Centralized Web Portal";
$email->Subject   = $subject;
$email->Body = $msg;
$email->AddAddress('paul-alcabasa@isuzuphil.com','SERVAÑEZ, MARY GRACE B.');
//$email->AddCC('paul-alcabasa@isuzuphil.com', 'Paul Alcabasa');
//$email->AddCC('marlo-lerit@isuzuphil.com', 'Marlo Lerit');
//$email->AddCC($div_head_email, $dh_name);
$email->Send();
if($email->Send()){
//$output .= "<li>Failed sending email to ".$data['SH']." at " . $to . "</li>";
echo "success";
} else {
echo "failed";
//$output .= "<li>Successfully sent email to ".$data['SH']."(".$sect." HEAD) at " . $to . "</li>";
}*/
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Meta Tags-->
    <meta http-equiv = "Content-Type" content = "text/html; charset=utf-8" />
    <meta name = "Description" content = "Web-Based Centralized Isuzu Philippines Corporation (IPC) Database" />
    <meta name = "Viewport" content = "width = device-width, initial-scale = 1, maximum-scale = 1" />
    <meta name = "Author" content = "John Paul Alcabasa, MIS" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ipc favicon -->
    <link rel="icon" type="image/png" href="../../../img/favicon.ico"/>
    <!-- select 2 css -->
    <link rel="stylesheet" type="text/css" href="../../../libs/select2-4.0.0/dist/css/select2.min.css"/>
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="../../../libs/bootstrap-3.3.4-dist/css/bootstrap.min.css"/>
    <!-- bootstrap date picker -->
    <link rel="stylesheet" type="text/css" href="../../../libs/bootstrap-datepicker/build/css/bootstrap-datetimepicker.min.css" />
    <!-- font awesome -->
    <link rel="stylesheet" type="text/css" href="../../../libs/font-awesome-4.3.0/css/font-awesome.min.css" /> 
    <!-- data tables -->
    <link rel="stylesheet" type="text/css" href="../../../libs/DataTables-1.10.7/media/css/jquery.dataTables.css" /> 
     <!-- data responsive -->
    <link rel="stylesheet" type="text/css" href="../../../libs/DataTables-1.10.7/extensions/Responsive/css/dataTables.responsive.css" /> 
    <!-- custom style for IPC TRAINING DB -->
    <link rel="stylesheet" type="text/css" href="../../../css/sys-training-style.css" />
    
      <!-- awesome checkbox -->
    <link rel="stylesheet" type="text/css" href="../../../libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" />
    <!-- title -->
    <title>Training Product Knowledge Entry | Centralized IPC Database</title>
    <style>
        .table {
            table-layout:fixed;
        }

        .table td {
          white-space: wrap;
          overflow: auto;
          text-overflow: ellipsis;
          
        }


        #dialog_info .modal-body {
            max-height: 520px;
            max-width: 900px;
            overflow-y: auto;
        } 
    </style>
</head>
<body>

<!-- navigation top panel included -->
<nav class="nav navbar-default">
	<div class="container-fluid" style="margin:0 3.9em 0 3.2em;">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation-collapse">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
      		</button>
      		<a class="navbar-brand" href="../../../main_home.php"><img src='../../../img/logo_2.png'/></a>
		</div>
	

		<div class="collapse navbar-collapse" id="navigation-collapse">
			<ul class="nav navbar-nav" id="navigation-top">
				<li id="nav_home"><a href = "index.php"><i class = "fa fa-home fa-1x"></i> Home</a></li>
				<li id="nav_training_info"><a href="view_trainees.php" >Trainee Information</a></li>
				<li><a href="view_training_programs.php" >Training Programs</a></li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Maintenance <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="manage_dealer_groups.php">Dealers</a></li>
						<li><a href="manage_job_category.php">Job Positions</a></li>
						<li><a href="view_programs_modules.php" >Programs and Modules</a></li>
						<li><a href="manage_trainors.php">Trainors</a></li>
						<li><a href="#">Grading System</a></li>
						<li><a href="#">Name Suffix</a></li>
					</ul>
				</li>				

			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><strong>JOHN PAUL ALCABASA</strong> <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#"><i class="fa fa-signal fa-1x"></i> Views : 44</a></li>
						<li><a href = "../../../main_profile.php"><span class = "glyphicon glyphicon-user"></span> Profile</a></li>
						<li><a href = "../../../php_processors/proc_logout.php" name = "btn_logout" id = "btn_logout"><span class = "glyphicon glyphicon-th-large"></span> Logout</a></li>
						
					</ul>
				</li>
			</ul>
          
		</div>
	</div>
</nav>
<br/>
<div id="container">
    <div class="page-wrapper">
        
        <h1>Training Program Exam</h1>
        <hr/>
        <div class="alert alert-info">
            <div class="col-md-6">
                <table>
                    <tr>
                        <td>Program Title</td>
                        <td> : <strong id="program_title">Isuzu Service Technician Education Program (ISTEP) 1</strong></td>
                    </tr>
                     <tr>
                        <td>Trainor</td>
                        <td> : <strong>Maria Abegail J. Valenzuela</strong></td>
                    </tr>
                    <tr>
                        <td>Venue</td>
                        <td> : <strong>IPC Training Center</strong></td>
                    </tr>
                     <tr>
                        <td>Start Date</td>
                        <td> : <strong>August 3, 2015</strong></td>
                    </tr>
                      <tr>
                        <td>End Date</td>
                        <td> : <strong>August 19, 2015</strong></td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6">
                  <table>
                      <tr>
                        <td>Trainee</td>
                        <td> : <strong>Maine D. Mendoza,Ii</strong></td>
                    </tr>
                    <tr>
                        <td>Module</td>
                        <td> : <strong>Basic Electrical System</strong></td>
                    </tr>
                     <tr>
                        <td>Exam title</td>
                        <td> : <strong>2015 Comprehensive Product Knowledge w/ Basic Selling Skills Training</strong></td>
                    </tr>
                    <tr>
                        <td>Score</td>
                        <td> : <strong id="exam_score">0 / 30 </strong></td>
                    </tr>
                     <tr>
                        <td>Remarks</td>
                        <td> : <strong id="exam_remarks"><a href='#' class='view_unanswered' data-content='<ul><li>1. This component is an important part of a gasoline engine ignition system, but is not present in a diesel engine.</li><li>2. This device is used to lower the temperature of the air after being compressed by a turbocharger (or a supercharger) to produce more power.</li><li>3. This system transfers the engine output power to the final driven gear.</li><li>4. It is a mechanical assembly of parts that includes speed changing gears that transmit the power of the engine to the axle.</li><li>5. This device allows the outer drive wheel to rotate faster than the inner drive wheel when the vehicle is turning.</li><li>6. This kind of suspension allows each wheel on the same axle to move vertically independently from each other resulting to a more comfortable ride.</li><li>7. A kind of suspension in which a set of wheels is connected laterally by a single beam or shaft.</li><li>8. It is a suspension component that controls the unwanted motion of the spring through the process called dampening which reduces the excessive suspension movement.</li><li>9. This system allows the vehicle to turn left and right and follow the driver’s desired direction.</li><li>10. It is a power steering system that uses hydraulic pressure supplied by an engine driven pump to assist the motion of turning the steering wheel.</li><li>11. This power steering system uses a small electric motor installed in the steering column to assist the driver in turning the steering wheel.</li><li>12. This system uses friction to stop the motion of a moving vehicle.</li><li>13. It is a type of brake that works by squeezing the rotor disc by the caliper to prevent the motion of the wheels.</li><li>14. Sometimes known as emergency brake, this type of latching brake is used to keep the vehicle stationary.</li><li>15. It is the only part of the vehicle that is in contact with the road.</li><li>16. This type of wheel is made from Aluminum and Magnesium, which is lighter compared to its steel counterpart.</li><li>17. A type of wheel that is stronger and inexpensive to produce, it is usually found on vehicles designed for heavy payload.</li><li>18. It is a type of vehicle body structure where the body is combined with the chassis as a single unit.</li><li>19.  It is a type of vehicle body structure where a separate body is mounted on a rigid frame.</li><li>20. This type of safety features prevents accidents from happening.</li><li>21. This vehicle safety feature helps maintain directional stability of the vehicle during panic braking situations by keeping the wheels from locking up and skidding.</li><li>22. This vehicle safety feature prevents over steer and under steer by proactively controlling the brake pressure and engine output during dangerous maneuvers.</li><li>23. This vehicle safety feature protects passengers by absorbing the impact in the event of a collision.</li><li>24. It is a type of vehicle air conditioning where the temperature and fan speed is manually operated by the vehicle occupants.</li><li>25. This electronic instrument provides range of data to the driver that includes; distance travelled, elapsed time, distance to empty, average speed etc. that is necessary during vehicle operation.</li><li>26. It is an electronic security device that prevents the engine from running unless the correct key is present. This prevents the car from being “hot-wired” even if the vehicle forcefully entered.</li><li>27. Which Isuzu vehicle is positioned in the Big Sport Utility Vehicle (Big SUV) segment?</li><li>28. Which Isuzu vehicle is positioned in the Light Duty Truck segment?</li><li>29. Which Isuzu vehicle is positioned in the Medium Duty Truck segment?</li><li>30. Describe yourself</li></ul>'>Incomplete answer</a></div></strong></td>
                    </tr>
                   
                </table>
            </div>
             <div class="clearfix"></div>   
        </div>
         
        <div class="panel panel-primary">  <!-- start of panel -->
            <div class="panel-heading text-center">Answer sheet</div> <!-- start of panel heading -->
            
            <div class="panel-body"> <!-- start of panel body -->
                <div class="exam_wrapper" style="width:100%;">
                <div class='exam_item'><p class='exam_question'>1. This component is an important part of a gasoline engine ignition system, but is not present in a diesel engine.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice1' data-item_id='2' class='rdo_answer' value='5' type='radio' id='rdo_choice1' >
	                        <label for='rdo_choice1'><em style='color:red;'>Piston</em> - <span class="badge">2</span></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice1' data-item_id='2' class='rdo_answer' value='6' type='radio' id='rdo_choice2' >
	                        <label for='rdo_choice2'>Spark Plug - <span class="badge">5</span></label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice1' data-item_id='2' class='rdo_answer' value='7' type='radio' id='rdo_choice3' >
	                        <label for='rdo_choice3'>Camshaft - <span class="badge">0</span></label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice1' data-item_id='2' class='rdo_answer' value='8' type='radio' id='rdo_choice4' >
	                        <label for='rdo_choice4'>None of the above - <span class="badge">1</span></label>
	                    </div>
                    </li></ol>
                    <u>Total Correct :  2</u>
                    <p>Total Incorrect : 6</p>
                    </div>

                    <div class='exam_item'><p class='exam_question'>2. This device is used to lower the temperature of the air after being compressed by a turbocharger (or a supercharger) to produce more power.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice2' data-item_id='3' class='rdo_answer' value='9' type='radio' id='rdo_choice5' >
	                        <label for='rdo_choice5'><em style='color:red;'>Intercooler </em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice2' data-item_id='3' class='rdo_answer' value='10' type='radio' id='rdo_choice6' >
	                        <label for='rdo_choice6'>CRDi</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice2' data-item_id='3' class='rdo_answer' value='11' type='radio' id='rdo_choice7' >
	                        <label for='rdo_choice7'>VGS</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice2' data-item_id='3' class='rdo_answer' value='12' type='radio' id='rdo_choice8' >
	                        <label for='rdo_choice8'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>3. This system transfers the engine output power to the final driven gear.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice3' data-item_id='4' class='rdo_answer' value='13' type='radio' id='rdo_choice9' >
	                        <label for='rdo_choice9'><em style='color:red;'>Drivetrain</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice3' data-item_id='4' class='rdo_answer' value='14' type='radio' id='rdo_choice10' >
	                        <label for='rdo_choice10'>Ignition</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice3' data-item_id='4' class='rdo_answer' value='15' type='radio' id='rdo_choice11' >
	                        <label for='rdo_choice11'>Brake</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice3' data-item_id='4' class='rdo_answer' value='16' type='radio' id='rdo_choice12' >
	                        <label for='rdo_choice12'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>4. It is a mechanical assembly of parts that includes speed changing gears that transmit the power of the engine to the axle.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio'>
	                        <input name='exam_choice4' data-item_id='5' class='rdo_answer' value='17' type='radio' id='rdo_choice13' >
	                        <label for='rdo_choice13'>Differential</label>
	                    </div>
                    </li><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice4' data-item_id='5' class='rdo_answer' value='18' type='radio' id='rdo_choice14' >
	                        <label for='rdo_choice14'><em style='color:red;'>Transmission</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice4' data-item_id='5' class='rdo_answer' value='19' type='radio' id='rdo_choice15' >
	                        <label for='rdo_choice15'>Turbocharger</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice4' data-item_id='5' class='rdo_answer' value='20' type='radio' id='rdo_choice16' >
	                        <label for='rdo_choice16'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>5. This device allows the outer drive wheel to rotate faster than the inner drive wheel when the vehicle is turning.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice5' data-item_id='6' class='rdo_answer' value='21' type='radio' id='rdo_choice17' >
	                        <label for='rdo_choice17'><em style='color:red;'>Differential</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice5' data-item_id='6' class='rdo_answer' value='22' type='radio' id='rdo_choice18' >
	                        <label for='rdo_choice18'>Transmission</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice5' data-item_id='6' class='rdo_answer' value='23' type='radio' id='rdo_choice19' >
	                        <label for='rdo_choice19'>Turbocharger</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice5' data-item_id='6' class='rdo_answer' value='24' type='radio' id='rdo_choice20' >
	                        <label for='rdo_choice20'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>6. This kind of suspension allows each wheel on the same axle to move vertically independently from each other resulting to a more comfortable ride.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio'>
	                        <input name='exam_choice6' data-item_id='7' class='rdo_answer' value='25' type='radio' id='rdo_choice21' >
	                        <label for='rdo_choice21'>Rigid Axle</label>
	                    </div>
                    </li><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice6' data-item_id='7' class='rdo_answer' value='26' type='radio' id='rdo_choice22' >
	                        <label for='rdo_choice22'><em style='color:red;'>Independent Suspension</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice6' data-item_id='7' class='rdo_answer' value='27' type='radio' id='rdo_choice23' >
	                        <label for='rdo_choice23'>MacPherson Strut</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice6' data-item_id='7' class='rdo_answer' value='28' type='radio' id='rdo_choice24' >
	                        <label for='rdo_choice24'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>7. A kind of suspension in which a set of wheels is connected laterally by a single beam or shaft.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice7' data-item_id='8' class='rdo_answer' value='29' type='radio' id='rdo_choice25' >
	                        <label for='rdo_choice25'><em style='color:red;'>Rigid Axle</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice7' data-item_id='8' class='rdo_answer' value='30' type='radio' id='rdo_choice26' >
	                        <label for='rdo_choice26'>Independent Suspension</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice7' data-item_id='8' class='rdo_answer' value='31' type='radio' id='rdo_choice27' >
	                        <label for='rdo_choice27'>Trailing Arm</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice7' data-item_id='8' class='rdo_answer' value='32' type='radio' id='rdo_choice28' >
	                        <label for='rdo_choice28'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>8. It is a suspension component that controls the unwanted motion of the spring through the process called dampening which reduces the excessive suspension movement.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice8' data-item_id='9' class='rdo_answer' value='33' type='radio' id='rdo_choice29' >
	                        <label for='rdo_choice29'><em style='color:red;'>Shock Absorber</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice8' data-item_id='9' class='rdo_answer' value='34' type='radio' id='rdo_choice30' >
	                        <label for='rdo_choice30'>Leaf Spring</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice8' data-item_id='9' class='rdo_answer' value='35' type='radio' id='rdo_choice31' >
	                        <label for='rdo_choice31'>Intercooler</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice8' data-item_id='9' class='rdo_answer' value='36' type='radio' id='rdo_choice32' >
	                        <label for='rdo_choice32'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>9. This system allows the vehicle to turn left and right and follow the driver’s desired direction.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio'>
	                        <input name='exam_choice9' data-item_id='10' class='rdo_answer' value='37' type='radio' id='rdo_choice33' >
	                        <label for='rdo_choice33'>Drivetrain System </label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice9' data-item_id='10' class='rdo_answer' value='38' type='radio' id='rdo_choice34' >
	                        <label for='rdo_choice34'>Brake System </label>
	                    </div>
                    </li><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice9' data-item_id='10' class='rdo_answer' value='39' type='radio' id='rdo_choice35' >
	                        <label for='rdo_choice35'><em style='color:red;'>Steering System</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice9' data-item_id='10' class='rdo_answer' value='40' type='radio' id='rdo_choice36' >
	                        <label for='rdo_choice36'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>10. It is a power steering system that uses hydraulic pressure supplied by an engine driven pump to assist the motion of turning the steering wheel.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio'>
	                        <input name='exam_choice10' data-item_id='11' class='rdo_answer' value='41' type='radio' id='rdo_choice37' >
	                        <label for='rdo_choice37'>Electric Power Steering</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice10' data-item_id='11' class='rdo_answer' value='42' type='radio' id='rdo_choice38' >
	                        <label for='rdo_choice38'>Electro-Hydraulic Power Steering</label>
	                    </div>
                    </li><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice10' data-item_id='11' class='rdo_answer' value='43' type='radio' id='rdo_choice39' >
	                        <label for='rdo_choice39'><em style='color:red;'>Hydraulic Power Steering</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice10' data-item_id='11' class='rdo_answer' value='44' type='radio' id='rdo_choice40' >
	                        <label for='rdo_choice40'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>11. This power steering system uses a small electric motor installed in the steering column to assist the driver in turning the steering wheel.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice11' data-item_id='12' class='rdo_answer' value='45' type='radio' id='rdo_choice41' >
	                        <label for='rdo_choice41'><em style='color:red;'>Electric Power Steering</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice11' data-item_id='12' class='rdo_answer' value='46' type='radio' id='rdo_choice42' >
	                        <label for='rdo_choice42'>Electro-Hydraulic Power Steering</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice11' data-item_id='12' class='rdo_answer' value='47' type='radio' id='rdo_choice43' >
	                        <label for='rdo_choice43'>Hydraulic Power Steering</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice11' data-item_id='12' class='rdo_answer' value='48' type='radio' id='rdo_choice44' >
	                        <label for='rdo_choice44'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>12. This system uses friction to stop the motion of a moving vehicle.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio'>
	                        <input name='exam_choice12' data-item_id='13' class='rdo_answer' value='49' type='radio' id='rdo_choice45' >
	                        <label for='rdo_choice45'>Drivetrain System</label>
	                    </div>
                    </li><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice12' data-item_id='13' class='rdo_answer' value='50' type='radio' id='rdo_choice46' >
	                        <label for='rdo_choice46'><em style='color:red;'>Brake System</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice12' data-item_id='13' class='rdo_answer' value='51' type='radio' id='rdo_choice47' >
	                        <label for='rdo_choice47'>Steering System</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice12' data-item_id='13' class='rdo_answer' value='52' type='radio' id='rdo_choice48' >
	                        <label for='rdo_choice48'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>13. It is a type of brake that works by squeezing the rotor disc by the caliper to prevent the motion of the wheels.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice13' data-item_id='14' class='rdo_answer' value='53' type='radio' id='rdo_choice49' >
	                        <label for='rdo_choice49'><em style='color:red;'>Disc Brake</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice13' data-item_id='14' class='rdo_answer' value='54' type='radio' id='rdo_choice50' >
	                        <label for='rdo_choice50'> Drum Brake</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice13' data-item_id='14' class='rdo_answer' value='55' type='radio' id='rdo_choice51' >
	                        <label for='rdo_choice51'>Parking Brake</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice13' data-item_id='14' class='rdo_answer' value='56' type='radio' id='rdo_choice52' >
	                        <label for='rdo_choice52'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>14. Sometimes known as emergency brake, this type of latching brake is used to keep the vehicle stationary.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio'>
	                        <input name='exam_choice14' data-item_id='15' class='rdo_answer' value='57' type='radio' id='rdo_choice53' >
	                        <label for='rdo_choice53'>Disc Brake</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice14' data-item_id='15' class='rdo_answer' value='58' type='radio' id='rdo_choice54' >
	                        <label for='rdo_choice54'> Drum Brake</label>
	                    </div>
                    </li><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice14' data-item_id='15' class='rdo_answer' value='59' type='radio' id='rdo_choice55' >
	                        <label for='rdo_choice55'><em style='color:red;'>Parking Brake</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice14' data-item_id='15' class='rdo_answer' value='60' type='radio' id='rdo_choice56' >
	                        <label for='rdo_choice56'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>15. It is the only part of the vehicle that is in contact with the road.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice15' data-item_id='16' class='rdo_answer' value='61' type='radio' id='rdo_choice57' >
	                        <label for='rdo_choice57'><em style='color:red;'>Tires</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice15' data-item_id='16' class='rdo_answer' value='62' type='radio' id='rdo_choice58' >
	                        <label for='rdo_choice58'>Bumper</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice15' data-item_id='16' class='rdo_answer' value='63' type='radio' id='rdo_choice59' >
	                        <label for='rdo_choice59'>Muffler</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice15' data-item_id='16' class='rdo_answer' value='64' type='radio' id='rdo_choice60' >
	                        <label for='rdo_choice60'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>16. This type of wheel is made from Aluminum and Magnesium, which is lighter compared to its steel counterpart.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio'>
	                        <input name='exam_choice16' data-item_id='17' class='rdo_answer' value='65' type='radio' id='rdo_choice61' >
	                        <label for='rdo_choice61'>Steel Rim</label>
	                    </div>
                    </li><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice16' data-item_id='17' class='rdo_answer' value='66' type='radio' id='rdo_choice62' >
	                        <label for='rdo_choice62'><em style='color:red;'>Alloy Wheel</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice16' data-item_id='17' class='rdo_answer' value='67' type='radio' id='rdo_choice63' >
	                        <label for='rdo_choice63'>Hub Cap</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice16' data-item_id='17' class='rdo_answer' value='68' type='radio' id='rdo_choice64' >
	                        <label for='rdo_choice64'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>17. A type of wheel that is stronger and inexpensive to produce, it is usually found on vehicles designed for heavy payload.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice17' data-item_id='18' class='rdo_answer' value='69' type='radio' id='rdo_choice65' >
	                        <label for='rdo_choice65'><em style='color:red;'>Steel Rim</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice17' data-item_id='18' class='rdo_answer' value='70' type='radio' id='rdo_choice66' >
	                        <label for='rdo_choice66'>Alloy Wheel</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice17' data-item_id='18' class='rdo_answer' value='71' type='radio' id='rdo_choice67' >
	                        <label for='rdo_choice67'>Hub Cap</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice17' data-item_id='18' class='rdo_answer' value='72' type='radio' id='rdo_choice68' >
	                        <label for='rdo_choice68'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>18. It is a type of vehicle body structure where the body is combined with the chassis as a single unit.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice18' data-item_id='19' class='rdo_answer' value='73' type='radio' id='rdo_choice69' >
	                        <label for='rdo_choice69'><em style='color:red;'>Monocoque</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice18' data-item_id='19' class='rdo_answer' value='74' type='radio' id='rdo_choice70' >
	                        <label for='rdo_choice70'>Body on Frame</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice18' data-item_id='19' class='rdo_answer' value='75' type='radio' id='rdo_choice71' >
	                        <label for='rdo_choice71'>None of the above</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice18' data-item_id='19' class='rdo_answer' value='76' type='radio' id='rdo_choice72' >
	                        <label for='rdo_choice72'>All of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>19.  It is a type of vehicle body structure where a separate body is mounted on a rigid frame.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio'>
	                        <input name='exam_choice19' data-item_id='20' class='rdo_answer' value='77' type='radio' id='rdo_choice73' >
	                        <label for='rdo_choice73'>Monocoque</label>
	                    </div>
                    </li><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice19' data-item_id='20' class='rdo_answer' value='78' type='radio' id='rdo_choice74' >
	                        <label for='rdo_choice74'><em style='color:red;'>Body on Frame</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice19' data-item_id='20' class='rdo_answer' value='79' type='radio' id='rdo_choice75' >
	                        <label for='rdo_choice75'>None of the above</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice19' data-item_id='20' class='rdo_answer' value='80' type='radio' id='rdo_choice76' >
	                        <label for='rdo_choice76'>All of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>20. This type of safety features prevents accidents from happening.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice20' data-item_id='21' class='rdo_answer' value='81' type='radio' id='rdo_choice77' >
	                        <label for='rdo_choice77'><em style='color:red;'>Active Safety Features</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice20' data-item_id='21' class='rdo_answer' value='82' type='radio' id='rdo_choice78' >
	                        <label for='rdo_choice78'>Passive Safety Features</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice20' data-item_id='21' class='rdo_answer' value='83' type='radio' id='rdo_choice79' >
	                        <label for='rdo_choice79'>Modern Safety Features</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice20' data-item_id='21' class='rdo_answer' value='84' type='radio' id='rdo_choice80' >
	                        <label for='rdo_choice80'>All of the above</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice20' data-item_id='21' class='rdo_answer' value='138' type='radio' id='rdo_choice81' >
	                        <label for='rdo_choice81'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>21. This vehicle safety feature helps maintain directional stability of the vehicle during panic braking situations by keeping the wheels from locking up and skidding.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice21' data-item_id='22' class='rdo_answer' value='85' type='radio' id='rdo_choice82' >
	                        <label for='rdo_choice82'><em style='color:red;'>Anti-lock Brake System</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice21' data-item_id='22' class='rdo_answer' value='86' type='radio' id='rdo_choice83' >
	                        <label for='rdo_choice83'>Electronic Brake Distribution</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice21' data-item_id='22' class='rdo_answer' value='87' type='radio' id='rdo_choice84' >
	                        <label for='rdo_choice84'>Brake Assist System</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice21' data-item_id='22' class='rdo_answer' value='88' type='radio' id='rdo_choice85' >
	                        <label for='rdo_choice85'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>22. This vehicle safety feature prevents over steer and under steer by proactively controlling the brake pressure and engine output during dangerous maneuvers.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio'>
	                        <input name='exam_choice22' data-item_id='23' class='rdo_answer' value='89' type='radio' id='rdo_choice86' >
	                        <label for='rdo_choice86'>Traction Control System</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice22' data-item_id='23' class='rdo_answer' value='90' type='radio' id='rdo_choice87' >
	                        <label for='rdo_choice87'>Downhill Brake Control</label>
	                    </div>
                    </li><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice22' data-item_id='23' class='rdo_answer' value='91' type='radio' id='rdo_choice88' >
	                        <label for='rdo_choice88'><em style='color:red;'>Electronic Stability Control</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice22' data-item_id='23' class='rdo_answer' value='92' type='radio' id='rdo_choice89' >
	                        <label for='rdo_choice89'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>23. This vehicle safety feature protects passengers by absorbing the impact in the event of a collision.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio'>
	                        <input name='exam_choice23' data-item_id='24' class='rdo_answer' value='93' type='radio' id='rdo_choice90' >
	                        <label for='rdo_choice90'>Reinforced Cabin</label>
	                    </div>
                    </li><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice23' data-item_id='24' class='rdo_answer' value='94' type='radio' id='rdo_choice91' >
	                        <label for='rdo_choice91'><em style='color:red;'>Crumple Zone</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice23' data-item_id='24' class='rdo_answer' value='95' type='radio' id='rdo_choice92' >
	                        <label for='rdo_choice92'>Whiplash Injury Lessening Seats</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice23' data-item_id='24' class='rdo_answer' value='96' type='radio' id='rdo_choice93' >
	                        <label for='rdo_choice93'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>24. It is a type of vehicle air conditioning where the temperature and fan speed is manually operated by the vehicle occupants.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio'>
	                        <input name='exam_choice24' data-item_id='25' class='rdo_answer' value='97' type='radio' id='rdo_choice94' >
	                        <label for='rdo_choice94'>Auto Climate Control Air Conditioning</label>
	                    </div>
                    </li><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice24' data-item_id='25' class='rdo_answer' value='98' type='radio' id='rdo_choice95' >
	                        <label for='rdo_choice95'><em style='color:red;'>Manual Air Conditioning</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice24' data-item_id='25' class='rdo_answer' value='99' type='radio' id='rdo_choice96' >
	                        <label for='rdo_choice96'>Dual Air Conditioning</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice24' data-item_id='25' class='rdo_answer' value='100' type='radio' id='rdo_choice97' >
	                        <label for='rdo_choice97'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>25. This electronic instrument provides range of data to the driver that includes; distance travelled, elapsed time, distance to empty, average speed etc. that is necessary during vehicle operation.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice25' data-item_id='26' class='rdo_answer' value='101' type='radio' id='rdo_choice98' >
	                        <label for='rdo_choice98'><em style='color:red;'>Multi Information Display</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice25' data-item_id='26' class='rdo_answer' value='102' type='radio' id='rdo_choice99' >
	                        <label for='rdo_choice99'>Immobilizer</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice25' data-item_id='26' class='rdo_answer' value='103' type='radio' id='rdo_choice100' >
	                        <label for='rdo_choice100'>Transponder</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice25' data-item_id='26' class='rdo_answer' value='104' type='radio' id='rdo_choice101' >
	                        <label for='rdo_choice101'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>26. It is an electronic security device that prevents the engine from running unless the correct key is present. This prevents the car from being “hot-wired” even if the vehicle forcefully entered.</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio'>
	                        <input name='exam_choice26' data-item_id='27' class='rdo_answer' value='105' type='radio' id='rdo_choice102' >
	                        <label for='rdo_choice102'>Multi Information Display</label>
	                    </div>
                    </li><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice26' data-item_id='27' class='rdo_answer' value='106' type='radio' id='rdo_choice103' >
	                        <label for='rdo_choice103'><em style='color:red;'>Immobilizer</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice26' data-item_id='27' class='rdo_answer' value='107' type='radio' id='rdo_choice104' >
	                        <label for='rdo_choice104'>Transponder</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice26' data-item_id='27' class='rdo_answer' value='108' type='radio' id='rdo_choice105' >
	                        <label for='rdo_choice105'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>27. Which Isuzu vehicle is positioned in the Big Sport Utility Vehicle (Big SUV) segment?</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio'>
	                        <input name='exam_choice27' data-item_id='28' class='rdo_answer' value='109' type='radio' id='rdo_choice106' >
	                        <label for='rdo_choice106'>Isuzu Crosswind</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice27' data-item_id='28' class='rdo_answer' value='110' type='radio' id='rdo_choice107' >
	                        <label for='rdo_choice107'>Isuzu D-Max</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice27' data-item_id='28' class='rdo_answer' value='111' type='radio' id='rdo_choice108' >
	                        <label for='rdo_choice108'>Isuzu N-Series</label>
	                    </div>
                    </li><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice27' data-item_id='28' class='rdo_answer' value='112' type='radio' id='rdo_choice109' >
	                        <label for='rdo_choice109'><em style='color:red;'>None of the above</em></label>
	                    </div>
	                </li></ol></div><div class='exam_item'><p class='exam_question'>28. Which Isuzu vehicle is positioned in the Light Duty Truck segment?</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio'>
	                        <input name='exam_choice28' data-item_id='29' class='rdo_answer' value='113' type='radio' id='rdo_choice110' >
	                        <label for='rdo_choice110'>Isuzu Crosswind</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice28' data-item_id='29' class='rdo_answer' value='114' type='radio' id='rdo_choice111' >
	                        <label for='rdo_choice111'>Isuzu D-Max</label>
	                    </div>
                    </li><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice28' data-item_id='29' class='rdo_answer' value='115' type='radio' id='rdo_choice112' >
	                        <label for='rdo_choice112'><em style='color:red;'>Isuzu N-Series</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice28' data-item_id='29' class='rdo_answer' value='116' type='radio' id='rdo_choice113' >
	                        <label for='rdo_choice113'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>29. Which Isuzu vehicle is positioned in the Medium Duty Truck segment?</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio'>
	                        <input name='exam_choice29' data-item_id='30' class='rdo_answer' value='117' type='radio' id='rdo_choice114' >
	                        <label for='rdo_choice114'>Isuzu Giga</label>
	                    </div>
                    </li><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice29' data-item_id='30' class='rdo_answer' value='118' type='radio' id='rdo_choice115' >
	                        <label for='rdo_choice115'><em style='color:red;'>Isuzu F-Series</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice29' data-item_id='30' class='rdo_answer' value='119' type='radio' id='rdo_choice116' >
	                        <label for='rdo_choice116'>Hino Super Great</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice29' data-item_id='30' class='rdo_answer' value='120' type='radio' id='rdo_choice117' >
	                        <label for='rdo_choice117'>None of the above</label>
	                    </div>
                    </li></ol></div><div class='exam_item'><p class='exam_question'>30. Describe yourself</p><ol type='a' style='list-style-type:none;'><li>
	                    <div class='radio radio-danger'>
	                        <input name='exam_choice30' data-item_id='31' class='rdo_answer' value='121' type='radio' id='rdo_choice118' >
	                        <label for='rdo_choice118'><em style='color:red;'>Handsome / Beautiful</em></label>
	                    </div>
	                </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice30' data-item_id='31' class='rdo_answer' value='122' type='radio' id='rdo_choice119' >
	                        <label for='rdo_choice119'>Hot</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice30' data-item_id='31' class='rdo_answer' value='123' type='radio' id='rdo_choice120' >
	                        <label for='rdo_choice120'>Sexy</label>
	                    </div>
                    </li><li>
	                    <div class='radio'>
	                        <input name='exam_choice30' data-item_id='31' class='rdo_answer' value='124' type='radio' id='rdo_choice121' >
	                        <label for='rdo_choice121'>None of the above</label>
	                    </div>
                    </li></ol></div>             <!--        <div class="exam_item">

                            <p class="exam_question">
                                 1)  It is a part of a vehicle that converts chemical energy to mechanical energy through the 4-stroke process. It also gives the force to make the vehicle move.
                            </p>
                            <div class="exam_choices" style="margin-left:1em;">
                                <ol type="a" style="list-style-type:none;">
                                    <li>
                                        <div class="radio">
                                            <input name="optradio" id="radio2" value="option2" type="radio">
                                            <label for="radio2"><em style="color:red;">asd</em></label>
                                        </div>
                                    </li>
                                     <li>
                                        <div class="radio">
                                            <input name="optradio" id="radio2" value="option2" type="radio">
                                            <label for="radio2"></label>
                                        </div>
                                    </li>
                                     <li>
                                        <div class="radio">
                                            <input name="optradio" id="radio2" value="option2" type="radio">
                                            <label for="radio2"></label>
                                        </div>
                                    </li>
                                     <li>
                                         <div class="radio">
                                            <input name="optradio" id="radio2" value="option2" type="radio">
                                            <label for="radio2"></label>
                                        </div>
                                    </li>
                                </ol>
                            </div>
                        </div> -->
                    </div>
                </div>


            </div> <!-- end of panel body -->
            
            <div class="panel-footer"> <!-- start of panel footer -->

            </div> <!-- end of panel footer -->
        </div> <!-- end of panel -->

    </div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->

<div class="modal fade" id="dialog_info">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="dialog_info_title"></h4>
      </div>
      <div class="modal-body" id="dialog_info_content">
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- page variables -->
<input type="hidden" id="txt_trainee_id" value="1"/>
<input type="hidden" id="txt_exam_id" value="1"/>
<!-- Latest jquery -->
<script src="../../../js/jquery-2.1.4.min.js"></script>
<!-- moment.js -->
<script src="../../../libs/bootstrap-datepicker/build/js/moment.js"></script>
<!-- bootstrap jquery -->
<script src="../../../libs/bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>
<!-- datepicker.js -->
<script src="../../../libs/bootstrap-datepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!-- select 2 js -->
<script src="../../../libs/select2-4.0.0/dist/js/select2.full.min.js"></script>
<!-- data tables js -->
<script src="../../../libs/datatables-1.10.7/media/js/jquery.dataTables.min.js"></script>
  <!-- data tables responsive -->
<script src="../../../libs/DataTables-1.10.7/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<!-- common functions -->
<script src="../../../js/common_functions.js"></script>


</body>
</html>