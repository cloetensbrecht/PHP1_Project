<?php

require_once 'bootstrap.php';
$conn = Db::getInstance(); // db connection

//sanitize post value
//$pageNumber = filter_var($_POST['page'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
$pageNumber = 1;

$PostsPerPage = 3;
//get current starting point of records
$position = (($pageNumber - 1) * $PostsPerPage);
//fetch records using page position and item per page.

$result = $conn->prepare('SELECT * FROM posts, users, friends
WHERE users.id = posts.user_id
AND users.id = friends.user_id_friend
AND friends.user_id = :id
ORDER BY posts.time DESC LIMIT :p, :ppp');
$result->bindParam(':p', $position);
$result->bindParam(':ppp', $PostsPerPage);
$result->bindParam(':id', $id);
$result->execute();
$resultOfPosts = $result->fetchAll();

//var_dump($resultOfPosts);

foreach ($resultOfPosts as $r => $row) {
    echo '<p><strong>'.$row['username'].'</strong></p>';
    echo '<p>'.$row['description'].'</p>';
    echo '<p>'.$row['filter'].'</p>'; // FEATURE 16
}
