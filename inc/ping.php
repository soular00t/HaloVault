<?php require_once "core.php";
if ($_SERVER['REMOTE_ADDR'] != "172.3.194.51" && $_SERVER['REMOTE_ADDR'] != "::1" && $_SERVER['REMOTE_ADDR'] != "127.0.0.1") {
	captureLog(); 
}
?>