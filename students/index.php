<?php 
	include_once('../app/functions.php');
	include_once('../app/connection.php');
	$stmt = "SELECT `students`.`id` as `id`, `first_name`, `last_name`, `course_listened`, `course_name` 
			FROM `students`  
			JOIN `courses` ON `courses`.`id` = `students`.`course_id`
			ORDER BY `students`.`id` DESC";
	$students = $conn->query($stmt);
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>KURSEVI | STUDENTI</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<?php include_once('../includes/nav-bar.php'); ?>

		<h1>STUDENTI</h1>	
		
		<a href="<?php echo url('students/create.php') ?>" class="btn btn-info">Dodaj Studenta</a>

		<table class="table table-hover">
		  <thead>
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Ime</th>
		      <th scope="col">Prezime</th>
		      <th scope="col">KURS</th>
		      <th scope="col">ODLUŠAN BROJ ČASOVA</th>
		      <th scope="col">IZMJENA</th>
		      <th scope="col">OBRIŠI</th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php foreach ($students as $key => $value) { ?>
		    	<tr>
		    		<td><?php echo $key + 1 ?></td>
		    		<td><?php echo $value['first_name'] ?></td>
		    		<td><?php echo $value['last_name'] ?></td>
		    		<td><?php echo $value['course_name'] ?></td>
		    		<td><?php echo $value['course_listened'] ?></td>
		    		<td><a href="<?php echo url('students/update.php?student_id=' . $value['id']) ?>">Izmjena</a></td>
		    		<td>
		    			<form action="<?php echo url('students/delete.php') ?>" method="POST">
		    				<input type="hidden" name="student_id" value="<?php echo $value['id'] ?>">
		    				<button class="btn btn-danger">Obriši</button>
		    			</form>
		    		</td>
		    	</tr>
		    <?php } ?>
		  </tbody>
		</table>
	</div>
</body>
</html>