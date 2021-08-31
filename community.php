<?php if (isset($_GET['id']) && $_GET['id'] == '94') { header("Location:files.php?id=28"); } 
if (isset($_GET['id']) && $_GET['id'] == '93') { header("Location:files.php?id=25"); }
if (isset($_GET['id']) && $_GET['id'] == '89') { header("Location:files.php?id=26"); }
include_once "inc/core.php"; error_reporting(E_ALL & ~E_NOTICE);
include_once "inc/header.php"; ?>
<?php
echo "<div class='content'><div class='contentHeader'>Community</div><div style='float:right; border:1px dotted black; padding:2px; background:#333; opacity:0.7; margin-top:-63px;'><a href='users.php'>👤 Registered Users</a></div>";
$NEWbody = ''; $NEWtitle = ''; 
if (isset($_POST['postsubmit'])) { 
	$NEWbody = htmlspecialchars($_POST['info']); 
	$NEWtitle = htmlspecialchars($_POST['title']); 
} 	
$html = "<h3>📰 Post New Topic</h3><div id='contentHolder' id='contentHolder' class='contentHolder'>"
	."<small>&#9874; = Required field.<br /><br />"
	."<small>Please don't post anything insulting. And remember: dont spam!</small><br /><br />"
	."<table><form method='post'>"
	."<tr><td><input type='text' name='title' placeholder='&#9874; Title' value=\"".$NEWtitle."\" /> "
	."<select id=\"flair\" name='flair' onchange=\"javascript: setTimeout('__processURL(\'flair\')', 1)\">
	<option data-url=\"\" value=\"\">⚒ Flair:</option>
	<option data-url=\"\" value=\"general\">General</option>
	<option data-url=\"media.php?new\" value=\"media\">Media</option>
	<option data-url=\"\" value=\"tutorial\">Tutorial</option>
	<option data-url=\"\" value=\"help\">Help</option>
	<option data-url=\"\" value=\"suggestion\">Suggestion</option>
	<option data-url=\"files.php?new\" value=\"download\">Download</option>
	</select></td></tr>"
	."<tr><td><br />".$bbcode_buttons."<textarea cols='100%' rows='15' id='edit' name='info' placeholder=\"&#9874; Enter topic body here. If this post is artwork, screenshots, or video, please post in Media rather than community. If this post is a question, flair it as help. Please try and be polite, and please don't spam.\">".$NEWbody."</textarea></td></tr>"
	."<tr><td><input type='submit' value='Post Thread' name='postsubmit' /></td></tr>"
	."</form></table></div><br /><br />";
$orderBY = "id";
$oForm = "<form method='post' enctype='multipart/form-data'>Order by: <select name='orderBY' onchange=\"location = this.value;\">
<option>date posted</option>
<option value='/community.php?order=la'>last activity</option>
<option value='/community.php?order=views'>views</option>
<option value='/community.php?order=v'>votes</option>
<option value='/community.php?order=r'>responses</option>
</select></form>";
$filterForm = "<form method='post' name='f'>Topic Flair: 
<select name='filter' onchange=\"javascript: setTimeout('__processURL(\'flair\')', 1); this.form.submit();\">
<option data-url=\"\" value=\"\">All</option>
<option data-url=\"\" value=\"general\">General</option>
<option data-url=\"media.php?new\" value=\"media\">Media</option>
<option data-url=\"\" value=\"tutorial\">Tutorial</option>
<option data-url=\"\" value=\"help\">Help</option>
<option data-url=\"\" value=\"suggestion\">Suggestion</option>
<option data-url=\"files.php?new\" value=\"download\">Download</option>
</select></form>";
if (isset($_GET['order']) && $_GET['order'] == 'views') { 
	$oForm = "<form method='post'>Order by: <select name='orderBY' onchange=\"location = this.value;\">
<option>views</option>
<option value='/community.php?order=v'>votes</option>
<option value='/community.php'>date posted</option>
<option value='/community.php?order=la'>last activity</option>
<option value='/community.php?order=r'>responses</option>"
		."</select></form>";
} elseif (isset($_GET['order']) && $_GET['order'] == 'v') { 
	$orderBY = "votes"; 
	$oForm = "<form method='post'>Order by: <select name='orderBY' onchange=\"location = this.value;\">
<option>votes</option>
<option value='/community.php'>date posted</option>	
<option value='/community.php?order=views'>views</option>
<option value='/community.php?order=la'>last activity</option>
<option value='?&order=r'>responses</option>"
		."</select></form>";
} elseif (isset($_GET['order']) && $_GET['order'] == 'r') {
	$orderBY = "replies"; 
	$oForm = "<form method='post'>Order by: <select name='orderBY' onchange=\"location = this.value;\">
<option>responses</option>
<option value='?&order=v'>votes</option>
<option value='/community.php?order=views'>views</option>
<option value='/community.php'>date posted</option>
<option value='/community.php?order=la'>last activity</option>"
		."</select></form>";
} elseif (isset($_GET['order']) && $_GET['order'] == 'la') {
	$orderBY = "updated"; 
	$oForm = "<form method='post'>Order by: <select name='orderBY' onchange=\"location = this.value;\">
<option>last activity</option>
<option value='?&order=r'>responses</option>
<option value='/community.php?order=views'>views</option>
<option value='?&order=v'>votes</option>
<option value='/community.php'>date posted</option>"
		."</select></form>";
}
if (isset($_POST['filter']) && $_POST['filter'] == 'media') { 
	die("<script>location.href='/media.php';</script>");
} 
elseif (isset($_POST['filter']) && $_POST['filter'] == 'download') { 
	die("<script>location.href='/files.php';</script>");
} elseif (isset($_POST['filter']) && $_POST['filter'] == 'general') {
	$filterForm = "<form method='post' name='f'>Flair: 
<select name='filter' onchange=\"javascript: setTimeout('__processURL(\'flair\')', 1); this.form.submit();\">
<option data-url=\"\" value=\"general\">General</option>
<option data-url=\"media.php?new\" value=\"media\">Media</option>
<option data-url=\"\" value=\"tutorial\">Tutorial</option>
<option data-url=\"\" value=\"help\">Help</option>
<option data-url=\"\" value=\"suggestion\">Suggestion</option>
<option data-url=\"files.php?new\" value=\"download\">Download</option>
</select></form>";
} elseif (isset($_POST['filter']) && $_POST['filter'] == 'help') {
	$filterForm = "<form method='post' name='f'>Flair: 
<select name='filter' onchange=\"javascript: setTimeout('__processURL(\'flair\')', 1); this.form.submit();\">
<option data-url=\"\" value=\"help\">Help</option>
<option data-url=\"\" value=\"general\">General</option>
<option data-url=\"media.php?new\" value=\"media\">Media</option>
<option data-url=\"\" value=\"tutorial\">Tutorial</option>
<option data-url=\"\" value=\"suggestion\">Suggestion</option>
<option data-url=\"files.php?new\" value=\"download\">Download</option>
<option value='suggestion'>Suggestions</option>
</select></form>";
} elseif (isset($_POST['filter']) && $_POST['filter'] == 'suggestion') {
	$filterForm = "<form method='post' name='f'>Flair: 
<select name='filter' onchange=\"javascript: setTimeout('__processURL(\'flair\')', 1); this.form.submit();\">
<option data-url=\"\" value=\"suggestion\">Suggestion</option>
<option data-url=\"\" value=\"help\">Help</option>
<option data-url=\"\" value=\"general\">General</option>
<option data-url=\"media.php?new\" value=\"media\">Media</option>
<option data-url=\"\" value=\"tutorial\">Tutorial</option>
<option data-url=\"files.php?new\" value=\"download\">Download</option>
<option value='suggestion'>Suggestions</option>
</select></form>";
} elseif (isset($_POST['filter']) && $_POST['filter'] == 'tutorial') {
	$filterForm = "<form method='post' name='f'>Flair: 
<select name='filter' onchange=\"javascript: setTimeout('__processURL(\'flair\')', 1); this.form.submit();\">
<option data-url=\"\" value=\"tutorial\">Tutorial</option>
<option data-url=\"\" value=\"help\">Help</option>
<option data-url=\"\" value=\"general\">General</option>
<option data-url=\"media.php?new\" value=\"media\">Media</option>
<option data-url=\"\" value=\"suggestion\">Suggestion</option>
<option data-url=\"files.php?new\" value=\"download\">Download</option>
<option value='suggestion'>Suggestions</option>
</select></form>";
} if (!isset($_GET['id']) && $comCount != 0 && !isset($_GET['ec']) && !isset($_GET['change'])) {

	$WHERE = " WHERE public = 'y'"; $filter = $_SQL->real_escape_string(htmlspecialchars($_POST['filter']));
	if (isset($_POST['filter']) && !empty($_POST['filter'])) { $WHERE = " WHERE flair = '".$filter."' AND public != 'n'"; }
	if ($_GET['order'] != "views") { $listComs = $_SQL->query("SELECT * FROM community{$WHERE} ORDER BY ".$orderBY." DESC"); }
	else {	$listComs = $_SQL->query("SELECT c.*, COUNT(v.id) AS views FROM community AS c LEFT JOIN views AS v ON v.com_id=c.id{$WHERE} GROUP BY c.id ORDER BY views DESC") or die($_SQL->error); }
	$comCount = $listComs->num_rows;
	if ($comCount == 0 && !isset($_GET['id']) && !isset($_GET['new'])) {
		echo "There is currently no community posts in the category you selected.<br />Please feel free to <a href='/community.php?new'>post new content</a>. <br /><br />";
}
} /* Edit & Delete Comment */
if (isset($_GET['ec']) && is_numeric($_GET['ec']) && is_numeric($_GET['id'])) {
	$grabcmnt=$_SQL->query("SELECT * FROM notifications WHERE id = '".$_GET['ec']."' AND type = 'com'");
	$eCmnt = $grabcmnt->fetch_assoc();
	$comid = $_GET['id'];
	$grabCom = $_SQL->query("SELECT * FROM community WHERE id = '".$comid."'");
	$COM = $grabCom->fetch_assoc();
	$grabUsercmnt = $_SQL->query("SELECT * FROM users WHERE id = '".$eCmnt['from_id']."'");
	$cUSER = $grabUsercmnt->fetch_assoc();
	if ($eCmnt['from_id'] == $_USER['id'] OR $_USER['group'] > 1) {
		echo "<a href='javascript:history.back();'>← <small>Go Back</small></a><br /><h3>📰 ".$COM['title']."</h3>
<div id='contentHolder' id='contentHolder' class='contentHolder'><div class='comment' style='margin:0 auto;'><h5>".$cUSER['uname'].": Edit Response</h5><table align='center'>
<tr><td><img src=\"".$cUSER['avatar']."\" height='120px' width='120px' align='left' style='padding-right:15px;' /></td><td><form method='post'>
".$bbcode_buttons."<br /><textarea rows='7' cols='75%' name='editcmnt' id='edit' class='edit'>".$eCmnt['comment']."</textarea></td></tr>
<tr><td></td><td><input type='submit' name='cmnteditSubmit' value='Save Changes' /> <input type='submit' name='delCmnt' value='Delete Comment' onclick=\"return confirm('Are you sure you want to delete this item?');\" />
</td></tr></form></table><br /></div><br /><br /></div>";
		if (isset($_POST['cmnteditSubmit'])) {
			$cmntt = $_SQL->real_escape_string(htmlentities($_POST['editcmnt']));
			if (empty($cmntt)) { $cmntt = $eCmnt['comment']; }
			$_SQL->query("UPDATE notifications set comment='".$cmntt."' WHERE `id` ='".$_GET['ec']."'") or die($_SQL->error);
			echo "<script>alert(\"Response on ".$COM['title']." has been modified!\");</script>"
				."<script>window.location.replace(\"/community.php?id=".$eCmnt['com_id']."#".$eCmnt['id']."\");</script><meta http-equiv='refresh' content='0;/community.php?id=".$eCmnt['com_id']."#".$eCmnt['id']."' />";
		} elseif (isset($_POST['delCmnt'])) {
			$_SQL->query("DELETE FROM notifications WHERE `id` = '".$_GET['ec']."' AND type = 'com'") or die($_SQL->error);
			$_SQL->query("DELETE FROM notifications WHERE `com_id` = '".$_GET['id']."' AND comment = '{$_GET['ec']}' AND type = 'tag'") or die($_SQL->error);
			$sr = $COM['replies'] - 1;
			$_SQL->query("UPDATE community set replies='{$sr}' WHERE id = '{$_GET['id']}'");
			echo "<script>alert(\"Response on ".$COM['title']." has been deleted!\");</script>"
				."<script>window.location.replace(\"/community.php?id=".$COM['id']."\");</script><meta http-equiv='refresh' content='0;/community.php?id=".$COM['id']."' />";
		}
	} else { echo "<span style='color:red;'>You don't have permission to edit this comment. Only the responder, a moderator, or administrator may perform this action.</span>"; }
} // INDIVIDUAL COMMUNITY TOPIC VIEW
if (isset($_GET['id']) && is_numeric($_GET['id']) && $comCount != 0 && !isset($_GET['ec']) && !isset($_GET['change'])) {
	$comid = $_GET['id'];
	$grabCom = $_SQL->query("SELECT * FROM community WHERE id = '".$comid."'");
	$COM = $grabCom->fetch_assoc();
	$tCnt = $grabCom->num_rows;
	if ($tCnt < 1) { die("<script>alert('Sorry, the content you requested does not exist yet.'); location.href='/community.php';</script>"); }
	$getUser = $_SQL->query("SELECT * FROM users WHERE id = '".$COM['uid']."'");
	$getUsr = $getUser->fetch_assoc();
	$COMuser = $getUsr['uname'];
	$cleanInfo = nl2br(bb_parse(htmlspecialchars($COM['info'])));
	$checkifVoted = $_SQL->query("SELECT * FROM notifications WHERE com_id = '".$_GET['id']."' AND type = 'vote' AND from_id = '".$_USER['id']."'") or die($_SQL->error);
	$voteCount = $checkifVoted->num_rows;
	$getAllVotes = $_SQL->query("SELECT * FROM notifications WHERE com_id = '".$_GET['id']."' AND type = 'vote'") or die($_SQL->error);
	$totalVotes1 = $getAllVotes->num_rows;
	$totalVotes = "+".$totalVotes1."";
	/* Count Views */
	$loggedU = '0';
	if (isset($_USER['id'])) { $loggedU = $_USER['id']; }
	$grabViews = $_SQL->query("SELECT * FROM views WHERE com_id = '{$comid}' AND (user = '{$loggedU}' OR ip='{$_SERVER['REMOTE_ADDR']}')");
	if (!isset($_USER['id'])) { $grabViews = $_SQL->query("SELECT * FROM views WHERE com_id = '{$comid}' AND ip = '{$_SERVER['REMOTE_ADDR']}'"); }
	$VIEW = $grabViews->fetch_assoc();
	$uVcount = $grabViews->num_rows;
	$th3n = $VIEW['last_viewed'];
	$now = time();
	$then = strtotime($th3n);
	$difference = $now - $then;
	if($difference > 43200 AND $uVcount < 1 AND $_USER['id'] != $COM['uid']) { $_SQL->query("INSERT INTO views (com_id, user, ip) VALUES ('{$_GET['id']}', '{$loggedU}', '{$_SERVER['REMOTE_ADDR']}')"); }
	$totalViewsSQL = $_SQL->query("SELECT * FROM views WHERE com_id = '{$_GET['id']}'");
	$totalViews = $totalViewsSQL->num_rows;
	if ($_GET['id'] == 82) { $totalViews = $totalViews + 232; }

	if ($totalVotes1 == 0) { $totalVotes = "0"; }
	if (isset($_USER['id'])) {
		if ($_USER['group'] > 1 OR $COM['uid'] == $_USER['id']) { echo"<small><a href='/community.php?change=".$COM['id']."'>✎ Update Content</a></small><br /><br />"; }
	}
	$checkuserComCount = $_SQL->query("SELECT * FROM community WHERE uid = '".$_USER['id']."'");
	$userComCount = $checkuserComCount->num_rows;
	if ($voteCount == 0) { 
		$thumbs = "<style>
		#vote {
		display:block; 
		border:none; 
		width:100px; font-family:sans-serif; color:white; margin-right:10px;
		padding-bottom:3px;
		} 
		</style>
<a href='/community.php?upvote&id=".$COM['id']."'>
<img onmouseover=\"this.src='/css/images/vote/".$_SESSION['theme'].".png';\" onmouseout=\"this.src='//cdn.discordapp.com/attachments/227232976763748355/260872266219257856/VoteOff.png';\" src='//cdn.discordapp.com/attachments/227232976763748355/260872266219257856/VoteOff.png' id='vote' type='submit' title='Vote on this content! Give this post a +1.' />
</a>"; }
	if ($voteCount > 0) { $thumbs = "<span style='color:white; font-family:sans-serif; font-size:small; color:grey;' title=\"You've already liked this post with a +1\">&#9733; Upvoted</span>"; }
	if ($COM['uid'] == $_USER['id']) { $thumbs = ""; }
	if (!isset($_USER['id'])) { $thumbs = ''; }
	if ($COM['flair'] == 'general') { $f = "📰"; }
	if ($COM['flair'] == 'help') { $f = "❔"; }
	if ($COM['flair'] == 'suggestion') { $f = "&#128161;"; }
	if ($COM['flair'] == 'media') { $f = "🎬"; } 
	if ($COM['flair'] == 'tutorial') { $f = "📋"; }
	if ($COM['flair'] == 'download') { $f = "💾"; }
	$grabComments = $_SQL->query("SELECT * FROM notifications where com_id = '".$_GET['id']."' AND type = 'com' ORDER BY id DESC");
	$cmntCount = $grabComments->num_rows;
	if ($cmntCount == 1) { $s = ''; } 
	else { $s = 's'; }
	$Title = preg_replace("/\.?\s*([^\.]+):/", "<span title='$1'>", $COM['title']);
	echo "<h3>".$f." ".$Title."<div style='float:right; margin-top:5px; margin-right:5px;'>".$thumbs."</div></h3>"
		."<div id='contentHolder' id='contentHolder' class='contentHolder'><div style='margin-top:0px;'>"
		."<div style='border:1px solid black; padding:3px; font-size:xx-small; float:left;'><b>Topic Flair:</b> ".ucwords($COM['flair'])."</a></div>"
		."<div style='float:right; text-align:right; border:1px solid black; padding:3px; font-size:xx-small;'><b>Total Votes:</b> ".$totalVotes."</div><br /><hr style='margin-top:9px; border-top:1px dotted grey;' />"
		."<div style='margin-left:40px; margin-right:40px;'>".$cleanInfo."</div><br /><br />";
	echo "<div style='border-top:1px dashed grey; padding-top:8px; font-size:x-small;'><div style='float:left;'><em title='Views are only counted once every 12 hours unless you are a unique visitor.'>Unique Views: ".$totalViews."</em></div>";
	echo "<div style='float:right;'><a href='users.php?id=".$COM['uid']."'><img src=\"".$getUsr['avatar']."\" width='20' style='padding:-2px;' /> ".$COMuser."</a> posted this <span title='".dateConvert($COM['date'])."'>".dateConvert2($COM['date'])."</span></div>"
		."</div></div></div>";
	/* List & Post Comments */
	echo "<br /><h4 id='cmnts'>&#128172; ".$cmntCount." Response".$s."</h4><div id='contentHolder' id='contentHolder' class='contentHolder'>";
	if ($cmntCount == 0) { echo "No responses yet.<br /><br />"; }
	if (isset($_USER['id'])) {
		echo "<form method='post'><table><tr>"
			."<td style='padding-right:20px;'><img src=\"".$_USER['img']."\" width='84' height='84' /></td>"
			."<td title='You can tag users by typing @ following the persons username or alias.'>".$bbcode_buttons2."<textarea id='multi-users' name='cmnt' cols='80%' rows='3' placeholder='Post a comment'></textarea></td></tr>"
			."<tr><td></td><td><input type='submit' value='Leave Response' name='postcmnt' /></td></tr></table></form><br />";
	} else { echo "<small>Login first to respond.</small><br /><br />"; }
	echo "<div data-load-more='10' id='comments' class='comments'>";
	if ($cmntCount != 0 && !isset($_POST['postcmnt'])) {
		while ($cmnt = $grabComments->fetch_assoc()) {
			$grabCmntUser = $_SQL->query("SELECT * FROM users WHERE id = '".$cmnt['from_id']."'");
			$cmntUser = $grabCmntUser->fetch_assoc();
			$displayedCMNT = nl2br(bb_parse($cmnt['comment']));
			preg_match_all("/@[a-zA-Z0-9._-]+/", $displayedCMNT, $username_matches);
			$username_matches = $username_matches[0];
			if (!empty($username_matches)) {
				foreach($username_matches as $ut) {
					$com_ut = trim(str_replace('@', '', $ut));
					$user_id = $_SQL->query("SELECT `id` FROM users where uname='{$com_ut}'")->fetch_object()->id;
					if (!empty($user_id)) { $displayedCMNT = str_replace($ut, "<a href='users.php?id=".$user_id."'>".$ut."</a>", $displayedCMNT); }
					else { $displayedCMNT = str_replace($ut, "".$ut."", $displayedCMNT); }
				}
			}
			echo "<div class='comment' style='margin:0 auto;' id='".$cmnt['id']."'><h5><a href='/users.php?id=".$cmntUser['id']."'>".$cmntUser['uname']."</a>&nbsp;responded&nbsp;<span title='".dateConvert2($cmnt['date'])."'>".dateConvert($cmnt['date'])."</span>";
			if (isset($_USER['id'])) {
				if ($cmnt['from_id'] == $_USER['id'] OR $_USER['group'] > 1) { echo "<div style='float:right; margin-right:15px;'><small><a href='/community.php?id=".$_GET['id']."&ec=".$cmnt['id']."'><b>✎</b> Edit</a></small></div>"; }
			}
			echo "</h5>"
				."<div><table><tr><td valign='top' style='min-width:100px;'><img src=\"".$cmntUser['avatar']."\" height='60' style='max-width:100px; padding-right:20px; padding-left:10px;' /></td><td></td><td>".$displayedCMNT."</td></tr></table><br /></div>\n";
			echo "</div>";
		} 
	} if ($cmntCount > 10) { echo "<br /></div><div class=\"loadMore\" data-action=\"load-more\" data-bound=\"comments\"><a>↻ <small>Load More</small></a>"; }
	echo "</div>";
	if (isset($_POST['postcmnt']) && !empty($_POST['cmnt'])) {
		$cmntBody = $_SQL->real_escape_string(htmlentities($_POST['cmnt']));
		preg_match_all("/@[a-zA-Z0-9._-]+/", $cmntBody, $username_matches);
		$username_matches = $username_matches[0];
		$_SQL->query("UPDATE users set last_action=CURRENT_TIMESTAMP WHERE `id` ='".$_USER['id']."'") or die($_SQL->error);
		$_SQL->query("INSERT INTO notifications (comment, to_id, from_id, type, com_id) VALUES ('".$cmntBody."', '".$COM['uid']."', '".$_USER['id']."', 'com', '".$_GET['id']."')") or die($_SQL->error);
		$replycnt = $cmntCount + 1;
		$_SQL->query("UPDATE community set replies = '".$replycnt."' WHERE id = '".$_GET['id']."'");
		$grabcID = $_SQL->query("SELECT * FROM notifications WHERE type = 'com' AND com_id = '{$_GET['id']}' ORDER BY id DESC LIMIT 1");
		$c = $grabcID->fetch_assoc();
		$cID = $c['id'];
		if (!empty($username_matches)) {
			foreach($username_matches as $ut) {
				$ut = trim(str_replace('@', '', $ut));
				$user_id = $_SQL->query("SELECT `id` FROM users where uname='{$ut}'")->fetch_object()->id;
				if (!empty($user_id) && $user_id != $getUsr['id']) { $_SQL->query("INSERT INTO notifications (to_id, from_id, com_id, type, comment) values ('{$user_id}', '{$_USER['id']}', '{$COM['id']}', 'tag', '{$cID}')"); }
			}
		}
		$commentID = $cID + 1;
		if ($_USER['id'] != $COM['uid']) { echo "<script>alert(\"Response posted. ".$COMuser." has been informed of your response. If any users have been tagged, they have also been notified.\");</script>"; }
		if ($_USER['id'] == $COM['uid']) { echo "<script>alert(\"Response posted. If any users have been tagged, they have been notified.\");</script>"; }
		echo "<META HTTP-EQUIV=\"Refresh\" Content=\"0;/community.php?id=".$_GET['id']."#cmnts\" />";
	} if (isset($_POST['postcmnt']) && empty($_POST['cmnt'])) { 
		echo "<script>alert('It seems you have left the comment field blank. Try Again!');</script>";
	} echo "</div>";
	/* Community Topic Voting System */
	if (isset($_GET['upvote']) && isset($_USER['id'])) { 
		if ($_USER['id'] != $COM['uid']) {
			if ($voteCount > 0 && $_USER['id'] != $COM['uid']) { 	
				echo "<script>alert(\"You can only vote once!\");</script>"; 
				echo "<meta http-equiv='refresh' content='0;/community.php?id=".$COM['id']."' /> ";
			} else {
				$IntotalVotes = $totalVotes + 1;
				$_SQL->query("UPDATE community set votes='".$IntotalVotes."' WHERE `id` ='".$_GET['id']."'") or die($_SQL->error);
				$_SQL->query("INSERT INTO notifications (from_id, to_id, comment, type, com_id) VALUES ('".$_USER['id']."', '".$COM['uid']."', '+1', 'vote', '".$COM['id']."')") or die($_SQL->error);
				echo "<script>alert(\"You've upvoted the topic: ".$COM['title'].". +1 point.\");</script>"; 
				echo "<meta http-equiv='refresh' content='0;/community.php?id=".$COM['id']."' /> ";
			}
		} else { 
			echo "<script>alert(\"You can't vote on your own content!\");</script>"; 
			echo "<meta http-equiv='refresh' content='0;/community.php?id=".$COM['id']."' /> ";
		}
	} elseif (isset($_GET['upvote']) && !isset($_USER['id'])) {
		echo "<script>alert(\"You must login first to vote on content!\");</script>"; 
		echo "<meta http-equiv='refresh' content='0;/community.php?id=".$COM['id']."' /> ";
	}
} // LIST ALL COMMUNITY TOPICS
if (!isset($_GET['new']) && !isset($_GET['id']) && !isset($_GET['uid']) && !isset($_GET['change']) && !isset($_GET['author']) && $comCount != 0) {
	echo "<span style='font-size:small;'>Discuss ideas, post about pretty much, anything you want in relation to Halo Online or this website.<br />We only ask that you do not spam! The administrators/moderators have the right to remove any unfit content.</span><br /> <h3 id='h3'>👤 Community Posts</h3><div id='contentHolder' id='contentHolder' class='contentHolder'>";
	if (isset($_USER['id'])) { echo "<a href='/community.php?new'>☲ Post New</a>"; }
	echo "<div style='float:right; font-size:x-small; opacity:0.7;'>".$oForm.$filterForm."</div>";
	echo "<br /><br /><div class='row' id='row' style='text-align:center; font-size:small;'><div class='col-md-1''></div><div class='col-md-5' style='text-align:left; padding-left:20px;'><b>Title</b></div><div class='col-md-1' style='text-align:center;'><b>Author</b></div><div class='col-md-3'><b>Date</b></div><div class='col-md-2'></div></div><br />"
		."<div id='forgeList' data-load-more='20' class='forgeList' style='min-width:100%;'>";
	while ($COMS = $listComs->fetch_assoc()) {
		$comDate = dateConvert($COMS['date']);
		$uSQL = $_SQL->query("SELECT * FROM users WHERE id = '".$COMS['uid']."'");
		$sub = $uSQL->fetch_assoc();
		$submitter = $sub['uname'];
		$flair = $COMS['flair'];
		$replies = $COMS['replies'];
		$getViews = $_SQL->query("SELECT * FROM views WHERE com_id = '{$COMS['id']}'");
		$views = $getViews->num_rows;
		$Title = preg_replace("/\.?\s*([^\.]+):/", "</a><sup style='display:block; font-size:8px; font-weight:normal;'>$1</sup><a href=\"/community.php?id=".$COMS['id']."\">", $COMS['title']);
		if ($COMS['flair'] == 'general') { $f = "📰"; }
		if ($COMS['flair'] == 'help') { $f = "❔"; }
		if ($COMS['flair'] == 'suggestion') { $f = "&#128161;"; }
		if ($COMS['flair'] == 'media') { $f = "🎬"; }
		if ($COMS['flair'] == 'tutorial') { $f = "📋"; }
		if ($COMS['flair'] == 'download') { $f = "💾"; }
?>
<div class="row" style="min-height:70px; padding:5px; text-align:center; display:flex; font-size:11pt; align-items:center;">
	<div class="col-md-1"><a href="/community.php?id=<?=$COMS['id'];?>" title="Flair: <?=ucwords($COMS['flair']);?>"><span style='font-size:x-large; font-weight:bold;'><?=$f;?></span></a></div>
	<div class="col-md-5" style="text-align:left; padding-left:20px;"><b><a href="/community.php?id=<?=$COMS['id'];?>" title="<?=htmlentities(removeBB($COMS['info']));?>"><?=$Title;?></a></b></div>
	<div class="col-md-1"><a href="users.php?id=<?=$sub['id'];?>"><?=$submitter;?></a></div>
	<div class="col-md-3" style="font-size:x-small;"><i><?=$comDate;?></i></div>
	<div class="col-md-2" style="font-size:x-small; float:right; text-align:left;">
		💬 Replies: <?=$replies;?><br />
		👍 Upvotes: <?=$COMS['votes'];?><br />
		👀 Views: <?=$views;?></div>
</div>
<?php
	}
	echo "<!-- end load-more --></div><br />";
	if ($comCount > 20) { echo "<br /><div id='loadMoreF' class='loadMore' data-action='load-more' data-bound='forgeList'><a>&#x21bb; <small>Load More</small></a></div>"; }
	if (isset($_USER['id']) && $comCount > 8) { echo "<div style='float:right; margin-right:20px;'><a href='/community.php?new'>☲ Post New</a></div><br /><br />"; }	echo "</div>";
} // LIST TOPICS BASED ON AUTHOR
if (!isset($_GET['new']) && !isset($_GET['id']) && isset($_GET['uid']) && is_numeric($_GET['uid']) && !isset($_GET['change']) && !isset($_GET['author']) && $comCount != 0) {
	$WHERE = " WHERE uid = '{$_GET['uid']}'";
	if (isset($_POST['filter']) && !empty($_POST['filter'])) { $WHERE = " WHERE flair = '".$filter."' AND uid = '{$_GET['uid']}'"; }
	if ($_GET['order'] != "views") { 
		$listComs = $_SQL->query("SELECT * FROM community{$WHERE} ORDER BY ".$orderBY." DESC") or die($_SQL->error); 
	} else {
		$listComs = $_SQL->query("SELECT c.*, COUNT(v.id) AS views FROM community AS c LEFT JOIN views AS v ON v.com_id=c.id{$WHERE} GROUP BY c.id ORDER BY views DESC") or die($_SQL->error); 
	}
	$userName = $_SQL->query("SELECT uname FROM users WHERE id='{$_GET['uid']}'")->fetch_assoc(); $uName=$userName['uname'];
	echo "<span style='font-size:small;'>Discuss ideas, post about pretty much, anything you want in relation to Halo Online or this website.<br />We only ask that you do not spam! The administrators/moderators have the right to remove any unfit content.</span><br /> <h3 id='h3'>👤 Topics by ".$uName."</h3><div id='contentHolder' id='contentHolder' class='contentHolder'>";
	if (isset($_USER['id'])) { echo "<a href='/community.php?new'>☲ Post New</a>"; }
	echo "<div style='float:right; font-size:x-small; opacity:0.7;'>".$oForm.$filterForm."</div>";
	echo "<br /><br /><div class='row' id='row' style='text-align:center; font-size:small;'><div class='col-md-1''></div><div class='col-md-5' style='text-align:left; padding-left:20px;'><b>Title</b></div><div class='col-md-1' style='text-align:right;'><b>Author</b></div><div class='col-md-3'><b>Date</b></div><div class='col-md-2'></div></div><br />"
		."<div id='forgeList' data-load-more='20' class='forgeList' style='min-width:100%;'>";
	while ($COMS = $listComs->fetch_assoc()) {
		$comDate = dateConvert($COMS['date']);
		$uSQL = $_SQL->query("SELECT * FROM users WHERE id = '".$COMS['uid']."'");
		$sub = $uSQL->fetch_assoc();
		$submitter = $sub['uname'];
		$flair = $COMS['flair'];
		$replies = $COMS['replies'];
		$getViews = $_SQL->query("SELECT * FROM views WHERE com_id = '{$COMS['id']}'");
		$views = $getViews->num_rows;
		$Title = preg_replace("/\.?\s*([^\.]+):/", "</a><sup style='display:block; font-size:8px; font-weight:normal;'>$1</sup><a href=\"/community.php?id=".$COMS['id']."\">", $COMS['title']);
		if ($COMS['flair'] == 'general') { $f = "📰"; }
		if ($COMS['flair'] == 'help') { $f = "❔"; }
		if ($COMS['flair'] == 'suggestion') { $f = "&#128161;"; }
		if ($COMS['flair'] == 'media') { $f = "🎬"; }
		if ($COMS['flair'] == 'tutorial') { $f = "📋"; }
		if ($COMS['flair'] == 'download') { $f = "💾"; }
?>
<div class="row" style="min-height:70px; padding:5px; text-align:center; font-size:small; display:flex; align-items:center;">
	<div class="col-md-1"><a href="/community.php?id=<?=$COMS['id'];?>" title="Flair: <?=ucwords($COMS['flair']);?>"><span style='font-size:x-large; font-weight:bold;'><?=$f;?></span></a></div>
	<div class="col-md-5" style="text-align:left; padding-left:20px;"><b><a href="/community.php?id=<?=$COMS['id'];?>" title="<?=htmlentities(removeBB($COMS['info']));?>"><?=$Title;?></a></b></div>
	<div class="col-md-1" style="font-size:small;"><a href="users.php?id=<?=$sub['id'];?>"><?=$submitter;?></a></div>
	<div class="col-md-3" style="font-size:x-small;"><?=$comDate;?></div>
	<div class="col-md-2" style="font-size:xx-small; float:right; text-align:left;">Views: <?=$views;?><br />Replies: <?=$replies;?><br />Upvotes: <?=$COMS['votes'];?></div>
</div>
<?php
	}
	echo "<!-- end load-more --></div><br />";
	if ($comCount > 20) { echo "<br /><div id='loadMoreF' class='loadMore' data-action='load-more' data-bound='forgeList'><a>&#x21bb; <small>Load More</small></a></div>"; }
	if (isset($_USER['id']) && $comCount > 8) { echo "<div style='float:right; margin-right:20px;'><a href='/community.php?new'>☲ Post New</a></div><br /><br />"; }	echo "</div>";
}  // POST NEW TOPIC
if (isset($_GET['new'])) {
	if (isset($_USER['id'])) {
		if (!isset($_POST['postsubmit'])) {
			echo $html;
		} else {
			$comtitle = $_SQL->real_escape_string(htmlentities($_POST['title']));
			$cominfo = $_SQL->real_escape_string($_POST['info']);
			$composer = $_USER['id'];
			$flair = $_SQL->real_escape_string(htmlentities($_POST['flair']));
			$checkMapSpam = $_SQL->query("SELECT id FROM maps where uid = '{$_USER['id']}' AND `date` > date_sub(CURRENT_TIMESTAMP, INTERVAL 8 MINUTE)");
			$checkModSpam = $_SQL->query("SELECT id FROM files where uid = '{$_USER['id']}' AND `date` > date_sub(CURRENT_TIMESTAMP, INTERVAL 8 MINUTE)");
			$checkComSpam = $_SQL->query("SELECT id FROM community where uid = '{$_USER['id']}' AND `date` > date_sub(CURRENT_TIMESTAMP, INTERVAL 8 MINUTE)");
			$checkModSpam = $checkModSpam->num_rows;
			$checkComSpam = $checkComSpam->num_rows;
			$checkMapSpam = $checkMapSpam->num_rows;
			$checkSpam = $checkMapSpam + $checkModSpam + $checkComSpam;
			if (empty($comtitle) OR empty($flair) OR empty($cominfo) OR $checkSpam > 4) {
				echo $html;
				echo "<script>alert(\"Either you are postng too often, or have left a required field blank\");</script>";
			} else {
				$_SQL->query("INSERT INTO community (uid, title, flair, info, `date`) VALUES ('".$composer."', '".$comtitle."', '".$flair."', '".$cominfo."', CURRENT_TIMESTAMP)") or die($_SQL->error);
				$getcomID = $_SQL->query("SELECT * FROM community where title = '".$comtitle."'");
				$yourcom = $getcomID->fetch_assoc();
				echo "<b>".$comtitle."</b> has been posted! You can see your content <a href='/community.php?id=".$yourcom['id']."'>here</a>.";
			}
		}
	} else { echo "<span style='color:red;'>You must <a href='login.php'>login</a> or <a href='reg.php'>register</a> first in order to post new content!</span>"; }
} // EDIT TOPIC
if (isset($_GET['change']) && is_numeric($_GET['change']) && isset($_USER['id']) && $comCount != 0) {
	$comid = $_GET['change'];
	$grabCom = $_SQL->query("SELECT * FROM community WHERE id = '".$comid."'");
	$comCom = $grabCom->fetch_assoc();
	if ($_USER['group'] > 1 OR $_USER['id'] == $comCom['uid']) { 
		$_SQL->query("UPDATE users SET last_action=CURRENT_TIMESTAMP WHERE id = '{$_USER['id']}'");
		if ($comCom['flair'] == 'help') { 
			$flairForm = "<select name='flair'>
<option value='help'>Help</option>
<option value='general'>General</option>
<option value='tutorial'>Tutorial</option>
<option value='media'>Media</option>
<option value='suggestion'>Suggestion</option>
<option value='download'>Download</option></select>";
		} elseif ($comCom['flair'] == 'suggestion') { 
			$flairForm = "<select name='flair'>
<option value='suggestion'>Suggestion</option>
<option value='help'>Help</option>
<option value='general'>General</option>
<option value='tutorial'>Tutorial</option>
<option value='media'>Media</option>
<option value='download'>Download</option></select>";
		} elseif ($comCom['flair'] == 'general') { 
			$flairForm = "<select name='flair'>
<option value='general'>General</option>
<option value='help'>Help</option>
<option value='media'>Media</option>
<option value='tutorial'>Tutorial</option>
<option value='suggestion'>Suggestion</option>
<option value='download'>Download</option></select>";
		} elseif ($comCom['flair'] == 'media') { 
			$flairForm = "<select name='flair'>
<option value='media'>Media</option>
<option value='help'>Help</option>
<option value='general'>General</option>
<option value='tutorial'>Tutorial</option>
<option value='suggestion'>Suggestion</option>
<option value='download'>Download</option></select>";
		} elseif ($comCom['flair'] == 'tutorial') { 
			$flairForm = "<select name='flair'>
<option value='tutorial'>Tutorial</option>
<option value='media'>Media</option>
<option value='help'>Help</option>
<option value='general'>General</option>
<option value='suggestion'>Suggestion</option>
<option value='download'>Download</option></select>";
		} elseif ($comCom['flair'] == 'download') { 
			$flairForm = "<select name='flair'>
<option value='download'>Download</option>
<option value='tutorial'>Tutorial</option>
<option value='media'>Media</option>
<option value='help'>Help</option>
<option value='general'>General</option>
<option value='suggestion'>Suggestion</option>
</select>";
		} else { 
			$flairForm = "<select name='flair'>
<option value='download'>Download</option>
<option value='tutorial'>Tutorial</option>
<option value='media'>Media</option>
<option value='help'>Help</option>
<option value='general'>General</option>
<option value='suggestion'>Suggestion</option>
</select>";
		}
		$stickyForm = '';
		if ($_USER['group'] > 1) { $stickyForm = "<div style='float:right; font-size:large; line-height:100%;'>&#128204; <input type='checkbox' name='sticky' /></div>"; }
		$comhtml = "<h3>Update Topic: ".$comCom['title']."".$stickyForm."</h3>
<div id='contentHolder' id='contentHolder' class='contentHolder'>&#9874; <small>= Required field.</small><br /><br />"
			."<small>Please don't post anything insulting. And remember: dont spam!</small><br /><br />"
			."<table><form method='post'>"
			."<tr><td>Title:</td><td><input type='text' name='title' value='".$comCom['title']."' requird/></td></tr>"
			."<tr><td>Flair:</td><td>".$flairForm."</td></tr>"
			."<tr><td>Body:</td><td><br />".$bbcode_buttons."<textarea cols='100%' rows='15' name='info' id='edit' required>".$comCom['info']."</textarea></td></tr>"
			."<tr><td></td><td><input type='submit' value='Save Changes' name='comsubmit' /> <input type='submit' value='Delete Topic' name='deletetop' onclick=\"return confirm('Are you sure you want to delete this item? All relevnt upvotes & responses will also be removed.');\" /></td><td><input type='button' onclick=\"location.href='/community.php?id=".$_GET['change']."';\" value='Cancel' style='cursor:pointer; min-width:80px;' /></td></tr>"
			."</form></table><br /><br />";
		if (!isset($_POST['comsubmit']) && !isset($_POST['deletetop'])) {
			echo $comhtml;
		} elseif (isset($_POST['comsubmit'])) {
			$comtitle = $_SQL->real_escape_string(htmlentities($_POST['title']));
			$flair = $_SQL->real_escape_string(htmlentities($_POST['flair']));
			$cominfo = $_SQL->real_escape_string($_POST['info']);
			if (empty($comtitle) OR empty($flair) OR empty($cominfo)) {
				echo $comhtml;
				echo "<span style='color:red;'>Please ensure you haven't left any required fields blank.</span>";
			} else {
				$p='y'; if (isset($_POST['public'])) {$p='n';}
				$_SQL->query("UPDATE community set public='{$p}', title='".$comtitle."', flair='".$flair."', info='".$cominfo."', edited='".date("Y-m-d H:i:s")."' WHERE id = '".$_GET['change']."'") or die($_SQL->error);
				$getcomID = $_SQL->query("SELECT * FROM community where id = '".$_GET['change']."'");
				$yourcom = $getcomID->fetch_assoc();
				echo "<b>".$comtitle."</b> has been modified! You can see your changes <a href='/community.php?id=".$yourcom['id']."'>here</a>.";
			}
		} elseif (isset($_POST['deletetop'])) {
			$_SQL->query("DELETE FROM community WHERE id = '".$_GET['change']."'") or die($_SQL->error);
			$_SQL->query("DELETE FROM notifications WHERE com_id = '".$_GET['change']."'") or die($_SQL->error);
			echo "<script>alert(\"Your topic has been deleted. All relevant responses, upvotes, etc have also been removed.\");\n"
				."location.replace(\"/community.php\");</script>";
		}
	} else { echo "<span style='color:red;'>You are not authorized to modify this content. Only the original poster, a comerator, or an administrator may perform this action.</span><br />"; }
} echo "</div>";
include_once "inc/footer.php";
?>