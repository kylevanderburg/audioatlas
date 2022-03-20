<?php

$query=$_GET['query'];
$query = urlencode($query);
$string = "http://open.mapquestapi.com/geocoding/v1/address?key=Fmjtd|luur250an1,8s=o5-9w22l6&callback=&inFormat=kvp&outFormat=json&location=" . $query;
$result = file_get_contents($string);

// echo $result; //JSON Results

$result = json_decode($result, TRUE);

if($_GET['result']==TRUE){print_r($result);}
// echo "<br /><br /><br />";
$lat=$result['results']['0']['locations']['0']['latLng']['lat'];
echo $lat . ",";

$lng=$result['results']['0']['locations']['0']['latLng']['lng'];
echo $lng;

?>