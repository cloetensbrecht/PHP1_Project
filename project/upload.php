<?php
  require_once("bootstrap.php"); // edit EB
  
  // Create database connection
  //$db = mysqli_connect("localhost", "root", "", "inspirationhunter");
  $conn = Db::getInstance(); // edit EB
  // Initialize message variable
  $msg = "";

  // If upload button is clicked ...
  if (isset($_POST['upload'])) {
  	// Get image name
  	$image = $_FILES['image']['name'];
  	// Get text
       //$description = mysqli_real_escape_string($db, $_POST['image_text']);
       $description = $_POST['image_text'];

  	// image file directory
  	$target = "images/".basename($image);

    $statement = $conn->prepare("INSERT INTO images (image, description) VALUES ('$image', '$description')"); // edit EB
    $statement->execute(); // edit EB

  	//$sql = "INSERT INTO images (image, description) VALUES ('$image', '$description')";
  	// execute query
  	//mysqli_query($db, $sql);

  	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
       }
  }
  
    $result = $conn->prepare("SELECT * FROM images");  // edit EB
    $result->execute();
    $result = $result->fetchAll();

  //$result = mysqli_query($db, "SELECT * FROM images");
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<title>Upload</title>
<style type="text/css">
  body{
   	margin: 20px auto;
     text-align:center;
  }
   #img_div{
   	text-align:center;
   	padding: 5px;
   	margin: 15px auto;
   	
   }
   #img_div:after{
   	content: "";
   	display: block;
   	clear: both;
   }
   img{
   	margin: 5px;
   	width: 300px;
   	height: 300px;
   }
   h1{
        font-family: sans-serif;
        text-align: center;
        margin-bottom: 50px;
   }
   p{
     font-family: sans-serif;
   }
   .btn{
       
   }
   .hide {
        display: none;
      }
   .likes {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
      }

      span.like-btn {
        cursor: pointer;
        padding: 10px;
        font-size: 2em;
        color: red;
      }

      span.likes-count {
        text-decoration: none;
        color: #333;
      }
</style>
</head>
<body>

<h1>Upload image</h1>
<div id="content">
  <form method="post" action="upload.php" enctype="multipart/form-data">
  	<input type="hidden" name="size" value="1000000">
  	<div>
  	  <input type="file" name="image">
  	</div>
     <p>Description</p>
      <input type="text" id="text" name="image_text" style="width: 400px; padding-bottom: 50px;">
      <br/>
      <br/>
  	<div class="btn">
  	<button type="submit" name="upload">Upload</button>
  	</div>
  </form>
</div>
<?php
    // fetch(PDO::FETCH_BOTH) // edit EB
    
    //edit 
    /*while ($row = $result->fetch(PDO::FETCH_BOTH)) {   // edit EB
      echo "<div id='img_div'>";
      	echo "<img src='images/".$row['image']."' >";
      	echo "<p>".$row['description']."</p>";
      echo "</div>";
    }
*/
    foreach ($result as $r) {
     // echo  '<a href="'.  $link['foto'].'">' . $link['tags']. '</a></br>';
      echo "<div id='img_div'>";
      	echo "<img src='images/".$r['image']."' >";
      	echo "<p>".$r['description']."</p>";
      echo "</div>";?>

      <div class="likes">
        <?php $like = Post::like($_SESSION['id'], $r['id']); ?>
                
          <?php if ($like['active'] == 1): ?>
            <span data-id="<?php echo $r['id']; ?>" class="unlike like-btn fas fa-heart"></span>
            <span data-id="<?php echo $r['id']; ?>" class="like like-btn hide far fa-heart"></span>
          <?php endif; ?>

          <?php if ($like['active'] == 0): ?>
            <span data-id="<?php echo $r['id']; ?>" class="unlike like-btn hide fas fa-heart"></span>
            <span data-id="<?php echo $r['id']; ?>" class="like like-btn far fa-heart"></span>
          <?php endif; ?>
          
          <?php $likeCount = Post::likeCount($r['id']); ?>

          <?php if ( $likeCount == 1 ): ?>
            <span class="likes-count"><?php echo $likeCount; ?> like</span>
          <?php endif; ?>

          <?php if ( $likeCount == 0 || $likeCount > 1) : ?>
            <span class="likes-count"><?php echo $likeCount; ?> likes</span>
        <?php endif; ?>
      </div>


      <?php 
      
      


    
    
    }
    
    
    
    ?>
<?php

    /* orig
    while ($row = mysqli_fetch_array($result)) { 
         echo "<div id='img_div'>";
          echo "<img src='images/".$row['image']."' >";
          echo "<p>".$row['description']."</p>";
        echo "</div>";
      }
    */
  ?>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="ajax/like.js"></script>
  
</body>
</html>