<?php
// FEATURE 1 - sign in - account aanmaken
require_once 'bootstrap.php';

if (!empty($_POST)) {
    echo SafetyCheck::isValidEmail($_POST['email']);
    try {
        //if (SafetyCheck::isValidEmail($_POST['email'])) {
        $user = new User();
        //htmlspecialchars();
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $firstName = htmlspecialchars($_POST['firstName']);
        $lastName = htmlspecialchars($_POST['lastName']);
        $username = htmlspecialchars($_POST['username']);

        $user->setEmail($email);
        $user->setPassword($password);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setUsername($username);

        if ($user->register()) {
            //$user->loginToIndex();
            session_start();
            $_SESSION['email'] = $email;
            header('Location:index.php');
        }
        /*} else {
            $errorMail = 'Your email is invalid.';

            return $errorMail;
        }
        */
    } catch (Exception $e) {
        //$error = $e->getMessage();
        $error = 'fout'; // $user->canLogin();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
		integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title>Sign up </title>
	<link rel="stylesheet" href="css/login.css">
</head>

<body>
	<div class="container InspirationHunter--register">
		<div class="form form--login">
			<h1>Travel Inspiration</h1>
			<form action="" method="post" role="form" data-toggle="validator" id="signinForm">
				<h2 form__title>Sign in</h2>

				<?php if (isset($errorMail)): ?>
				<div class="form__error">
					<?php echo '⛔️'.$errorMail; ?>
				</div>
				<?php endif; ?>

				<div class="form-row">
					<div class="form-group col-md-6 has-feedback">
						<label for="firstName">Firstname</label>
						<input type="text" class="form-control" id="firstName" name="firstName" placeholder="Firstname"
							required>
					</div>
					<div class="form-group col-md-6 has-feedback">
						<label for="lastName">Lastname</label>
						<input type="text" class="form-control" id="lastName" name="lastName" placeholder="Lastname"
							required>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-6 has-feedback">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" data-minlength="8"
							placeholder="Password" required>
					</div>
					<div class="form-group col-md-6 has-feedback">
						<label for="username">Username</label>
						<input type="text" class="form-control" id="username" name="username" placeholder="Username"
							required>
					</div>
				</div>
				<div class="form-group has-feedback">
					<label for="email">Email</label>
					<input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
				</div>
				<div class="form-group has-feedback">
					<button type="submit" class="btn btn-primary btn-block">Sign in</button>
				</div>
				<div class="switch">
					<p>Already a account? <a href="login.php"> Login </a></p>
				</div>
			</form>

			<!--
				<form action="" method="post">
				<h2 class="form__title">Sign up for an account</h2>
				< ?php if (isset($error)): ?>
				<div class="form__error">
					<p> You didn't fill in everything, try again! </p>
				</div>
				< ?php endif; ?>

				<div class="email__error">
					<p id="email_error"></p>
				</div>

				<div class="form__field">
					<input type="text" id="email" name="email" placeholder="Email">
				</div>
				<div class="form__field">
					<input type="text" id="firstname" name="firstName" placeholder="Firstname">
				</div>
				<div class="form__field">
					<input type="text" id="lastname" name="lastName" placeholder="Lastname">
				</div>
				<div class="username__error">
					<p id="username_error"></p>
				</div>

				<div class="form__field">
					<input type="text" id="username" name="username" placeholder="Username">
				</div>
				<div class="form__field">
					<input type="password" id="password" name="password" placeholder="Password">
				</div>

				<div class="form__btn">
					<input type="submit" name="submit" value="Let's register now!">
				</div>

				<p id="gotAccount">Already got an account? <a href="login.php">Log in here</a></p>

			</form>
			
			<form action="" method="post">
				<h2 form__title>Sign up for an account</h2>

				< ?php if (isset($error)): ?>
					<div class="form__error">
					< ?php echo '⛔️'.$error; ?>
					</div>
				< ?php endif; ?>

				<div class="form__field">
					<label for="email">Email</label>
					<input type="mail" id="email" name="email">
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
			-->
		</div>
	</div>
	<script>
		$('#signinForm').validator();

		$('#form').validator().on('submit', function (e) {
			if (e.isDefaultPrevented()) {
				// handle the invalid form...
			} else {
				// everything looks good!
			}
		});

		// https://1000hz.github.io/bootstrap-validator/#validator-options
		// add 
		//https://getbootstrap.com/docs/3.4/css/#forms-control-validation 
	</script>
</body>

</html>