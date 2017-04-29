<?

?>
<html>
<head>
<style>
body {
	color:white;
}
.path {
	margin-left:30px;
	margin-bottom:5px;
	background-color:blue;
}

.place {
	margin-left:55px;
	background-color:pink;
}

.media {
	margin-left:55px;
	background-color:red;

}

.polyline {
	margin-left:55px;
	background-color:grey;
}

.bundle {

	margin-bottom:10px;
	background-color:green;
}

.media {

	margin-left:70px;
}
</style>
<script>
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
    if ((xmlhttp.readyState===4) && (xmlhttp.status===200)) {
        var myObj = JSON.parse(xmlhttp.responseText);
       	console.log(myObj);
		var theContent="";
		for (i = 0; i < myObj.length; i++) {
			theContent+="<div class='bundle'>(BUNDLE) "+myObj[i].id+" / "+myObj[i].name+" / "+myObj[i].info+" / "+myObj[i].image;
				for (j = 0; j < myObj[i].paths.length; j++) {
					theContent+="<div class='path'>(PATH) "+myObj[i].paths[j].id+" | "+myObj[i].paths[j].name+" | "+myObj[i].paths[j].info+" | "+myObj[i].paths[j].length+" | "+myObj[i].paths[j].image+" | "+myObj[i].paths[j].duration;
					for (k = 0; k < myObj[i].paths[j].places.length; k++ ) {
						theContent+="<div class='place'>(PLACE) "+myObj[i].paths[j].places[k].name+" | "+myObj[i].paths[j].places[k].info+" | "+myObj[i].paths[j].places[k].image+" | "+myObj[i].paths[j].places[k].radius+" | lat: "+myObj[i].paths[j].places[k].position.lat+" | long: "
						+myObj[i].paths[j].places[k].position.lng+" | "+myObj[i].paths[j].places[k].radius+"</div> <div class='media'>(MEDIA) type: "+myObj[i].paths[j].places[k].media[0].type+" | Contents: "+myObj[i].paths[j].places[k].media[0].contents+" | Name: "+myObj[i].paths[j].places[k].media[0].name+" | Image: "+myObj[i].paths[j].places[k].media[0].image+"</div>";
						
					}
					for (l = 0; l < myObj[i].paths[j].polyline.length; l++) {
						theContent+="<div class='polyline'>(POLYLINE) lat: "+myObj[i].paths[j].polyline[l].lat+" long: "+myObj[i].paths[j].polyline[l].lng+"</div>";
					}
					theContent+="</div>";
				}	
			theContent+="</div>";
		}
		document.getElementById("content").innerHTML=theContent;
    }	
    
}
xmlhttp.open("GET", "data.JSON", true);
xmlhttp.send();
</script>
</head>

<body>
<div id="content"> </div>
</body>
</html>