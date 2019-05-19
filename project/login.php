<?php
    //FEATURE 2 - login
    require_once 'bootstrap.php';

    // session
    if (isset($_SESSION['id'])) {
        header('location: index.php');
    }
    // check mail & pw
    if (!empty($_POST)) {
        $user = new User();
        $user->setEmail($_POST['email'])->setPassword($_POST['password']);
        $error = $user->canLogin();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css/login.css"> 
</head>

<body>
  <div class="container login ">
    <div class="form-login">
      <h1>Travel Inspiration</h1>
      <form action="" method="post">
        <h2 form__title>Login</h2>

        <?php if (isset($error)): ?>
        <div class="form__error">
          <?php echo '⛔️'.$error; ?>
        </div>
        <?php endif; ?>

        <div class="form__field">
          <label for="email" class="sr-only">Email</label>
          <input type="email" name="email" class="form-control" placeholder="email" required>
        </div>

        <div class="form__field">
          <label for="password" class="sr-only">Password</label>
          <input type="password" name="password" class="form-control" placeholder="password" required>
        </div>

        <div class="form__field">
          <button class="btn btn-lg btn-primary btn-block" type="submit">Log in!</button>
        </div>
        <div class="switch">
          <p>No account yet? <a href="signup.php"> Sign up first</a></p>
        </div>
      </form>
    </div>
  </div>
</body>

</html>