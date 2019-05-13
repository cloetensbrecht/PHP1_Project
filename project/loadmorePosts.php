<?php

require_once 'bootstrap.php';
$conn = Db::getInstance(); // db connection

$row = $_POST['row'];
$rowperpage = 3;

echo 'row'.$row;

// id ophalen uit db
$emailCheck = $_SESSION['id'];

$conn = Db::getInstance(); // db connection
$result = $conn->prepare('SELECT id FROM users WHERE email= :email');
$result->bindParam(':email', $emailCheck);
$result->execute();
$id = $result->fetch(PDO::FETCH_COLUMN);

/* FEATURE 5 - laatste 20 posts  */ // overzicht geuploade img
$result = $conn->prepare("SELECT * FROM posts, users, friends
WHERE users.id=posts.user_id 
AND users.id=friends.user_id_friend 
AND friends.user_id= :id ORDER BY posts.time DESC LIMIT $row, $rowperpage");
$result->bindParam(':id', $id);
$result->execute();
$resultOfPosts = $result->fetchAll(PDO::FETCH_ASSOC);

$html = '';

foreach ($resultOfPosts as $rop => $r) {
    $id = $r['id'];
    $images = $r['image'];
    $description = $r['description'];
    $username = $r['username'];
    $filter = $r['filter'];

    // create HTML

    $html .= "<div id='img_div'> ";
    $html .= "<div class='".$filter."'><img src='postImages/".$images."'> </div>";
    $html .= '<p><strong>'.$username.'</strong></p>';
    $html .= '<p>'.$description.'</p>';
    //$html .= '<p>'.$timeStatus.'</p>'; // FEATURE 13
    $html .= '<p>'.$filter.'</p>'; // FEATURE 16
    $html .= '</div>';
}

echo $html;
