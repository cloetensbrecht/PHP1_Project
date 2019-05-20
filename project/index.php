<?php
    require_once 'bootstrap.php';
    if (!isset($_SESSION['id'])) {
        header('location: login.php');
    }
    // id ophalen uit db
    $id = User::getId();
    /*
    if (!$id) { // als de id == false > dan naar login.php
        header('Location: login.php');
        exit;
    }
    */
    /* FEATURE 5 - laatste 20 posts  */
    // overzicht geuploade img
    $posts = Post::getAll();

    //$posts = Post::getPostInfo(); // niet SELECT * // maar specifieke kolomen selecteren
    //var_dump($posts);

    // FEATURE 6 - SEARCH
    $search = new Search();
    $searchInput = $search->checkSearchInput();
    $searchResults = $search->searchResultsFormDb();
    $searchResultsCount = $search->countSearchResultsFormDb();

    // FEATURE 7 - loadMore // doesnt work yet
    // count number of posts
    //$postCount = count($posts); // ! let op met limit
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once 'inc/head.inc.php'; // link naar CSS bootstrap , CSS filter & jquery?>
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
    <header>
        <?php include_once 'inc/navSearch.inc.php'; ?>
    </header>
    <main>
        <div class="container">
            <h1>Travel Inspiration</h1>
            <?php if (!empty($_GET['searchInput'])): ?>
            <div class="search">
                <?php
                echo '<h2>Search Results</h2>';
        if ($search->checkSearchInputLength() === 2) {
            echo $search->showMessageSearchResults();
        } elseif (!$searchResultsCount) { // if there is no matching row
            echo $search->showMessageSearchResults();
        } elseif ($searchResultsCount >= 1) { // search result are found //&& $search->checkSearchInputLength() === true // === 1)
            // let user know if we found search results
            echo $search->showMessageSearchResults();
            // show search results
            foreach ($searchResults as $r => $row) {
                echo '<div class="row"> <div class="col feed">';

                // FEATURE 5 - 20 posts van je vriendenlijst
                echo "<div class='".$row['filter']."'  id='img_div ".$row['id']."' ><a href='postImages/".$row['image']."'><img src='postImages/".$row['image']."'></a></div>";
                echo '<a href="profile.php?id='.$row['user_id_friend'].'"><p><strong>'.$row['username'].'</strong></p></a>'; // FEATURE 12 detailpagina

                // FEATURE 12 detailpagina  // persoonlijker met profile.php?id='.$row['username']  /???
                echo '<p>'.$row['description'].'</p>';

                // FEATURE 13 - tijd geleden
                $timeStatus = Post::timeStatus($row['time']);
                echo '<p>'.$timeStatus.'</p>'; // FEATURE 13
                echo '</div></div>';
            }
            echo '<br>';
        } else {
            echo $search->showMessageSearchResults();
        }
        echo '<div><a href="index.php">Go back to feed</a></div>';
        ?>
            </div>
            <!--end row -->
            <?php    else:    ?>

            <!-- FEATURE 5 - load 20 images of friends on index  -->
            <h2>Feed</h2>
            <div class="row">

                <?php
    if (count($posts) > 0):     // if no post / if no friends

    foreach ($posts as $r => $row):
        echo ' <div class="col feed">';

        // FEATURE 5 - 20 posts van je vriendenlijst

        echo "<div class='".$row['filter']."'  id='img_div ".$row['id']."' ><a href='postImages/".$row['image']."'><img src='postImages/".$row['image']."'></a></div>";
        echo '<a href="profile.php?id='.$row['user_id_friend'].'"><p><strong>'.$row['username'].'</strong></p></a>'; // FEATURE 12 detailpagina

        // FEATURE 12 detailpagina  // persoonlijker met profile.php?id='.$row['username']  /???
        echo '<p>'.$row['description'].'</p>';

        // FEATURE 13 - tijd geleden
        $timeStatus = Post::timeStatus($row['time']);
        echo '<p>'.$timeStatus.'</p>'; // FEATURE 13

        //echo '<p>'.$row['filter'].'</p>'; // FEATURE 16

        echo '</div>';
        //echo '</div>';   //<!-- end row -->
     endforeach;
        // if no post / if no friends
        else:
            echo 'Oops, no posts yet. First make some friends';
       endif;

    ?>

            </div>
            <?php endif; ?>

            <!-- FEATURE 7 - loadMore  // doesnt work yet -->
            <div id="loadMore">
                <ul id="results">
                    <!-- results in a list -->
                </ul>
                <button id="load--more">Load More</button>
                <input type="hidden" id="row" value="0">
                <input type="hidden" id="all" value="<?php echo $postCount; ?>">
            </div>
        </div>
    </main>
    <footer>
    </footer>

    <?php include_once 'inc/bootstrapJs.inc.php'; // link naar JS bootstrap?>
</body>

</html>