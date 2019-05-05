<?php
    require_once 'bootstrap.php';

    if (!isset($_SESSION['id'])) {
        header('location: login.php');
    }

    // info ophalen uit db
    $emailCheck = $_SESSION['id'];

    $conn = Db::getInstance(); // db connection
    $result = $conn->prepare('SELECT * FROM users WHERE email= :email;');
    $result->bindParam(':email', $emailCheck);
    $result->execute();
    $resultOfUsers = $result->fetchAll();

    $id = null;
    foreach ($resultOfUsers as $res => $r) {
        $id = $r['id'];
    }

    // FEATURE 6 - SEARCH
    $countRows = 0;
    if (!empty($_GET['searchInput'])) {
        // gets input from search
        $searchInput = $_GET['searchInput'];

        // minimum length of searchInput
        $min_length = 2;

        if (strlen($searchInput) >= $min_length) {
            // htmlspecialchars() tegen XSS attack > changes characters to equivalents like < to &gt;
            $searchInput = htmlspecialchars($searchInput);

            // real_escape_string() tegen SQL injection
            //$searchInput = real_escape_string($searchInput);

            // items = table name in db
            $statement = $conn->prepare("SELECT * FROM items WHERE tags LIKE '%$searchInput%' ORDER BY id DESC LIMIT 20");

            // title, username zoeken?
            $statement->execute();
            $resultInput = $statement->fetchAll();
            //print_r($resultInput); // print hele array van resultaat

            $counter = $conn->prepare("SELECT COUNT(*) FROM items WHERE tags LIKE '%$searchInput%'");
            $counter->execute();
            $countRows = $counter->fetchColumn();  // OR  $countRows = $statement->rowCount();
        } else { // if searchInput length is less than minimum
            $error = 'Minimum length is '.$min_length;
        }
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="https://cssgram-cssgram.netdna-ssl.com/cssgram.min.css">
    <title>Inspiration Hunter</title>
</head>
<body>
    <h1>Inspiration Hunter</h1>
    <p>Dit onderdeel wordt later nog aangevuld.</p>
    <br>
   
    <!--  FEATURE 4 -  POST foto met beschrijving --> 
    <a href="upload.php">New Post</a>

    <!--  FEATURE 3 - profiel aanpassen  -->
    <?php echo "<a href='updateProfile.php?id=".$id."'>Edit profile</a>"; ?> 
   
    <!--  FEATURE  2  inloggen & uitloggen -->
    <a href="logout.php">Logout</a>

    <!-- FEATURE 6 - SEARCH -->
    <div class="form form--search">
        <form action="" method="GET">
            <div class="form__field">
                <input type="text" name="searchInput" placeholder="search" />
                <!-- <input type="submit" value="Search" class="btn btn--primary" /> -->
            </div>
        </form>
        <?php if (isset($error)): ?>
        <div class="form__error">
            <?php echo '⛔️'.$error; ?>
        </div>
        <?php endif; ?>
    </div>

    <div>
        <?php
        if (!empty($_GET['searchInput'])) {
            if ($countRows > 0) {
                // let user know if we found search results
                echo '<h3> We found '.$countRows.' results for '.$searchInput.'</h3>';
                // show search results
                foreach ($resultInput as $row => $link) {
                    echo  '<a href="'.$link['foto'].'">'.$link['tags'].'</a></br>';
                }
            } else { // if there is no matching rows do following
                echo '<h3> We found no results for '.$searchInput.'</h3>';
                $error = 'We found no results for '.$searchInput;
            }
        } else {
            $error = 'First enter what you want to look for.';
        }
        ?>
    </div>

    <!-- FEATURE 5 - load 20 images of friends on index  -->
    <div class="feed">
    <h1>Feed</h1>
        <?php
        /*
        foreach ($result as $r => $row) {
        // echo  '<a href="'.  $link['foto'].'">' . $link['tags']. '</a></br>';
        echo "<div id='img_div'>";
            echo "<img src='images/".$row['image']."' >";
            echo "<p>".$row['description']."</p>";
            echo "<p>".$row['time']."</p>";
        echo "</div>";
        }*/
    ?>
</div>
     <!-- FEATURE 7 - loadMore  -->
    <div id="loadMore">

    </div>
</body>
</html>