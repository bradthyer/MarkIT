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

      
        <?php
        
        try{
            $mongo = new Mongo();
            $db = $mongo->test;
            $collection = $db->tweets;
            
            $regex = new MongoRegex("//");
            $cursor = $collection->find(array('text' => $regex));
            
            #echo $cursor->count() . ' document(s) found. <br/> <br/>';  
            foreach ($cursor as $obj) {
                if ((sizeof($obj['geo']['coordinates'])) > 1){
                    
                    echo 'Screen Name: ' . $obj['user']['screen_name'] . '<br/>';
                    echo 'Tweet: ' . $obj['text'] . '<br/>';
                    
                    $lat = $obj['geo']['coordinates'][0];
                    $long = $obj['geo']['coordinates'][1];
                    
                    echo 'Lat: ' . $lat . '<br/>';
                    echo 'Long: ' . $long . '<br/> <br/>';
                }
                
                
        }
            
          // disconnect from server
        $mongo->close();
        } catch (MongoConnectionException $e) {
          die('Error connecting to MongoDB server');
        } catch (MongoException $e) {
          die('Error: ' . $e->getMessage());
        }
        
        ?>
      
    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>