<?php
require_once("../initialize.php");
$exam = new Exam();
$exam_details = $exam->getExamByParticipantByModule($post->participant_id,$post->module_id);
$exam_count = count($exam_details);
if($exam_count > 0){
?>
	<table class="table">
		<thead>
			<tr>
				<th>No.</th>
				<th>Exam</th>
				<th>Score</th>
				<th>Percentage Score</th>
				<th>Passing Score</th>
				<th>Remarks</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$ctr = 1;
			$total_score = 0;
			foreach($exam_details as $e){

				$e = (object)$e;
				$total_items = count($exam->getExamQuestionsList($e->exam_id));
				$score = $exam->getExamScoreByParticipant($post->participant_id);
				$percentage_score = ($score / $total_items) * 100;
       			$trainee_exam_answers = $exam->getTraineeExamAnswers($e->id);
       			$total_score += $percentage_score;
				$remarks = $exam->getExamRemarks(
					count($trainee_exam_answers),
					$total_items,
					$percentage_score,
					$e->passing_score
				);
		?>
			<tr>
				<td><?php echo $ctr;?></td>
				<td><?php echo $e->exam;?></td>
				<td><?php echo $score . "/" . $total_items;?></td>
				<td><?php echo Format::to_decimal($percentage_score);?>%</td>
				<td><?php echo $e->passing_score;?>%</td>
				<td><?php echo $remarks;?></td>
			</tr>
		<?php	
				$ctr++;	
			}

			$average_score = $total_score / ($ctr-1); // 
		?>
		</tbody>

		<tfoot>
			<tr style="background-color:#ccc;" class="text-bold">
				<td class="text-right" colspan="3">Average Score:</td>
				<td colspan="3"><?php echo Format::to_decimal($average_score);?>%</td>
			</tr>
		</tfoot>
	</table>
	
<?php
}
else {
	echo "<h4 class='text-center text-muted'>No exams recorded.</h4>";
}