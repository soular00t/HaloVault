<?php include_once "../inc/core.php";
include_once "../inc/header.php";
echo "<div class='content'><div class='contentHeader'>Moderation</div><a href='javascript:window.history.back;'>⟵ Back</a>
<script>
function changesSaved() {
    alert('Changes have been saved!');
}
</script>";
if (isset($_SESSION['uid']) && $_USER['group'] > 1) {
	$modPanel = "<form method='post'>"
	."<h3>Dedicated Server Management</h3><div class='contentHolder'>"
	."<ul><li><a href='bans.php' title='Lizard smells really bad.'>Banlist Moderation</a></li></ul>"
	."</div><br /><br />
	<h3>Extra/More</h3><div class='contentHolder'>
	<ul><li><a class='dialog_link' data-dialog='dialog23456' href='javascript:void();'>RCON</a></div></li></ul>
	<div class='dialog' id='dialog23456' title=''><iframe src='http://rabidsquabbit.github.io/' width='750' height='800'></iframe></div>";
	echo $modPanel;
} else { echo "<span style='color:red;'>You are not authorized see this content. Only an <b>administrator or moderator</b> may perform this action.</span><br />"; }
echo "</div>";
include_once "../inc/footer.php";
?>