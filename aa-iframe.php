<?php
$options['vanguard']=FALSE;
require "/var/www/liszt.cloud/hammer/vanilla.php";
$hammer->head("AudioAtlas","<link rel=\"stylesheet\" href=\"/assets/aa-bootstrap.css?v=".$hammer->getHT('timestamp')."\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"//cdn.liszt.app/vendor/leaflet/1.3.1/leaflet.css?v=".$hammer->getHT('timestamp')."\" type=\"text/css\" />
<script src=\"//cdn.liszt.app/vendor/leaflet/1.6.0/leaflet.js\"></script>
<script src=\"//cdn.liszt.app/vendor/leaflet/ajax/leaflet.ajax.min.js\"></script>
");
$hr = new audioatlas_datapoint($hammer);
$dd = new david_document($hammer);
$u = new user($hammer);
$a=$hr->getByGUID($_GET['fileguid']);
$hammer->setHS($a['own']);
//$hammer->debug();
$f=$dd->getByFolder($a['guid']);
?>
<body style="height:100%;">
<?php //TOP MENU ?>
<div class="container-fluid" style="height:100%;">
	<div class="row" style="height:100%;">
		<div class="col-md-6" style="height:100%;">
			<div id="FullMap" style="border:1px solid #333;height:100%;"></div>
		</div>
		<div class="col-md-6">
			<?php 
			echo "<h3>".$a['name']."</h3>";
			echo "Location: ".$a['loc']."<br />";
			echo "Equipment: ".$a['equip']."<br />";
			echo "<br />";
			if($a['created_by']>0){$u->getByID($a['created_by']);echo "Uploaded by ".$u->row['firstname']." ".$u->row['lastname'];}
			
			?>
			<br />
			<iframe frameborder="0" height="72" scrolling="no" src="/audio/?platform=audioatlas&player=1&title=<?php echo $a['name'];?>&name=&file=<?php echo $f[0]['guid'];?>" width="522"></iframe>
		</div>
	</div>
</div>
<script>
var map = L.map('FullMap').setView([<?php echo $a['lat'];?>, <?php echo $a['lon'];?>], 13);
L.control.scale().addTo(map);

//tiles
	// var dark1 = L.tileLayer('http://a.tile.stamen.com/toner/{z}/{x}/{y}.png', {attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);
	var Stamen_Toner = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/toner/{z}/{x}/{y}{r}.{ext}', {
	attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
	subdomains: 'abcd',
	minZoom: 0,
	maxZoom: 20,
	ext: 'png'
	});
	var dark = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/dark_all/{z}/{x}/{y}.png', {attribution: '&copy; Map tiles by Carto, under CC BY 3.0. Data by OpenStreetMap, under ODbL'});
	var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 19,attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);

//Locate
	// map.locate({setView: true, maxZoom: 5}); //on autolocate
	document.getElementById('locate').addEventListener('click', function() {
		map.locate({ setView: true, maxZoom: 13 });
	});


//Tile Control
	var baseMaps = {
		// "Grayscale": dark1,
		"Stamen Toner": Stamen_Toner,
		"Dark Carto": dark,
		"OpenStreetMap":osm
	};

	// var overlayMaps = {
		// "Cities": dark2
	// };

	L.control.layers(baseMaps).addTo(map); //add ,overlayMaps if needed

L.marker([<?php echo $a['lat'];?>, <?php echo $a['lon'];?>]).addTo(map);


</script>
<?php require_once "/var/www/liszt.cloud/liszt-templates/footer-scripts.php"; ?>
</body>




