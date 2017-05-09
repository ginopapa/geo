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
				
				for (j=0; j <= myObj[k].paths.length; j++) {
					var route= [];
					if(typeof myObj[k].paths[j] ==="object") {
						var pathname=myObj[k].paths[j].name;
						for (i=0; i <= myObj[k].paths[j].polyline.length; i++){
							if (typeof myObj[k].paths[j].polyline[i] ==="object"){
								if (myObj[k].paths[j].polyline[i].lat==0 || myObj[k].paths[j].polyline[i].lng==0){} else {
       								route.push(new google.maps.LatLng(myObj[k].paths[j].polyline[i].lat, myObj[k].paths[j].polyline[i].lng));
       							}
       						}
       					}
       					//Marker
       					for (l=0; l<= myObj[k].paths[j].places.length;l++ ){
       						if(typeof myObj[k].paths[j].places[l] ==="object"){
       							var latitude=myObj[k].paths[j].places[l].latitude;
       							var longitude=myObj[k].paths[j].places[l].longitude;
       							var name=myObj[k].paths[j].places[l].name;
       							var meter=1000*(myObj[k].paths[j].places[l].radius);
       							var coordinates=(new google.maps.LatLng(latitude, longitude));
       							
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
								var content = myObj[k].paths[j].places[l].name+
								"<p><img src='"+myObj[k].paths[j].places[l].image+"'>"+
								"<p>"+myObj[k].paths[j].places[l].info+
								"<p> Latitude: "+myObj[k].paths[j].places[l].latitude+
								" Longitude: "+myObj[k].paths[j].places[l].longitude;
								
								var infowindow = new google.maps.InfoWindow()
								
								google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
      								return function() {
          							infowindow.setContent(content);
           							infowindow.open(map,marker);
        							};
   								})(marker,content,infowindow)); 

  
  
  
       						}
       					}
       					
       					
       				}
       				
       				
       				
       					if (j==pathnr){var pen=3;}else{var pen=2;}
       					polyline = new google.maps.Polyline({
       					path:route,
       					strokeColor: 'green',
       					strokeOpacity: 0.6,
       					strokeWeight: pen
       				});	
       				polyline.setMap(map);
       				var content=pathname;
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
	
	
