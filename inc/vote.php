<?php include_once "core.php";
	$checkifVoted = $_SQL->query("SELECT * FROM notifications WHERE forge_id = '".$_GET['id']."' AND type = 'vote' AND from_id = '".$_USER['id']."'");
	$voteCount = $checkifVoted->num_rows;
	echo $voteCount;
?>