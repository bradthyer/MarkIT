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


        
        try{
            $mongo = new Mongo();
            $db = $mongo->test;
            $collection = $db->tweets;
            $sentiment = $db->sentiment;
            
            $positive_tweets = 0;
            $negative_tweets = 0;
            
            $product = $_POST['product'];
            
            $regex = new MongoRegex("/$product/");
            $cursor = $collection->find(array('text' => $regex));
            
            $number_found = $cursor->count();  
            foreach ($cursor as $obj) {
                if ((sizeof($obj['geo']['coordinates'])) > 1){
                    
                    $sn = $obj['user']['screen_name'];
                    $lat = $obj['geo']['coordinates'][0];
                    $long = $obj['geo']['coordinates'][1];
                    $id_str = $obj['id_str'];
                    
                    //echo 'Screen Name: ' . $obj['user']['screen_name'] . '<br/>';
                    //echo 'Tweet: ' . $obj['text'] . '<br/>';
                    //echo 'ID string: ' . $obj['id_str'] . '<br/>';
                    //echo 'Lat: ' . $lat . '<br/>';
                    //echo 'Long: ' . $long . '<br/>';
                    //echo '[' . $lat . ',' . $long . '] <br/>';
                    
                    $sent = $sentiment->findOne(array('id_str' => $obj['id_str']), array('sent_score' => true, 'id_str' => true));
                    $sentiment_score = $sent['sent_score'];
                    //echo 'Sentiment score: ' . $sentiment_score;
                    if ($sentiment_score >= 1)
                    {
                        $positive_tweets = $positive_tweets + 1;
                    }else if ($sentiment_score <= -1){
                        $negative_tweets = $negative_tweets + 1;
                    }
                    //echo '<br/> <br/>';
                    
                }else{
                    
                    //echo 'Screen Name: ' . $obj['user']['screen_name'] . '<br/>';
                    //echo 'Tweet: ' . $obj['text'] . '<br/>';
                    //echo 'ID string: ' . $obj['id_str'] . '<br/>';
                    $sent = $sentiment->findOne(array('id_str' => $obj['id_str']), array('sent_score' => true, 'id_str' => true));
                    $sentiment_score =$sent['sent_score'];
                    //echo 'Sentiment score: ' . $sentiment_score;
                    if ($sentiment_score >= 1)
                    {
                        $positive_tweets = $positive_tweets + 1;
                    }else if ($sentiment_score <= -1){
                        $negative_tweets = $negative_tweets + 1;
                    }
                    //echo '<br/> <br/>';
                    $total_tweets = $cursor->count();
                    $total_sentiments = $positive_tweets + $negative_tweets;
                    $neutral_tweets = $total_tweets - $total_sentiments;
                }

        }
        //echo 'Positive tweets: '. $positive_tweets . '<br>';
        //echo 'Negative tweets: ' . $negative_tweets . '<br>';
        //echo 'Neutral tweets: ' . $neutral_tweets . '<br>';
            
          // disconnect from server
        $mongo->close();
        } catch (MongoConnectionException $e) {
          die('Error connecting to MongoDB server');
        } catch (MongoException $e) {
          die('Error: ' . $e->getMessage());
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
            <h3>Tweets containing the word <a><?php echo $product; ?></a></h3>
            <h4>Number of tweets: <?php echo $number_found; ?></h4>
            <h4>Positive tweets: <?php echo $positive_tweets; ?></h4>
            <h4>Negative tweets: <?php echo $negative_tweets; ?></h4>
            <h4>Neutral tweets: <?php echo $neutral_tweets; ?></h4>
      </div>
      
      
      
    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
