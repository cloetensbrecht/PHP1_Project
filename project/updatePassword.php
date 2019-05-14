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
    if (!isset($_SESSION['id'])) {
        header('location: login.php');
    }

    echo $_SESSION['id']; echo $id;

    if (!empty($_POST)) {
        // check pw
        $user = new User();
        $user->setPassword($_POST['CurrentPassword']);
        $error = $user->canLogin();

        // keep track validation errors
        $NewPasswordError = null;
        $CurrentPasswordError = null;

        // keep track post values
        //$password = $_POST['password'];
        //$NewPassword = $_POST['NewPassword'];
        //$CurrentPassword = $_POST['CurrentPassword'];

        // validate input
        $valid = true;
        if (empty($NewPassword)) {
            $passwordError = 'Please enter a new password';
            $valid = false;
        }
        if (empty($CurrentPassword)) {
            $passwordError = 'Please enter a current password';
            $valid = false;
        }

        // update data
        if ($valid) {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'UPDATE users set password=? WHERE id = ?';
            $q = $conn->prepare($sql);
            $q->execute(array($password, $id));
            //Database::disconnect();
            header('Location: index.php');
        }
    } /*else {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT * FROM users where id = ?';
        $q = $conn->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        //$NewPassword = $data['NewPassword'];
        //$CurrentPassword = $data['CurrentPassword'];

        //Database::disconnect();
    }*/
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
                <h3>Change your password</h3>
                <form class="form-horizontal" action="updatePassword.php?id=<?php echo $id; ?>" method="post">
                    <div class="control-group <?php echo !empty($NewPasswordError) ? 'error' : ''; ?>">
                        <label class="control-label">New Password</label>
                        <div class="controls">
                            <input name="NewPassword" type="password" placeholder="********">
                            <?php if (!empty($NewPasswordError)): ?>
                            <span class="help-inline"><?php echo $NewPasswordError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- protect profile - pw -->
                    <p>To change password, you must enter the current password.</p>
                    <div class="control-group <?php echo !empty($CurrentPasswordError) ? 'error' : ''; ?>">
                        <label class="control-label">Current Password</label>
                        <div class="controls">
                            <input name="CurrentPassword" type="password" placeholder="********" required>
                            <?php if (!empty($CurrentPasswordError)): ?>
                            <span class="help-inline"><?php echo $CurrentPasswordError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">Update password</button>

                    </div>
                </form>
            </div>
            <a class="btn" href="index.php">Back</a>
        </div>
    </div>
</body>

</html>