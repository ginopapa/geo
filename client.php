<?

?>

<!DOCTYPE html>
<html>
	<head>
    	<meta charset="utf-8">
    	<title>Trail Deluxe</title>
    	<link rel="stylesheet" type="text/css" href="geo.css">
    	<script type="text/JavaScript" src="geolite.js"></script> 
    	<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY"></script>
	</head>
	
	<body onload="loadBundle();">

			<div class="welcome"><center> Trail Deluxe Bundles </div>

				

			<div id="mapdiv" style="position:fixed; top:0; left:0; height:90%; width:100%; z-index:1;"></div>
			<div style="position:fixed; width:80%; margin-left:10%; bottom:20px;  left:0; z-index:2;"><div id="bundlescontainer" class="center" style=""></div></div>
			<div id="bundleinfo" style="position: fixed; top:100px; width:200px; right:40px;; z-index:2; background-color:white;"><center>
			
				<div id="bundlename" style="margin-bottom:7px;">Bundle</div>
				<img id="bundleimage" style="max-height:100px;" src="">
				<small><small><div id="bundleinfotext" style="margin:5px;">Info</div></small></small>
			</div>
		
    </body>
</html>