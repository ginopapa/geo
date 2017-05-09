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
   			
   			function resetVar(from){
   				myObj=[];
   				idindex=0; //ta bort senare
   				
   				switch(from){ //with fall-through
   					
   					case 'bundle':
   						bundlenr=0;
   					case 'path':
   						pathnr=0;
   					case 'place':	
   						placenr=0;
   					case 'media':
   						medianr=0;
   					default:
   						break;
   					}
   			}
   
   			function reset(){
   				document.getElementById("nr"+bundlenr).style.backgroundColor='white';
   			}
   			
   			function selection() {
   				
   				if (!document.getElementById("nr"+bundlenr)) {
   				
   				} else {
   					document.getElementById("nr"+bundlenr).style.backgroundColor='lightgrey';
   				}
   				
   				//document.getElementById("path0").style.backgroundColor='lightgrey';
   			}
   			
   			function contactServer(method, uri, message, action) {
				time=nowTime();
				
				cShttp = new XMLHttpRequest();
				cShttp.onreadystatechange = function() {
    				if ((cShttp.readyState===4) && (cShttp.status===200)) {
    					if(cShttp.responseText!="0 records UPDATED successfully"){
							document.getElementById("myConsole").innerHTML=time+"  Method: "+method+" "+uri+" >> "+cShttp.responseText;	
						}
						console.log(cShttp.responseText);
						if(cShttp.responseText=="ok"){
							document.getElementById("cover").style.display="none";
							loadBundle();
							reloadMap(); 
							
							
						}
						if (cShttp.responseText=="wrong password") {
							document.getElementById("username").value="";
							document.getElementById("password").value="";
							document.getElementById("username").placeholder="Login failed,";
							document.getElementById("password").placeholder="try again!";
						}
						
						switch (action){
							
								case 'deletebundle':
									resetVar('bundle'); loadBundle();
									break;
								case 'deletepath':
									resetVar('path'); loadBundle('path');
									break;		
								case 'newbundle':
									loadBundle();
									break;
								case 'newpath':
									loadBundle('path');
									break;
								case 'newplace':
									loadBundle('place');
									break;							
								case 'newmedia':
									loadBundle('media');
									break;	
								case 'polyline':
									reloadMap();
									break;										
								
								default:
									break;
						}
					}	
    			}
    			
    			cShttp.open(method , uri+message, true);
				cShttp.send();			
			}
   			
   			
			function loadBundle(x){
				
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
   					if ((xmlhttp.readyState===4) && (xmlhttp.status===200)) {
        				myObj = JSON.parse(xmlhttp.responseText);
       					console.log(myObj);   			
       					 switch (x){
       					 	case "place":
    							loadPlacesPictures();
    							break;
    							
    						case "path":
    							loadPathsPictures();
    							break;
    							
    						case "media":
    							loadMediaPictures();
    							break;
    							
    							case "bundle":
    							loadBundlePictures();
    							bundlemaxnr=myObj.length-1;
    							switchBundle("nr"+bundlemaxnr)
    							break;
    							
    						 	default:
    						 	loadBundlePictures();
    						}	
					}
				}
				xmlhttp.open("GET", "v1/api/bundle", true);
				xmlhttp.send();
				// initMap();
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

						document.getElementById("nr"+i).onclick=function(){switchBundle(this.id);}; // Se över DOM, rita upp ett träd och förbättra
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
						
						var deleteimg = document.createElement("img"); 
						deleteimg.src="img/delete.png";
						deleteimg.id="pathdelete"+i;
						deleteimg.className="pathdeletebutton";
											
						
						var div = document.createElement("div");
						div.className="pathpickcontainer";
						div.id = "path"+i;
						var parent=document.getElementById("pathscontainer");
						div.appendChild(img);
						div.appendChild(deleteimg);
						parent.appendChild(div);
						
						document.getElementById("path"+i).onclick=function(){presentPath(this.id);}; //Sometimes... strange solutions
						document.getElementById("pathdelete"+i).onclick=function(){deletePath(this.id);};
					}
					
				}
				var imgplus = document.createElement("img");
				imgplus.src="img/plus.png";
				imgplus.className="bundleimage";
				imgplus.onclick= function (){newPath();};
				parent.appendChild(imgplus);
				
				
				presentPath('path0');
				presentPolyline()	
			
			}
			
			function newPath(){
				contactServer("POST", "v1/api/paths/", idindex, 'newpath');
				document.getElementById("pathscontainer").innerHTML="";
				document.getElementById("polylinecontainer").innerHTML="";
				document.getElementById("placecontainer").innerHTML="";
			}
			
	
			
			function loadPlacesPictures() {
				document.getElementById("placecontainer").innerHTML="";
				var places=myObj[bundlenr].paths[pathnr].places;
				for (i=0; i<places.length; i++ ) {
					if (typeof (places[i] ==="object")){	
						var img = document.createElement("img");
						img.src=places[i].image;
						img.id="placesimg"+i;
						img.className="placeimage";
						
						var deleteimg = document.createElement("img"); 
						deleteimg.src="img/delete.png";
						deleteimg.id="placedelete"+i;
						deleteimg.className="placedeletebutton";
												
						var div = document.createElement("div");
						div.className="placepickcontainer";
						div.id = "place"+i;
						var parent=document.getElementById("placecontainer");
						div.appendChild(img);
						div.appendChild(deleteimg);
						parent.appendChild(div);
						
						document.getElementById("place"+i).onclick=function(){presentPlace(this.id);}; //Sometimes... strange solutions
						document.getElementById("placedelete"+i).onclick=function(){deletePlace(this.id);};
					}
				}
				
				var imgplus = document.createElement("img");
				imgplus.src="img/plus.png";
				imgplus.className="bundleimage";
				imgplus.onclick= function (){newPlace();};
				parent.appendChild(imgplus);
				presentPlace('place0');
			}
			
			function newPlace(){
				var pathid=myObj[bundlenr].paths[pathnr].id;
				contactServer("POST", "v1/api/places/", pathid ,'newplace');
			}
			
			function newMedia(){
				var placeid=myObj[bundlenr].paths[pathnr].places[placenr].id;
				contactServer("POST", "v1/api/media/", placeid, 'newmedia');
			}
			
			function loadMediaPictures() {
				document.getElementById("mediacontainer").innerHTML="";
				places=myObj[bundlenr].paths[pathnr].places;
				if (typeof (places[placenr] === "object")){
					var media=places[placenr].media;
					for (i=0; i<media.length; i++ ) {
						if (typeof (media[i] ==="object")){	
							var img = document.createElement("img");
							img.src=media[i].image;
							img.id="mediaimg"+i;
							img.className="mediaimage";
							
							var deleteimg = document.createElement("img"); 
							deleteimg.src="img/delete.png";
							deleteimg.id="mediadelete"+i;
							deleteimg.className="mediadeletebutton";
							
							var div = document.createElement("div");
							div.className="mediapickcontainer";
							div.id = "media"+i;
							var parent=document.getElementById("mediacontainer");
							div.appendChild(img);
							div.appendChild(deleteimg);
							parent.appendChild(div);
						
							document.getElementById("media"+i).onclick=function(){presentMedia(this.id);}; //Sometimes... strange solutions
							document.getElementById("mediadelete"+i).onclick=function(){deleteMedia(this.id);};
						}
					}
					var imgplus = document.createElement("img");
					imgplus.src="img/plus.png";
					imgplus.className="bundleimage";
					imgplus.onclick= function (){newMedia();};
					parent.appendChild(imgplus);
					presentMedia('media0');
				}
			}
			
			function deleteBundle(bundle) {
				bundle=bundle.substr(3);
				var question=confirm('Are you sure you want to delete');
				if (question){
					contactServer("DELETE", "v1/api/bundles/", myObj[bundle].id, "deletebundle");
				}
			}
			
			function deletePath(path) {
				path=path.substr(10);
				var question=confirm('Are you sure you want to delete');
				if (question){
					contactServer("DELETE", "v1/api/paths/", myObj[bundlenr].paths[path].id, 'deletepath');
				}
			}

			function deletePlace(place) {
				place=place.substr(11);
				var question=confirm('Are you sure you want to delete');
				if (question){
					contactServer("DELETE", "v1/api/places/", myObj[bundlenr].paths[pathnr].places[place].id);
					loadBundle('place');
				}
			}

			function deleteMedia(media) {
				media=media.substr(11);
				var question=confirm('Are you sure you want to delete');
				if (question){
					contactServer("DELETE", "v1/api/media/", myObj[bundlenr].paths[pathnr].places[placenr].media[media].id);
					loadBundle('media');
				}
			}

			function switchBundle(bundle) {
				bundle=bundle.substr(2);
				presentBundle(bundle);
				loadPathsPictures();
				loadPlacesPictures();
				presentPolyline(bundle, pathnr);
				reloadMap();
			}
			

			
			function changePolyline(id, bundle, path) {
			//Att fixa: Dubbelchecka om värdet ändrats
				var lat = document.getElementsByClassName("polylat");
				var lng = document.getElementsByClassName("polylong");
				var newPolyline="[";
				for (i = 0; i < lat.length; i++) {
					newPolyline += '{"lat": '+lat[i].value+', '+'"lng": '+lng[i].value+'},';
				}
				newPolyline = newPolyline.slice(0, -1);
				newPolyline += ']'
				myObj[bundle].paths[path].polyline=JSON.parse(newPolyline);
				
				contactServer("UPDATE", "v1/api/polyline/polyline/"+id+"/", newPolyline, 'polyline');
				
			}
			
			function reloadMap() {
				var latitude=myObj[bundlenr].paths[0].polyline[0].lat;
          	 	var longitude=myObj[bundlenr].paths[0].polyline[0].lng;
    				initMap(latitude,longitude);
    				loadPolylines()
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
					case 'contents':
					var newdata=document.getElementById("mediacontents").value;
						myObj[bundlenr].paths[pathnr].places[placenr].media[medianr].contents=newdata;
						break;	
					default:
				}	
				mediaindex=myObj[bundlenr].paths[pathnr].places[placenr].media[medianr].id; //ändra sen?
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
						document.getElementById("placesimg"+placenr).src=newdata;
						newdata=newdata.replace(/\//g, "--"); //för att ta sig igenom till databasen
						break;
					case 'latitude':
						var newdata=document.getElementById("placelat").value;
						myObj[bundlenr].paths[pathnr].places[placenr].latitude=newdata;
						break;
					case 'longitude':
						var newdata=document.getElementById("placelng").value;
						myObj[bundlenr].paths[pathnr].places[placenr].longitude=newdata;
						break;	
					case 'radius':
						var newdata=document.getElementById("placeradius").value;
						myObj[bundlenr].paths[pathnr].places[placenr].radius=newdata;
						break;						default:
				}	
				placeindex=myObj[bundlenr].paths[pathnr].places[placenr].id; //ändra sen?
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
					presentPolyline();
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
					reloadMap();
					
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
						var placename="";
						var placeimage="";
						var placelat="";
						var placelng="";
						var placeinfo="";
						var placeradius="";
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
							var mediatype=media[medianr].type;
							var mediacontents=media[medianr].contents;
						} else {
							var medianame="";
							var mediaimage="";
							var mediatype="";
							var mediacontents="";

						}
					} else {
						var medianame="";
						var mediaimage="";
					}
					document.getElementById("medianame").value=medianame;	
					document.getElementById("mediaimageurl").value=mediaimage;
					document.getElementById("mediatype").value=mediatype;	
					document.getElementById("mediacontents").value=mediacontents;	
					
			}
			
			var myTimer=""; 
			function polyTimer (id, position, path){
				clearTimeout(myTimer);
				myTimer=setTimeout(function() {changePolyline(id, position, path);}, 900);
			
			}
   		 	
   		 	function presentPolyline(){
   		 		document.getElementById("polylinecontainer").innerHTML="";
				var polyline = myObj[bundlenr].paths[pathnr].polyline;
				var id=myObj[bundlenr].paths[pathnr].id;
				var nr=0;
			
				for (j=0; j <= polyline.length; j++) {
					if (typeof polyline[j] ==="object"){
						var div = document.createElement("div");
						var parent = document.getElementById("polylinecontainer");
						div.innerHTML="Latitude: <input onkeyup='polyTimer("+id+", "+bundlenr+", "+pathnr+");' onblur='changePolyline("+id+", "+bundlenr+", "+pathnr+");' class='polylat' value='"+polyline[j].lat+"'> Longitude: <input onkeyup='polyTimer("+id+", "+bundlenr+", "+pathnr+");' onblur='changePolyline("+id+", "+bundlenr+", "+pathnr+");' class='polylong' value='"+polyline[j].lng+"'> <img src='img/delete.png' style='height:20px; margin:-5px;' class='removePolyline' onclick='removePolyline(this);changePolyline("+id+", "+bundlenr+", "+pathnr+");'>";
						parent.appendChild(div);
					}
					nr++;	
				}
				///add poly button
				var buttonclickfunction= function () {
					var div = document.createElement("div");
					var parent = document.getElementById("polylinecontainer");
					div.innerHTML="Latitude: <input onkeyup='polyTimer("+id+", "+bundlenr+", "+pathnr+");' onblur='changePolyline("+id+", "+bundlenr+", "+pathnr+");' class='polylat' value='0'> Longitude: <input class='polylong' value='0' onkeyup='polyTimer("+id+", "+bundlenr+", "+pathnr+");' onblur='changePolyline("+id+", "+bundlenr+", "+pathnr+");'>  <img src='img/delete.png' style='height:20px; margin:-5px;' class='removePolyline' onclick='removePolyline(this);changePolyline("+id+", "+bundlenr+", "+pathnr+");'>";
					parent.appendChild(div);
					changePolyline(id, bundlenr, pathnr);
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
  				reloadMap();
   		 	
   		 	}
   		 	
   		
   		 	
   		 	
   		 	function newBundle() {
				contactServer("POST", "v1/api/bundles", '', 'newbundle');
				document.getElementById("bundlescontainer").innerHTML="";
				document.getElementById("pathscontainer").innerHTML="";
				document.getElementById("polylinecontainer").innerHTML="";
				//document.getElementById("placeinfocontainer").innerHTML="";
				
			}
			
			function checkSubmit(e) {
  				 if(e && e.keyCode == 13) {
     			 	login();
  				 }
			}
			
			function login() {
				var username = document.getElementById("username").value;
				var password = document.getElementById("password").value;
				contactServer("AUTH", "v1/api/login/", username+"/"+password);
			}
///////////MAPS////////////
    var map;
    var myObj = [];
    var polyline= [];
          function initMap(latitude, longitude) {	
       		 map = new google.maps.Map(document.getElementById('map'), {
         	 zoom: 11,
         	  center: {lat: latitude, lng: longitude}
        	});
     	 }
     	 
	function loadPolylines() {
		route=[];
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
       					if (j==pathnr){var pen=1.8;}else{var pen=0.8;}
       					polyline = new google.maps.Polyline({
       					path:route,
       					strokeColor: 'green',
       					strokeOpacity: 0.6,
       					strokeWeight: pen
       				});	
       				polyline.setMap(map);	
       			}	
       		}
       	}	
	}
	
			