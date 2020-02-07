<?php 
	require_once("initialize.php");
	require_once("includes/user_access.php");
	$employee_masterfile->incrementSystemHits($_SESSION['user_data']['employee_id'],SYSTEM_ID);
	require_once("includes/header_files.php");
?>

<div class="container">

<div style="height: 10em;position: relative;">
	<img style="margin: 0;position: relative;top: 50%;left: 25%;" src = "../../../img/banner_training.png"  draggable="false">
</div>

<!-- Latest jquery -->
<script src="<?php echo JQUERY;?>"></script>
<!-- bootstrap jquery -->
<script src="<?php echo BOOTSTRAP_JS;?>"></script>
	
<?php include("includes/footer.php");?>		
<script>
	$("#navigation-top").children("li:nth-child(1)").addClass("active");
</script>	
</body>
</html>
