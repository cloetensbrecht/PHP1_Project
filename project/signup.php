<?php

require_once("bootstrap.php");

  if(!empty($_POST)){
		$user = new User();

		// GET & SET gegevens formulier
		$user->setEmail($_POST['email']);
		$user->setPassword($_POST['password']);
		$user->setPasswordConfirmation(['password_confirmation']);
		
		if($user->register()){
			session_start();
			
			// SESSION adhv email
			$_SESSION['email'] = $user->getEmail();

			// Ga naar feed
			header('Location: index.php');
		}

  }
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>InspirationHunter</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="InspirationHunterLogin InspirationHunterLogin--register">
		<div class="form form--login">
			<form action="" method="post">
				<h2 form__title>Sign up for an account</h2>

				<div class="form__error hidden">
					<p>
						Some error here 
						<!-- hier wil je enkel een error als die er is // denk aan if (isset($error)): .. zoals bij login.php --> 
					</p>
				</div>

				<div class="form__field">
					<label for="email">Email</label>
					<input type="text" id="email" name="email">
				</div>
				<div class="form__field">
					<label for="password">Password</label>
					<input type="password" id="password" name="password">
				</div>

                <div class="form__field">
					<label for="password_confirmation">Confirm your password</label>
					<input type="password" id="password_confirmation" name="password_confirmation">
				</div>

				<div class="form__field">
					<input type="submit" value="Sign me up!" class="btn btn--primary">	
				</div>
				<div>
					<p>Already a account? <a href="login.php"> Login </a></p>
				</div>
			</form>
		</div>
	</div>
</body>
</html>