<?
$json = file_get_contents('php://input');
//$code=json_decode($json);
echo $_GET['request'];

$method=$_SERVER['REQUEST_METHOD'];
//echo "<br>Method: ".$method.$json;



if ($json!="" AND $method=="POST"){
	echo "ok POST".$json;
file_put_contents("data.json", $json);
}
?>