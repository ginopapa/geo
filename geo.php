<?

?>

<!DOCTYPE html>
<html>
	<head>
    	<meta charset="utf-8">
    	<title>Trail Deluxe</title>
    	<link rel="stylesheet" type="text/css" href="geo.css">
    	<script type="text/JavaScript" src="geo.js"></script> 
	</head>
	
	<body onload="loadBundle();">
		<div id="cover" onclick="event.preventDefault();" style="position:fixed; top:0; left:0; width:100%; height:100%; background-color:white; opacity:0.97; z-index:100000;">
			<div  style="position:fixed; top:50%; left:50%; width:300px; height:50px; margin-top: -25px; margin-left: -150px; background-color: lightgrey;  "></div>
			<input id="username" type="text" style="position:fixed; top:50%; left:50%; width:117px; height:30px; margin-top: -17px; margin-left: -142px; background-color: white; line-height:30px;text-align:center;" placeholder="LOGIN" onKeyPress="return checkSubmit(event)"></input>
			<input id="password" type="password" style="position:fixed; top:50%; left:50%; width:117px; height:30px; margin-top: -17px; margin-left: -9px; background-color: white; line-height:30px;text-align:center;" placeholder="PASSWORD" onKeyPress="return checkSubmit(event)"></input>
			<button type="submit" style="position:fixed; top:50%; left:50%; width:30px; height:30px; margin-top: -15px; margin-left: 118px; background-color: white; line-height:20px;text-align:center; border-radius:30px; font-weight:700; font-size:18px; color:grey; padding:0px;" onclick="login();">&rArr;</button>
		</div> <!--cover-->
		
		<div class="welcome"><center> Trail Deluxe Bundles </div>
		
		<div id="bundles">
			<div id="bundlescontainer" class="center" style="padding-left:65px;"></div>
		</div>
		
		<div id="leftcontainer">
			<div id="bundleinfocontainer" class="infocontainer">
					<div style="width:25%; margin-left:2%; margin-right:2%; height: 34px; float:left; background-color:white; font-size:10px;">Bundle name<br><input onkeyup="bundleinfoTimer('name');" id="bundlename" class="bundleinput"></div>
					<div style="width:50%; height: 34px; float:left; background-color:white; font-size:10px;">Image url<br><input onkeyup="bundleinfoTimer('image');" id="bundleimageurl" class="bundleinput"></div>
					<div style="width:21%; height: 34px; float:left; background-color:white; font-size:10px;">Id<br><input id="bundleid" value="" style="width:81%;" disabled></div>
					<div style="width:100%;  margin-left:2%; margin-top:6px; height: 34px; float:left; background-color:white; font-size:10px;">Info<br><input onkeyup="bundleinfoTimer('info');" id="bundleinfo" class="bundleinput"></div>
			</div><!--bundleinfocontainer -->
			
			<div class="welcome"><center> Paths in this bundle </div>
			
			<div id="paths" style="padding-bottom:5px;"> 
				<div id="pathscontainer" class="center" style="padding-left:55px;">
				</div>
			</div><!--paths -->
			
			<div id="pathsinfocontainer" class="infocontainer">
					
					<div style="width:25%; margin-left:2%; margin-right:2%; height: 34px; float:left; background-color:white; font-size:10px;">Path name<br><input onkeyup="pathinfoTimer('name');" id="pathname" class="pathsinput"></div>
					<div style="width:50%; height: 34px; float:left; background-color:white; font-size:10px;">Image url<br><input onkeyup="pathinfoTimer('image');" id="pathimageurl" class="pathsinput"></div>
					<div style="width:9%; height: 34px; float:left; background-color:white; font-size:10px;">Length<br><input onkeyup="pathinfoTimer('length');" id="pathlength" class="pathsinput" style="width:60%;"></div>
					<div style="width:9%; height: 34px; float:left; background-color:white; font-size:10px;">Duration<br><input onkeyup="pathinfoTimer('duration');" id="pathduration" class="pathsinput" style="width:60%;"></div>
					<div style="width:100%; margin-left:2%; margin-top:6px; height: 34px; float:left; background-color:white; font-size:10px;">Info<br><input onkeyup="pathinfoTimer('info');" id="pathinfo" class="pathsinput"></div>
			</div><!--pathsinfocontainer -->
			
			<div class="welcome"><center> Places of interest in this path</div>
			<div id="placecontainer" class="center" style="padding-left:55px;">
			

			</div> <!--placecontainer -->
			
			<div id="placeinfocontainer" class="infocontainer">
					<div style="width:24%; margin-left:2%; margin-right:2%; height: 34px; float:left; background-color:white; font-size:10px;">Place name<br><input onkeyup="placeinfoTimer('name');" id="placename" class="pathsinput"></div>
					<div style="width:40%; height: 34px; float:left; background-color:white; font-size:10px;">Image url<br><input onkeyup="placeinfoTimer('image');" id="placeimageurl" class="pathsinput"></div>
					<div style="width:16%; height: 34px; float:left; background-color:white; font-size:10px;">Latitude<br><input onkeyup="placeinfoTimer('latitude');" id="placelat" class="pathsinput" style="width:60%;"></div>
					<div style="width:16%; height: 34px; float:left; background-color:white; font-size:10px;">Longitude<br><input onkeyup="placeinfoTimer('longitude');" id="placelng" class="pathsinput" style="width:60%;"></div>
					<div style="width:85%; margin-left:2%; margin-top:6px; height: 34px; float:left; background-color:white; font-size:10px;">Info<br><input onkeyup="placeinfoTimer('info');" id="placeinfo" class="pathsinput"></div>
					<div style="width:7%; margin-top:6px; height: 34px; float:left; background-color:white; font-size:10px;">Radius<br><input onkeyup="placeinfoTimer('radius');" id="placeradius" class="pathsinput"></div>	
			</div><!--placeinfocontainer -->
			
			<div class="welcome"><center> Media</div>
			<div id="mediacontainer" class="center" style="padding-left:55px;">
			 
			</div><!--mediacontainer -->
			
			<div id="mediainfocontainer">
					<div style="width:24%; margin-left:2%; margin-right:2%; height: 34px; float:left; background-color:white; font-size:10px;">Media name<br><input onkeyup="mediainfoTimer('name');" id="medianame" class="pathsinput"></div>
					<div style="width:24%; height: 34px; float:left; background-color:white; font-size:10px;">Image url<br><input onkeyup="mediainfoTimer('image');" id="mediaimageurl" class="pathsinput"></div>
					<div style="width:24%; height: 34px; float:left; background-color:white; font-size:10px;">Type<br><input onkeyup="mediainfoTimer('type');" id="mediatype" class="pathsinput"></div>
					<div style="width:24%; height: 34px; float:left; background-color:white; font-size:10px;">Contents<br><input onkeyup="mediainfoTimer('contents');" id="mediacontents" class="pathsinput"></div>
			</div><!--mediainfocontainer -->
		</div>
		
		<div id="rightcontainer" style="text-align:center;">
			<iframe src="" id="mapframe"></iframe>
			<div style="max-height:30%; overflow-y:scroll;">
			<center><button onclick="reloadMap();" id="reloadbutton">Reload map</button>
			<div class="line"></div> <!-- bind hade varit smart -->
			<div id="polylinecontainer"></div>
			 </div>
		</div>
		<div id="myConsole" style="position:fixed; bottom:0; left:0; width:100%; height:14px; background-color:black; color:#00FF00; font-size:9px; line-height:14px;"></div>
	</body>
	
</html>
    