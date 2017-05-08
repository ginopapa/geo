<?php
//// Run script in web browser
if($_GET['servername']==""){$servername = "localhost";} else{ $servername=$_GET['servername'];}
if($_GET['username']==""){$username = "username";} else{ $username=$_GET['username'];}
if($_GET['password']==""){$password = "password";} else{ $password=$_GET['password'];}
if($_GET['dbname']==""){$dbname = "myDBPDO";} else{ $dbname=$_GET['dbname'];}

////
if ($password=="password"){
echo $html="<html><body><form action='geoinstall.php'><input type='text' name='servername' placeholder='servename(or localhost)'><br><input type='text' name='username' placeholder='username'><br><input type='password' name='password' placeholder='password'><br><input type='text' name='dbname' placeholder='database name'><br><button type='submit'>CREATE DB</button></form></body></html>";

}else {
//Bundle-table
	$success=0;
	try {
   		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   		 $sql = "CREATE TABLE bundles (
    			published VARCHAR(3), 
    			id VARCHAR(16),
    			name VARCHAR(48),
   				info VARCHAR(512),
    			image VARCHAR(256)
   		  )";
   		  $success++;
   		 $conn->exec($sql);
    	echo "<br>Table: bundles, created successfully";
   	}
   	
	catch(PDOException $e)
    {
   	 	echo $sql . "<br>" . $e->getMessage();
    }


//paths-table
	try {
   		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   		 $sql = "CREATE TABLE paths (
    			published VARCHAR(3),
    			bundleID VARCHAR(16), 
    			id VARCHAR(16),
    			name VARCHAR(48),
   				info VARCHAR(512),
   				length VARCHAR(5),
    			image VARCHAR(256),
    			duration VARCHAR(3)
   		  )";
   		  $success++;
   		 $conn->exec($sql);
    	echo "<br>Table: paths, created successfully";
   	}
   	
	catch(PDOException $e)
    {
   	 	echo $sql . "<br>" . $e->getMessage();
    }



//places-table
	try {
   		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   		 $sql = "CREATE TABLE places (
    			published VARCHAR(3),
    			pathID VARCHAR(16), 
    			id VARCHAR(16),
    			name VARCHAR(48),
   				info VARCHAR(512),
    			image VARCHAR(256),
   				radius VARCHAR(5),    			
    			latitude VARCHAR(32),
    			longitude VARCHAR(32)
   		  )";
   		  $success++;
   		 $conn->exec($sql);
    	echo "<br>Table: places, created successfully";
   	}
   	
	catch(PDOException $e)
    {
   	 	echo $sql . "<br>" . $e->getMessage();
    }
    
    
//polyline-table
	try {
   		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   		 $sql = "CREATE TABLE polylines (
    			published VARCHAR(3), 
    			pathID VARCHAR(16),
    			polyline VARCHAR(2056)

   		  )";
   		  $success++;
   		 $conn->exec($sql);
    	echo "<br>Table: polyline, created successfully";
   	}
   	
	catch(PDOException $e)
    {
   	 	echo $sql . "<br>" . $e->getMessage();
    }     

//media-table
	try {
   		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   		 $sql = "CREATE TABLE media (
    			published VARCHAR(3), 
    			id VARCHAR(16),
    			placeID VARCHAR(16),
    			name VARCHAR(48),
   				type VARCHAR(16),
    			image VARCHAR(256),
    			contents VARCHAR(48)
   		  )";
   		  $success++;
   		 $conn->exec($sql);
    	echo "<br>Table: media, created successfully";
   	}
   	
	catch(PDOException $e)
    {
   	 	echo $sql . "<br>" . $e->getMessage();
    }
  
//auth-table
	try {
   		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   		 $sql = "CREATE TABLE auth (
    			login VARCHAR(48), 
    			password VARCHAR(48)
   		  )";
   		  $success++;
   		 $conn->exec($sql);
    	echo "<br>Table: auth, created successfully";
   	}
   	
	catch(PDOException $e)
    {
   	 	echo $sql . "<br>" . $e->getMessage();
    }  
  
    
$conn = null;



if ($success==6){
		$myfile = fopen("sql.php", "w") or die("Unable to open file!");
		echo $data="<?php 
				$username=".$username.";

				$password=".$password.";

				$database=".$dbname.";

				$server=".$servername.";

				mysql_connect($server,$username,$password);

				@mysql_select_db($database) or die( 'Unable to select database');

				$con=mysqli_connect(localhost,$username,$password,$database);
				if (mysqli_connect_error())
 				 {
 					 echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
  					}		
		
		
		 ?>";
		fwrite($myfile, $data);
		fclose($myfile);
	echo "<br> All tables installed, you can start using geo.php now";
}
}
?>


