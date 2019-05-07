<?php
    require_once 'bootstrap.php';
    include_once 'loadmorePosts.php';

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

    // FEATURE 7 - loadMore

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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- feature 9 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- -->

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
    
</head>

<body>
    
<header>

    <!-- FEATURE 6 - SEARCH -->
    <a href="search.php" id="item4"><img src="https://image.flaticon.com/icons/svg/149/149852.svg" alt="search">search</a> 

    <!--  FEATURE 4 -  POST foto met beschrijving -->
    <a href="upload.php">New Post</a>

    <!--  FEATURE 3 - profiel aanpassen  -->
    <?php echo "<a href='updateProfile.php?id=".$id."'>Edit profile</a>"; ?>

    <!--  FEATURE  2  inloggen & uitloggen -->
    <a href="logout.php">Logout</a>
    

</header>
<title>Inspiration Hunter</title>
<h1>Inspiration Hunter</h1>
    <p>Dit onderdeel wordt later nog aangevuld.</p>
    <br>
    <!-- FEATURE 5 - load 20 images of friends on index  -->
    <div class="feed">
        <h1>Feed</h1>

    <?php
    /* FEATURE 13 - wanneer foto opgeladen in de databank ? > toon hoe lang geleden
    (vb: 1 uur geleden, een half uur geleden, zonet, gisteren 12u54)
    */
    $currentTime = time();   // NOW

    //if (count($posts) > 0):
    //foreach ($posts as $row):

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
        /* else:
            echo 'Oops, no posts yet.';
       / endif; */
    ?>
    </div>
    <!-- FEATURE 7 - loadMore  -->
    <div id="loadMore">
		<ul id="results"><!-- results in a list --></ul>
    </div>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="loadmore.js"></script>


    <!-- FEATURE 9 - comment -->
        <br />
    <h2 align="center"><a href="#">comment</a></h2>
        <br />
     <div class="container">
    <form method="POST" id="comment_form">
     <div class="form-group">
        <input type="text" name="comment_name" id="comment_name" class="form-control" placeholder="Enter Name" />
     </div>
     <div class="form-group">
        <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Enter Comment" rows="5"></textarea>
     </div>
     <div class="form-group">
         <input type="hidden" name="comment_id" id="comment_id" value="0" />
         <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
     </div>
    </form>
   <span id="comment_message"></span>
    <br />
   <div id="display_comment"></div>
  </div>

</body>

</html>

<!-- comments -->
<script>
$(document).ready(function(){
 
 $('#comment_form').on('submit', function(event){
  event.preventDefault();
  var form_data = $(this).serialize();
  $.ajax({
   url:"add_comment.php",
   method:"POST",
   data:form_data,
   dataType:"JSON",
   success:function(data)
   {
    if(data.error != '')
    {
     $('#comment_form')[0].reset();
     $('#comment_message').html(data.error);
     $('#comment_id').val('0');
     load_comment();
    }
   }
  })
 });

 load_comment();

 function load_comment()
 {
  $.ajax({
   url:"fetch_comment.php",
   method:"POST",
   success:function(data)
   {
    $('#display_comment').html(data);
   }
  })
 }

 $(document).on('click', '.reply', function(){
  var comment_id = $(this).attr("id");
  $('#comment_id').val(comment_id);
  $('#comment_name').focus();
 });
 
});
</script>