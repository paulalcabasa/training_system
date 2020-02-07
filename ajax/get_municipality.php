<?php
	include("../initialize.php");
	
	$phzipcode = new Phzipcode();
	$list_of_municipality = $phzipcode->getMunicipalitiesList($post->province_id);
	echo "<option value=''>Select Municipality</option>";

	foreach($list_of_municipality as $municipality){
		$municipality = (object)$municipality;
		echo "<option value='".$municipality->id."' data-zip_code='".$municipality->zip_code."'>" . $municipality->municipality_name  . "</option>";
	}	

?>