<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MarkIT : Menu</title>
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
                <div class="row">
                  <h4>Welcome <?php echo $_SESSION['user_name']; ?>.</h4>
                  <a href="index.php?logout"><p>Logout</p></a>
                  <a href="results.php"><p>MongoDB Results (Testing Page)</p></a>
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
