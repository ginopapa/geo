<?

?>

<script>

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
    if ((xmlhttp.readyState===4) && (xmlhttp.status===200)) {
        var myObj = JSON.parse(xmlhttp.responseText);
       	console.log(myObj);
		console.log(myObj[1].paths[0].polyline[0].lat);

    }
}
xmlhttp.open("GET", "data.JSON", true);
xmlhttp.send();
</script>