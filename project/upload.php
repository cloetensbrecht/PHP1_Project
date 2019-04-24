<?php
  // Create database connection
  $db = mysqli_connect("localhost", "root", "", "upload");

  // Initialize message variable
  $msg = "";

  // If upload button is clicked ...
  if (isset($_POST['upload'])) {
  	// Get image name
  	$image = $_FILES['image']['name'];
  	// Get text
       $description = mysqli_real_escape_string($db, $_POST['image_text']);

  	// image file directory
  	$target = "images/".basename($image);

  	$sql = "INSERT INTO tbl_images (image, description) VALUES ('$image', '$description')";
  	// execute query
  	mysqli_query($db, $sql);

  	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
       }
       
       
  }
  $result = mysqli_query($db, "SELECT * FROM tbl_images");
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
  <form method="post" action="index.php" enctype="multipart/form-data">
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
    while ($row = mysqli_fetch_array($result)) {
      echo "<div id='img_div'>";
      	echo "<img src='images/".$row['image']."' >";
      	echo "<p>".$row['description']."</p>";
      echo "</div>";
    }

    
  ?>
</body>
</html>