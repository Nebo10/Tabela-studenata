<?php 
	include_once('../app/functions.php');
	include_once('../app/connection.php');

	$instructor_id = $_POST['instructor_id'] ?? false;
	if (!$instructor_id) {
		die('Ne postoji instruktor');
	}

	$stmt = $conn->prepare("SELECT * FROM `instructors` WHERE `id` = :id");
	$instructor = $stmt->execute([':id' => $instructor_id]);
	$instructor = $stmt->fetch();

	if (!$instructor['id']) {
		die('Ne postoji instruktor');
	}

	
	$stmt = $conn->prepare("DELETE FROM `instructors` WHERE `id` = :id");
	$deleted = $stmt->execute([':id' => $instructor['id']]);
	if ($deleted) {
		echo "Uspješno ste obrisali instruktora " . $instructor['first_name'] . " " . $instructor['last_name'];
		echo "<br>";
		echo "<a href=". url('instructors').">Vrati se </a>";
	}
?>
