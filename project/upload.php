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
    <form method="post" action="upload.php" enctype="multipart/form-data">
      <input type="hidden" name="size" value="1000000" >
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
      </div>
    </form>
  </div>
  <?php
    /* FEATURE 13 - wanneer foto opgeladen in de databank ? > toon hoe lang geleden
    (vb: 1 uur geleden, een half uur geleden, zonet, gisteren 12u54)
    */
    $currentTime = time();   // NOW

    /* FEATURE 4 - foto posten met beschrijving */
    //if (!empty($result)):
    foreach ($result as $r => $row):

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
      echo "<div id='img_div'> ";
          /* FEATURE 16 filter op foto met CSSGram  // class='".$row['filter']  */
          echo "<div class='".$row['filter']."'><img src='postImages/".$row['image']."'> </div>";
          echo '<p><strong>'.$row['username'].'</strong></p>';
          echo '<p>'.$row['description'].'</p>';
          echo '<p>'.$timeStatus.'</p>'; // FEATURE 13
          echo '<p>'.$row['filter'].'</p>'; // FEATURE 16

      echo '</div>';
      //var_dump($row); // TESTEN
  ?>

  <?php endforeach;
  //endif;
  //if (empty($result)) {    echo 'Oops, no posts yet. '; }
  ?>

<?php include_once 'inc/bootstrapJs.inc.php'; // link naar JS bootstrap?>
</body>   
</html>