<?php 
  include_once('../app/functions.php');
  include_once('../app/connection.php');
  $stmt = "SELECT * FROM `instructors` ORDER BY `id` DESC";
  $instructors = $conn->query($stmt);
 ?>
<!DOCTYPE html>
<html>
<head>
  <title>KURSEVI | INSTRUKTORI</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <?php include_once('../includes/nav-bar.php'); ?>

    <h1>INSTRUKTORI</h1>  
    
    <a href="<?php echo url('instructors/create.php') ?>" class="btn btn-info">Dodaj Instruktora</a>

    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Ime</th>
          <th scope="col">Prezime</th>
          <th scope="col">Tehnologije</th>
          <th scope="col">IZMJENA</th>
          <th scope="col">OBRIŠI</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($instructors as $key => $value) { ?>
          <tr>
            <td><?php echo $key + 1 ?></td>
            <td><?php echo $value['first_name'] ?></td>
            <td><?php echo $value['last_name'] ?></td>
            <td><?php echo $value['technology'] ?></td>
            <td><a href="<?php echo url('instructors/update.php?instructor_id=' . $value['id']) ?>">Izmjena</a></td>
            <td>
              <form action="<?php echo url('instructors/delete.php') ?>" method="POST">
                <input type="hidden" name="instructor_id" value="<?php echo $value['id'] ?>">
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