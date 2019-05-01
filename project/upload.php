<?php
  require_once("bootstrap.php"); 

  // Create database connection
  $conn = Db::getInstance(); 
  
  // If upload button is clicked ...
  if (isset($_POST['upload'])) {
  	// Get image name
  	$image = $_FILES['image']['name'];
    // Get text
    $description = $_POST['description'];
       
  	// image file directory
  	$target = "postImages/".basename($image);
    $statement = $conn->prepare("INSERT INTO posts (image, description) VALUES ('$image', '$description')"); 
    $statement->execute(); 

    $result = $conn->prepare("SELECT * FROM posts");  
    $result->execute();
    $result = $result->fetchAll();

    // Initialize message variable
    $msg = "";
  	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
       }
    }
?>
<!DOCTYPE html>
<html>
<head>
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
      <input type="text" id="description" name="description" style="width: 400px; padding-bottom: 50px;">
      <br/>
      <br/>
  	<div class="btn">
  	<button type="submit" name="upload">Upload</button>
  	</div>
  </form>
</div>
<?php
    /* feature 13 - wanneer foto opgeladen in de databank ? > toon hoe lang geleden 
    (vb: 1 uur geleden, een half uur geleden, zonet, gisteren 12u54)
    */
    $currentTime = time();   // NOW
    
    /* feature 4 - foto posten met beschrijving */
    foreach ($result as $r => $row):

       // feature 13
        $timeOfPost = strtotime($row['time']); // uit databank de tijd halen 
        $timeStatus = "";
        $seconds = $currentTime - $timeOfPost;
        $minutes = (int)floor($seconds / 60);
        $hours = (int)floor($minutes / 60);
        $days = (int)floor($hours / 24);

        // hoelang geleden - tijd bepalen 
        if ($seconds <60) {
          $timeStatus = "now";
        } else if ($minutes == 1) {
            $timeStatus = "a minute ago";
        } else if ($minutes == 2) {
            $timeStatus = "two minutes ago";
        } else if ($minutes == 3) {
            $timeStatus = "three minutes ago";
        } else if ($minutes <15) {
            $timeStatus = "less than fifteen minutes ago";
        } else if ($minutes == 15) {
            $timeStatus = "fifteen minutes ago";
        } else if ($minutes <30) {
            $timeStatus = "less than half an hour ago";
        } else if ($minutes == 30) {
            $timeStatus = "half an hour ago";
        } else if ($hours <1) {
            $timeStatus = "less than an hour ago";
        } else if ($hours == 1) {
            $timeStatus = "an hour ago";
        } else if ($hours == 2) {
            $timeStatus = "two hours ago";
        } else if ($hours == 3) {
            $timeStatus = "three hours ago";
        } else if ($days <1) {
            $timeStatus = "less than a day ago";
        } else if ($days == 1 && $seconds> 1) {
            $timeStatus = "yesterday";
        } else if ($days == 2 && $seconds> 1) {
            $timeStatus = "the day before yesterday";
        } else {
            $timeStatus = date ('d / m / Y', time () - $seconds);
        }

      // feature 4
      echo "<div id='img_div'>";
      	echo "<img src='postImages/".$row['image']."' >";
        echo "<p>".$row['description']."</p>";
        echo "<p>".$timeStatus."</p>"; // feature 13
      echo "</div>";
  ?>
  <?php endforeach; ?>
</body>
</html>