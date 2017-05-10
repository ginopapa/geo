Geo installation manual

--Start--
Upload the folder geo to your server.
---------

--Database table install--
Install mysql on your server or use an online service. 
Run the file geoinstall.php from your web browser.
--------------------------

--Configure sqlconnect.php--
Edit the file sqlconnect.php in the folder api (geo/V1/api) and
update with your servername(or localhost), username, password, database.
----------------------------

--Google Key--
To use the map view, you have to have a Google api key.
Get it here -> https://developers.google.com/maps/documentation/javascript/get-api-key
Replace the word YOUR_KEY in both "geo.php" and "client.php" with the google api key.
--------------

--Using the Geo Admin--
Run the file geo.php in your web browser to administer your trails.
Press "+" to add Bundle/Path/Place/Media.
To delete bundles/paths/places/media/polylines, press the red button with a white "x";
The fields will update data to the DB after you stop writing.
Also images and polylines on the map will update instantly.
(Radius(in km) will affect the circle surrounding the place on the map.)

--The user client--
Run the file client.php.
You can choose the different Bundles on bottom of the window.
Paths are painted with green lines and if you click the "S"-pin(or on the line) you will get information 
about the path.
Pins with a bullet marks out and special place and here you get information about the place and look at media attached to it.
-------------------








