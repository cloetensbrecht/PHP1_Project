<?php

require_once("bootstrap.php");

  if(!empty($_POST) && !empty($_POST['password'] && $_POST['password_confirmation'] )){
		$user = new User();

		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$passwordComfirmation = $_POST['password_confirmation'];
		
		// You can register if password = passworfComfirmation
		if($password == $passwordComfirmation) {
			// GET & SET gegevens formulier
			$user->setFirstname($firstname);
			$user->setLastname($lastname);
			$user->setUsername($username);
			$user->setEmail($email);
			$user->setPassword($password);
			$user->setPasswordConfirmation($passwordComfirmation);
			
			if($user->register()){
				session_start();
				
				// SESSION adhv email
				$_SESSION['email'] = $user->getEmail();
	
				// Ga naar feed
				header('Location: index.php');
			}
		}
		else {
			$error = "Wrong password";
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

				<?php if (isset($error)): ?>
					<div class="form__error">
					<?php echo "⛔️" . $error; ?>
					</div>
				<?php endif; ?>


				<div class="form__field">
					<label for="firstname">Firstname</label>
					<input type="text" id="firstname" name="firstname">
				</div>

				<div class="form__field">
					<label for="lastname">Lastname</label>
					<input type="text" id="lastname" name="lastname">
				</div>

				<div class="form__field">
					<label for="username">Username</label>
					<input type="text" id="username" name="username">
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