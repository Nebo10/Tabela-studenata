<?php 
	include_once('../app/functions.php');
	include_once('../app/connection.php');

	$course_id = $_POST['course_id'] ?? false;
	if (!$course_id) {
		die('Ne postoji kurs');
	}

	$stmt = $conn->prepare("SELECT * FROM `courses` WHERE `id` = :id");
	$course = $stmt->execute([':id' => $course_id]);
	$course = $stmt->fetch();

	if (!$course['id']) {
		die('Ne postoji kurs');
	}

	
	$stmt = $conn->prepare("DELETE FROM `courses` WHERE `id` = :id");
	$deleted = $stmt->execute([':id' => $course['id']]);
	if ($deleted) {
		echo "Uspješno ste obrisali kurs " . $course['course_name'] ;
		echo "<br>";
		echo "<a href=". url('courses').">Vrati se </a>";
	}
?>
