<!doctype html>
<html lang="en">

<head>
  <title>Home</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>


  <?php require_once 'includes/header.php'; ?>


  <?php require_once 'core/init.php';


  if (Session::exists('home')) {
    echo '<p>' . Session::flash('home') . '</p>';
  }

  $user = new User();
  if ($user->isLoggedIn()) {

    ?>

    <p> Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?><?php echo escape($user->data()->username); ?>">
       
      </a>!</p>



    <ul>
      <li><a href="update.php" class="btn btn-outline-primary my-2 my-sm-0 ml-3" type="submit">Update User</a></li>
      <li><a href="changepassword.php" class="btn btn-outline-warning my-2 my-sm-0 ml-3" type="submit">Change Password</a></li>
    </ul>
    <?php

    if($user->hasPermission('admin'))
    {
      echo '<p>Welcome, Admin!</p>';

    }

  } else {
    echo '<p>You need to <a href="login.php" class="btn btn-success">Login</a> Or <a href="register.php" class="btn btn-primary">Register</a></p';
  }
  ?>

  <?php require_once 'includes/footer.php'; ?>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
</body>

</html>