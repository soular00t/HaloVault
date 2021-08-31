<?php require_once "core.php"; error_reporting(E_ERROR | E_WARNING | E_PARSE); ?>
<html><head><?php
$brainsIP = "98.203.22.190:11775"; 
$brains2IP = "24.96.99.253:11775"; 
$mlgIP = "69.197.155.244:11775"; 
$slayerIP = "73.67.143.125:11775"; 
?>
<style>
@font-face {
	font-family: 'Rubik';
	src: url('/css/fonts/Rubik-Regular.ttf') format('truetype');
}
tr.td, div {border-radius:7px; padding:none;}
body, table, div, td, tr {font-size:10px!important;}
</style>	 
</head>
<body>
<?php
echo "<table title='If your game is open, click a server to join.' style=\"font-family:OCR A Std, 'Rubik'; min-width:100%; font-size:8px;\">
<tr>
	<td style='border-radius:7px; width:33%; background-size:100% 100%; color:white; font-size:12px; height:220px; min-width:80%;'><iframe style=\"border:none; min-width:100%;\" src=\"/serverWidget.php?ip=".$brainsIP."&color=01DF01&font=Comic Sans\" width=\"100%\" height=\"100%\"></iframe></td>"
//	."<td style='border-radius:7px; width:33%; background-size:100% 100%; color:white; font-size:12px; height:195px; min-width:50%;'><iframe style=\"border:none; min-width:100%;\" src=\"/serverWidget.php?ip=".$brains2IP."&color=01DF01&font=arial\" width=\"100%\" height=\"100%\"></iframe></td>"
//	."<td style='border-radius:7px; background-size:100% 100%; color:white; font-size:12px; height:195px; width:33%;'><iframe style=\"border:none;\" src=\"/serverWidget.php?ip=".$ffaIP."&color=00ffff&font=arial\" width=\"100%\" height=\"100%\"></iframe></td>";
//	."<td style='border-radius:7px; width:33%; background-size:100% 100%; color:white; font-size:12px; height:195px; min-width:33%;'><iframe style=\"border:none; min-width:100%;\" src=\"/serverWidget.php?ip=".$slayerIP."&color=FAAC58&font=arial\" width=\"100%\" height=\"100%\"></iframe></td>"
."</tr></table>";

	?> 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.4.0/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.4.0/mode/javascript/javascript.min.js"></script>
	<script src="/js/dewSocket.js"></script>
	<script type='text/javascript'>var dew = new dewWebSocket(true);</script></body></html>