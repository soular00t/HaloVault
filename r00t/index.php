<?php include_once "../inc/core.php";
include_once "../inc/header.php";
echo "<div class='content'><div class='contentHeader' style='cursor:pointer;' onclick=\"location='/r00t';\">Administration</div>";
if (isset($_SESSION['uid']) && $_USER['group'] == 3) {
	$fpquery = $_SQL->query("SELECT * FROM frontpage WHERE id = '1'") or die($_SQL->error);
	$fp = $fpquery->fetch_assoc();
	$adminPanel = "<a href='../m0d'><div style='background-color:#acc4f2; padding:5px; text-align:center; margin-top:-70px; color:black; float:right;'>🔩 Moderation Panel</div></a>
	<form method='post'>
	<h3>Management</h3><div id='contentHolder' class='contentHolder'><br />
	<ul><li style='text-decoration:underline; list-style:none;'>WWW</li>
	<li><a href='IC3' target='_blank'>ICEcoder</a></li>
	</ul><br />
	<ul><li style='text-decoration:underline; list-style:none;'>Database</li>
	<!--<li><a href='/phpmyadmin' target='_blank'>phpMyAdmin</a></li>-->
	<li><a href='passHash.php'>Passwords</a></li>
	<li><a href='adminer.php' target='_blank'>Adminer</a></li>
	</ul><br />
	<ul><li style='text-decoration:underline; list-style:none;'>FileShare</li>
	<li><a href='/inc/api/clean.api?screenshots'>Screenshot Cleanup</a></li>
	<li><a href='/inc/api/clean.api?maps'>Forge Map Cleanup</a></li>
	<li><a href='/inc/api/clean.api?variants'>Gametype Cleanup</a></li>
	</ul>
	</div><br /><br />\n
	<h3>Front Page</h3><div id='contentHolder' class='contentHolder'>
	<textarea cols='80%' rows='15' name='frontpage'>".$fp['content']."</textarea>
	<br /><input type='submit' name='submit' onclick=\"alert('Changes have been saved!');\" value='Save Changes' /></form></div>";
	if (isset($_POST['submit'])) {
		$content = $_SQL->real_escape_string($_POST['frontpage']);
		$_SQL->query("UPDATE frontpage set content='".$content."', last_user='{$_USER['id']}' WHERE id = '1'") or die($_SQL->error);
		echo "<meta http-equiv='refresh' content='0;' />";
	} else { print_r($adminPanel); }
} else { echo "<span style='border:1px solid red; color:black; background-color:#E8C1B9; text-align:center; padding:2px;'>You are not authorized see this content. Only an <b>administrator</b> may perform this action.</span><br />"; }
echo "</div>";
include_once "../inc/footer.php";
?>