  		 	///Globals
   			var myObj=[];
   			var idindex=0; //ta bort senare
   			var bundlenr=0;
   			var pathnr=0;
   			var placenr=0;
   			var medianr=0;
   			

   

   			
			function loadBundle(x){
				
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
   					if ((xmlhttp.readyState===4) && (xmlhttp.status===200)) {
        				myObj = JSON.parse(xmlhttp.responseText);
       					console.log(myObj);   			
						loadBundlePictures()
						reloadMap();
					}
				}
				xmlhttp.open("GET", "v1/api/bundle", true);
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
				
						
						var div = document.createElement("div");
						div.className="bundlepickcontainer";

						div.id = "nr"+i;

						var parent=document.getElementById("bundlescontainer");
						div.appendChild(img);

						parent.appendChild(div);

						document.getElementById("nr"+i).onclick=function(){switchBundle(this.id);}; // Se över DOM, rita upp ett träd och förbättra
					}
				}
				
				switchBundle('nr0');
			}


			function switchBundle(bundle) {
				bundle=bundle.substr(2);
				presentBundle(bundle);
				reloadMap();
			}
			


			
			function reloadMap() {
				var latitude=myObj[bundlenr].paths[0].polyline[0].lat;
          	 	var longitude=myObj[bundlenr].paths[0].polyline[0].lng;
    				initMap(latitude,longitude);
    				loadPolylines()
			}
	
			
	
			
			

			
			function presentBundle(nr){
					reset();
					document.getElementById("nr"+bundlenr).style.backgroundColor='white';
					idindex=myObj[nr].id;
					bundlenr=nr;
					document.getElementById("nr"+bundlenr).style.backgroundColor='lightgrey';
					pathnr=0;
					placenr=0;
					medianr=0;

					
			}
			
   			function reset(){
   				document.getElementById("nr"+bundlenr).style.backgroundColor='white';
   			}
			


///////////MAPS////////////
    var map;
    var myObj = [];
    var polyline= [];
          function initMap(latitude, longitude) {	
       		 map = new google.maps.Map(document.getElementById('mapdiv'), {
         	 zoom: 12,
         	  center: {lat: latitude, lng: longitude}
        	});
     	 }
     	 
	function loadPolylines() {
		route=[];
		for (k=0; k <= myObj.length; k++){
			if (typeof myObj[k] ==="object"){
				var paths=myObj[k].paths;
				for (j=0; j <= paths.length; j++) {
					var route= [];
					if(typeof paths[j] ==="object") {
						var pathname=paths[j].name;
						var pathimage=paths[j].image;
						var pathinf=paths[j].info;
						var pathlength=paths[j].length;
						var pathduration=paths[j].duration;
						var poly=myObj[k].paths[j].polyline;
						for (i=0; i <= poly.length; i++){
							if (typeof poly[i] ==="object"){
								if (poly[i].lat==0 || poly[i].lng==0){} else {
       								route.push(new google.maps.LatLng(poly[i].lat, poly[i].lng));
       							}
       						}
       					}
       					//Marker
       					var places=myObj[k].paths[j].places;
       					for (l=0; l<= places.length;l++ ){
       						if(typeof places[l] ==="object"){
       							var latitude=places[l].latitude;
       							var longitude=places[l].longitude;
       							var name=places[l].name;
       							var meter=1000*(places[l].radius);
       							var coordinates=(new google.maps.LatLng(latitude, longitude));
       							
       							///Content in media
       							var mediacontent="";
       							var media=myObj[k].paths[j].places[l].media;
       							for (m=0; m<= media.length; m++) {
       								if(typeof media[m] ==="object"){
       									mediacontent+="<p>"+media[m].name+
       									"<br><img style='max-height:150px;' src='"+media[m].image+"'>";
       								}
       							}
       							///////////////////
       							var marker = new google.maps.Marker({
        							position: coordinates,
        							title: name,
       								map: map,
       								
      							 });
      							 
      							var circle = new google.maps.Circle({
  										map: map,
  										radius: meter,    
 										fillColor: '#AA0000',
 										strokeWeight: 0.6
									});
								circle.bindTo('center', marker, 'position');
								//////Content in places
								var content = places[l].name+
								"<p><img src='"+places[l].image+"'>"+
								"<br>"+places[l].info+
								"<p> Latitude: "+places[l].latitude+
								" Longitude: "+places[l].longitude+"<p>"+mediacontent;
								
								var infowindow = new google.maps.InfoWindow()
								
								google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
      								return function() {
          							infowindow.setContent(content);
           							infowindow.open(map,marker);
        							};
   								})(marker,content,infowindow)); 

  
  
  
       						}
       					}
       				

					    var clat=poly[0].lat;
       					var clng=poly[0].lng;
       					var latlng = new google.maps.LatLng(clat, clng);
       					
      					var circle = new google.maps.Circle({
  							map: map,
  							center: latlng,
  							radius: 150,    
 							fillColor: 'darkgreen',
 							strokeWeight: 0.9
						});  
						
         				var marker = new google.maps.Marker({
        					position: latlng,
        					title: name,
       						map: map,
       						label: 'S'
       								
      					});     					
						
										
						var content=pathname+"<p><img style='max-height:200px;' src='"+pathimage+"'><br>"+pathinf+"<p>"+"Length: "+pathlength+"km<br>Duration: "+pathduration+"H";
						google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
      						return function() {
      							infowindow.setPosition(circle.getCenter()); // blev kortare så..
          						infowindow.setContent(content);
           						infowindow.open(map,marker);
        					};
   						})(marker,content,infowindow));  						
						
						
       			}
       				
       				
       				
       			if (j==pathnr){var pen=4;} else {var pen=3;}
       				polyline = new google.maps.Polyline({
       					path:route,
       					strokeColor: 'green',
       					strokeOpacity: 0.6,
       					strokeWeight: pen
       				});	
       				polyline.setMap(map);

       				
 					var infowindow = new google.maps.InfoWindow()
							
					google.maps.Polyline.prototype.getPosition = function() {
       					return this.getPath().getAt(0);
  					  }		
			
					google.maps.event.addListener(polyline,'click', (function(polyline,content,infowindow){ 
      						return function() {
          						infowindow.setContent(content);
           						infowindow.open(map,polyline);
        					};
   					})(polyline,content,infowindow));       				
       				
       					
       			}	
       		}
       	}
       		
	}
	
