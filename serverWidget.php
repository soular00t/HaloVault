<?php require_once "inc/core.php"; 
if (isset ($_GET['ip'])) {
	echo "<html><head>";
	$ip = str_replace(':11775', '', $_GET['ip']);
	if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') $ip = '127.0.0.1';
	$ip2 = str_replace('http://', '', $ip);
	$serverIP = htmlspecialchars($ip2).":11775"; 
	$dews = get_url("http://".$serverIP."");
	$dewServer = json_decode($dews, 1);
	$font="'Rubik'"; 
	if (isset($_GET['font'])) { $font=htmlspecialchars($_GET['font']); }
	$fontColor="white"; 
	if (isset($_GET['color'])) { $fontColor="#" . htmlspecialchars($_GET['color']); }

	$dewStatus1 = str_replace('InGame', 'Playing', $dewServer['status']);
	$dewStatus = str_replace('InLobby', 'Waiting in lobby', $dewStatus1);
	$bgIMG = "/css/images/maps/".$dewServer['mapFile'].".jpg";
	$bg2IMG = "/css/images/variants/".$dewServer['variantType'].".png";
	$checkMaps = $_SQL->query("SELECT * FROM maps WHERE `title` LIKE '%".$_SQL->real_escape_string($dewServer['map'])."%' OR `title` LIKE '%".$_SQL->real_escape_string($dewServer['map'])."%' LIMIT 1") or die($_SQL->error);
	$map=$checkMaps->fetch_assoc(); $mapImg=$map['img'];
	if ($checkMaps->num_rows > 0 && isImage($mapImg)) { $bgIMG = $mapImg; }
	$pCount = "0/0"; $host = "".htmlentities($dewServer['hostPlayer'])."";
	$title1 = htmlentities($dewServer['name']);
	$title = str_ireplace(' - Fixed Physics, Spectating, Object Cleanup', ' 🎲🎮', $title1);
	$inRotation = "<i>".$dewStatus." <u>".$dewServer['variant']."</u> on <u>".$dewServer['map']."</u></i>";
	if (is_numeric($dewServer['maxPlayers'])) {
		$pCount = "".$dewServer['numPlayers']."/".$dewServer['maxPlayers']."";
	}
	$generalGame = "".ucwords($dewServer['variantType'])." on ".ucwords(str_replace('s3d_', '', $dewServer['mapFile']))."";
	if ($dewServer['hostPlayer'] == FALSE) {
		$host = "ElDewrito";
		$title = "{ OFFLINE }</h2><span style='font-size:8px;'>be back soon</span>";
		$inRotation = "<i>Waiting for server administrator..</i>";
		$generalGame ='';
		$bgIMG = "/css/images/maps/undefined.png";
	}
	?>
	<style>
		@font-face {
			font-family: 'Rubik';
			src: url('//halovau.lt/css/fonts/Rubik-Regular.ttf') format('truetype');
		}
		tr.td {width:33%!important;}
		tr.td, div {border-radius:7px;}
		div.norad {border-radius:0px;}
		body, table, div, td, tr {font-size:10px!important; overflow:hidden!important;}
	</style>	 
	</head>
	<body>
		<?php
	echo "<div style='background:url(".$bgIMG."); background-size:100% 100%; min-height:170px;'>
<div title='If your game is open, click a server to join.' onClick=\"dew.send('server.connect ".$serverIP."');\" style=\"text-align:center; font-family:".$font.", Arial; width:100%; cursor:url('/css/images/hoSmall_cursor.png'), pointer; border-radius:7px; background-image:url(".$bg2IMG."); background-size:50% 90%; background-repeat:no-repeat; background-position:center center; color:".$fontColor."; font-size:12px;\">
<div style='display:flex; align-items:center; justify-content:center; paddin:2px; top:0px; min-width:100%; background-color:rgba(0,0,0, 0.7); font-size:11px; text-align:center!important; font-weight:bold; border-bottom-left-radius:0px; border-bottom-right-radius:0px;'>
<table width='100%' style='padding-left:4px; padding-right:4px; color:".$fontColor."'><tr><td>👤 ".$pCount." players online</td>
<td style='text-align:right;'>🖥 hosted by ".$host."</td></tr></table></div>
<div class='norad' style='text-shadow:0px 0px 9px black; padding:6px; margin-top:40px; background:rgba(255,255,255, 0.1); text-align:center;'>
<h2>".$title."</h2><span style='font-size:8px;'>".$generalGame."</a>
</div>
<div style='text-align:center; padding:1px; font-size:11px; float:bottom; margin-top:40px; background:rgba(0,0,0, 0.7); border-top-left-radius:0px; border-top-right-radius:0px;'>
<b>".$inRotation."</b></div>
</div>
</div>
</div>";
} 
elseif (!isset($_POST['srvSubmit'])) {
	include_once "inc/header.php";
	echo "<div class='content'><div class='contentHeader'>Services</div><h3>Server Widget</h3>
	<div class='contentHolder'>
	<form method='post'><table style='width:100%;'>
	<tr><td>Server IP:</td><td><input type='text' name='ip' placeholder=\"ex: ".$_SERVER['REMOTE_ADDR']."\" /></td></tr>
	<tr><td>Font:</td><td><input type='text' name='font' placeholder=\"ex: Times New Roman\" /></td></tr>
	<tr><td>Color:</td><td><input type='text' name='color' placeholder=\"ex: FFFFFF\" /></td></tr>
	<tr><td>Height:</td><td><input type='text' name='height' placeholder=\"ex: 150px or 80%\" value='195px' /></td></tr>
	<tr><td>Width:</td><td><input type='text' name='width' placeholder=\"ex: 200px or 100%\" value='300px' /></td></tr>
	<tr><td></td><td><input type='submit' value='Create Widget' name='srvSubmit' /></form></td></tr></table></div></div>";
	include_once "inc/footer.php";
} 
else {
	include_once "inc/header.php";
	$font = htmlspecialchars($_POST['font']);
	$color = htmlspecialchars($_POST['color']);
	$ip = htmlspecialchars($_POST['ip']);
	$h = htmlspecialchars($_POST['height']);
	$w = htmlspecialchars($_POST['width']);
	echo "<div class='content'><div class='contentHeader'>Services</div>
	You widget has been generated! A preview, along with an embedable code are available below: 
	<h3>Server Widget</h3><div class='contentHolder'><span style='font-size:10pt;'>Please note, we do not check if the information you entered was accurate. 
	If your widget doesnt show below, try submitting the form <a href='serverWidget.php'>again</a></span>
	<hr /><b>Preview:</b><br />
	<center><iframe style=\"border:none;\" src=\"http://halovau.lt/serverWidget.php?ip=".$ip."&color=".$color."&font=".$font."\" width=\"".$w."\" height=\"".$h."\"></iframe></center>
	<hr style='border:1px dashed grey; opacity:0.3;' /><b>Code:</b>
	<textarea><iframe style=\"border:none;\" src=\"http://halovau.lt/serverWidget.php?ip=".$ip."&color=".$color."&font=".$font."\" width=\"".$w."\" height=\"".$h."\"></iframe></textarea>
	</div></div>";
	include_once "inc/footer.php";
}	?> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.4.0/codemirror.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.4.0/mode/javascript/javascript.min.js"></script>
		<script src="/js/dewSocket.js"></script>
		<script type='text/javascript'>var dew = new dewWebSocket(true);</script></body></html>