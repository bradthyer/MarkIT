<?php

//Include database connection file
require_once("config/db.php");

		/**
		 * Data for the markers consisting of a name, a LatLng and a zIndex for
		 * the order in which these markers should display on top of each
		 * other.
		 */


				
				try{
					$mongo = new Mongo();
					$db = $mongo->test;
					$collection = $db->tweets;
					
					$regex = new MongoRegex("//");
					$cursor = $collection->find(array('text' => $regex));
					
					#echo $cursor->count() . ' document(s) found. <br/> <br/>';  
					foreach ($cursor as $obj) {
						if ((sizeof($obj['geo']['coordinates'])) > 1){
							
							
								$lat = $obj['geo']['coordinates'][0];
								$long = $obj['geo']['coordinates'][1];
								
								$loc = $lat.","." ".$long;
							
							
							/* echo 'Coord: ' . $loc . '<br/>'; */
							
						    /* echo 'Lat: ' . $lat . '<br/>';
							echo 'Long: ' . $long . '<br/> <br/>'; */
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
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Example</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>	
		var loc = '<?php echo $loc; ?>';
		function setMarkers(map, loc) {
		  // Add markers to the map

		  // Marker sizes are expressed as a Size of X,Y
		  // where the origin of the image (0,0) is located
		  // in the top left of the image.

		  // Origins, anchor positions and coordinates of the marker
		  // increase in the X direction to the right and in
		  // the Y direction down.
		  var image = {
			url: 'http://202.28.94.63/domsearch1/image/beachflag.png',
			// This marker is 20 pixels wide by 32 pixels tall.
			size: new google.maps.Size(20, 32),
			// The origin for this image is 0,0.
			origin: new google.maps.Point(0,0),
			// The anchor for this image is the base of the flagpole at 0,32.
			anchor: new google.maps.Point(0, 32)
		  };
		  // Shapes define the clickable region of the icon.
		  // The type defines an HTML &lt;area&gt; element 'poly' which
		  // traces out a polygon as a series of X,Y points. The final
		  // coordinate closes the poly by connecting to the first
		  // coordinate.
		  var shape = {
			  coord: [1, 1, 1, 20, 18, 20, 18 , 1],
			  type: 'poly'
		  };
		  for (var i = 0; i < loc.length; i++) {
			var beach = loc[i];
			var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
			var marker = new google.maps.Marker({
				position: myLatLng,
				map: map,
				icon: image,
				shape: shape,
				title: beach[0],
				zIndex: beach[3]
			});
		  }
		}
				
		function initialize() {
			var mapOptions = { zoom: 5, center: new google.maps.LatLng(45.363882, 21.044922) }
			  
			var map = new google.maps.Map(document.getElementById('map-canvas'),
											mapOptions);

			setMarkers(map, loc);
		}

		google.maps.event.addDomListener(window, 'load', initialize);
		


    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>
