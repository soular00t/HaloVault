<?php include_once "inc/core.php";
include_once "inc/header.php";
echo "<div class='content'>";
$frontPageQ = $_SQL->query("SELECT * FROM frontpage WHERE id = '1'"); 
$front = $frontPageQ->fetch_assoc();
echo nl2br($front['content']);
echo "</div>";
include_once "inc/footer.php"; ?>