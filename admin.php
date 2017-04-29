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

.bundleimage {
	height:50px;
	width:50px;

}

.url {
	width:400px;

}
</style>
<script>
var myObj=[];
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
    if ((xmlhttp.readyState===4) && (xmlhttp.status===200)) {
        myObj = JSON.parse(xmlhttp.responseText);
       	console.log(myObj);
		var theContent="";
		for (i = 0; i < myObj.length; i++) {
			theContent+="<div class='bundle'><img id='imB"+i+"' class='bundleimage' src='"+myObj[i].image+"'>(BUNDLE) "+myObj[i].id+" / "+myObj[i].name+" / "+myObj[i].info+" / <input id ='bi"+i+"' class='url' onblur='bundleImage("+i+");' value='"+myObj[i].image+"'></input>";
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
			theContent+="</div><button onclick='save();'>Save</button>";
		}
		document.getElementById("content").innerHTML=theContent;
    }	
    
}
xmlhttp.open("GET", "api/data.json", true);
xmlhttp.send();



function bundleImage (bundleNr, thisId){
	myObj[bundleNr].image=document.getElementById("bi"+bundleNr).value;
	document.getElementById("imB"+bundleNr).src=myObj[bundleNr].image;
	console.log (myObj[bundleNr].image);
}

function save() {
	var my_json= JSON.stringify(myObj);
	savedata = new XMLHttpRequest();
	savedata.onreadystatechange = function() {
    	if ((savedata.readyState===4) && (savedata.status===200)) {
    		console.log(savedata.responseText);
    	}
    }
	savedata.open("POST" , "api/api.php", true);
	savedata.setRequestHeader("Content-type", "application/json");
	savedata.send(my_json);
	
}
</script>
</head>

<body>
<div id="content"> </div>
</body>
</html>