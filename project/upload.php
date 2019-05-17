<?php

require_once 'bootstrap.php';

  if (!isset($_SESSION['id'])) {
      header('location: login.php');
  }

if (isset($_POST['submit']) && !empty($_FILES['image']['name'])) {
    if (move_uploaded_file($_FILES['image']['tmp_name'], 'postImages/'.$_FILES['image']['name'])) {
        echo 'image has uploaded successfully.';
    } else {
        echo 'Some problem occurred, please try again.';
    }
}

if (isset($_POST['submit'])) {
    // Get image name
    $image = htmlspecialchars($_FILES['image']['name']);
    // Get description text & filter
    $description = htmlspecialchars($_POST['description']);
    $filter = htmlspecialchars($_POST['filter']);

    $id = User::getId(); // id ophalen uit db

    //$filter = 'test';
    // image image directory
    //$target = 'postImages/'.basename($image);
    $conn = Db::getInstance();
    $statement = $conn->prepare('INSERT INTO posts (image, description, filter, user_id) VALUES (:image, :description, :filter, :user_id)');
    $statement->bindParam(':image', $image);
    $statement->bindParam(':description', $description);
    $statement->bindParam(':filter', $filter);
    $statement->bindParam(':user_id', $id); // from session // MY ID

    $statement->execute();
    var_dump($statement);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form method="post" action="upload.php" enctype="multipart/form-data" id="uploadForm">
        <div>
        <input type="file" name="image" id="image" />
        </div> 
        <div class="description">
            <p>Description</p>
            <input type="text" id="description" name="description" style="width: 400px; padding-bottom: 50px;">
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
    <div>
        <input type="submit" name="submit" value="Upload" /></div>
    </form>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

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

        $("#image").change(function () {
            filePreview(this);
        });
    </script>
</body>

</html>