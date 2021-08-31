<?php header('Content-type: application/json; charset=utf8'); header("Access-Control-Allow-Origin: *");
require_once "../core.php"; error_reporting(E_ALL & ~E_NOTICE);
if (isset($_GET['u']) && preg_match('/^[a-z0-9.\-\_]+$/i', $_GET['u'])) { 
	$sql = $_SQL->query("SELECT id as id, uname as uname, alias as alias, avatar as avatar FROM `users` WHERE `uname` LIKE '%{$_GET['u']}%' OR `alias` LIKE '%{$_GET['u']}%' ORDER BY id") or die($_SQL->error);	
	if ($sql->num_rows < 1) { $sql = $_SQL->query("select uname as uname, alias as alias, avatar as avatar from `users` ORDER BY id ASC"); }
	while ($MEMBERS = $sql->fetch_assoc()) {
		$_MEMBERS[] = $MEMBERS;
	}
}
else { 
	$sql = $_SQL->query("select id as id, uname as uname, alias as alias, avatar as avatar from `users` ORDER BY id ASC") or die($_SQL->error);
	while ($MEMBERS = $sql->fetch_assoc()) {
		$_MEMBERS[] = $MEMBERS;
	}
}
$membersJson = json_encode($_MEMBERS, JSON_PRETTY_PRINT);
$membersJson = str_replace("\\/", "/", $membersJson);
print_r($membersJson);
?>