<?php
session_start();
$_SESSION['uname'] = "";
$_SESSION['uid'] = "";
$_SESSION['group'] = "";
$_SESSION['email'] = "";
$_SESSION['password'] = "";
$_SESSION['alias'] = "";
session_destroy();
header('location: index.php');
?>