<?php
	/* 
     * All of this file is included in every though
     * not all of them are always used.
     *
     * This should be corrected using an autoloader
     *
	 */
	/*include("includes/secure_training.php");
	include("config.php");
	include("classes/class.connection.php");
	include("classes/class.trainee.php");
	include("classes/class.program.php");
	include("classes/class.trainor.php");
	include("classes/class.dealer.php");
	include("classes/class.job.php");
 	include("classes/class.phzipcode.php");
 	include("classes/class.database.php");
 	include("classes/class.exam.php");
 	include("classes/class.format.php");
 	include("classes/class.encryption.php");
	$conn = new Connection();
	$trainee = new Trainee();
	$program = new Program();
	$trainor = new Trainor();
	$dealer = new Dealer();
	$job = new Job();
	$exam = new Exam();
	$phzipcode = new Phzipcode();*/
	include("includes/secure_training.php");
	include("config.php");

	// Function for autoloading classes in php
	spl_autoload_register(function ($class) {
		$class = strtolower($class);
	    include 'classes/class.' . $class . '.php';
	});

	$get = (object)$_GET;
	$post = (object)$_POST;
	$user_data = (object)$_SESSION['user_data'];
?>