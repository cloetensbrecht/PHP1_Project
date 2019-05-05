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

    // GET ID uit EMAIL
    $id = null;
    foreach ($resultOfUsers as $res => $r) {
        $id = $r['id'];
    }

    /* FEATURE 5 - laatste 20 posts  */
    // overzicht geuploade img
    $result = $conn->prepare('SELECT * FROM posts, users, friends 
    WHERE users.id = posts.user_id 
    AND users.id = friends.user_id_friend
    AND friends.user_id = :id
    ORDER BY posts.time DESC LIMIT 2');
    $result->bindParam(':id', $id);
    $result->execute();
    $resultOfPosts = $result->fetchAll();
    /*
    user_id		    = mijn id           // LINK users.id = friends.user_id
    user_id_friend	= user id die ik volg = vriend // LINK users.id = friends.user_id_friend
    status			= 1 = vriend / 0 = “ont-vriend”
    */

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
            $statement = $conn->prepare("SELECT * FROM posts, users WHERE users.id = posts.user_id AND description LIKE '%$searchInput%' ORDER BY users.id DESC LIMIT 10");

            // title, username zoeken?
            $statement->execute();
            $resultInput = $statement->fetchAll();
            //print_r($resultInput); // print hele array van resultaat

            $counter = $conn->prepare("SELECT COUNT(*) FROM posts, users WHERE users.id = posts.user_id AND description LIKE '%$searchInput%'");
            $counter->execute();
            $countRows = $counter->fetchColumn();  // OR  $countRows = $statement->rowCount();
        } else { // if searchInput length is less than minimum
            $error = 'Minimum length is '.$min_length;
        }
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="https://cssgram-cssgram.netdna-ssl.com/cssgram.min.css">
    <style type="text/css">
    body {
      font-family: Helvetica, sans-serif;
      margin: 20px auto;
    }
    
    #img_div {
      padding: 5px;
      margin: 15px auto;

    }
    
    #img_div:after {
      content: "";
      display: block;
      clear: both;
    }

    img {
      margin: 5px;
      max-width: 300px;
      max-height: 300px;
    }

    h1 {
      margin-bottom: 50px;
    }
  </style>
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
                foreach ($resultInput as $r => $row) {
                    //echo  '<a href="'.$link['foto'].'">'.$link['tags'].'</a></br>';

                    echo "<div class='".$row['filter']."'><img src='postImages/".$row['image']."'> </div>";
                    echo '<p><strong>'.$row['username'].'</strong></p>';
                    echo '<p>'.$row['description'].'</p>';
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
    /* FEATURE 13 - wanneer foto opgeladen in de databank ? > toon hoe lang geleden
    (vb: 1 uur geleden, een half uur geleden, zonet, gisteren 12u54)
    */
    $currentTime = time();   // NOW

    foreach ($resultOfPosts as $r => $row):
       // FEATURE 13
        $timeOfPost = strtotime($row['time']); // uit databank de tijd halen
        $timeStatus = '';
        $seconds = $currentTime - $timeOfPost;
        $minutes = (int) floor($seconds / 60);
        $hours = (int) floor($minutes / 60);
        $days = (int) floor($hours / 24);

        // hoelang geleden - tijd bepalen
        if ($seconds < 60) {
            $timeStatus = 'now';
        } elseif ($minutes == 1) {
            $timeStatus = 'a minute ago';
        } elseif ($minutes == 2) {
            $timeStatus = 'two minutes ago';
        } elseif ($minutes == 3) {
            $timeStatus = 'three minutes ago';
        } elseif ($minutes < 15) {
            $timeStatus = 'less than fifteen minutes ago';
        } elseif ($minutes == 15) {
            $timeStatus = 'fifteen minutes ago';
        } elseif ($minutes < 30) {
            $timeStatus = 'less than half an hour ago';
        } elseif ($minutes == 30) {
            $timeStatus = 'half an hour ago';
        } elseif ($hours < 1) {
            $timeStatus = 'less than an hour ago';
        } elseif ($hours == 1) {
            $timeStatus = 'an hour ago';
        } elseif ($hours == 2) {
            $timeStatus = 'two hours ago';
        } elseif ($hours == 3) {
            $timeStatus = 'three hours ago';
        } elseif ($days < 1) {
            $timeStatus = 'less than a day ago';
        } elseif ($days == 1 && $seconds > 1) {
            $timeStatus = 'yesterday';
        } elseif ($days == 2 && $seconds > 1) {
            $timeStatus = 'the day before yesterday';
        } else {
            $timeStatus = date('d / m / Y', time() - $seconds);
        }

      // FEATURE 4
      echo "<div id='img_div'> "; /* class=". $row['filter']*/ /* FEATURE 16 filter op foto met CSSGram  */
      //echo "<div id='img_div' class=".$row['filter']."'>"; /* class=". $row['filter']*/ /* FEATURE 16 filter op foto met CSSGram  */

          echo "<div class='".$row['filter']."'><img src='postImages/".$row['image']."'> </div>";
          echo '<p><strong>'.$row['username'].'</strong></p>';
          echo '<p>'.$row['description'].'</p>';
          echo '<p>'.$timeStatus.'</p>'; // FEATURE 13
          echo '<p>'.$row['filter'].'</p>'; // FEATURE 16

      echo '</div>';
      //var_dump($row); // TESTEN
  ?>
        <?php endforeach;
        //endif;
        //if (empty($resultOfPosts)) {    echo 'Oops, no posts yet. '; }
        ?>

    </div>
    <!-- FEATURE 7 - loadMore  -->
    <div id="loadMore">
        <a class="loadMore" href=""> " >load more</a>
    </div>
</body>

</html>