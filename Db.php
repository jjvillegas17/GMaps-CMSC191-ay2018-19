<?php
$con = mysqli_connect("localhost","root","zachary","gmaps");

// Check connection
if (mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

$sql="SELECT lat, lng, name, type , address from markers";

$lat = []; $lng = []; $name = []; $type = []; $addr = [];
$index = 0;
$data = [];

if ($result=mysqli_query($con,$sql)) {
  // Fetch one and one row
  while ($row=mysqli_fetch_array($result)) {
    	$lat[$index] = $row['lat'];
    	$lng[$index] = $row['lng'];
    	$name[$index] = $row['name'];
    	$type[$index] = $row['type'];	
    	$addr[$index] = $row['address'];
    	$index += 1;
    }
  // Free result set
  mysqli_free_result($result);
}
else {
	echo "Querying failed";
}

mysqli_close($con);

$count =  count($lat);
echo "<input type=hidden value=$count id='count'>";
for ($i = 0; $i < count($lat); $i++) {
	$lngId = 'lng'.$i;
	$nameId = 'name'.$i;
	$typeId = 'type'.$i;
	$addrId = 'addr'.$i;
	echo "<input type=hidden value=$lat[$i] id = $i>";
	echo "<input type=hidden value=$lng[$i] id = $lngId>";
	echo "<input type=hidden value='$name[$i]' id = $nameId>";	
	echo "<input type=hidden value='$type[$i]' id = $typeId>";	
	echo "<input type=hidden value='$addr[$i]' id = $addrId>";	
}