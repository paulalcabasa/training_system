<?php
require_once("../initialize.php");
$trainee = new Trainee();

$position_history = $trainee->getJobPositionHistory($post->trainee_code);

foreach($position_history as $history){
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