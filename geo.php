<?

?>

<!DOCTYPE html>
<html>
	<head>
    	<meta charset="utf-8">
    	<title>Trail Deluxe</title>
    	
    	<style>
    		html, body{
  				height: 100%;
  				font-family: Geneva, Tahoma, Verdana, sans-serif;
  				overflow:hidden;
			}
    		
    		.line {
    			width:100%;
    			height:16px;
    			background-color:white;
    			padding-left:10px;
    			padding-top:5px;
    			
    		}
    		
    		.text {
    			line-height:16px;
    			font-size:12px;
    		}
    		#leftcontainer {
    			position:fixed;
    			width: 60%;
    			height: 100%;
    			background-color:white;
    			left:0;
    			top:15;
    			
    		}
    		
    		#rightcontainer {
    			position:fixed;
    			width: 40%;
    			height: 100%;
    			
    			left:60%;
    			top:15;
    		}
    		
    		#mapframe {
    			margin-top:3px;
    			width:100%; 
    			height:40%;
    		} 
    		
    		#polylinecontainer {
    			width:100%;
    			text-align:center;
				overflow:auto;
				font-size:12px;
    		}
			

			
			#bundles {
				width:100%;
				height:90px;
				background-color:white;
				overflow-x: auto;
				overflow-y: hidden;
				white-space: nowrap;
				padding-bottom:5px;
			}
			
			#paths {
				width:100%;
				height:70px;
				background-color:white;
				overflow-x: auto;
				overflow-y: hidden;
				white-space: nowrap;
				
			}
			
			.infocontainer {
				width:100%;
				height:74px;
				background-color:white;
				padding:6px 0px 6px 0px;
				margin-top: 3px;
				margin-bottom: 2px;
			}
			
			#mediainfocontainer {
				width:100%;
				height:37px;
				background-color:white;
				padding:6px 0px 6px 0px;
				margin-top: 3px;
				margin-bottom: 2px;
			}			
			

			#places {
				width:100%;
				height:20px;
				background-color:white;
			}
				
			.bundleinput {
				width:92%;
				margin-left:2%;
				
			}	

			.pathsinput {
				width:90%;
				margin-left:1%;
				
			}	
			
			.bundlepickcontainer{
				width:100px;
				height:80px;
				background-color:white;
				box-sizing: border-box;
				border: 1px dotted black;
				display:inline-block;
				margin-left:15px;
				margin-right:15px;
				text-align:center;
				padding-top:2px;
			}
			
			.pathpickcontainer{
				width:80px;
				height:64px;
				background-color:white;
				box-sizing: border-box;
				border: 1px dotted black;
				display:inline-block;
				margin-left:15px;
				margin-right:15px;
				cursor:pointer;
				text-align:center;
				padding-top:10px;
			}
			
			.placepickcontainer{
				width:64px;
				height:51px;
				background-color:white;
				box-sizing: border-box;
				border: 1px dotted black;
				display:inline-block;
				margin-left:15px;
				margin-right:15px;
				cursor:pointer;
				text-align:center;
				padding-top:8px;
			}
			
			.mediapickcontainer{
				width:51px;
				height:41px;
				background-color:white;
				box-sizing: border-box;
				border: 1px dotted black;
				display:inline-block;
				margin-left:15px;
				margin-right:15px;
				cursor:pointer;
				text-align:center;
				padding-top:6px;
			}			
			
			.center {
				display:table;
				margin: 0 auto;
			
			}
			
			.bundleimage {
				position:relative;
				top:8px;
				height:53px;
				cursor:pointer;
			}
			
			.pathimage {
				height:44px;
				
			}
			
			.placeimage {
				height:35px;
				
			}

			.mediaimage {
				height:28px;
			}
			
			.placecolumns {
				width:12%;
				float:left;
				font-size:10px;
			}
			
			.place {
				width:20%;
				float:left;
				font-size:12px;
				height:14px;
			}
			
			.welcome {
				width:100%;
				height:30px;
				background-color:white;
				border-top:2px solid green;
			}
			
			.placecontainer {
				width:100%;
				height:20px;
				background-color:white;
				padding-top:10px;
			
			}

			.media {
				padding-left:18%;
				padding-right:2%;
				width:80%;
				height:18px;
				background-color:white;
				color:white;
				font-size:8px;
				line-height:14px;
				text-align:right;
			}
			
			.mediainfo {
				width:120px;
				height:16px;
				border-top:1px solid white;
				color:white;
				line-height:18px;
				background-color:black;
				display:inline-block;
			}

			
			.deletebutton {
				display:block;
				position:relative;
				height:20px;
				margin-left:40px;
				margin-top:11px;
			}
			
			.polylong, .polylat {
				width:80px;
			
			}
			
	
    		
    	</style>
    
   		 <script>
   		 	///Globals
   			var myObj=[];
   			var idindex=0; //ta bort senare
   			var bundlenr=0;
   			var pathnr=0;
   			var placenr=0;
   			var medianr=0;
   			
   			///Functions
   			function nowTime() {
   				var now = new Date();
   				return now;
   			}
   			
   			function reset(){
   				//document.getElementById("nr"+bundlenr).style.backgroundColor='white';
   			}
   			
   			function selection() {
   				//document.getElementById("nr"+bundlenr).style.backgroundColor='lightgrey';
   				//document.getElementById("path0").style.backgroundColor='lightgrey';
   			}
   			
   			function contactServer(method, uri, message) {
				time=nowTime();
				
				cShttp = new XMLHttpRequest();
				cShttp.onreadystatechange = function() {
    				if ((cShttp.readyState===4) && (cShttp.status===200)) {
    					if(cShttp.responseText!="0 records UPDATED successfully"){
							document.getElementById("myConsole").innerHTML=time+"  Method: "+method+" "+uri+" >> "+cShttp.responseText;	
						}
					}	
    			}
    			
    			cShttp.open(method , uri+message, true);
				cShttp.send();			
			}
   			
   			
			function loadBundle(bundle){
			
				if (bundle==null){var bundle="bundle";}
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
   					if ((xmlhttp.readyState===4) && (xmlhttp.status===200)) {
        				myObj = JSON.parse(xmlhttp.responseText);
       					console.log(myObj);   			
       					 if (bundle=="bundle"){
    						loadBundlePictures();
    						 
    						}	
					}
				}
				xmlhttp.open("GET", "v1/api/"+bundle, true);
				xmlhttp.send();
				
			}
			
			function loadBundlePictures(){
				document.getElementById("bundlescontainer").innerHTML="";
				for (i=0; i<myObj.length; i++ ) {
					if (typeof (myObj[i] ==="object")){
						
						
						var img = document.createElement("img");
						img.src=myObj[i].image;
						img.className="bundleimage";
						img.id="bundleimg"+i;
					
						var deleteimg = document.createElement("img"); 
						deleteimg.src="img/delete.png";
						deleteimg.id="img"+i;
						deleteimg.className="deletebutton";
						
						var div = document.createElement("div");
						div.className="bundlepickcontainer";

						div.id = "nr"+i;

						var parent=document.getElementById("bundlescontainer");
						div.appendChild(img);
						div.appendChild(deleteimg);
						parent.appendChild(div);

						document.getElementById("nr"+i).onclick=function(){switchBundle(this.id);}; //Sometimes... strange solutions
						document.getElementById("img"+i).onclick=function(){deleteBundle(this.id);};
					}
				}
				

				
				var imgplus = document.createElement("img");
				imgplus.src="img/plus.png";
				imgplus.className="bundleimage";
				imgplus.onclick= function (){newBundle();};
				parent.appendChild(imgplus);
				
				switchBundle('nr0');
			}
		
		
			function loadPathsPictures() {
				document.getElementById("pathscontainer").innerHTML="";
				var paths=myObj[bundlenr].paths;
				for (i=0; i<paths.length; i++ ) {
					if (typeof (paths[i] ==="object")){	
					
					
						var img = document.createElement("img");
						img.src=paths[i].image;
						img.id="pathimg"+i;
						img.className="pathimage";
						var div = document.createElement("div");
						div.className="pathpickcontainer";
						div.id = "path"+i;
						var parent=document.getElementById("pathscontainer");
						div.appendChild(img);
						parent.appendChild(div);
						
						document.getElementById("path"+i).onclick=function(){presentPath(this.id);}; //Sometimes... strange solutions

					}
					
				}
				presentPath('path0')
					
			
			}
			
			function loadPlacesPictures() {
				document.getElementById("placecontainer").innerHTML="";
				var places=myObj[bundlenr].paths[pathnr].places;
				console.log(places);
				for (i=0; i<places.length; i++ ) {
					if (typeof (places[i] ==="object")){	
						var img = document.createElement("img");
						img.src=places[i].image;
						img.id="placesimg"+i;
						img.className="placeimage";
						var div = document.createElement("div");
						div.className="placepickcontainer";
						div.id = "place"+i;
						var parent=document.getElementById("placecontainer");
						div.appendChild(img);
						parent.appendChild(div);
						
						document.getElementById("place"+i).onclick=function(){presentPlace(this.id);}; //Sometimes... strange solutions
					}
				}
				presentPlace('place0');
			}
			
			function loadMediaPictures() {
				document.getElementById("mediacontainer").innerHTML="";
				var media=myObj[bundlenr].paths[pathnr].places[placenr].media;
				console.log(media);
				for (i=0; i<media.length; i++ ) {
					if (typeof (media[i] ==="object")){	
						var img = document.createElement("img");
						img.src=media[i].image;
						img.id="mediaimg"+i;
						img.className="mediaimage";
						var div = document.createElement("div");
						div.className="mediapickcontainer";
						div.id = "media"+i;
						var parent=document.getElementById("mediacontainer");
						div.appendChild(img);
						parent.appendChild(div);
						
						document.getElementById("media"+i).onclick=function(){presentMedia(this.id);}; //Sometimes... strange solutions
					}
				}
				presentMedia('media0');
			}
			
			function deleteBundle(bundle) {
				bundle=bundle.substr(3);
				var question=confirm('Are you sure you want to delete');
				if (question){
					contactServer("DELETE", "v1/api/bundles/", myObj[bundle].id);
					loadBundle();
				
				}

				
				
			}

			function switchBundle(bundle) {
				bundle=bundle.substr(2);
				presentBundle(bundle);
				loadPathsPictures();
				loadPlacesPictures();
				presentPolyline(bundle, 0);
				reloadMap();
			}
			

			
			function changePolyline(id, bundle, path) {
			//Att fixa: Dubbelchecka om värdet ändrats
			console.log(id);
				var lat = document.getElementsByClassName("polylat");
				var lng = document.getElementsByClassName("polylong");
				var newPolyline="[";
				for (i = 0; i < lat.length; i++) {
					newPolyline += '{"lat": '+lat[i].value+', '+'"lng": '+lng[i].value+'},';
				}
				newPolyline = newPolyline.slice(0, -1);
				newPolyline += ']'
				myObj[bundle].paths[path].polyline=JSON.parse(newPolyline);
				
				contactServer("UPDATE", "v1/api/polyline/polyline/"+id+"/", newPolyline);
				
			}
			
			function reloadMap() {
						var lat=myObj[bundlenr].paths[0].polyline[0].lat;
						var lng=myObj[bundlenr].paths[0].polyline[0].lng;
						var iframe = document.getElementById('mapframe');
						iframe.src = "client.php?lat="+lat+"&lng="+lng;	
						
			}
			
			var mymediainfoTimer="";
			function mediainfoTimer(type) {
				clearTimeout(mymediainfoTimer);
				mymediainfoTimer=setTimeout(function() {changeMediainfo(type);}, 500);
			}	
			
			function changeMediainfo(type){
				switch(type) {
					case 'name':
						var newdata=document.getElementById("medianame").value;
						myObj[bundlenr].paths[pathnr].places[placenr].media[medianr].name=newdata;
						break;
					case 'type':
						var newdata=document.getElementById("mediatype").value;
						myObj[bundlenr].paths[pathnr].places[placenr].media[medianr].type=newdata;
						break;
					case 'image':
						var newdata=document.getElementById("mediaimageurl").value;
						myObj[bundlenr].paths[pathnr].places[placenr].media[medianr].image=newdata;
						document.getElementById("mediaimg"+medianr).src=newdata;
						newdata=newdata.replace(/\//g, "--"); //för att ta sig igenom till databasen
						break;
						default:
				}	
				mediaindex=myObj[bundlenr].paths[pathnr].places[placenr].media[medianr].id; //ändra sen?
				console.log(pathindex=myObj[bundlenr].paths[pathnr].places[placenr].media[medianr].id);
				contactServer("UPDATE", "v1/api/media/"+type+"/"+mediaindex+"/", newdata);
			}			

			var myplaceinfoTimer="";
			function placeinfoTimer(type) {
				clearTimeout(myplaceinfoTimer);
				myplaceinfoTimer=setTimeout(function() {changePlaceinfo(type);}, 500);
			}		
			
			function changePlaceinfo(type){
				switch(type) {
					case 'name':
						var newdata=document.getElementById("placename").value;
						myObj[bundlenr].paths[pathnr].places[placenr].name=newdata;
						break;
					case 'info':
						var newdata=document.getElementById("placeinfo").value;
						myObj[bundlenr].paths[pathnr].places[placenr].info=newdata;
						break;
					case 'image':
						var newdata=document.getElementById("placeimageurl").value;
						myObj[bundlenr].paths[pathnr].places[placenr].image=newdata;
						document.getElementById("placeimg"+placenr).src=newdata;
						newdata=newdata.replace(/\//g, "--"); //för att ta sig igenom till databasen
						break;
						default:
				}	
				placeindex=myObj[bundlenr].paths[pathnr].places[placenr].id; //ändra sen?
				console.log(pathindex=myObj[bundlenr].paths[pathnr].places[placenr].id);
				contactServer("UPDATE", "v1/api/places/"+type+"/"+placeindex+"/", newdata);
			}
			
			
			var mypathinfoTimer="";
			function pathinfoTimer(type) {
				clearTimeout(mypathinfoTimer);
				mypathinfoTimer=setTimeout(function() {changePathinfo(type);}, 500);
			}
			
			function changePathinfo(type) {
				switch(type) {
					case 'name':
						var newdata=document.getElementById("pathname").value;
						myObj[bundlenr].paths[pathnr].name=newdata;
						break;
					case 'info':
						var newdata=document.getElementById("pathinfo").value;
						myObj[bundlenr].paths[pathnr].info=newdata;
						break;
					case 'image':
						var newdata=document.getElementById("pathimageurl").value;
						myObj[bundlenr].paths[pathnr].image=newdata;
						document.getElementById("pathimg"+pathnr).src=newdata;
						newdata=newdata.replace(/\//g, "--"); //för att ta sig igenom till databasen
						break;
					case 'length':
						var newdata=document.getElementById("pathlength").value;
						myObj[bundlenr].paths[pathnr].length=newdata;
						break;
					case 'duration':
						var newdata=document.getElementById("pathduration").value;
						myObj[bundlenr].paths[pathnr].image=newdata;
						break;	
						default:															
				}
				pathindex=myObj[bundlenr].paths[pathnr].id; //ändra sen?
				console.log(pathindex=myObj[bundlenr].paths[pathnr].id);
				contactServer("UPDATE", "v1/api/paths/"+type+"/"+pathindex+"/", newdata);
			}
			
			
			var mybundleinfoTimer="";
			function bundleinfoTimer(type) {
				clearTimeout(mybundleinfoTimer);
				mybundleinfoTimer=setTimeout(function() {changeBundleinfo(type);}, 500);			
			}
			
			function changeBundleinfo(type) {
				switch (type) {
					case 'name': 
						var newdata=document.getElementById("bundlename").value;
						myObj[bundlenr].name=newdata;
						break;
					case 'info':
						var newdata=document.getElementById("bundleinfo").value;
						myObj[bundlenr].info=newdata;
						break;
					case 'image':
						var newdata=document.getElementById("bundleimageurl").value;
						myObj[bundlenr].image=newdata;
						document.getElementById("bundleimg"+bundlenr).src=newdata;
						newdata=newdata.replace(/\//g, "--"); //för att ta sig igenom till databasen
						break;	
					default:
				}
				contactServer("UPDATE", "v1/api/bundles/"+type+"/"+idindex+"/", newdata);


			}
			
			function presentBundle(nr){
					reset();
					idindex=myObj[nr].id;
					bundlenr=nr;
					pathnr=0;
					placenr=0;
					medianr=0;
					document.getElementById("bundlename").value=myObj[nr].name;	
					document.getElementById("bundleinfo").value=myObj[nr].info;
					document.getElementById("bundleid").value=myObj[nr].id;	
					document.getElementById("bundleimageurl").value=myObj[nr].image;
					selection();
			}
			
			function presentPath(path){
					pathnr=path.substr(4);
					placenr=0;
					medianr=0;
					document.getElementById("pathname").value=myObj[bundlenr].paths[pathnr].name;	
					document.getElementById("pathinfo").value=myObj[bundlenr].paths[pathnr].info;
					document.getElementById("pathimageurl").value=myObj[bundlenr].paths[pathnr].image;
					document.getElementById("pathlength").value=myObj[bundlenr].paths[pathnr].length;
					document.getElementById("pathduration").value=myObj[bundlenr].paths[pathnr].duration;
					loadPlacesPictures();
					presentPlace('place0');
					presentMedia('media0');
			}
			
			function presentPlace(place){
					placenr=place.substr(5);
					var places=myObj[bundlenr].paths[pathnr].places;
					if (typeof places[placenr] ==="object"){
						var placename=places[placenr].name;
						var placeimage=places[placenr].image;
						var placelat=places[placenr].latitude;
						var placelng=places[placenr].longitude;
						var placeinfo=places[placenr].info;
						var placeradius=places[placenr].radius;
					} else {
						placename="";
						placeimage="";
						placelat="";
						placelng="";
						placeinfo="";
						placeradius="";
					}
					document.getElementById("placename").value=placename;	
					document.getElementById("placeimageurl").value=placeimage;	
					document.getElementById("placelat").value=placelat;	
					document.getElementById("placelng").value=placelng;	
					document.getElementById("placeinfo").value=placeinfo;	
					document.getElementById("placeradius").value=placeradius;	
					loadMediaPictures();
					presentMedia('media0');
			}
			
			function presentMedia(media){
					medianr=media.substr(5);
					var places=myObj[bundlenr].paths[pathnr].places;
					if (typeof places[placenr] ==="object"){
						var media=myObj[bundlenr].paths[pathnr].places[placenr].media;
						if (typeof media[medianr] ==="object"){
							var medianame=media[medianr].name;
							var mediaimage=media[medianr].image;
						} else {
							var medianame="";
							var mediaimage="";
						}
					} else {
						var medianame="";
						var mediaimage="";
					}
					document.getElementById("medianame").value=medianame;	
					document.getElementById("mediaimageurl").value=mediaimage;	
			}
			
			var myTimer=""; 
			function polyTimer (id, position, path){
				clearTimeout(myTimer);
				myTimer=setTimeout(function() {changePolyline(id, position, path);}, 900);
			
			}
   		 	
   		 	function presentPolyline(position, path){
   		 		document.getElementById("polylinecontainer").innerHTML="";
				var polyline = myObj[position].paths[path].polyline;
				var id=myObj[position].paths[path].id;
				var nr=0;
			
				for (j=0; j <= polyline.length; j++) {
					if (typeof polyline[j] ==="object"){
						var div = document.createElement("div");
						var parent = document.getElementById("polylinecontainer");
						div.innerHTML="Latitude: <input onkeyup='polyTimer("+id+", "+position+", "+path+");' onblur='changePolyline("+id+", "+position+", "+path+");' class='polylat' value='"+polyline[j].lat+"'> Longitude: <input onkeyup='polyTimer("+id+", "+position+", "+path+");' onblur='changePolyline("+id+", "+position+", "+path+");' class='polylong' value='"+polyline[j].lng+"'> <img src='img/delete.png' style='height:20px; margin:-5px;' class='removePolyline' onclick='removePolyline(this);changePolyline("+id+", "+position+", "+path+");'>";
						parent.appendChild(div);
					}
					nr++;	
				}
				///add poly button
				var buttonclickfunction= function () {
					var div = document.createElement("div");
					var parent = document.getElementById("polylinecontainer");
					div.innerHTML="Latitude: <input onkeyup='polyTimer("+id+", "+position+", "+path+");' onblur='changePolyline("+id+", "+position+", "+path+");' class='polylat' value='0'> Longitude: <input class='polylong' value='0' onkeyup='polyTimer("+id+", "+position+", "+path+");' onblur='changePolyline("+id+", "+position+", "+path+");'>  <img src='img/delete.png' style='height:20px; margin:-5px;' class='removePolyline' onclick='removePolyline(this);changePolyline("+id+", "+position+", "+path+");'>";
					parent.appendChild(div);
					changePolyline(id, position, path);
					console.log(" "+id+" "+position+" "+path);
				};
				
				var element=document.getElementById("addpolybutton");
				if (typeof(element) == 'undefined' || element == null){
					var button = document.createElement("button");
					button.id="addpolybutton";
					button.innerHTML="Add line";
					button.onclick=buttonclickfunction;
					var buttonparent = document.getElementById("rightcontainer");	
					buttonparent.appendChild(button);
					
   		 		}
   		 		else {
   		 			document.getElementById("addpolybutton").onclick=buttonclickfunction;
   		 		}
   		 	}
   		 	

   		 	
   		 	function removePolyline(poly) {
  				poly.parentNode.parentNode.removeChild(poly.parentNode);
   		 	
   		 	}
   		 	
   		
   		 	
   		 	
   		 	function newBundle() {
				contactServer("POST", "v1/api/bundles", '');
				document.getElementById("bundlescontainer").innerHTML="";
				document.getElementById("pathscontainer").innerHTML="";
				document.getElementById("polylinecontainer").innerHTML="";
				document.getElementById("placeinfocontainer").innerHTML="";
				loadBundle();
			}
			

			
    	</script>
	</head>
	
	<body onload="loadBundle();">
		<div class="welcome"><center> Trail Deluxe Bundles </div>
		<div id="bundles">
			
			<div id="bundlescontainer" class="center" style="padding-left:65px;">
						
		</div>
		</div>
		<div id="leftcontainer">
			
			
			<div id="bundleinfocontainer" class="infocontainer">
					<div style="width:25%; margin-left:2%; margin-right:2%; height: 34px; float:left; background-color:white; font-size:10px;">Bundle name<br><input onkeyup="bundleinfoTimer('name');" id="bundlename" class="bundleinput"></div>
					<div style="width:50%; height: 34px; float:left; background-color:white; font-size:10px;">Image url<br><input onkeyup="bundleinfoTimer('image');" id="bundleimageurl" class="bundleinput"></div>
					<div style="width:21%; height: 34px; float:left; background-color:white; font-size:10px;">Id<br><input id="bundleid" value="" style="width:81%;" disabled></div>
					<div style="width:100%;  margin-left:2%; margin-top:6px; height: 34px; float:left; background-color:white; font-size:10px;">Info<br><input onkeyup="bundleinfoTimer('info');" id="bundleinfo" class="bundleinput"></div>
			</div><!--bundleinfocontainer -->
			
			<div class="welcome"><center> Paths in this bundle </div>
			<div id="paths"> 
				<div id="pathscontainer" class="center">
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
			<div id="placecontainer" class="center">
			

			</div><!--placecontainer -->
			
			<div id="placeinfocontainer" class="infocontainer">
					<div style="width:24%; margin-left:2%; margin-right:2%; height: 34px; float:left; background-color:white; font-size:10px;">Place name<br><input onkeyup="placeinfoTimer('name');" id="placename" class="pathsinput"></div>
					<div style="width:40%; height: 34px; float:left; background-color:white; font-size:10px;">Image url<br><input onkeyup="placeinfoTimer('image');" id="placeimageurl" class="pathsinput"></div>
					<div style="width:16%; height: 34px; float:left; background-color:white; font-size:10px;">Latitude<br><input onkeyup="placeinfoTimer('latitude');" id="placelat" class="pathsinput" style="width:60%;"></div>
					<div style="width:16%; height: 34px; float:left; background-color:white; font-size:10px;">Longitude<br><input onkeyup="placeinfoTimer('longitue');" id="placelng" class="pathsinput" style="width:60%;"></div>
					<div style="width:85%; margin-left:2%; margin-top:6px; height: 34px; float:left; background-color:white; font-size:10px;">Info<br><input onkeyup="placeinfoTimer('info');" id="placeinfo" class="pathsinput"></div>
					<div style="width:7%; margin-top:6px; height: 34px; float:left; background-color:white; font-size:10px;">Radius<br><input onkeyup="placeinfoTimer('radius');" id="placeradius" class="pathsinput"></div>	
			</div><!--placeinfocontainer -->
			
			<div class="welcome"><center> Media</div>
			<div id="mediacontainer" class="center">
			 
			</div><!--mediacontainer -->
			
			<div id="mediainfocontainer">
					<div style="width:24%; margin-left:2%; margin-right:2%; height: 34px; float:left; background-color:white; font-size:10px;">Media name<br><input onkeyup="mediainfoTimer('name');" id="medianame" class="pathsinput"></div>
					<div style="width:24%; height: 34px; float:left; background-color:white; font-size:10px;">Image url<br><input onkeyup="mediainfoTimer('image');" id="mediaimageurl" class="pathsinput"></div>
					<div style="width:24%; height: 34px; float:left; background-color:white; font-size:10px;">Type<br><input onkeyup="mediainfoTimer('type');" id="mediatype" class="pathsinput"></div>
					<div style="width:24%; height: 34px; float:left; background-color:white; font-size:10px;">Contents<br><input onkeyup="mediainfoTimer('contents');" id="mediacontents" class="pathsinput"></div>
			</div><!--mediainfocontainer -->
		</div>
		
		<div id="rightcontainer" style="text-align:center;">
			<iframe src="client.php" id="mapframe"></iframe>
			<center><button onclick="reloadMap();" id="reloadbutton">Reload map</button>
			<div class="line"></div> <!-- binding hade varit smart -->
			<div id="polylinecontainer">
				
				
			 </div>
			 
		</div>
		<div id="myConsole" style="position:fixed; bottom:0; left:0; width:100%; height:20px; background-color:black; color:#00FF00; font-size:9px; line-height:20px;"></div>
	</body>
	
</html>
    