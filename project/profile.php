<?php
    require_once 'bootstrap.php';
    //require_once '././classes/User.class.php';
    //require_once __DIR__.DIRECTORY_SEPARATOR.'classes/User.class.php';

    // class user laden
    User::isFollowing(1, 1); // input halen uit session en url

    $id = null;
    if (!empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
    if (null == $id) {
        header('Location: index.php');
    } else {
        $data = User::readProfileData($id);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
  </script> -->
</head>
<body>

    <div class="container">
                <div class="span10 offset1">
                    <div class="row">
                    <h1>Detail page</h1>
                    </div>
                    <div class="form-horizontal" >
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

    <a href="#" class="btn follow" id="btnFollow" data-friendid="1" >&#10084; <?php $following = 'Follow'; echo $following === true ? 'Unfollow' : 'Follow'; //LEEG Follow?> </a> 

<!-- jquery FOR ajax -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

<script>
/* FEATURE 12 klikken op  username voor detailpagina + “follow” */
//	Wat is je empty state als je nog geen vrienden volgt? Bedenk een goede oplossing
 
$(document).ready(function(){
  //console.log("jquery works");
  $(".follow").on("click", function(e){
    var friendid = ($(this).data('friendid'));

    // AJAX CALL > post request > ajax/follow.php
    // ! geen user id meegeven aan client side // wat niet gegeven wordt kan ook niet gemanipuleerd worden.
    $.ajax({
      method:"POST",
      url: "ajax/follow.php",
      dataType: "json";
      data: {friendid : friendid}
    })
.done(function(res){
  console.log(res.status);
  if(res.status === "succes"){
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
});
</script>
  </body>
</html>