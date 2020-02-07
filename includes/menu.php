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
						<li><a href="view_programs_modules.php" >Programs</a></li>
						<li><a href="manage_trainors.php">Trainors</a></li>
						<li><a href="manage_name_suffix.php">Name Suffix</a></li>
						<li><a href="manage_competency_rating.php">Competency and Rating</a></li>
					</ul>
				</li>				
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><strong><?php echo $user_data->full_name; ?></strong> <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
					
						<li><a href = "../../../main_profile.php"><span class = "fa fa-user fa-1x"></span> Profile</a></li>
						<li><a href = "../../../php_processors/proc_logout.php" name = "btn_logout" id = "btn_logout"><span class = "fa fa-power-off fa-1x"></span> Logout</a></li>
					</ul>
				</li>
			</ul>
          
		</div>
	</div>
</nav>
<br/>