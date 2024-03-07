<?php
require "/var/www/api.ntfg.net/htdocs/hammer/vanilla.php";
$hammer->head("AudioAtlas","<link rel=\"stylesheet\" href=\"/assets/aa-bootstrap.css?v=".$hammer->getHT('timestamp')."\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"//cdn.ntfg.net/vendor/leaflet/1.6.0/leaflet.css?v=".$hammer->getHT('timestamp')."\" type=\"text/css\" />
<script src=\"//cdn.ntfg.net/vendor/leaflet/1.6.0/leaflet.js\"></script>
<script src=\"//cdn.ntfg.net/vendor/leaflet/ajax/leaflet.ajax.min.js\"></script>
")
?>
<body>
<?php
//Some Debug Lines
//print_r($permissions);
//echo $DateTime->format('c');
if(isset($_GET['page'])){$page=$_GET['page'];}else{$page="index";}
?>
<?php //TOP MENU ?>
<nav class="navbar navbar-dark navbar-bg-dark navbar-expand-md navbar-fixed-top">
	<div class="container-fluid">
		<a class="navbar-brand" href="/"><img src="/assets/AudioAtlas-2020.png" style="height:40px;"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#audioatlasnav" aria-controls="audioatlasnav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
	<div class="collapse navbar-collapse" id="audioatlasnav">
		<ul class="navbar-nav ms-auto">
			<a class="nav-link<?php if($page=="index"){echo " active";}?>" href="http://audioatlas.org/">Home</a>
			<a class="nav-link" id="locate" href="#"><i class="fa fa-location-arrow" title="Locate Me"></i></a>
			<a class="nav-link" id="globe" href="#"><i class="fa fa-globe" title="Full Map"></i></a>
			<a class="nav-link" href="https://noteforge.com/legal/liszt-terms-of-service/">License</a>
			<a class="nav-link" href="http://noteforge.com/contact/">Contact</a>
		</ul>
	</div>
	</div><!--Container-->
</nav>
<div class="wrapper">
<div id="FullMap"></div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="lz-drawer<?php echo $hammer->getHT('timestamp')?>" aria-labelledby="lz-drawer<?php echo $hammer->getHT('timestamp')?>Label">
	<div class="offcanvas-header">
		<h5 id="lz-drawer<?php echo $hammer->getHT('timestamp')?>Label">AudioAtlas</h5>
	<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body" style="height:100%">
			<iframe src="//liszt.dev/zz-loading.php" frameborder="0" style="height:99%; width:100%; overflow:hidden;overflow-x:hidden;overflow-y:hidden;" id="lz-drawer<?php echo $hammer->getHT('timestamp');?>iframe"></iframe>
	</div>
</div>

<script>
var map = L.map('FullMap',{worldCopyJump:false, }).setView([46.851, -96.987], 5);
L.control.scale().addTo(map);

//tiles
	// var dark1 = L.tileLayer('http://a.tile.stamen.com/toner/{z}/{x}/{y}.png', {attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);
	var dark = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/dark_all/{z}/{x}/{y}.png', {attribution: '&copy; Map tiles by Carto, under CC BY 3.0. Data by OpenStreetMap, under ODbL'});
	var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 19,attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'});
	var Stamen_Toner = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/toner/{z}/{x}/{y}{r}.{ext}', {attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',subdomains: 'abcd',minZoom: 0, maxZoom: 20,ext: 'png'}).addTo(map);
	var Esri_WorldImagery = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
	attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'});
//Locate
	//map.locate({setView: true, maxZoom: 5});
	$('#locate').on('click', function(){map.locate({setView: true, maxZoom: 13})});
	$('#globe').on('click', function(){map.locate({setView: true, maxZoom: 1})});

//Tile Control
	var baseMaps = {
		// "Grayscale": dark1,
		"Stamen Toner": Stamen_Toner,
		"Dark Carto": dark,
		"OpenStreetMap":osm,
		"Esri World Imagery":Esri_WorldImagery
	};

	// var overlayMaps = {
		// "Cities": dark2
	// };

	L.control.layers(baseMaps).addTo(map); //add ,overlayMaps if needed

//map.on('click', function(e){
//  var coord = e.latlng;
//  var lat = coord.lat;
//  var lng = coord.lng;
//  alert("You clicked the map at latitude: " + lat + " and longitude: " + lng);
//  var newMarker = new L.marker(e.latlng).addTo(map);
//  });
//Get from external?

function onEachFeature(feature, layer) {
    //bind click
    layer.on('click', function (e) {
		url = "/aa-iframe.php?fileguid="+feature.properties.fileguid;
		// alert(url);
	  // modal<?php echo $hammer->getHT('timestamp');?>.iframe(options);
	  $('#lz-drawer<?php echo $hammer->getHT('timestamp');?>iframe').attr('src',url);
	  bsOffcanvas.show();
    });
}

var aageojsonLayer = new L.GeoJSON.AJAX("aa-data.php",{onEachFeature:onEachFeature}).addTo(map); 

</script>
<?php require_once "/var/www/cdn.ntfg.net/htdocs/footer-scripts.php"; ?>
</body>
