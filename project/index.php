<?php
    require_once 'bootstrap.php';

    if (!isset($_SESSION['id'])) {
        header('location: login.php');
    }

    // id ophalen uit db
    $id = User::getId();

    /* FEATURE 5 - laatste 20 posts  */
    // overzicht geuploade img
    $posts = Post::getAll();

    // FEATURE 6 - SEARCH
    $search = new Search();
    $searchInput = $search->checkSearchInput();
    $searchResults = $search->searchResultsFormDb();
    $searchResultsCount = $search->countSearchResultsFormDb();

    // FEATURE 7 - loadMore
    // count number of posts
    $postCount = count($posts); // ! let op met limit
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="https://cssgram-cssgram.netdna-ssl.com/cssgram.min.css">
    <!-- script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="script.js"></script>
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
      margin: 20px 0;
    }
  </style>
    <title>Travel Inspiration</title>
</head>

<body>
    <h1>Travel Inspiration</h1>

    <!--  FEATURE 4 -  POST foto met beschrijving -->
    <a href="upload.php">New Post</a> |
 
    <!--  FEATURE 3 - profiel aanpassen -->
    <a href='updateProfile.php?id=<?php echo $id; ?>'>Edit profile</a> |

    <!--  FEATURE 3 - profiel aanpassen - password  -->
    <a href='updatePassword.php?id=<?php echo $id; ?>'>Edit password</a> |

    <!--  FEATURE  2  inloggen & uitloggen -->
    <a href="logout.php">Logout</a>

    <!-- FEATURE 6 - SEARCH -->
    <div class="form form--search">
        <form action="" method="GET" name='search'>
            <div class="form__field">
                <input type="text" name="searchInput" value="" placeholder="search" />
            </div>
        </form>
        <?php if (isset($error)): ?>
        <div class="form__error">
            <?php //echo '⛔️'.$search->checkSearchInputLength(); // $error;?>
        </div>
        <?php endif; ?>
    </div>

    <div>
        <?php
        if ($search->checkSearchInputLength() === 2) {
            echo $search->showMessageSearchResults();
        } elseif (!$searchResultsCount) { // if there is no matching row
            echo $search->showMessageSearchResults();
        } elseif ($searchResultsCount >= 1) { // search result are found //&& $search->checkSearchInputLength() === true // === 1)
            // let user know if we found search results
            echo '<h2>Search Results</h2>';
            echo $search->showMessageSearchResults();
            // show search results
            foreach ($searchResults as $row) {
                echo "<div class='".$row['filter']."'><img src='postImages/".$row['image']."'> </div>";
                echo '<p><strong>'.$row['username'].'</strong></p>';
                echo '<p>'.$row['description'].'</p>';
            }
            echo '<br>';
        } else {
            echo $search->showMessageSearchResults();
        }

        ?>
    </div>

    <!-- FEATURE 5 - load 20 images of friends on index  -->
    <div class="feed">
        <h2>Feed</h2>

    <?php
    /* FEATURE 13 - wanneer foto opgeladen in de databank ? > toon hoe lang geleden
    (vb: 1 uur geleden, een half uur geleden, zonet, gisteren 12u54)
    */
    $currentTime = time();   // NOW

    //if (count($posts) > 0):
    //foreach ($posts as $row):

    foreach ($posts as $r => $row):
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
        /* else:
            echo 'Oops, no posts yet.';
       / endif; */
    ?>
    </div>
    <!-- FEATURE 7 - loadMore  -->
    <div id="loadMore">
		<ul id="results"><!-- results in a list --></ul>
        <button id="load--more">Load More</button>
        <input type="hidden" id="row" value="0">
        <input type="hidden" id="all" value="<?php echo $postCount; ?>">
    </div>
    <?php
   //var_dump($row);
   //var_dump($html);
   //var_dump($resultOfPosts);
?>
</body>

</html>