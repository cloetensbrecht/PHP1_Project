<?php

require_once("functions.inc.php");
    // indien signup
    if(!empty($_POST)){
        // veldjes uitlezen
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConfirmation = $_POST['password_confirmation'];
        
        if(canRegister($email,$password,$passwordConfirmation)){
            $conn = @new mysqli("localhost","root","root","InspirationHunter");
            
            $password = md5($password);
            $sql = "INSERT into users(email,password) VALUES ('$email','$password')";
            $result = $conn->query($sql);
            if($result){
                echo "gelukt";
            }else{
                echo "misslukt";
            }
        }else{
						//error tonen
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
			</form>
		</div>
	</div>
</body>
</html>