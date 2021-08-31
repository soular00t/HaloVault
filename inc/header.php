<?php header('Content-Type: text/html; charset=utf-8');

if ($_SERVER['HTTP_HOST'] == "halovau.lt") {
	die("<center><img style='margin:0 auto;' src='/css/images/domainGone.png' /><p>Redirecting to proper domain..</p></center><meta http-equiv='refresh' content='3;url=//haloshare.org' />");
}
$icon = "/favicon.ico";

$_BASEURL = $_SERVER['REQUEST_URI'];
$_TITLE = "Build, Browse, Share";
if (stripos($_BASEURL, "/forg") !== FALSE) { $_TITLE = "Forged Maps"; }
if (stripos($_BASEURL, "/community") !== FALSE) { $_TITLE = "Community"; }
if (stripos($_BASEURL, "/users") !== FALSE OR stripos($_BASEURL, "/u/") !== FALSE) { $_TITLE = "Members"; }
if (stripos($_BASEURL, "/media") !== FALSE) { $_TITLE = "Media"; }
if (stripos($_BASEURL, "/file") !== FALSE) { $_TITLE = "Files"; }
if (stripos($_BASEURL, "/r00t/") !== FALSE) { $_TITLE = "Administration"; }
if (stripos($_BASEURL, "/m0d/") !== FALSE) { $_TITLE = "Moderation"; }
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<base href="http://haloshare.org/" />
		<link rel="SHORTCUT ICON" href="<?=$icon;?>" />
		<title>HaloVault | <?=$_TITLE;?></title>
		<META NAME="description" CONTENT="Welcome to HaloVault. This is a place for users to gather and share Halo Online related information and content." />
		<link rel='stylesheet' type='text/css' href='/css/mention.css' />
		<link rel="stylesheet" href="/js/vader-jquery-ui.css"><script src="/js/jquery-3.1.0.js"></script>
		<script src="/js/jquery-3.1.0.min.js"></script><script src="/js/jquery-ui.js"></script>
		<link rel="stylesheet" href="/css/bootstrap.min.css" />
		<script src="//cdn.jsdelivr.net/fingerprintjs2/1.4.1/fingerprint2.min.js"></script>
		<?php
if (!isset($_GET['theme'])) {
	if (isset($_USER['id'])) { 
		echo "<link rel='stylesheet' type='text/css' href='/css/".$_USER['theme'].".css' />";
	}
	else {
		if (isset($_SESSION['theme']) && $_SESSION['theme'] == 'b') {  echo "<link rel='stylesheet' type='text/css' href='/css/b.css' />"; }
		elseif (isset($_SESSION['theme']) && $_SESSION['theme'] == 'g') {  echo "<link rel='stylesheet' type='text/css' href='/css/g.css' />"; }
		elseif (isset($_SESSION['theme']) && $_SESSION['theme'] == 'y') {  echo "<link rel='stylesheet' type='text/css' href='/css/y.css' />"; }
		elseif (isset($_SESSION['theme']) && $_SESSION['theme'] == 'sm') {  echo "<link rel='stylesheet' type='text/css' href='/css/sm.css' />"; }
		elseif (isset($_SESSION['theme']) && $_SESSION['theme'] == 'o') {  echo "<link rel='stylesheet' type='text/css' href='/css/o.css' />"; }
		elseif (isset($_SESSION['theme']) && $_SESSION['theme'] == 'bb') {  echo "<link rel='stylesheet' type='text/css' href='/css/bb.css' />"; }
		else {  echo "<link rel='stylesheet' type='text/css' href='/css/o.css' />"; }
	}
} else { echo "<link rel='stylesheet' type='text/css' href='/css/".htmlspecialchars($_GET['theme']).".css' />"; }
		?>
		<style type='text/css'>
			.ui-dialog-title { 
				font-size:13px !important;
			} 
			.ui-dialog {
				min-width:400px !important; 
			}
			.dialog {
				display:none;
			}
		</style>

		<script type="text/javascript">
			function toggle_visibility(id) {
				var e = document.getElementById(id);
				if(e.style.display == 'block')
					e.style.display = 'none';
				else
					e.style.display = 'block';
			}
			function toggle_tr(id) {
				var e = document.getElementById(id);
				if(e.style.display == 'table-row')
					e.style.display = 'none';
				else
					e.style.display = 'table-row';
			}
			function selectTextarea(tarea, startPos, endPos) { 
				if(typeof(tarea.selectionStart) != "undefined") {
					tarea.focus();
					tarea.selectionStart = startPos;
					tarea.selectionEnd = endPos;
					return true;
				}

				// IE
				if (document.selection && document.selection.createRange) {
					tarea.focus();
					tarea.select();
					var range = document.selection.createRange();
					range.collapse(true);
					range.moveEnd("character", endPos);
					range.moveStart("character", startPos);
					range.select();
					return true;
				}

				return false;
			}
			function wrapText(elementID, openTag, closeTag) {
				var textArea = document.getElementById(elementID);

				if (typeof(textArea.selectionStart) != "undefined") {
					var select_start = textArea.selectionStart;
					var select_end = textArea.selectionEnd;
					var begin = textArea.value.substr(0, textArea.selectionStart);
					var selection = textArea.value.substr(textArea.selectionStart, textArea.selectionEnd - textArea.selectionStart);
					var end = textArea.value.substr(textArea.selectionEnd);
					textArea.value = begin + openTag + selection + closeTag + end;
					selectTextarea(textArea, (select_start + openTag.length), (select_end + closeTag.length - 1));
				}
			}
			function changeValue(o){
				document.getElementById('tagged').value=o.innerHTML;
			}
			$(document).ready(function() {

				if(window.location.href.indexOf('#report') != -1) {
					$( "#dialog888888" ).dialog();
				}
				if(window.location.href.indexOf('#donate.bitcoin') != -1) {
					$( "#dialog888889" ).dialog();
				}
				if(window.location.href.indexOf('#donate.paypal') != -1) {
					$( "#dialog888889" ).dialog();
				}
				if(window.location.href.indexOf('#donate') != -1) {
					$( "#dialog888889" ).dialog();
				}

			});
		</script>
<script type="text/javascript">
	//<![CDATA[
	function __processURL(target) {
		var e = document.getElementById(target);
		if (e) {
			var url = $(e.options[e.selectedIndex]).attr("data-url");
			if (url) {
				location.href = url;
			}
		}
	}
	//]]>
</script>
		<?php
if (isset($_POST['tswitch'])) { 
	$_SESSION['theme'] = htmlspecialchars($_SQL->real_escape_string($_POST['theme']));
	if (empty($_POST['theme'])) { $_SESSION['theme'] = 'y'; echo "<script>alert('ITS EMPTY?');</script>"; }
	if (isset($_USER['id'])) {
		$_SQL->query("UPDATE users SET theme='".$_SESSION['theme']."' WHERE id = '".$_USER['id']."'");
	}
	echo "<script>location = window.location;</script>";
} ?>
		</div>
	</head>
<body>
	<div style="display:none;">
		<script type="text/javascript">
			var images = new Array()
			function preload() {
				for (i = 0; i < preload.arguments.length; i++) {
					images[i] = new Image()
					images[i].src = preload.arguments[i]
				}
			}
			preload(
				"/css/images/hbg/guardian.jpg",
				"/css/images/hbg/diamondback.jpg",
				"/css/images/hbg/valhalla.jpg",
				"/css/images/hbg/reactor.jpg",
				"/css/images/hbg/highground.jpg",
				"/css/images/hbg/thepit.jpg",
				"/css/images/hbg/flatgrass.jpg",
				"/css/images/hbg/icebox.jpg", 
				"/css/images/hbg/narrows.jpg",
				"/css/images/hbg/lastresort.jpg",
				"/css/images/hbg/edge.jpg",
				"/css/images/hbg/sandtrap.jpg",
				"/css/images/h2/panel.png"
			)
		</script>
		<script src="/js/jquery.are-you-sure.js"></script>
		<form style='display:none;' method='post' id='2manyposts'>
			<input type='text' name='2manymotherfuckingpostsbiotch' />
		</form>
	</div>
	<?php if (!empty($_POST['2manymotherfuckingpostsbiotch'])) { die("No Spam Bots Allowed!"); } ?>	
	<div class='wrapper'>
		<div class='banner' title="Banners created by Cuuube, Stick, & Teh0xes."><div style='float:right; margin-right:30px; margin-top:-35px;'><h1>HaloVault</h1></div></div>
		<div class='nav'>
			<a href='/'><div class='navButton'>HOME</div></a>
			<a href='/forge'><div class='navButton'>FORGE</div></a>
			<a href='/community'><div class='navButton'>COMMUNITY</div></a>
			<a href='/files'><div class='navButton'>FILES</div></a>
			<a href='/media.php'><div class='navButton'>MEDIA</div></a>
		</div>
		<div class='inner-wrapper'>
			<div class='sidebar'>
				<br /><div class='innerSidebar'><?php include_once "search_form.php"; ?></div>
				<div class='innerSidebar'><?php include_once "auth.php"; ?></div>
				<div class='innerSidebar'><?php include_once "activity.php"; ?></div>
				<div class='innerSidebar'><?php include_once "xtra.php"; ?></div>

			</div>