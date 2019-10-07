<?php 
	include_once('../app/functions.php');
	include_once('../app/connection.php');

	$instructor_id = $_GET['instructor_id'] ?? false;
	if (!$instructor_id) {
		die('Ne postoji instruktor');
	}

	$stmt = $conn->prepare("SELECT * FROM `instructors` WHERE `id` = :id");
	$instructor = $stmt->execute([':id' => $instructor_id]);
	$instructor = $stmt->fetch();

	if (!$instructor['id']) {
		die('Ne postoji instruktor');
	}


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

		if (isset($_POST['technology']) && !empty($_POST['technology'])) {
			$input_data['technology'] = $_POST['technology'];
		}else{
			$errors['technology'] = $err_required;
		}


		if (count($errors) == 0) {
			$stmt = $conn->prepare("UPDATE `instructors` SET first_name = :first_name, last_name = :last_name, technology = :technology WHERE `id` = :id");
			$stmt = $stmt->execute([
									':first_name' => $input_data['first_name'],
									':last_name' => $input_data['last_name'],
									':technology' => $input_data['technology'],
									':id' => $instructor['id'],
									]);
			$flash_msg = '<p class="text-success">Uspješno ste sačuvali instruktora.</p>';

			$stmt = $conn->prepare("SELECT * FROM `instructors` WHERE `id` = :id");
			$instructor = $stmt->execute([':id' => $instructor_id]);
			$instructor = $stmt->fetch();
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
				<input type="text" class="form-control" value="<?php echo $instructor['first_name'] ?>" id="first_name" placeholder="Ime" name="first_name">
				<?php echo $errors['first_name']??'' ?>
			</div>
			<div class="form-group">
				<label for="last_name">Prezime</label>
				<input type="text" class="form-control" value="<?php echo $instructor['last_name'] ?>" id="last_name" placeholder="Prezime" name="last_name">
				<?php echo $errors['last_name']??'' ?>
			</div>

			<div class="form-group">
				<label for="technology">Programski jezici</label>
				<input type="text" class="form-control" value="<?php echo $instructor['technology'] ?>" id="technology" placeholder="Programski jezici" name="technology">
				<?php echo $errors['technology']??'' ?>
			</div>
			
			<a href="<?php echo url('instructors/') ?>" class="btn btn-danger">Odustani</a>
			<button type="submit" name="submit" class="btn btn-success">Sačuvaj izmjene</button>
			</form>
		
	</div>
</body>
</html>