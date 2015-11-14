<?php
  require_once("login/classes/Login.php");
  require_once("config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FacieJetser - Login</title>

  <meta content="width=device-width, user-scalable=0, minimal-ui" name="viewport">
  <link rel="stylesheet" href="library/style/bootstrap.min.css">
  <link rel="stylesheet" href="library/style/login.css">
  
  <script type="text/javascript" src="library/js/jquery-2.1.1.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#user_name").blur( function() {
        $.getJSON("library/scripts/api.php?facebook=" + $("#user_name").val(), function( json ) {
          $("#user_pf").attr("src", "http://graph.facebook.com/" + json.result + "/picture?type=large");
        });
      })
    })
  </script>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-6 col-md-4 col-md-offset-4">
        <h1 class="text-center login-title">FaCieJetser</h1>
        <div class="account-wall">
          <img id="user_pf" class="profile-img" src="http://graph.facebook.com/FaCie/picture?type=large" alt="">
          <form class="form-signin" role="form" action="/faciejetser/login/index.php" method="POST">
            <input type="text" id="user_name" name="user_name" class="form-control" placeholder="Gebruikersnaam" required autofocus>
            <input type="password" name="user_password" class="form-control" placeholder="Wachtwoord" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Sign in!</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>