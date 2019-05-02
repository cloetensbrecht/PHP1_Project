<?php

Class Post {
    public static function like($userID, $postID) {
    $conn = Db::getInstance();
    $statement = $conn->prepare("SELECT * FROM likes_post WHERE user_id = '$userID' AND post_id = '$postID'");
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result;
  }

  public static function likeCount($postID) {
    $conn = Db::getInstance();
    $statement = $conn->prepare("SELECT * FROM likes_post WHERE post_id = '$postID' AND active = '1'");
    $statement->execute();
    $result = $statement->fetchAll();
    
    return count($result);
  }

}