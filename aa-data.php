<?php 
//Load the NoteForge Hammer Core to connect to DB and load important functions.
require_once "/var/www/api.ntfg.net/htdocs/hammer/hammer.php";
$hammer = new Hammer;
$hr = new audioatlas_datapoint($hammer);
$hammer->setSystem();
foreach($hr->systemq() as $dp){
	$content = "{
    \"type\": \"Feature\",
    \"properties\": {
        \"name\": \"".$dp['name']."\",
        \"show_on_map\": true,
		\"popupContent\": \"".$dp['loc']."\",
		\"fileguid\": \"".$dp['guid']."\"
    },
    \"geometry\": {
        \"type\": \"Point\",
        \"coordinates\": [".$dp['lon'].", ".$dp['lat']."]
    }
	}";
	$array[] = $content;
}
echo "[".implode(", ",$array)."]";
$hammer->unsetSystem();
?>