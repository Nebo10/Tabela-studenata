<?php 
	include_once('../app/functions.php');
	include_once('../app/connection.php');

	$stmt = "SELECT CONCAT(`first_name`, ' ', `last_name`) as `full_name`, `id` 
			FROM `instructors`
			ORDER BY `id` DESC";
	$instructors = $conn->query($stmt);

	if (isset($_POST['submit'])) {
		$err_required = '<p class="text-danger">Ovo polje je obavezno</p>';
		$errors = [];
		$input_data = [];
		if (isset($_POST['course_name']) && !empty($_POST['course_name'])) {
			$input_data['course_name'] = $_POST['course_name'];
		}else{
			$errors['course_name'] = $err_required;
		}

		if (isset($_POST['course_hour']) && !empty($_POST['course_hour'])) {
			$input_data['course_hour'] = $_POST['course_hour'];
		}else{
			$errors['course_hour'] = $err_required;
		}

		if (isset($_POST['instructor_id']) && !empty($_POST['instructor_id'])) {
			$input_data['instructor_id'] = $_POST['instructor_id'];
		}else{
			$errors['instructor_id'] = $err_required;
		}


		if (count($errors) == 0) {
			$stmt = $conn->prepare("INSERT INTO `courses`(`course_name`, `course_hour`, `instructor_id`) VALUES(:course_name, :course_hour, :instructor_id)");
			$stmt = $stmt->execute([
									':course_name' => $input_data['course_name'],
									':course_hour' => $input_data['course_hour'],
									':instructor_id' => $input_data['instructor_id'],
									]);
			unset($input_data);
			$flash_msg = '<p class="text-success">Uspješno ste dodali kurs.</p>';
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
		<?php include_once('../includes/nav-bar.php'); ?>	
		
		<?php echo $flash_msg??'' ?>
		<form action="#" method="POST">
			<div class="form-group">
				<label for="course_name">Naziv Kursa</label>
				<input type="text" class="form-control" value="<?php echo $input_data['course_name']??'' ?>" id="course_name" placeholder="Naziv Kursa" name="course_name">
				<?php echo $errors['course_name']??'' ?>
			</div>
			<div class="form-group">
				<label for="course_hour">Trajanje kursa</label>
				<input type="text" class="form-control" value="<?php echo $input_data['course_hour']??'' ?>" id="course_hour" placeholder="Trajanje kursa" name="course_hour">
				<?php echo $errors['course_hour']??'' ?>
			</div>

			<div class="form-group">
				<label for="instructor_id">Instruktori</label>
				<select name="instructor_id">
					<option value="">-- Odaberi --</option>
					<?php foreach ($instructors as $key => $value) { ?>
						<option value="<?php echo $value['id'] ?>"  <?php echo $value['id'] == ($input_data['instructor_id']??false) ? 'selected' : '' ?>> <?php echo $value['full_name'] ?></option>
					<?php } ?>
					
				</select>
				<?php echo $errors['instructor_id']??'' ?>
			</div>
			
			<a href="<?php echo url('instructors/') ?>" class="btn btn-danger">Odustani</a>
			<button type="submit" name="submit" class="btn btn-success">Kreiraj</button>
			</form>
		
	</div>
</body>
</html>