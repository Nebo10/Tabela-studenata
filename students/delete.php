<?php 
	include_once('../app/functions.php');
	include_once('../app/connection.php');

	$student_id = $_POST['student_id'] ?? false;
	if (!$student_id) {
		die('Ne postoji instruktor');
	}

	$stmt = $conn->prepare("SELECT * FROM `students` WHERE `id` = :id");
	$student = $stmt->execute([':id' => $student_id]);
	$student = $stmt->fetch();

	if (!$student['id']) {
		die('Ne postoji instruktor');
	}

	
	$stmt = $conn->prepare("DELETE FROM `students` WHERE `id` = :id");
	$deleted = $stmt->execute([':id' => $student['id']]);
	if ($deleted) {
		echo "Uspješno ste obrisali studenta " . $student['first_name'] . " " . $student['last_name'];
		echo "<br>";
		echo "<a href=". url('students').">Vrati se </a>";
	}
?>
