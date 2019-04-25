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
    foreach ($result as $r => $row) {
     // echo  '<a href="'.  $link['foto'].'">' . $link['tags']. '</a></br>';
      echo "<div id='img_div'>";
      	echo "<img src='images/".$row['image']."' >";
      	echo "<p>".$row['description']."</p>";
      echo "</div>";
      }


    /* orig
    while ($row = mysqli_fetch_array($result)) { 
         echo "<div id='img_div'>";
          echo "<img src='images/".$row['image']."' >";
          echo "<p>".$row['description']."</p>";
        echo "</div>";
      }
    */
  ?>
</body>
</html>