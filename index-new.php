<?php
/*
NoteForge Hammer
	by Kyle Vanderburg, in Poplar Bluff & Springfield, Missouri, and Norman, OK.
	Hammer Backend Index Page
	Debuted on November 30, 2007, at www.kyledavey.com/blink.  Went live December 2, 2007.
	All code copyright Kyle Vanderburg
*/
require "/var/www/liszt.cloud/hammer/vanilla.php";
$hammer->clientUrlParse();
$hammer->head("AudioAtlas","<link rel=\"stylesheet\" href=\"//liszt.dev/assets/lz-master3.css\" type=\"text/css\" /><link rel=\"shortcut icon\" href=\"//liszt.me/assets/lisztfav.png\"/><script src=\"//liszt.dev/assets/lz-master3.js\"></script><link rel=\"stylesheet\" href=\"/assets/aa-bootstrap.css?v=".$hammer->getHT('timestamp')."\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"//cdn.liszt.app/vendor/leaflet/1.6.0/leaflet.css?v=".$hammer->getHT('timestamp')."\" type=\"text/css\" />
<script src=\"//cdn.liszt.app/vendor/leaflet/1.6.0/leaflet.js\"></script>
<script src=\"//cdn.liszt.app/vendor/leaflet/ajax/leaflet.ajax.min.js\"></script>
");



// $hammer->debug(); ?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php include('lz-nav-top.php'); ?>
<?php include('lz-nav-sidebar.php'); ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper" style="height:calc(100% - 60px);">

		<!-- Main content -->
		<section class="content m-0 p-0">
			<div class="container-fluid m-0 p-0">
				<div class="wrapper" style="">
                <div id="FullMap"></div>
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
                    document.getElementById('locate').addEventListener('click', function() {
                        map.locate({ setView: true, maxZoom: 13 });
                    });

                    document.getElementById('globe').addEventListener('click', function() {
                        map.locate({ setView: true, maxZoom: 1 });
                    });


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
                    // Bind click
                    layer.on('click', function (e) {
                        // Construct the URL
                        var url = "/aa-iframe.php?fileguid=" + feature.properties.fileguid;

                        // Set the iframe source
                        const iframe = document.getElementById('lz-drawer<?php echo $hammer->getHT('timestamp'); ?>iframe');
                        if (iframe) {
                            iframe.setAttribute('src', url);
                        }

                        // Show the offcanvas
                        bsOffcanvas.show();
                    });
                }

                var aageojsonLayer = new L.GeoJSON.AJAX("aa-data.php",{onEachFeature:onEachFeature}).addTo(map); 

                </script>
			</div>
			</div><!-- container-fluid -->
		</section><!-- content -->
	</div>
	<!-- content-wrapper -->
  
</div><!-- ./wrapper -->

<div class="offcanvas offcanvas-end" tabindex="-1" id="lz-drawer<?php echo $hammer->getHT('timestamp')?>" aria-labelledby="lz-drawer<?php echo $hammer->getHT('timestamp')?>Label">
	<div class="offcanvas-header">
		<h5 id="lz-drawer<?php echo $hammer->getHT('timestamp')?>Label">AudioAtlas</h5>
	<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body" style="height:100%">
			<iframe src="//liszt.app/zz-loading.php" frameborder="0" style="height:99%; width:100%; overflow:hidden;overflow-x:hidden;overflow-y:hidden;" id="lz-drawer<?php echo $hammer->getHT('timestamp');?>iframe"></iframe>
	</div>
</div>

<?php require_once "/var/www/liszt.cloud/templates/footer-scripts.php"; ?>

</body>
</html>