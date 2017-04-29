<?

?>
<html>
<head>
<style>
body {
	color:white;
}

.smallblock {
	float:left;
	height:40px;
}

.path {
	margin-left:0px;
	margin-bottom:5px;
	background-color:olive;
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
	margin-top:20px;
	background-color:green;
}

.bundleleft {
	width:20%;
	height:100px;
	float:left;
	background-color:green;
}

.bundlemiddle {
	width:8%;
	height:100px;
	float:left;
	background-color:green;
}

.bundleright {
	width:70%;
	height:90px;
	float:left;
	background-color:green;
	padding-left:2%;
	padding-top:10px;
}

.media {

	margin-left:70px;
}

.bundleinfo{
	background-color:darkgreen;
}

.bundleimage {
	height:55px;
	width:85px;

}

.url {
	width:400px;

}

.mybutton {
	width:100%;
	height:50%;
}
</style>
<script>
var myObj=[];
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
    if ((xmlhttp.readyState===4) && (xmlhttp.status===200)) {
        myObj = JSON.parse(xmlhttp.responseText);
       	console.log(myObj);
       	makeMenu();
		loadBundles();
    }
    
}
xmlhttp.open("GET", "api/data.json", true);
xmlhttp.send();

var bundlemeny="";
function makeMenu(start) { //<option value="volvo">Volvo</option>
	bundlemenu="<select id='bundleswitch' onchange='switchBundle();'>";
	for (m = 1; m < myObj.length; m++){
		var selection="";
		if  (m==start){selection="selected";}
		bundlemenu+="<option value='"+m+"'"+selection+">"+myObj[m].name+"</option>";
	}
	bundlemenu+="</select>";
}

function switchBundle (){
	var e = document.getElementById("bundleswitch");
	var selectedvalue = e.options[e.selectedIndex].value;
	loadBundles(selectedvalue);
}

function loadBundles(i) {
		if(i==null){i=1;}
		makeMenu(i);
		var theContent="";
		myEmpty=myObj[0];
		//for (i = 1; i < myObj.length; i++) {
			theContent+="<div class='bundle'><div class='bundleleft'><center>BUNDLE<br><img id='imB"+i+"' class='bundleimage' src='"+myObj[i].image+"'><br>"+bundlemenu+"</div><div class='bundlemiddle'><button class='mybutton' onclick='newBundle();'>New Bundle</button><br><button class='mybutton' onclick='save();'>Save Bundle</button></div><div class='bundleright'> <div class='smallblock'>ID<br><input value='"+myObj[i].id+"'></div><div class='smallblock'>Name <br><input value='"+myObj[i].name+"'></div><div class='smallblock'>Info<br><input style='width:280px;' value='"+myObj[i].info+"'></div> <div class='smallblock'>Image URL<br><input id ='bi"+i+"' class='url' onblur='bundleImage("+i+");' value='"+myObj[i].image+"'></input></div></div></div>";
				for (j = 0; j < myObj[i].paths.length; j++) {
					theContent+="<div class='path'>(PATH) "+myObj[i].paths[j].id+" | "+myObj[i].paths[j].name+" | "+myObj[i].paths[j].info+" | "+myObj[i].paths[j].length+" | "+myObj[i].paths[j].image+" | "+myObj[i].paths[j].duration;
					for (k = 0; k < myObj[i].paths[j].places.length; k++ ) {
						theContent+="<div class='place'>(PLACE) "+myObj[i].paths[j].places[k].name+" | "+myObj[i].paths[j].places[k].info+" | "+myObj[i].paths[j].places[k].image+" | "+myObj[i].paths[j].places[k].radius+" | lat: "+myObj[i].paths[j].places[k].position.lat+" | long: "
						+myObj[i].paths[j].places[k].position.lng+" | "+myObj[i].paths[j].places[k].radius+"<div class='media'>(MEDIA) type: "+myObj[i].paths[j].places[k].media.type+" | Contents: "+myObj[i].paths[j].places[k].media.contents+" | Name: "+myObj[i].paths[j].places[k].media.name+" | Image: "+myObj[i].paths[j].places[k].media.image+"</div></div>";
						
					}
					theContent+="<div class='place'><button onclick='addPlace("+i+","+j+","+k+");'>ADD PLACE</button></div>";
					for (l = 0; l < myObj[i].paths[j].polyline.length; l++) {
						theContent+="<div class='polyline'>(POLYLINE) lat: <input onblur='polyLat("+i+","+j+","+l+");' id='lat"+i+"s"+j+"s"+l+"' value='"+myObj[i].paths[j].polyline[l].lat+"'> long: <input onblur='polyLng("+i+","+j+","+l+");' id='lng"+i+"s"+j+"s"+l+"' value='"+myObj[i].paths[j].polyline[l].lng+"'></div>";
					}
					
					theContent+="<div class='polyline'><button onclick='addPoly("+i+","+j+","+l+");'>ADD POLYLINE</button></div></div>";
				}	
			theContent+="</div>";
		//}
		theContent+="<div><button onclick='addPath("+i+","+j+");'>ADD PATH</button></div>"
		document.getElementById("content").innerHTML=theContent;
}

function bundleImage (bundleNr){
	myObj[bundleNr].image=document.getElementById("bi"+bundleNr).value;
	document.getElementById("imB"+bundleNr).src=myObj[bundleNr].image;
	console.log (myObj[bundleNr].image);
}

function polyLat(bundleNr, pathNr, polyNr) {
	var latId="lat"+bundleNr+"s"+pathNr+"s"+polyNr;
	myObj[bundleNr].paths[pathNr].polyline[polyNr].lat=document.getElementById(latId).value;
	console.log (myObj[bundleNr].paths[pathNr].polyline[polyNr].lat);
}

function polyLng(bundleNr, pathNr, polyNr) {
	var lngId="lng"+bundleNr+"s"+pathNr+"s"+polyNr;
	myObj[bundleNr].paths[pathNr].polyline[polyNr].lng=document.getElementById(lngId).value;
	console.log (myObj[bundleNr].paths[pathNr].polyline[polyNr].lng);
}

function addPoly(bundleNr, pathNr, polyNr) {
	myObj[bundleNr].paths[pathNr].polyline.push({lat:0, lng:0});
	console.log(myObj[bundleNr].paths[pathNr].polyline[polyNr]);
	loadBundles(bundleNr);
}

function addPlace(bundleNr, pathNr, placeNr) {
	myObj[bundleNr].paths[pathNr].places.push({name:"", info: "", radius: 0, position: {lat:0, lng:0}, media: {type: "", contents: "", name: "", image: ""}, image: ""});
	console.log(myObj[bundleNr].paths[pathNr].places[placeNr]);
	loadBundles(bundleNr);
}

function addPath(bundleNr, pathNr) {
	myObj[bundleNr].paths.push({places: {name:"", info: "", radius: 0, position: {lat:0, lng:0}, media: {type: "", contents: "", name: "", image: ""}, image: ""}, id:"",name : "",info : "",length : 0, duration : 0, image: "", polyline: {lat:0, lng:0}});
	console.log(myObj[bundleNr].paths);
	loadBundles(bundleNr);
	console.log(bundleNr);
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

function newBundle() {
	myObj=myObj.concat(myEmpty);
	loadBundles(myObj.length-1);
	console.log(myObj.length);
}
</script>
</head>

<body>
<div id="content"> </div>

</body>
</html>