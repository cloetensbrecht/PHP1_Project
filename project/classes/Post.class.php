<?php
    require_once 'bootstrap.php';

    class Post
    {
        // variabelen ///////////////////////////////////////////////
        private $time;

        // getters ///////////////////////////////////////////////
        public function getTime()
        {
            return $this->time;
        }

        // FEATURE 13
        public static function getTimeNow()
        {
            $conn = Db::getInstance(); // db connection
            $result = $conn->prepare('SELECT time FROM posts, users
            WHERE users.id = posts.user_id');
            $result->bindParam(':id', $id);
            $result->execute();
            $result->fetch(PDO::FETCH_COLUMN);
            //$time = $result['time'];
            //$result->fetch(PDO::FETCH_COLUMN, 'time');

            return $result;
        }

        // setters ///////////////////////////////////////////////
        public function setTime($time)
        {
            $this->time = $time;

            return $this;
        }

        // functions ///////////////////////////////////////////////

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

        public static function getAllExplore()
        {
            $conn = Db::getInstance(); // db connection
            $result = $conn->prepare('SELECT id FROM users WHERE email= :email;');
            $result->bindParam(':email', $emailCheck);
            $result->execute();
            $id = $result->fetch(PDO::FETCH_COLUMN);

            //echo 'dit is id'.$id;

            $result = $conn->prepare('SELECT * FROM posts, users, friends
            WHERE users.id = posts.user_id
            AND users.id = friends.user_id_friend
            ORDER BY posts.time DESC'); //LIMIT $row, $rowperpage'
            $result->bindParam(':id', $id);
            $result->execute();

            return $resultExplore = $result->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function getPostInfo()
        {
            $emailCheck = $_SESSION['id'];

            $conn = Db::getInstance(); // db connection
            $result = $conn->prepare('SELECT id FROM users WHERE email= :email;');
            $result->bindParam(':email', $emailCheck);
            $result->execute();
            $id = $result->fetch(PDO::FETCH_COLUMN);

            $result = $conn->prepare('SELECT posts.id, post.filter, post.description, post.image, users.username  FROM posts, users, friends
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

        // FEATURE 13 - wanneer foto opgeladen in de databank
        public static function timeStatus($timeOfPost)
        {
            $currentTime = time();   // NOW

            //$timeOfPost = self::getTimeNow();
            //$timeOfPost = $this->time;
            //var_dump($timeOfPost);

            $timeOfPostCode = strtotime($timeOfPost); // uit databank de tijd halen
            //$timeOfPost = strtotime($row['time']); // uit databank de tijd halen
            $timeStatus = '';
            $seconds = $currentTime - $timeOfPostCode;
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

            return $timeStatus;
        }
    }
?> 