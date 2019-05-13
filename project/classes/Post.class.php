<?php
    require_once 'bootstrap.php';

    class Post extends User
    {
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