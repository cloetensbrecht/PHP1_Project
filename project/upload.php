<?php

require_once 'bootstrap.php';

  if (!isset($_SESSION['id'])) {
      header('location: login.php');
  }

  if (isset($_POST['submit']) && !empty($_FILES['image']['name'])) {
      $feedbackUpload = Post::feedbackUpload();
      //echo Post::feedbackUpload();
  }
  if (isset($_POST['submit'])) {
      Post::uploadImage();
      //var_dump(Post::uploadImage());
  }

  /*
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
}*/

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once 'inc/head.inc.php'; // link naar CSS bootstrap , CSS filter & jquery?>
    <title>Upload</title>

    <style type="text/css">
        html,
        body {
            height: 100%;
        }

        main {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-upload {
            width: 100%;
            max-width: 530px;
            padding: 15px;
            margin: auto;
        }
    </style>
</head>


<body>
    <header>
        <?php include_once 'inc/navSearch.inc.php'; ?>
    </header>
    <main>
        <div class="container upload">
            <div class="form-login">
                <form method="post" action="upload.php" enctype="multipart/form-data" id="uploadForm" class="form-upload">

                    <!-- <input>s and <textarea>s with .form-control (including up to one .form-control in input groups)
<select>s with .form-select or .custom-select
.form-checks
.custom-checkboxs and .custom-radios
.custom-file
<div class="custom-file">
                        <input type="file" class="custom-file-input" id="validatedCustomFile" required>
                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                        <div class="invalid-feedback">Example invalid custom file feedback</div>
                    </div>


<div class="input-group">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
  </div>
  <div class="custom-file">
    <input type="file" class="custom-file-input" id="inputGroupFile01"
      aria-describedby="inputGroupFileAddon01">
    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
  </div>
</div>
-- >
                    <div class="custom-file">
                    <input type="file" name="image" class="custom-file-input form-control-file" id="inputGroupFile01"id="image"
      aria-describedby="inputGroupFileAddon01" required>
    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
-->
                     <!--   <input type="file" name="image" class="form-control-file" id="image" class="custom-file-input" id="validatedCustomFile" required />
                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                        -->
                        <div class="custom-file">
                        <input type="file" name="image" id="image" class="form-control-file" required />
                        <div class="invalid-feedback">Example invalid custom file feedback</div>

                    </div>
                    <div class="description">
                        <p>Description</p>
                        <input type="text" id="description" name="description" class="form-control" required>
                    </div>
                    <!-- FEATURE 16 filter op foto met CSSGram  -->
                    <div class="filter">
                        <p>Filter</p>
                        <select name="filter" class="form-control">
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
                        <input type="submit" class="btn btn-outline-secondary" name="submit" value="Upload" />
                    </div>

                    <div>
                        <p><?php
                if (isset($feedbackUpload)) {
                    echo $feedbackUpload;
                }?></p>
                    </div>
                </form>

            </div> <!-- end form-login -->
        </div> <!-- end div class="cover-container -->
    </main>
    <footer>
    </footer>

    <?php include_once 'inc/bootstrapJs.inc.php'; // link naar JS bootstrap?>

    <script>
        function filePreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#uploadForm + img').remove();
                    $('#uploadForm').after('<img  src="' + e.target.result + '" width="450" height="300"/>');
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