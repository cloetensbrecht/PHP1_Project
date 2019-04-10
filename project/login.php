<?php 
	require_once("bootstrap.php");
	
	// session 
	if(isset($_SESSION["id"])){
        header("location: index.php");
	}

	// check mail & pw
    if(!empty($_POST)){
        $user = new User;
        $user->setEmail($_POST["email"])->setPassword($_POST["password"]);
        $error = $user->canLogin();
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="login">
		<div class="form form--login">
			<form action="" method="post">
				<img id="logo" src="#" alt="">
				<h2 form__title>Login</h2>

				<?php if (isset($error)): ?>
					<div class="form__error">
						<p>Sorry, we can't log you in with that email address and password. Can you try again?</p>
					</div>
				<?php endif; ?>

				<div class="form__field">
					<label for="email">Email</label>
					<input type="text" name="email" placeholder="email">
				</div>
				<div class="form__field">
					<label for="password">Password</label>
					<input type="password" name="password" placeholder="password">
				</div>

				<div class="form__field">
					<input type="submit" value="Log in!" class="btn btn--primary">
				</div>
				<div>
					<p>No account yet? <a href="register.php"> Sign up first</a></p>
				</div>
			</form>
		</div>
	</div>
</body>
</html>