<?php

//Include database connection file
require_once("config/db.php");

//Load the login class
require_once("classes/Login.php");

//Create a login object, this handles all the entire login process
$login = new Login();

//Check if user is logged in
if ($login->isUserLoggedIn() == false) {
    //Allow the user to access the site
    header('Location: index.php');
}

?>

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MarkIT : Quick Search</title>
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
      
      <form data-abide class="custom" method="post" action="results.php" >
          <div class="row">
            <div class="large-6 medium-6 small-6 columns small-centered">
                <label class ="has-tip">
                    <span class="has-tip" title="Enter the lead product name here." data-tooltip="" data-width="300">
                        <label>Product Name</label>
                    </span>
                </label>
                    <input type="text"  name="product" required placeholder="Enter the main product name..."/>
            </div>
          </div> 
          
          <div class="row">
            <div class="large-6 medium-6 small-6 columns small-centered">
                <div class="row">
                  <div class="large-3 medium-3 small-3 columns">
                    <input class="button" type="submit"/>
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
