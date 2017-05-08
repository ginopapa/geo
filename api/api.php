<?
include("sqlconnect.php"); //
//Security script not included in this version.
//session_start();
//$db=$_SESSION["db"]; 
///////////////////////
$db="";

$method=$_SERVER['REQUEST_METHOD'];
$request_parts = explode('/', $_GET['request']);



/////////////////////////////////< ta bort innan github
if ($method=="POST"){
	$table=str_replace(' ', '', $request_parts[0]);
	if ($table=="bundles"){
		$now=round(microtime(true) * 1000);
		$sql="INSERT INTO ".$db."bundles (id, published) VALUES (".substr($now, 4).", 'yes')";
		mysqli_query($con,$sql);
		$sql="INSERT INTO ".$db."paths (id, bundleID, published) VALUES (".substr($now, 3).", ".substr($now, 4).", 'yes')";
		mysqli_query($con,$sql);
		$sql="INSERT INTO ".$db."places (id, pathID, published) VALUES (".substr($now, 2).", ".substr($now, 3).", 'yes')";
		mysqli_query($con,$sql);
		$polyline='[{"lat": 0, "lng": 0}]';
		$sql="INSERT INTO ".$db."polyline (pathID, published, polyline) VALUES (".substr($now, 3).", 'yes', '".$polyline."')";
		mysqli_query($con,$sql);
		$sql="INSERT INTO ".$db."media (id, placeID, published) VALUES (".substr($now, 1).", ".substr($now, 2).", 'yes')";
		mysqli_query($con,$sql);
		echo substr($now, 4);
	}
	
	if ($table=="paths"){
		$now=round(microtime(true) * 1000);
		$sql="INSERT INTO ".$db."paths (id, bundleID, published) VALUES (".substr($now, 3).", ".$request_parts[1].", 'yes')";
		mysqli_query($con,$sql);
		$sql="INSERT INTO ".$db."places (id, pathID, published) VALUES (".substr($now, 2).", ".substr($now, 3).", 'yes')";
		mysqli_query($con,$sql);
		$polyline='[{"lat": 0, "lng": 0}]';
		$sql="INSERT INTO ".$db."polyline (pathID, published, polyline) VALUES (".substr($now, 3).", 'yes', '".$polyline."')";
		mysqli_query($con,$sql);
		$sql="INSERT INTO ".$db."media (id, placeID, published) VALUES (".substr($now, 1).", ".substr($now, 2).", 'yes')";
		mysqli_query($con,$sql);
		echo substr($now, 4);
	}
	
	if ($table=="places"){
		$now=round(microtime(true) * 1000);
		$sql="INSERT INTO ".$db."places (id, pathID, published) VALUES (".substr($now, 2).", ".$request_parts[1].", 'yes')";
		mysqli_query($con,$sql);
		$polyline='[{"lat": 0, "lng": 0}]';
		$sql="INSERT INTO ".$db."polyline (pathID, published, polyline) VALUES (".substr($now, 3).", 'yes', '".$polyline."')";
		mysqli_query($con,$sql);
		$sql="INSERT INTO ".$db."media (id, placeID, published) VALUES (".substr($now, 1).", ".substr($now, 2).", 'yes')";
		mysqli_query($con,$sql);
		echo substr($now, 4);
	}
	
	if ($table=="media"){
		$now=round(microtime(true) * 1000);
		$polyline='[{"lat": 0, "lng": 0}]';
		$sql="INSERT INTO ".$db."media (id, placeID, published) VALUES (".substr($now, 1).", ".$request_parts[1].", 'yes')";
		mysqli_query($con,$sql);
		echo substr($now, 4);
	}
	
	mysqli_close($con);
}



/*///Tillfällig innan databas klar/////
$json = file_get_contents('php://input');
//$code=json_decode($json);



if ($json!="" AND $method=="POST"){
	echo "ok POST".$json;
file_put_contents("data.json", $json);
}*/

////////////////////////////////////////


///////////CREATE//////////////



////////////READ////////////////
if ($method=="GET"){

	

	switch (count($request_parts)) {
	
		case 1: //Contact all db, admin client uses this one
			if (strtoupper($request_parts[0])=="BUNDLE"){
				$sqlbundle="SELECT * FROM ".$db."bundles WHERE published = 'yes' ORDER BY id ASC";
			} else {
				$id=$request_parts[0];
				$sqlbundle="SELECT * FROM ".$db."bundles WHERE published = 'yes' AND id=".$id." ORDER BY id ASC";
			}
			$sqlpaths="SELECT * FROM ".$db."paths WHERE published = 'yes'";
			$sqlplaces="SELECT * FROM ".$db."places WHERE published = 'yes'";
			$sqlpolylines="SELECT * FROM ".$db."polyline WHERE published = 'yes'";
			$sqlmedia="SELECT * FROM ".$db."media WHERE published = 'yes'";
		break;
		
		case 2: //Contact only paths/places/polylines/media or only bundle if user wants bundleinfo
		break;
		
		case 3: //Contact only places or polylines or media or only paths for pathinfo
		break;
		
		case 4: //Only one value from places, polylines or media
		break;
	}



if ($result=mysqli_query($con,$sqlbundle))
  {
  $bx=0;
  while ($obj=mysqli_fetch_object($result))
    {
    $bundle[$bx]=$obj;
    $bx++;
    }
}

if ($result=mysqli_query($con,$sqlpaths))
  {
  $px=0;
  while ($obj=mysqli_fetch_object($result))
    {
    $path[$px]=$obj;
    $px++;
    }
}

if ($result=mysqli_query($con,$sqlplaces))
  {
  $plx=0;
  while ($obj=mysqli_fetch_object($result))
    {
    $place[$plx]=$obj;
    $plx++;
    }
}

if ($result=mysqli_query($con,$sqlpolylines))
  {
  $pox=0;
  while ($obj=mysqli_fetch_object($result))
    {
    $polyline[$pox]=$obj;
    $pox++;
    }
}

if ($result=mysqli_query($con,$sqlmedia))
  {
  $mex=0;
  while ($obj=mysqli_fetch_object($result))
    {
    $media[$mex]=$obj;
    $mex++;
    }
}

//media first into places
for ($y = 0; $y < $plx; $y++ ) {
$x=0;
$newmedia=[];
foreach($media as $row) {
	if ($place[$y]->id== $row->placeID){ 
		$newmedia[$x]=$row;
		$x++;
	}
}
array_push($place[$y]->media, '' ); 
$place[$y]->media=$newmedia;
json_encode($place[1], JSON_UNESCAPED_SLASHES);
}

//place into paths
for ($y = 0; $y < $px; $y++ ) {
$x=0;
$newplace=[];
foreach($place as $row) {
	if ($path[$y]->id== $row->pathID){ 
		$newplace[$x]=$row;
		$x++;
	}
}
array_push($path[$y]->places, '' ); 
$path[$y]->places=$newplace;

}

//polylines also into paths
for ($y = 0; $y < $px; $y++ ) {
$x=0;
$newpolyline="";
foreach($polyline as $row) {
	if ($path[$y]->id == $row->pathID){ 
		$newpolyline[$x]=json_decode($row->polyline, JSON_UNESCAPED_SLASHES);
		$x++;
	}
}
array_push($path[$y]->polyline, '' ); 
$path[$y]->polyline=$newpolyline[0];
}

/// Inte helt optimalt..
$callback=[];
for ($y = 0; $y < $bx; $y++ ) {
$x=0;
$newpath=[];
foreach($path as $row) {
	if ($bundle[$y]->id == $row->bundleID){ 
		$newpath[$x]=$row;
		$x++;
	}
}
array_push($bundle[$y]->paths, '' ); 
$bundle[$y]->paths=$newpath;
array_push($callback, $bundle[$y]);
}
echo json_encode($callback, JSON_UNESCAPED_SLASHES);


}

mysqli_close($con);
///////////UPDATE///////////////

if ($method=="UPDATE"){
	echo $db=$db.$request_parts[0];
	$type=$request_parts[0];
	$column=$request_parts[1];
	$id=$request_parts[2];
	$value=$request_parts[3];
	if ($column=="image"){$value=preg_replace('"--"','/',$value);} //fixa slash..
	if (is_numeric($id)) {
		switch ($type) {
			case "bundles":
				$sqlupdate="UPDATE ".$db." SET ".$column."='".$value."' WHERE id=".$id;
				break;	
			case "polyline":
				$sqlupdate="UPDATE ".$db." SET ".$column."='".$value."' WHERE pathID=".$id;
				break;
			case "paths":
				$sqlupdate="UPDATE ".$db." SET ".$column."='".$value."' WHERE id=".$id;
				break;
			case "places":
				$sqlupdate="UPDATE ".$db." SET ".$column."='".$value."' WHERE id=".$id;
				break;
			case "media":
				$sqlupdate="UPDATE ".$db." SET ".$column."='".$value."' WHERE id=".$id;
				break;
		}
		
///
		try {
   				$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    			
   			 	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);// set the PDO error mode to exception ...
    			$stmt = $conn->prepare($sqlupdate); // Prepare statement
   			 	$stmt->execute();// execute the query

   			 
   				echo $stmt->rowCount() . " records UPDATED successfully";
    	} catch(PDOException $e) {
   			 echo $sql . "<br>" . $e->getMessage();
    	}
		$conn = null;

	} else {"error: not valid id";}
	
}
//////////////DELETE//////////
if ($method=="DELETE"){
	$db=$db.$request_parts[0];
	$id=$request_parts[1];
	$sqldelete="UPDATE ".$db." SET published='no' WHERE id=".$id."";
	try {
   				$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    			
   			 	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);// set the PDO error mode to exception ...
    			$stmt = $conn->prepare($sqldelete); // Prepare statement
   			 	$stmt->execute();// execute the query

   			 
   				echo $stmt->rowCount() . " record DELETED successfully";
    	} catch(PDOException $e) {
   			 echo $sql . "<br>" . $e->getMessage();
    	}
		$conn = null;

	
}
/*
                       _..yyyyyppppp.._                       
                  _.yd$$$$$$$$$$$$$$$$$$bp._                  
               .y$$$$$$P^^""j$$b""""^^T$$$$$$p.               
            .y$$$P^T$$b    d$P T;       ""^^T$$$p.            
          .d$$P^"  :$; `  :$;                "^T$$b.          
        .d$$P'      T$b.   T$b                  `T$$b.        
       d$$P'      .yy$$$$bpd$$$p.d$bpp.           `T$$b       
      d$$P      .d$$$$$$$$$$$$$$$$$$$$bp.           T$$b      
     d$$P      d$$$$$$$$$$$$$$$$$$$$$$$$$b.          T$$b     
    d$$P      d$$$$$$$$$$$$$$$$$$P^^T$$$$P            T$$b    
   d$$P    '-'T$$$$$$$$$$$$$$$$$$byypd$$$$b.           T$$b   
  :$$$      .d$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$p._.y.     $$$;  
  $$$;     d$$$$$$$$$$$$$$$$$$$$$$$P^"^T$$$$P^^T$$$;    :$$$  
 :$$$     :$$$$$$$$$$$$$$:$$$$$$$$$_    "^T$bpd$$$$,     $$$; 
 $$$;     :$$$$$$$$$$$$$$bT$$$$$P^^T$p.    `T$$$$$$;     :$$$ 
:$$$      :$$$$$$$$$$$$$$P `^^^'    "^T$p.    lb`TP       $$$;
:$$$      $$$$$$$$$$$$$$$              `T$$p._;$b         $$$;
$$$;      $$$$$$$$$$$$$$;       PHP      `T$$$$:Tb        :$$$
$$$;      $$$$$$$$$$$$$$$                        Tb    _  :$$$
:$$$     d$$$$$$$$$$$$$$$.                        $b.__Tb $$$;
:$$$  .y$$$$$$$$$$$$$$$$$$$p...______...yp._      :$`^^^' $$$;
 $$$;  `^^'T$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$p.    Tb._, :$$$ 
 :$$$       T$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$b.   "^"  $$$; 
  $$$;       `$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$b      :$$$  
  :$$$        $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$;     $$$;  
   T$$b    _  :$$`$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$;   d$$P   
    T$$b   T$y$$; :$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$  d$$P    
     T$$b   `^^'  :$$ "^T$$$$$$$$$$$$$$$$$$$$$$$$$$$ d$$P     
      T$$b        $P     T$$$$$$$$$$$$$$$$$$$$$$$$$;d$$P      
       T$$b.      '       $$$$$$$$$$$$$$$$$$$$$$$$$$$$P       
        `T$$$p.   buy    d$$$$$$$$$$$$$$$$$$$$$$$$$$P'        
          `T$$$$p..__..y$$$$$$$$$$$$$$$$$$$$$$$$$$P'          
            "^$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$^"            
               "^T$$$$$$$$$$$$$$$$$$$$$$$$$$P^"               
                   """^^^T$$$$$$$$$$P^^^"""



gammal kod:
$bundleID=$bundle[0]->bundleID;
if (ctype_digit($request_parts[0])) {$bundleID="WHERE bundleId=".$request_parts[0];} else {$bundleID="";}
*/



?>