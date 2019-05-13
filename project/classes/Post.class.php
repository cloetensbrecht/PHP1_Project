<?php
    require_once 'bootstrap.php';

    class Post
    {
        public static function getAll()
        {
            $emailCheck = $_SESSION['id'];

            $conn = Db::getInstance(); // db connection
            $result = $conn->prepare('SELECT id FROM users WHERE email= :email;');
            $result->bindParam(':email', $emailCheck);
            $result->execute();
            $id = $result->fetch(PDO::FETCH_COLUMN);

            //echo 'dit is id'.$id;

            $result = $conn->prepare('SELECT * FROM posts, users, friends
            WHERE users.id = posts.user_id
            AND users.id = friends.user_id_friend
            AND friends.user_id = :id
            ORDER BY posts.time DESC'); //LIMIT $row, $rowperpage'
            $result->bindParam(':id', $id);
            $result->execute();

            return $resultOfPosts = $result->fetchAll(PDO::FETCH_ASSOC);
        }

        /*
    user_id		    = mijn id           // LINK users.id = friends.user_id
    user_id_friend	= user id die ik volg = vriend // LINK users.id = friends.user_id_friend
    status			= 1 = vriend / 0 = “ont-vriend”
    */

        public static function loadMore($limit)
        {
            $conn = Db::getInstance(); // db connection

            $result = $conn->prepare('SELECT * FROM posts, users, friends 
            WHERE users.id = posts.user_id 
            AND users.id = friends.user_id_friend
            AND friends.user_id = :id
            ORDER BY posts.time DESC LIMIT :lmt');
            $result->bindValue(':lmt', $limit, PDO::PARAM_INT);
            $result->bindParam(':id', $id);
            $result->execute();

            return $resultOfPosts = $result->fetchAll();
        }
    }
?> 