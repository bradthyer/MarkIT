<?php
// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo $error;
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo $message;
        }
    }
}
?>

<?php
// show potential errors / feedback (from login object)
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
    <title>MarkIT : Register</title>
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
      
      <form class="custom" method="post" action="register.php" name="registerform">
          
          <div class="row">
            <div class="large-6 medium-6 small-6 columns small-centered">
                <label>Username</label>
                <input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required placeholder="Username..."/>
            </div>
          </div> 
          
          <div class="row">
            <div class="large-6 medium-6 small-6 columns small-centered">
                <label>Email</label>
                <input id="login_input_email" class="login_input" type="email" name="user_email" required placeholder="example@mail.com"/>
            </div>
          </div>
          
          <div class="row">
            <div class="large-6 medium-6 small-6 columns small-centered">
                <label>Password</label>
                <input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" placeholder="Password"/>
            </div>
          </div>
          
          <div class="row">
            <div class="large-6 medium-6 small-6 columns small-centered">
                <label>Repeat Password</label>
                <input iid="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" placeholder="Password repeated"/>
            </div>
          </div>
      
          <div class="row">
            <div class="large-6 medium-6 small-6 columns small-centered">
                <div class="row">
                    
                  <div class="large-3 medium-3 small-3 columns">
                    <input class="button" type="submit" name="register" value="Register" />
                    <a href="index.php"><p float="right">Back to Login Page</p></a>
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