<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Access-Control-Allow-Methods: GET, HEAD");
header("Access-Control-Allow-Origin: *");
header("Pragma: no-cache");
?>
<?php
	use MicrosoftAzure\Storage\Blob\BlobRestProxy;
	use MicrosoftAzure\Storage\Common\ServiceException;
require_once "/var/www/api.ntfg.net/htdocs/hammer/hammer.php";
$hammer = new Hammer;
$hammer->setHS(1);
//FOR VARIABLES (currently in use)
//https://liszt.me/audio/?platform=audioatlas&player=1&title=Pipe%20Dreams&name=Kyle%20Vanderburg&file=EGR7W5GIXNIR4V9CBXFFP4TEL
$platform = $_GET['platform'];
$player = $_GET['player'];
$title = $_GET['title'];
$name = $_GET['name'];
$file = $_GET['file'];

$intplat = ""; $bucket = "files.liszt.me";

//Find the record from Central Permissions via hash2, and pull the info
$dox = new david_document($hammer);

if($hammer->isGUID($file)){
	$filerow = $dox->getByGUID($file);
}else{
	$filerow = $dox->getByHash($file);
}

if(!empty($filerow)){
//Assemble the download link
$file = $hammer->unsanitize($filerow['intfile']);
$public = $hammer->unsanitize($filerow['filename']);
// $url = S3::getAuthenticatedURL($bucket, $intplat.$file, 3600, true); //first true is for custom cname
// $url = S3::getAuthenticatedURL($bucket, $file, 3600, false, true);

	// Generate Shared Access Signature
		$sasHelper = new \MicrosoftAzure\Storage\Blob\BlobSharedAccessSignatureHelper("liszt", $hammer->msKey);
		$sas = $sasHelper->generateAccountSharedAccessSignatureToken(
			'2018-11-09',
			'rwl',
			'b',
			'sco',
			(new \DateTime())->modify('+10 minute'),
			(new \DateTime())->modify('-5 minute'),
			'',
			'https'
		);

$url = "https://liszt.blob.core.windows.net/liszt-files/". $dox->row['guid']."/".$dox->row['filename']."?".$sas;

?>
<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title>NoteForge Audio Player</title>
<!--  <link rel="stylesheet" type="text/css" media="all" href="css/styles.css">-->
  <script type="text/javascript" src="<?php echo $hammer->getCDN();?>noteforge-audio/js/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="<?php echo $hammer->getCDN();?>noteforge-audio/js/mediaelement-and-player.min.js"></script>
  <style>
  /** audio player styles **/
body, .audio-player, .audio-player div, .audio-player h2, .audio-player a, .audio-player span, .audio-player button {
  margin: 0;
  padding: 0;
  border: none;
  outline: none;
}

.vandermedia-player {
  border: 1px solid #000;
  display:inline;
  position: absolute;
  width: 520px;
  height: 70px;
  margin: 0 auto;
  background: #222;
}

.album-cover{
position:absolute;
height:70px;
width:70px;
}

.album-cover img{
position:absolute;
width:70px;
}

.audio-player {
  position: absolute;
  left:70px;
  width: 450px;
  height: 70px;
  margin: 0 auto;
}

.audio-player h2 {
  position: absolute;
  top: 2px;
  left: 10px;
  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-weight: bold;
  font-size: 16px;
  color: #ececec;
}

.audio-player h3 {
  position: absolute;
  top: 8px;
  left: 10px;
  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-weight: normal;
  font-size: 10px;
  color: #ececec;
}

/* play/pause control */
.mejs-controls .mejs-button button {
  cursor: pointer;
  display: block;
  position: absolute;
  text-indent: -9999px;
}

.mejs-controls .mejs-play button, .mejs-controls .mejs-pause button {
  width: 34px;
  height: 34px;
  top: 33px;
  left: 6px;
  background: transparent url('/audio/css/playpause.png') 0 0 no-repeat;
}
.mejs-controls .mejs-pause button { background-position: 0 -35px; }
 
 
/* mute/unmute control */
.mejs-controls .mejs-mute button, .mejs-controls .mejs-unmute button {
  width: 18px;
  height: 19px;
  top: 9px;
  right: 122px;
  background: transparent url('/audio/css/audio.png') 0 0;
}
.mejs-controls .mejs-unmute button { background-position: 0 -19px; }


/* volume scrubber bar */
.mejs-controls div.mejs-horizontal-volume-slider {
  position: absolute;
  top: 13px;
  right: 15px;
  cursor: pointer;
}

.mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total {
  width: 100px;
  height: 11px;
  background: #565860;
}

.mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current {
  position: absolute;
  width: 0;
  height: 9px;
  top: 1px;
  left: 1px;
  background: #007700;
}


/* time scrubber bar */
.mejs-controls div.mejs-time-rail { width: 380px; }
 
.mejs-controls .mejs-time-rail span {
  position: absolute;
  display: block;
  width: 380px;
  height: 12px;
  top: 40px;
  left: 55px;
  cursor: pointer;
}
 
.mejs-controls .mejs-time-rail .mejs-time-total { 
  background: #565860; 
  width: 380px !important; /* fixes display bug using jQuery 1.8+ */
}
.mejs-controls .mejs-time-rail .mejs-time-loaded {
  top: 0;
  left: 0;
  width: 0;
  background: #7b7d82;
}
.mejs-controls .mejs-time-rail .mejs-time-current {
  top: 0;
  left: 0;
  width: 0;
  background: #007700;
}

/* metallic sliders */
.mejs-controls .mejs-time-rail .mejs-time-handle {
  position: absolute;
  display: block;
  width: 20px;
  height: 22px;
  top: -6px;
  background: url('/audio/css/handle-lg.png') no-repeat;
}
.mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-handle {
  position: absolute;
  display: block;
  width: 12px;
  height: 14px;
  top: -1px;
  background: url('/audio/css/handle-sm.png') no-repeat;
}


/* time progress tooltip */
.mejs-controls .mejs-time-rail .mejs-time-float {
  position: absolute;
  display: none;
  width: 33px;
  height: 23px;
  top: -26px;
  margin-left: -17px;
  z-index: 9999;
  background: url('/audio/css/time-box.png');
}
 
.mejs-controls .mejs-time-rail .mejs-time-float-current {
  width: 33px;
  display: block;
  left: 0;
  top: 4px;
  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 10px;
  font-weight: bold;
  color: #666;
  text-align: center;
  z-index: 9999;
}

.anvil {
  position: absolute;
  top: 52px;
  left: 427px;
  opacity: 0.6;
}
.anvil:hover {
opacity: 0.9;
}

/** clearfix **/
.clearfix:after { content: "."; display: block; clear: both; visibility: hidden; line-height: 0; height: 0; }
.clearfix { display: inline-block; }
 
html[xmlns] .clearfix { display: block; }
* html .clearfix { height: 1%; }
  </style>
  
</head>
<body>
	<div class="vandermedia-player">
	<?php
	//Album Art
	if($platform=="audioatlas"){$albumart = "/audio/media/album-audioatlas.png";}
	elseif($platform=="scoreshare"){$albumart = "/audio/media/album-scoreshare.png";}
	else{$albumart = "/audio/media/vanderseal.png";}
	?>
	  <div class="album-cover"><img src="<?php echo $albumart?>" alt="<?php echo $title . " by " . $name; ?>"></div>
      <div class="audio-player">
        <h2><?php echo $hammer->truncate($title, 38, TRUE);?></h2>
		<h3><?php echo $hammer->truncate($name, 57, TRUE);?></h3>
        <audio id="audio-player" src="<?php echo $url;?>" type="audio/mp3" controls="controls"></audio>
		<a href="javascript:location.refresh()">.</a><div class="anvil"><a href="http://liszt.me"><img src="/audio/css/anvil.png" class="lisztlogo" alt="Liszt"></a></div>
      </div><!-- @end .audio-player -->
    </div>

<script type="text/javascript">
$(function(){
  $('#audio-player').mediaelementplayer({
    alwaysShowControls: true,
    features: ['playpause','progress','volume'],
    audioVolume: 'horizontal',
    audioWidth: 450,
    audioHeight: 70,
    iPadUseNativeControls: true,
    iPhoneUseNativeControls: true,
    AndroidUseNativeControls: true
  });
});


document.write(Date.now());
</script>
<?php echo time();?>
</body>
</html>
<?php }else{echo "File not found";}?>