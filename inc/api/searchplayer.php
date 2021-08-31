<?php require_once "core.php"; header('Content-type: application/json');
$player = htmlspecialchars($_GET['p']);
$statSrch = "http://halostats.click/privateapi/searchPlayers?name=".$player."";
$statsSrch = get_url($statSrch);
print_r($statsSrch);
?>