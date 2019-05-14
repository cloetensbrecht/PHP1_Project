<?php
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
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Login</title>
</head>
<body>
<div class="login">
		<div class="form form--login">
			<form action="" method="post">
				<img id="logo" src="#" alt="">
				<h2 form__title>Login</h2>
				<?php if (isset($error)): ?>
					<div class="form__error">
					<?php echo '⛔️'.$error; ?>
					</div>
				<?php endif; ?>

				<div class="form__field">
					<label for="email">Email</label>
					<input type="text" name="email" placeholder="email" require>
				</div>
				<div class="form__field">
					<label for="password">Password</label>
					<input type="password" name="password" placeholder="password" require>
				</div>

				<div class="form__field">
					<input type="submit" value="Log in!" class="btn btn--primary">
				</div>
				<div>
					<p>No account yet? <a href="signup.php"> Sign up first</a></p>
				</div>
			</form>
		</div>
	</div>
</body>
</html>