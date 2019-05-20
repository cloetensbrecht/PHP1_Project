<?php
    require_once 'bootstrap.php';

    $id = User::getId();
    // test // var_dump($id); exit;

    $friendid = !empty($_GET['id']) ? $_GET['id'] : null;

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

  <a href="#" class="btn follow" id="btnFollow" data-id="<?php echo $friendid; ?>">
    <?php // $following = 'Follow'; echo $following === true ? 'Unfollow' : 'Follow'; //LEEG Follow?> 
    <?php echo $following ? 'Unfollow' : 'Follow'; ?>
  </a>

  <!-- jquery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="script.js"></script>

  <script>
      let isFollowing = <?php echo $following ? 'true' : 'false'; ?> ;
      let isSubmitting = false;
      $(".follow").on("click", function (e) {
        if (isSubmitting) return;
        isSubmitting = true;
        const button = $(this);
          
        $.ajax({
            method: "POST",
            url: isFollowing ? "ajax/unfollow.php" : "ajax/follow.php",
            dataType: "json",
            //async: false,
            data: {
              id: button.data('id')
            }
          })
          .done(function (res) {
            isSubmitting = false;
            
            if (res.status == "success") {
                isFollowing = !isFollowing;
                button.text(isFollowing ? 'Unfollow' : 'Follow');
                isFollowing = ! isFollowing
             
            }
          });
        e.preventDefault();
      });
  </script>

<?php include_once 'inc/bootstrapJs.inc.php'; // link naar JS bootstrap?>
</body>

</html>
