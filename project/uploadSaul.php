<!--  FEATURE 4 -  POST foto met beschrijving -->
<?php
  require_once 'bootstrap.php';

  if (!isset($_SESSION['id'])) {
      header('location: login.php');
  }

  // Create database connection
  $conn = Db::getInstance();

  // overzicht geuploade img
  $result = $conn->prepare('SELECT * FROM posts, users WHERE users.id = posts.user_id LIMIT 20');
  $result->execute();
  $result = $result->fetchAll();

  // If upload button is clicked ...
  if (isset($_POST['upload'])) {
      // Get image name
      $image = $_FILES['image']['name'];
      // Get description text & filter
      $description = $_POST['description'];
      $filter = $_POST['filter'];
      //$filter = 'test';
      // image file directory
      $target = 'postImages/'.basename($image);
      $statement = $conn->prepare("INSERT INTO posts (image, description, filter) VALUES ('$image', '$description', '$filter')");
      $statement->execute();

      // Initialize message variable
      $msg = '';
      if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
          $msg = 'Image uploaded successfully';
      } else {
          $msg = 'Failed to upload image';
      }
  }

  if (isset($_POST['submit']) && !empty($_FILES['file']['name'])) {
      if (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.$_FILES['file']['name'])) {
          echo 'File has uploaded successfully.';
      } else {
          echo 'Some problem occurred, please try again.';
      }
  }

?>
<!DOCTYPE html>
<html>

<head>

  <?php include_once 'inc/head.inc.php'; // link naar CSS bootstrap , CSS filter & jquery?>
  <title>Upload</title>
  <style type="text/css">
    body {
      font-family: Helvetica, sans-serif;
      margin: 20px auto;
      text-align: center;
    }

    #img_div {
      text-align: center;
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
      width: 300px;
      height: 300px;
    }

    h1 {
      text-align: center;
      margin-bottom: 50px;
    }
  </style>
  <link rel="stylesheet" href="https://cssgram-cssgram.netdna-ssl.com/cssgram.min.css">

</head>

<body>
  <?php include_once 'inc/nav.inc.php'; ?>
  <!--  FEATURE 4 -  POST foto met beschrijving -->
  <h1>Upload image</h1>
  <div id="content">
    <form method="post" action="upload.php" enctype="multipart/form-data" id="uploadForm">
      <input type="file" name="file" id="file" />
      
    <</form>
    
    <div>
      <input type="file" name="image" required>
    </div>
    <div class="description">
      <p>Description</p>
      <input type="text" id="description" name="description" style="width: 400px; padding-bottom: 50px;">
      <br />
    </div>
    <!-- FEATURE 16 filter op foto met CSSGram  -->
    <div class="filter">
      <p>Filter</p>
      <select name="filter">
        <option value="noFilter" class="" selected>no filter</option>
        <option value="1977" class="_1977"> 1977</option>
        <option value="Aden" class="aden">Aden</option>
        <option value="Brannan" class="brannan">Brannan</option>
        <option value="Brooklyn" class="brooklyn">Brooklyn</option>
        <option value="Clarendon" class="clarendon">Clarendon</option>
        <option value="Earlybird" class="earlybird">Earlybird</option>
        <option value="Gingham" class="gingham">Gingham</option>
        <option value="Hudson" class="hudson">Hudson</option>
        <option value="Inkwell" class="inkwell">Inkwell</option>
        <option value="Kelvin" class="kelvin">Kelvin</option>
        <option value="Lark" class="lark">Lark</option>
        <option value="Lo-Fi" class="lofi">Lo-Fi</option>
        <option value="Maven" class="maven">Maven</option>
        <option value="Mayfair" class="mayfair">Mayfair</option>
        <option value="Moon" class="moon">Moon</option>
        <option value="Nashville" class="nashville">Nashville</option>
        <option value="Perpetua" class="perpetua">Perpetua</option>
        <option value="Reyes" class="reyes">Reyes</option>
        <option value="Rise" class="rise">Rise</option>
        <option value="Slumber" class="slumber">Slumber</option>
        <option value="Stinson" class="stinson">Stinson</option>
        <option value="Toaster" class="toaster">Toaster</option>
        <option value="Valencia" class="valencia">Valencia</option>
        <option value="Walden" class="walden">Walden</option>
        <option value="Willow" class="willow">Willow</option>
        <option value="X-pro II" class="xpro2">X-pro II</option>
      </select>
    </div>
    <!-- -->

    <br />
    <div class="btn">
      <button type="submit" name="upload">Upload</button>
      <input type="submit" name="submit" value="Upload"/>
    </div>
    </form>
  </div>
  <script>
    function filePreview(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#uploadForm + img').remove();
          $('#uploadForm').after('<img src="' + e.target.result + '" width="450" height="300"/>');
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    $('#uploadForm + embed').remove();
    $('#uploadForm').after('<embed src="' + e.target.result + '" width="450" height="300">');

    $("#file").change(function () {
      filePreview(this);
    });
  </script>
  <?php include_once 'inc/bootstrapJs.inc.php'; // link naar JS bootstrap?>
</body>

</html>