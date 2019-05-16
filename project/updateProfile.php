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

    //TEST // echo $_SESSION['id']; //    echo $id;

    $profile = new User();

    if (!empty($_POST)) {
        // keep track validation errors
        $firstNameError = null;
        $lastNameError = null;
        $usernameError = null;
        $emailError = null;
        $mobileError = null;
        $bioError = null;
        $profilePictureError = null;

        $CurrentPasswordError = null; // for NewPassword & CurrentPassword

        // keep track post values
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $mobile = $_POST['mobile'];
        $bio = $_POST['bio'];
        $profilePicture = $_POST['profilePicture'];
        //$profilePicture = $_FILES['profilePicture'];
        //$password = $_POST['password'];
        //$NewPassword = $_POST['NewPassword'];
        $CurrentPassword = $_POST['CurrentPassword'];

        // to setters
        $profile->setFirstName = ($_POST['firstName']);
        $profile->setLastName = ($_POST['lastName']);
        $profile->setEmail = ($_POST['email']);
        $profile->setUsername = ($_POST['username']);
        $profile->setMobile = ($_POST['mobile']);
        $profile->setBio = ($_POST['bio']);
        $profile->setProfilePicture($_POST['profilePicture']);

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

        if (empty($CurrentPassword)) {
            $CurrentPasswordError = 'Please enter your current password';
            $valid = false;
        } elseif (!empty($CurrentPassword)) {
            // check pw
            $valid = false;
            // FOUT ZIT HIER ?
            $CurrentPasswordCorrect = $profile->passwordCorrect();
            if ($CurrentPasswordCorrect = false) {
                $CurrentPasswordError = 'Something went wrong, your password are wrong. Try again.';
                $valid = false;
            } elseif ($CurrentPasswordCorrect = true) {
                $valid = true; // NU PAS gegevens updaten
            }
        }

        // update data
        if ($valid) {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'UPDATE users set firstName = ?, lastName = ?, email = ?, mobile =?, bio=? , profilePicture=? , username=? WHERE id = ?';
            $q = $conn->prepare($sql);
            $q->execute(array($firstName, $lastName, $email, $mobile, $bio, $profilePicture, $username, $id));

            //$update = $profile->validFormUpdateData();

            //Database::disconnect();
            //header('Location: index.php');
            //echo 'IT WORKS 🔥 TO index';
        }
    } else {
        // data ophalen uit db en invullen in de velden
        $data = $profile->getProfileInfo();

        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $email = $data['email'];
        $mobile = $data['mobile'];
        // Q - Waarom worden de velden bio en profilePicture niet ingevuld.
        $bio = $data['bio'];
        $profilePicture = $data['profilePicture'];
        $username = $data['username'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once 'inc/head.inc.php'; // link naar CSS bootstrap , CSS filter & jquery?>
    <title>Inspiration Hunter - Edit Profile</title>
</head>

<body>
    <header>
        <?php include_once 'inc/nav.inc.php'; ?>
    </header>
    <main>
        <!--  feature 3 - profiel aanpassen  -->
        <div class="container">
            <div class="span10 offset1">
                <div class="row">
                    <h3>Edit your profile</h3>
                </div>

                <form class="form-horizontal" action="updateProfile.php?id=<?php echo $id; ?>" method="post">
                    <div class="form-group row <?php echo !empty($firstNameError) ? 'error' : ''; ?>">
                        <label class="col-form-label text-md-right col-md-2text-md-right col-md-2">Firstname</label>
                        <div class="col-md-10">
                            <input name="firstName" type="text" placeholder="firstName"
                                value="<?php echo !empty($firstName) ? $firstName : ''; ?>">
                            <?php if (!empty($firstNameError)): ?>
                            <span class="help-inline"><?php echo $firstNameError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row <?php echo !empty($lastNameError) ? 'error' : ''; ?>">
                        <label class="col-form-label text-md-right col-md-2">Lastname</label>
                        <div class="col-md-10">
                            <input name="lastName" type="text" placeholder="lastName"
                                value="<?php echo !empty($lastName) ? $lastName : ''; ?>">
                            <?php if (!empty($lastNameError)): ?>
                            <span class="help-inline"><?php echo $lastNameError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row <?php echo !empty($emailError) ? 'error' : ''; ?>">
                        <label class="col-form-label text-md-right col-md-2">Email Address</label>
                        <div class="col-md-10">
                            <input name="email" type="text" placeholder="Email Address"
                                value="<?php echo !empty($email) ? $email : ''; ?>">
                            <?php if (!empty($emailError)): ?>
                            <span class="help-inline"><?php echo $emailError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row <?php echo !empty($usernameError) ? 'error' : ''; ?>">
                        <label class="col-form-label text-md-right col-md-2">Username</label>
                        <div class="col-md-10">
                            <input name="username" type="text" placeholder="username"
                                value="<?php echo !empty($username) ? $username : ''; ?>">
                            <?php if (!empty($usernameError)): ?>
                            <span class="help-inline"><?php echo $usernameError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row <?php echo !empty($mobileError) ? 'error' : ''; ?>">
                        <label class="col-form-label text-md-right col-md-2">Mobile Number</label>
                        <div class="col-md-10">
                            <input name="mobile" type="text" placeholder="Mobile Number"
                                value="<?php echo !empty($mobile) ? $mobile : ''; ?>">
                            <?php if (!empty($mobileError)): ?>
                            <span class="help-inline"><?php echo $mobileError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row <?php echo !empty($bioError) ? 'error' : ''; ?>">
                        <label class="col-form-label text-md-right col-md-2">Bio</label>
                        <div class="col-md-10">
                            <textarea name="bio" type="text" placeholder="bio"
                                value="<?php echo !empty($bio) ? $bio : ''; ?>"></textarea>
                            <?php if (!empty($bioError)): ?>
                            <span class="help-inline"><?php echo $bioError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row <?php echo !empty($bioError) ? 'error' : ''; ?>">
                        <label class="col-form-label text-md-right col-md-2">Profile Picture</label>
                        <div class="col-md-10">
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
                    <div class="form-group row <?php echo !empty($CurrentPasswordError) ? 'error' : ''; ?>">
                        <label class="col-form-label text-md-right col-md-2">Current Password</label>
                        <div class="col-md-10">
                            <input name="CurrentPassword" type="password" placeholder="********">
                            <?php if (!empty($CurrentPasswordError)): ?>
                            <span class="help-inline"><?php echo $CurrentPasswordError; ?></span>
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
    </main>
    <footer>
    </footer>
    <?php include_once 'inc/bootstrapJs.inc.php'; // link naar JS bootstrap?>
</body>

</html>