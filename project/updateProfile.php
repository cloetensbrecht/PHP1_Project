<?php
/* feature 3 - profiel aanpassen
○	opladen van foto / avatar
○	Beschrijving / korte profieltekst (emoji’s bewaren moet mogelijk zijn)
○	wachtwoord wijzigen
○	email adres wijzigen
>	Hoe kan je dit veilig toelaten? (wat als je even van je laptop weg bent en iemand je wachtwoord wijzigt?) Idem voor wachtwoord wijzigen.
○	Zorg dat je hier aantoont dat je hebt nagedacht over een veilige procedure
*/
    require_once 'bootstrap.php';  // import Classes
    $conn = Db::getInstance();      // db connection

    $id = null;
    if (!empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
    if (null == $id) {
        header('Location: index.php');
    }

    echo $_SESSION['id'];
    echo $id;

    if (!empty($_POST)) {
        // check pw
        $user = new User();
        $user->setPassword($_POST['CurrentPassword']);
        $error = $user->canLogin();

        // keep track validation errors
        $firstNameError = null;
        $lastNameError = null;
        $usernameError = null;
        $emailError = null;
        $mobileError = null;
        $bioError = null;
        $profilePictureError = null;

        $passwordError = null; // for NewPassword & CurrentPassword

        // keep track post values
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $mobile = $_POST['mobile'];
        $bio = $_POST['bio'];
        $profilePicture = $_FILES['profilePicture'];
        //$password = $_POST['password'];
        //$NewPassword = $_POST['NewPassword'];
        $CurrentPassword = $_POST['CurrentPassword'];

        // validate input
        $valid = true;
        if (empty($firstName)) {
            $firstNameError = 'Please enter firstname';
            $valid = false;
        }
        if (empty($lastName)) {
            $lastNameError = 'Please enter lastname';
            $valid = false;
        }

        if (empty($email)) {
            $emailError = 'Please enter Email Address';
            $valid = false;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = 'Please enter a valid Email Address';
            $valid = false;
        }

        if (empty($username)) {
            $usernameError = 'Please enter username';
            $valid = false;
        }

        if (empty($mobile)) {
            $mobileError = 'Please enter Mobile Number';
            $valid = false;
        }
        if (empty($bio)) {
            $bioError = 'Please enter bio';
            $valid = false;
        }

        if (empty($profilePicture)) {
            $profilePictureError = 'Please take a profile picture';
            $valid = false;
        }

        // update data
        if ($valid) {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'UPDATE users set firstName = ?, lastName = ?, email = ?, mobile =?, bio=? , profilePicture=? , username=? WHERE id = ?';
            $q = $conn->prepare($sql);
            $q->execute(array($firstName, $lastName, $email, $mobile, $bio, $profilePicture, $username, $id));
            //Database::disconnect();
            header('Location: index.php');
        }
    } else {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT * FROM users where id = ?';
        $q = $conn->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $email = $data['email'];
        $mobile = $data['mobile'];
        $bio = $data['bio'];
        $profilePicture = $data['profilePicture'];
        //$NewPassword = $data['NewPassword'];
        //$CurrentPassword = $data['CurrentPassword'];
        $username = $data['username'];
        //Database::disconnect();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <title>Inspiration Hunter - Edit Profile</title> 
</head>
<body>
    <!--  feature 3 - profiel aanpassen  -->
    <div class="container">
        <div class="span10 offset1">
            <div class="row">
                <h3>Edit your profile</h3>
            </div>

            <form class="form-horizontal" action="updateProfile.php?id=<?php echo $id; ?>" method="post">
                <div class="control-group <?php echo !empty($firstNameError) ? 'error' : ''; ?>">
                    <label class="control-label">Firstname</label>
                    <div class="controls">
                        <input name="firstName" type="text" placeholder="firstName"
                            value="<?php echo !empty($firstName) ? $firstName : ''; ?>">
                        <?php if (!empty($firstNameError)): ?>
                        <span class="help-inline"><?php echo $firstNameError; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="control-group <?php echo !empty($lastNameError) ? 'error' : ''; ?>">
                    <label class="control-label">Lastname</label>
                    <div class="controls">
                        <input name="lastName" type="text" placeholder="lastName"
                            value="<?php echo !empty($lastName) ? $lastName : ''; ?>">
                        <?php if (!empty($lastNameError)): ?>
                        <span class="help-inline"><?php echo $lastNameError; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="control-group <?php echo !empty($emailError) ? 'error' : ''; ?>">
                    <label class="control-label">Email Address</label>
                    <div class="controls">
                        <input name="email" type="text" placeholder="Email Address"
                            value="<?php echo !empty($email) ? $email : ''; ?>">
                        <?php if (!empty($emailError)): ?>
                        <span class="help-inline"><?php echo $emailError; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="control-group <?php echo !empty($usernameError) ? 'error' : ''; ?>">
                    <label class="control-label">Username</label>
                    <div class="controls">
                        <input name="username" type="text" placeholder="username"
                            value="<?php echo !empty($username) ? $username : ''; ?>">
                        <?php if (!empty($usernameError)): ?>
                        <span class="help-inline"><?php echo $usernameError; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="control-group <?php echo !empty($mobileError) ? 'error' : ''; ?>">
                    <label class="control-label">Mobile Number</label>
                    <div class="controls">
                        <input name="mobile" type="text" placeholder="Mobile Number"
                            value="<?php echo !empty($mobile) ? $mobile : ''; ?>">
                        <?php if (!empty($mobileError)): ?>
                        <span class="help-inline"><?php echo $mobileError; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="control-group <?php echo !empty($bioError) ? 'error' : ''; ?>">
                    <label class="control-label">Bio</label>
                    <div class="controls">
                        <textarea name="bio" type="text" placeholder="bio"
                            value="<?php echo !empty($bio) ? $bio : ''; ?>"></textarea>
                        <?php if (!empty($bioError)): ?>
                        <span class="help-inline"><?php echo $bioError; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="control-group <?php echo !empty($bioError) ? 'error' : ''; ?>">
                    <label class="control-label">Profile Picture</label>
                    <div class="controls">
                        <input name="profilePicture" type="file" placeholder="profilePicture"
                            value="<?php echo !empty($profilePicture) ? $profilePicture : ''; ?>">
                        <?php if (!empty($bioError)): ?>
                        <span class="help-inline"><?php echo $bioError; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- protect profile - pw -->
                <h3>Current password</h3>
                <p>To change profile information, you must enter the current password.</p>
                <div class="control-group <?php echo !empty($passwordError) ? 'error' : ''; ?>">
                    <label class="control-label">Current Password</label>
                    <div class="controls">
                        <input name="CurrentPassword" type="text" placeholder="********" required>
                        <?php if (!empty($passwordError)): ?>
                        <span class="help-inline"><?php echo $passwordError; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Update profile</button>
                </div>
            </form>

            <a class="btn" href="index.php">Back</a>
        </div>
    </div> 
</body>
</html>