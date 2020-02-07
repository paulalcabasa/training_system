<?php
require_once("../initialize.php");
$trainee = new Trainee();

$dealership_history = $trainee->getDealershipHistory($post->trainee_code);

foreach($dealership_history as $history){
	$history = (object)$history;
?>
	<tr>
		<td><?php echo $history->dealer_name;?></td>
		<td><?php echo $history->job_description;?></td>
		<td><?php echo $history->emp_status;?></td>
		<td><?php echo Format::format_date2($history->date_hired);?></td>
		<td><?php echo Format::format_date($history->date_updated);?></td>
	</tr>
<?php
}
?>