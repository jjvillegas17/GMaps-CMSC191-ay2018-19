<!DOCTYPE html>
<html>
<head>
<script src="http://maps.googleapis.com/maps/api/js?key=API_KEY"></script>
</head>


<body>
<?php
	include 'Db.php';
?>
<div>
	All bouncing markers are malls.
</div>
<div>
	Click markers to see its latitude and longitude.
</div>
<fieldset>
	<legend> Marker colors</legend>
	<div>Restaurant - Green</div>
	<div>Auditorium - Brown</div>
	<div>Mall - Blue</div>
	<div>Inn - Yellow</div>
	<div>Bank - Orange</div>
	<div>Municipal Hall - Black</div>
	<div>Resort - Red</div>
	<div>Amusement Park - Pink</div>
</fieldset>
<div id="googleMap" style="width:1500px;height:1500px;"></div>
</body>

<script>
var count = document.getElementById("count").value;    // get the number of rows
var lat = [], lng = [], namee = [], type = [], address = [];
for (i = 0; i < count; i++) {      // get data from each marker
	lat[i] = document.getElementById(i.toString()).value;
	lng[i] = document.getElementById("lng" + i.toString()).value;
	namee[i] = document.getElementById("name" + i.toString()).value;
	type[i] = document.getElementById("type" + i.toString()).value;
	address[i] = document.getElementById("addr" + i.toString()).value;
}

function initialize()
{
	var mapProp = {			// set map options
	  center:(new google.maps.LatLng(lat[0], lng[0])),
	  zoom:100,
	  mapTypeId:google.maps.MapTypeId.ROADMAP
	  };

	var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

	polyLineCoords = new Array();
	for (i = 0; i < lat.length; i++) { 			// initialize the array to be used for the path property of Polyline
		if (type[i] === "Mall") {
			polyLineCoords.push(new google.maps.LatLng(parseFloat(lat[i]), parseFloat(lng[i])));		
		}
	}

	var mallLine  = new google.maps.Polyline({		// draws the line from each mall
    	path: polyLineCoords,
    	geodesic:true,
 		strokeColor: '#ffff00',
 		strokeOpacity: 0.6,
 		strokeWeight: 2
    });

    mallLine.setMap(map);

	for (i = 0; i < lat.length; i++) {
		var icon;
		switch (type[i]) {   		// set the icon color depending on the type
			case 'Restaurant': icon = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'; break;
			case 'Auditorium': icon = '/Google Maps Markers/purple_MarkerA.png'; break;
			case 'Mall': icon = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'; break;
			case 'Inn': icon = 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png'; break;
			case 'Bank': icon = 'http://maps.google.com/mapfiles/ms/icons/orange-dot.png'; break;
			case 'Municipal Hall': icon = "/Google Maps Markers/brown_MarkerM.png"; break;
			case 'Resort': icon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'; break;
			case 'Amusement Park': icon = 'http://maps.google.com/mapfiles/ms/icons/pink-dot.png'; break;
		}


		animation = type[i] === "Mall" ? google.maps.Animation.BOUNCE : ""; 		// for the bouncing animation of markers

		var marker=new google.maps.Marker({				// add the markers for each place
			position:(new google.maps.LatLng(lat[i], lng[i])),
			animation: animation,
			icon: icon, 
			title: namee[i]
		});

		google.maps.event.addListener(marker, 'click', (function(marker, i) {     // to trigger info window when a marker is clicked
		     return function() {
		         infowindow.setContent("Lat: " + lat[i] + " , " + "Lng: " + lng[i]);
		         infowindow.open(map, marker);
		     }
		 })(marker, i));

		if (namee[i] === "SM City Calamba") {              // draw a circle if name is SM City Calamba
			var smcCircle = new google.maps.Circle({
					strokeColor: '#cc9900',
					strokeOpacity: 0.8,
					strokeWeight: 2,
					fillColor: '#ff9933',
					fillOpacity: 0.35,
					map: map,
					center: {lat: parseFloat(lat[i]), lng: parseFloat(lng[i])},
					radius: 250
				  });
		}

		marker.setMap(map);
	}
 
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

</html>
