<?php
    require_once 'bootstrap.php';

    $id = User::getId();
    $friendid = !empty($_GET["id"]) ? $_GET["id"] : null;

    if (!$id || !$friendid) {
        header('Location: index.php');
        exit;
    }

    $following = User::isFollowing($friendid, $id); // input halen uit session en url
    $data = User::readProfileData($friendid);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include_once 'inc/head.inc.php'; // link naar CSS bootstrap , CSS filter & jquery?>
  <title>Detail page</title>
</head>

<body>
  <header>
    <?php include_once 'inc/nav.inc.php'; ?>
  </header>

  <div class="container">
    <div class="span10 offset1">
      <div class="row">
        <h1>Detail page</h1>
      </div>
      <div class="form-horizontal">
        <div class="control-group">
          <label class="control-label">Name</label>
          <div class="controls">
            <label class="checkbox">
              <?php echo $data['firstName'].' '.$data['lastName']; ?>
            </label>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Email Address</label>
          <div class="controls">
            <label class="checkbox">
              <?php echo $data['email']; ?>
            </label>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Mobile Number</label>
          <div class="controls">
            <label class="checkbox">
              <?php echo $data['mobile']; ?>
            </label>
          </div>
        </div>
        <div class="form-actions">
          <a class="btn" href="index.php">Back</a>
        </div>
      </div>
    </div>

  </div> <!-- /container -->

  <a href="#" class="btn follow" id="btnFollow" data-id="<?php echo $friendid; ?>">&#10084;
    <?php $following = 'Follow'; echo $following === true ? 'Unfollow' : 'Follow'; //LEEG Follow?> 
    </a>

  
  <!-- jquery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="script.js"></script>

  <script>
    /* FEATURE 12 klikken op  username voor detailpagina + “follow” */
    //	Wat is je empty state als je nog geen vrienden volgt? Bedenk een goede oplossing

    //$(document).ready(function () {
      //console.log("jquery works");
      $(".follow").on("click", function (e) {
        let id = ($(this).data('id')); // = data-id="<?php echo $friendid; ?>" in a
        let button = $(this);
        console.log(id); // MIJN id 

        // AJAX CALL > post request > ajax/follow.php
        // ! geen user id meegeven aan client side // wat niet gegeven wordt kan ook niet gemanipuleerd worden.
        
        $.ajax({
            method: "POST",
            url: "ajax/follow.php",
            dataType: "json",
            data: {
              id: id
            }
          })
          .done(function (res) {
            console.log(res.status); 
            if (res.status === "succes") {
              button.text('Unfollow'); // text in de knop 
            }

            //alert("Data Saved" + msg);
          });

        /*
        .done(function(msg){
          alert("Data Saved" + msg);
        });
        */

        e.preventDefault();
      });
   // });
  </script>

<?php include_once 'inc/bootstrapJs.inc.php'; // link naar JS bootstrap?>
</body>

</html>
