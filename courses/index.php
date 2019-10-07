<?php 
	include_once('../app/functions.php');
	include_once('../app/connection.php');
	$stmt = "SELECT CONCAT(`instructors`.`first_name`, ' ', `instructors`.`last_name`) as `instructor`, `course_name`, `course_hour`, `courses`.`id` as `base_id`
			FROM `courses`
			JOIN `instructors` ON `courses`.`instructor_id` = `instructors`.id 
			ORDER BY `courses`.`id` DESC";
	$courses = $conn->query($stmt);
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>KURSEVI | Kursevi</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<?php include_once('../includes/nav-bar.php'); ?>	
		<h1>KURSEVI</h1>
		
		<a href="<?php echo url('courses/create.php') ?>" class="btn btn-info">Dodaj Kurs</a>

		<table class="table table-hover">
		  <thead>
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Naziv</th>
		      <th scope="col">Trajanje</th>
		      <th scope="col">Zaduzenje</th>
		      <th scope="col">IZMJENA</th>
		      <th scope="col">OBRIŠI</th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php foreach ($courses as $key => $value) { ?>
		    	<tr>
		    		<td><?php echo $key + 1 ?></td>
		    		<td><?php echo $value['course_name'] ?></td>
		    		<td><?php echo $value['course_hour'] ?></td>
		    		<td><?php echo $value['instructor'] ?></td>
		    		<td><a href="<?php echo url('courses/update.php?course_id=' . $value['base_id']) ?>">Izmjena</a></td>
		    		<td>
		    			<form action="<?php echo url('courses/delete.php') ?>" method="POST">
		    				<input type="hidden" name="course_id" value="<?php echo $value['base_id'] ?>">
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