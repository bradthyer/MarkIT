<?php
//Show potential errors from login project
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo $error;
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo $message;
        }
    }
}
?>

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MarkIT : Product Analysis</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
  </head>
  <body>
      
      <div class="row">
            <div class="large-6 medium-6 small-6 columns small-centered">
                <img src="img/mit_logo.svg">
            </div>
            <hr>
      </div>
      
      <form class="custom" method="post" action="index.php" name="loginform">
          
          <div class="row">
            <div class="large-6 medium-6 small-6 columns small-centered">
                <label>Username</label>
                <input id="login_input_username" class="login_input" type="text" name="user_name" required placeholder="Username..."/>
            </div>
          </div> 
          
          <div class="row">
                <div class="large-6 medium-6 small-6 columns small-centered">
                    <label>Password</label>
                    <input id="login_input_password" class="login_input" type="password" name="user_password" autocomplete="off" required placeholder="Password..." />
                </div>
          </div>
      
          <div class="row">
            <div class="large-6 medium-6 small-6 columns small-centered">
                <div class="row">
                    
                  <div class="large-3 medium-3 small-3 columns">
                    <input class="button" type="submit" name="login" value="Sign in" />
                  </div>
                    
                  <div class="large-3 medium-3 small-3 columns show-for-medium-up">
                    <a href="register.php"><h5>New user?</h5></a>
                  </div>
                    
                </div>
            </div>
          </div>
          
          <div class="row show-for-small-only">
            <div class="large-6 medium-6 small-6 columns small-centered">
                <div class="row">
                  <div class="large-3 medium-3 small-3 columns">
                    <a href="register.php"><p>New user?</p></a>
                  </div>     
                </div>
            </div>
          </div>
      
          <hr>
          
      </form>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>

