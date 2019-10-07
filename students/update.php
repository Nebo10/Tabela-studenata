<?php 
	include_once('../app/functions.php');
	include_once('../app/connection.php');

	$student_id = $_GET['student_id'] ?? false;
	if (!$student_id) {
		die('Ne postoji student');
	}

	$stmt = $conn->prepare("SELECT * FROM `students` WHERE `id` = :id");
	$student = $stmt->execute([':id' => $student_id]);
	$student = $stmt->fetch();

	if (!$student['id']) {
		die('Ne postoji student');
	}

	$stmt = "SELECT * FROM `courses` ORDER BY `id` DESC";
	$courses = $conn->query($stmt);


	if (isset($_POST['submit'])) {
		$err_required = '<p class="text-danger">Ovo polje je obavezno</p>';
		$errors = [];
		$input_data = [];
		if (isset($_POST['first_name']) && !empty($_POST['first_name'])) {
			$input_data['first_name'] = $_POST['first_name'];
		}else{
			$errors['first_name'] = $err_required;
		}

		if (isset($_POST['last_name']) && !empty($_POST['last_name'])) {
			$input_data['last_name'] = $_POST['last_name'];
		}else{
			$errors['last_name'] = $err_required;
		}

		if (isset($_POST['course_id']) && !empty($_POST['course_id'])) {
			$input_data['course_id'] = $_POST['course_id'];
		}else{
			$errors['course_id'] = $err_required;
		}

		if (isset($_POST['course_listened']) && !empty($_POST['course_listened'])) {
			$input_data['course_listened'] = $_POST['course_listened'];
		}else{
			$errors['course_listened'] = $err_required;
		}


		if (count($errors) == 0) {
			$stmt = $conn->prepare("UPDATE `students` SET first_name = :first_name, last_name = :last_name, course_listened = :course_listened, course_id = :course_id WHERE `id` = :id");
			$stmt = $stmt->execute([
									':first_name' => $input_data['first_name'],
									':last_name' => $input_data['last_name'],
									':course_listened' => $input_data['course_listened'],
									':course_id' => $input_data['course_id'],
									':id' => $student['id'],
									]);
			$flash_msg = '<p class="text-success">Uspješno ste sačuvali instruktora.</p>';

			$stmt = $conn->prepare("SELECT * FROM `students` WHERE `id` = :id");
			$student = $stmt->execute([':id' => $student_id]);
			$student = $stmt->fetch();
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
				<label for="first_name">Ime</label>
				<input type="text" class="form-control" value="<?php echo $student['first_name'] ?>" id="first_name" placeholder="Ime" name="first_name">
				<?php echo $errors['first_name']??'' ?>
			</div>
			<div class="form-group">
				<label for="last_name">Prezime</label>
				<input type="text" class="form-control" value="<?php echo $student['last_name'] ?>" id="last_name" placeholder="Prezime" name="last_name">
				<?php echo $errors['last_name']??'' ?>
			</div>

			<div class="form-group">
				<label for="course_id">Kursevi</label>
				<select name="course_id">
					<option value="">-- Odaberi --</option>
					<?php foreach ($courses as $key => $value) { ?>
						<option value="<?php echo $value['id'] ?>"  <?php echo $value['id'] == ($student['course_id']??false) ? 'selected' : '' ?>> <?php echo $value['course_name'] ?></option>
					<?php } ?>
					
				</select>
				<?php echo $errors['course_id']??'' ?>
			</div>

			<div class="form-group">
				<label for="course_listened">Broj odslušanih časova</label>
				<input type="text" class="form-control" value="<?php echo $student['course_listened'] ?>" id="course_listened" placeholder="Broj odslušanih časova" name="course_listened">
				<?php echo $errors['course_listened']??'' ?>
			</div>
			
			<a href="<?php echo url('students/') ?>" class="btn btn-danger">Odustani</a>
			<button type="submit" name="submit" class="btn btn-success">Sačuvaj izmjene</button>
			</form>
		
	</div>
</body>
</html>