
<?
/* Idéer
$request_parts = explode('/', $_GET['url']); // array('users', 'show', 'abc')
$file_type     = $_GET['type'];
echo json_encode($output);


*/
echo $_GET['request'];
echo "<br>Method: ".$_SERVER['REQUEST_METHOD'];
?>