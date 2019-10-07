<?php 
	include_once('app/functions.php');
	include_once('app/connection.php');

	$days = ['Pon', 'Uto', 'Sri', 'Čet', 'Pet', 'Sub', 'Ned'];
	$stmt = "SELECT `reports`.`id` as report_id, `course_name`, CONCAT(`students`.`first_name`, ' ', `students`.`last_name`) as `student_name`, CONCAT(`instructors`.`first_name`, ' ', `instructors`.`last_name`) as `instructor_name`
				FROM `reports`
				LEFT JOIN `students` ON `students`.`id` = `reports`.`student_id`
				LEFT JOIN `courses` ON `courses`.`id` = `students`.`course_id`
				LEFT JOIN `instructors` ON `instructors`.`id` = `courses`.`instructor_id`";
	$reports = $conn->query($stmt)->fetchAll(PDO::FETCH_OBJ);
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>KURSEVI | KALENDAR</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<?php include_once('includes/nav-bar.php') ?>	
		<table class="table table-hover">
		  <thead>
		    <tr>
		      <th scope="col">Satnica</th>
		      <?php foreach ($days as $day) { ?>
		      		<th scope="col"><?php echo $day; ?></th>
		      <?php } ?>
		      
		    </tr>
		  </thead>
		  <tbody>
		    <?php for ($i=9; $i < 21; $i++) { ?>
		    	<tr>
		    		<td><?php echo $i . ' - ' . ($i + 1); ?></td>
		    		<?php foreach ($days as $key => $day) { $report_id = (($key + 1) * $i);  ?>
		      			<th>
		      				<?php foreach ($reports as $report_key => $report) {
		      					if ($report_id == $report->report_id) {
		      						echo $report->student_name . '<br>';
		      						echo $report->course_name . '<br>';
		      						echo $report->instructor_name . '<br>';
		      					}
		      				} 
		      				?>
		      				<a href="<?php echo url('report.php?report_id='.$report_id) ?>">Uredi</a>
		      			</th>
		      		<?php } ?>
		    	</tr>
		    <?php } ?>
		  </tbody>
		</table>
	</div>
</body>
</html>