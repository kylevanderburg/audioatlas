<?php
/*
Hammer Music Management System V. 2
	by Kyle Vanderburg, in Poplar Bluff and Springfield, Missouri, and Norman, OK.
Hammer Download Clearinghouse Page
download.php last modified 1/26/11 KV
This code takes download links from http://download.noteforge.com/hash1/hash2/, determines permissions, and delivers files.
Debuted on November 30, 2007, at www.kyledavey.com/blink.  Went live December 2, 2007.
All code copyright 2011 Kyle Vanderburg

This code is a module that requires the BLINK Core in order to fully work. 
*/
if (isset($_GET['e'])){ini_set('display_errors',1); error_reporting(E_ALL);}
$platform = $_GET['platform'];
$file = $_GET['file'];

// echo $platform;
// echo $file;

//Load the Hammer Core, set the site config variable, and connect.
require_once "/var/www/api.ntfg.net/htdocs/hammer/hammer.php";
$hammersite = 1;
$hammer = new Hammer;

if($platform=="audioatlas"){$intplat = "audioatlas"; $platdb = $hdb['audioatlas-data'];}
elseif($platform=="scoreshare"){$intplat = "scoreshare-files"; $platdb = $hdb['scoreshare-files'];}
elseif($platform=="webfiles"){$intplat = "hammer-webfiles"; $platdb = $hdb['webfiles'];}

$query = "SELECT * FROM " . $platdb . " WHERE (hash = '{$file}')";
$result = $slacktub->query($query) or die(mysql_error());
$filerow = $result->fetch_array() or die("Invalid Download Link!");

//Assemble the download link
$file = $hammer->unsanitize($filerow['intfile']);
$public = $hammer->unsanitize($filerow['filename']);
// echo $intplat;
// $url = "http://vise.noteforge.com/".$intplat."/";
// $file = str_replace(" ", "%20", $file);
// $url = $url . $file;
$url = S3::getAuthenticatedURL("vise.noteforge.com", $intplat."/".$file, 3600, true);
// echo $url;
$headers = get_headers($url); //content-type 8

//OOOOOK let's figure out if this thing needs some header massage. If it's an MP3, it has to change to Content-Type: audio/mpeg
$extension = substr(pathinfo($url, PATHINFO_EXTENSION), 0, 3);
// echo $extension . ";";
if($extension=="mp3" OR $extension=="MP3"){$headers[6]="Content-Type: audio/mpeg";}
// if($extension=="pdf" OR $extension=="PDF"){$headers[6]="Content-type:application/pdf";}

/* THIS IS NEEDED IF WE GO TO GAAAAANDI! //(Well maybe not. Is working where it is now)
function get_headers_curl($url) 
 { 
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,            $url); 
    curl_setopt($ch, CURLOPT_HEADER,         true); 
    curl_setopt($ch, CURLOPT_NOBODY,         true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_TIMEOUT,        15); 
    $r = curl_exec($ch); 
    $r = split("\n", $r); 
    return $r; 
 }
$headers = get_headers_curl($url);
 */
// print_r($headers); //content-type 4

//Deliver the file
// header("Cache-Control: public");
// header("Content-Description: File Transfer");
// header("Content-Disposition: attachment; filename=$file");
// header($headers[6]); //determines Content-Type: //8 for Anvil, 6 for S3
// header("Content-Transfer-Encoding: binary");
// readfile($url);

header("Location: ".$url);

// }else {echo "Expired Link.";}
// }else {echo "Internal Hash Corrupt.";}
// }else {echo "Hash Corrupt.";}
?>