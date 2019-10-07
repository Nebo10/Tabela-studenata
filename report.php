<?php 
	include_once('app/functions.php');
	include_once('app/connection.php');

	$report_id = $_GET['report_id'] ?? false;
	if (!$report_id) {
		die('Ne postoji podatak');
	}

	$stmt = "SELECT `students`.`id` as `id`, `first_name`, `last_name`, `course_listened`, `course_name` 
			FROM `students`  
			JOIN `courses` ON `courses`.`id` = `students`.`course_id`
			ORDER BY `students`.`id` DESC";
	$students = $conn->query($stmt);

	$stmt = "SELECT *
			FROM `reports`
			WHERE `id` = :report_id";
	$stmt = $conn->prepare($stmt);

	$reports = $stmt->execute([':report_id' => $report_id]);
	$reports = $stmt->fetch();

	if (isset($_POST['submit'])) {
		$err_required = '<p class="text-danger">Ovo polje je obavezno</p>';
		$errors = [];
		$input_data = [];
		if (isset($_POST['student_id']) && !empty($_POST['student_id'])) {
			$input_data['student_id'] = $_POST['student_id'];
		}else{
			$errors['student_id'] = $err_required;
		}

		if (count($errors) == 0) {
			$stmt = $conn->prepare("INSERT INTO `reports`(`id`, `student_id`) VALUES(:id, :student_id) ON DUPLICATE KEY UPDATE `id` = :report_id, `student_id` = :student_id");
			$stmt = $stmt->execute([
									':id' => $report_id,
									':student_id' => $input_data['student_id'],
									':report_id' => $report_id,
									]);
			$stmt = "SELECT *
			FROM `reports`
			WHERE `id` = :report_id";
			$stmt = $conn->prepare($stmt);

			$reports = $stmt->execute([':report_id' => $report_id]);
			$reports = $stmt->fetch();
			unset($input_data);
			$flash_msg = '<p class="text-success">Uspješno ste dodali studenta.</p>';
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>KURSEVI | INSTRUKTORI - Kreiraj</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<?php include_once('includes/nav-bar.php'); ?>	
		
		<?php echo $flash_msg??'' ?>
		<form action="#" method="POST">
			<input type="hidden" name="report_id" value="<?php $report_id ?>">
			<div class="form-group">
				<label for="student_id">Studenti</label>
				<select name="student_id">
					<option value="">-- Odaberi --</option>
					<?php foreach ($students as $key => $value) { ?>
						<option value="<?php echo $value['id'] ?>"  <?php echo $value['id'] == ($reports['student_id']??false) ? 'selected' : '' ?>> <?php echo $value['first_name'] . ' ' . $value['last_name'] . ' - ' . $value['course_name'] ?></option>
					<?php } ?>
					
				</select>
				<?php echo $errors['student_id']??'' ?>
			</div>

			
			<a href="<?php echo url('') ?>" class="btn btn-danger">Odustani</a>
			<button type="submit" name="submit" class="btn btn-success">Kreiraj</button>
			</form>
		
	</div>
</body>
</html>