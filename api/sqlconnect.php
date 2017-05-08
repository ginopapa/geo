<?

$username="";

$password="";

$database="";

mysql_connect(localhost,$username,$password);

@mysql_select_db($database) or die( "Unable to select database");

$con=mysqli_connect(localhost,$username,$password,$database);
if (mysqli_connect_error())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

?>
