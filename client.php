<?
$lat=$_GET['lat'];
$lng=$_GET['lng'];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Complex Polylines</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
    <script>
    var myObj = [];
    
    function reload(){
   		setInterval(function(){ 
  
    		loadBundle();
    	}, 500);
    }
    
    function loadBundle(){
    	
      
		  
      
        
        
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		
   			if ((xmlhttp.readyState===4) && (xmlhttp.status===200)) {
        		myObj = JSON.parse(xmlhttp.responseText);
       			loadPolylines();
       			
    		}
		}
		
		xmlhttp.open("GET", "v1/api/bundle", true);
		xmlhttp.send();
		
	}
	
	function loadPolylines() {
	
		for (k=0; k <= myObj.length; k++){
			if (typeof myObj[k] ==="object"){
				
				for (j=0; j <= myObj[k].paths.length; j++) {
					var route= [];
					if(typeof myObj[k].paths[j] ==="object") {
						for (i=0; i <= myObj[k].paths[j].polyline.length; i++){
							if (typeof myObj[k].paths[j].polyline[i] ==="object"){
								if (myObj[k].paths[j].polyline[i].lat==0 || myObj[k].paths[j].polyline[i].lng==0){} else {
       								route.push(new google.maps.LatLng(myObj[k].paths[j].polyline[i].lat, myObj[k].paths[j].polyline[i].lng));
       							}
       						}
       					}
       				}
       				
       				var polyline = new google.maps.Polyline({
       					path:route,
       					strokeColor: "red",
       					strokeOpacity: 0.6,
       					strokeWeight: 1.6
       				});
       				
       				polyline.setMap(map);
       				
       			}	
       		}
       	}	
       	

	
	}



	
	</script>
    
  </head>
  <body onload="loadBundle(); reload();">
    <div id="map"></div>
    <script>


      var map;

      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 11,
          center: {lat: <?echo $lat;?>, lng: <?echo $lng;?>}
        });

      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuw8snqi5w8eC1xy2NYc7n8gBeXxvh5RY&callback=initMap">
    </script>
  </body>
</html>









