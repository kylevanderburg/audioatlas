<?php
require_once "/var/www/liszt.cloud/hammer/hammer.php";
$platform = $_GET['platform'];
$player = $_GET['player'];
$title = $_GET['title'];
$name = $_GET['name'];
$file = $_GET['file'];
$time = time();
// hash = Platform,player,title,Name,File

if (!isset($_GET['e'])){ini_set('display_errors',1); error_reporting(E_ALL);}

$string = $platform."||".$player."||".$title."||".$name."||".$file;

// $serialized = serialize($array);
$encoded = base64_encode($string);
$encoded = str_replace("=","",$encoded);
$encoded = strrev($encoded);
$encoded = base64_encode($encoded);
$encoded = str_replace("=","",$encoded);

echo $encoded;
echo "<br />";
$decoded = base64_decode($encoded);
$decoded = strrev($decoded);
$decoded = base64_decode($decoded);

echo $decoded . "<br />";

$data = explode("||", $decoded);
echo $data[0];

?>