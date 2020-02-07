<nav class="nav navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation-collapse">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
      		</button>
      		<a class="navbar-brand" href="../../../main_home.php"><i class = "fa fa-leaf fa-1x"></i> WEB IPC</a>
 
		</div>
	

		<div class="collapse navbar-collapse" id="navigation-collapse">
			<ul class="nav navbar-nav" id="navigation-top">
				<li id="nav_home"><a href = "index.php"><i class = "fa fa-home fa-1x"></i> Home</a></li>
				<li id="nav_training_info"><a href="view_trainees.php" >Training Information</a></li>
				<li id="nav_progs_mods"><a href="view_programs_modules.php" >Programs and Modules</a></li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="add_program.php">By Trainee</a></li>
						<li><a href="view_programs_modules.php">By Dealer</a></li>
						<li><a href="view_programs_modules.php" style="font-size:.9em;">By Program</a></li>
					</ul>
				</li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Maintenance <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="manage_trainors.php">Trainors</a></li>
						<li><a href="manage_dealer_groups.php">Dealers</a></li>
						<li><a href="#" style="font-size:.9em;">Job Positions</a></li>
					</ul>
				</li>

			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><strong><?php echo $_SESSION['EmpName']; ?></strong> <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href = "../../../main_profile.php"><span class = "glyphicon glyphicon-user"></span> Profile</a></li>
						<li><a href = "../../../php_processors/proc_logout.php" name = "btn_logout" id = "btn_logout"><span class = "glyphicon glyphicon-th-large"></span> Logout</a></li>
					</ul>
				</li>
			</ul>

		</div>
	</div>
</nav>
<br/>