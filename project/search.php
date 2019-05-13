<?php
require_once 'bootstrap.php';
$conn = Db::getInstance(); // db connection

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

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
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

</body>
</html>