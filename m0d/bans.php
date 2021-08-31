<?php include_once "../inc/core.php";
include_once "../inc/header.php";
echo "<div class='content'><div class='contentHeader'>Banlist Moderation</div>
<a target='_blank' title='Username: m0derator \nPassword: vaultMod ' href='/phpmyadmin/index.php?db=main&table=dedibans'>&#9998; Manage</a>
<h3>Player Reports</h3><div class='contentHolder'>";
echo "<div class='notList' id='notList' data-load-more='20'>";
if (isset($_SESSION['uid']) && $_USER['group'] > 1) {
	$noIPquery = $_SQL->query("SELECT * FROM dedibans ORDER BY id DESC");
	while ($REPORT = $noIPquery->fetch_assoc()) {
		$urSQL = $_SQL->query("SELECT * FROM users WHERE id = '".$REPORT['uid']."'");
		$ur = $urSQL->fetch_assoc();
		echo "<div class='row'><div class='col-md-1'><a href='/users.php?id=".$ur['id']."' title='Click to view senders profile.'><img src='".$ur['avatar']."' width='30' /></a></div><div class='col-md-9'><a title=\"".stripBB(strip_tags($REPORT['reason']))."\">".$ur['uname']." reported <<b>".$REPORT['player']."</b>> for abusive behavior in-game.</a></div><div class='col-md-2' title='".dateConvert2($REPORT['date'])."'>".dateConvert($REPORT['date'])."</div></div>";
		
	} echo "</div><br /><div id='loadMore' class='loadMore' data-action='load-more' data-bound='notList'><a>&#x21bb; <small>Load More</small></a></div>";
} else { echo "<span style='color:red;'>You are not authorized see this content. Only an <b>administrator or moderator</b> may perform this action.</span><br />"; }
echo "</div></div>";
include_once "../inc/footer.php";
?>