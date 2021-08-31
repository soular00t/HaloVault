<?php include_once "inc/core.php"; error_reporting(E_ALL & ~E_NOTICE);
include_once "inc/header.php"; 
echo "<div class='content'><div class='contentHeader'>Files</div>";
$Ztitle='';
$Zcreator='';
$Zsup='';
$Zdl='';
$Zbody='';
if (isset($_POST['postsubmit'])) {
	$Ztitle = htmlspecialchars($_POST['title']);
	$Zcreator = htmlspecialchars($_POST['author']);
	$Zsup= htmlspecialchars($_POST['support']);
	$Zdl = htmlspecialchars($_POST['url']);
	$Zbody = htmlspecialchars($_POST['info']);
}
$html = "<h3>⚙ Post New File</h3><div id='contentHolder' class='contentHolder'>"
	."<small style='font-weight:bold;'>⚙ = Required field.</small><br /><br />We encourage new content, just please be respectful and make sure to reference the correct author."
	."<div style='font-size:x-small; float:right; max-width:20%; border:1px solid grey; padding:3px; text-align:center; margin-top:-65px;'><a href='http://drive.google.com/'>Google Drive</a> recommended for quick and easy file version managment.</div><br /><br />"
	."<table><form method='post'>"
	."<tr><td><input value=\"".$Ztitle."\" type='text' name='title' placeholder='Title' /></td>"
	."<td><select name='type' id='flair' onchange=\"javascript: setTimeout('__processFlair(\'flair\')', 1)\">
	<option data-url=\"files.php?new#variant\" value='variants' title='This mainly exists as a way to submit gametypes, or variant/map packs.'>File Type: Variants</option>
	<option data-url=\"\" value='config' title='Files used to edit the game, usually useful for console commands through rcon, & used to bind keys'>Configuration</option>
	<option data-url=\"\" value='mod' title='Usually a tag modification to the game, almost always used with Foundation Mod Manager'>Tag Edit</option>
	<option data-url=\"\" value='app' title='External tools used to modify the game, example would be FMM, and the way it handles mod installation'>Application</option>
	</select></td></tr>"
	."<tr><td><input value=\"".$Zcreator."\" type='text' name='author' placeholder='Creator (if not you)' /></td></tr>"
	."<tr><td><input value=\"".$Zsup."\" type='text' name='support' placeholder='Support URL' /></td></tr>"
	."<tr><td><input value=\"".$Zdl."\" type='text' name='url' placeholder='⚙ Download URL' /></td></tr>"
	."<tr><td><br />".$bbcode_buttons."<textarea id='edit' cols='100%' rows='15' name='info' placeholder=\"⚙ Please include complete instructions & details on what tool it is your submitting, and which part of the game is affected. If there are any previews you'd like to show off, please link to them in the body.\">".$Zbody."</textarea></td></tr>"
	."<tr><td><input type='submit' value='Post File' name='postsubmit' /><div style='font-size:x-small; color:grey; display:flex; align-items:center; float:right; padding:2px;' title='Add file to databse, but hide post from public view. This is useful if you want to save this for later.'><input type='checkbox' id='public' name='public' value='n' /> Leave Unpublished?</div></td></tr>"
	."</form></table></div><br /><br />";
$WHERE=" WHERE public != 'n' AND public !='p'";  $filter='';
if (isset($_POST['filter']) && !empty($_POST['filter'])) { 
	$filter = $_SQL->real_escape_string(htmlspecialchars($_POST['filter']));
	$WHERE = " WHERE type = '".$filter."' AND public != 'n' AND public !='p'"; 
} elseif (isset($_GET['type']) && !empty($_GET['type'])) { 
	$filter =  preg_replace('/[^ \w0-9a-zA-Z_-]/', '', $_GET['type']);
	$WHERE = " WHERE type = '".$filter."' AND public != 'n' AND public !='p'"; 
}
$orderBY = "date";
	$oForm = "<form>Order by: <select name='orderBY' onchange=\"location = this.value + '&type=".$filter."';\">
		<option value='files.php?order=date'>date posted</option>
		<option value='files.php?order=edited'>last edited</option>
		<option value='files.php?order=votes'>votes</option>
		<option value='files.php?order=replies'>responses</option>
		<option value='files.php?order=views'>views</option>
		<option value='files.php?order=downloads'>downloads</option>
		<option value='files.php?order=updated'>last acitivty</option>"
		."</select></form>";
if (isset($_GET['order']) && $_GET['order'] == 'votes') { 
	$orderBY = "votes"; 
	$oForm = "<form>Order by: <select name='orderBY' onchange=\"location = this.value + '&type=".$filter."';\">
		<option value='files.php?order=votes'>votes</option>
		<option value='files.php?order=replies'>responses</option>
		<option value='files.php?order=views'>views</option>
		<option value='files.php?order=downloads'>downloads</option>
		<option value='files.php?order=date'>date posted</option>
		<option value='files.php?order=edited'>last edited</option>
		<option value='files.php?order=updated'>last acitivty</option>"
		."</select></form>";
} elseif (isset($_GET['order']) && $_GET['order'] == 'downloads') {
	$orderBY = "downloads"; 
	$oForm = "<form>Order by: <select name='orderBY' onchange=\"location = this.value + '&type=".$filter."';\">"
		."<option value='files.php?order=downloads'>downloads</option>
		<option value='files.php?order=votes'>votes</option>
		<option value='files.php?order=replies'>responses</option>
		<option value='files.php?order=date'>date posted</option>
		<option value='files.php?order=views'>views</option>
		<option value='files.php?order=edited'>last edited</option>
		<option value='files.php?order=updated'>last acitivty</option>"
		."</select></form>";
} elseif (isset($_GET['order']) && $_GET['order'] == 'replies') {
	$orderBY = "replies"; 
	$oForm = "<form>Order by: <select name='orderBY' onchange=\"location = this.value + '&type=".$filter."';\">"
		."<option value='files.php?order=replies'>responses</option>
		<option value='files.php?order=downloads'>downloads</option>
		<option value='files.php?order=votes'>votes</option>
		<option value='files.php?order=views'>views</option>
		<option value='files.php?order=date'>date posted</option>
		<option value='files.php?order=edited'>last edited</option>
		<option value='files.php?order=updated'>last acitivty</option>"
		."</select></form>";
} elseif (isset($_GET['order']) && $_GET['order'] == 'edited') {
	$orderBY = "edited DESC, updated"; 
	$oForm = "<form>Order by: <select name='orderBY' onchange=\"location = this.value + '&type=".$filter."';\">
		<option value='files.php?order=edited'>last edited</option>
		<option value='files.php?order=downloads'>downloads</option>
		<option value='files.php?order=votes'>votes</option>
		<option value='files.php?order=views'>views</option>
		<option value='files.php?order=replies'>responses</option>
		<option value='files.php?order=date'>date posted</option>
		<option value='files.php?order=updated'>last acitivty</option>
		</select></form>";
} elseif (isset($_GET['order']) && $_GET['order'] == 'updated') {
	$orderBY = "updated"; 
	$oForm = "<form>Order by: <select name='orderBY' onchange=\"location = this.value + '&type=".$filter."';\">
		<option value='files.php?order=updated'>last acitivty</option>
		<option value='files.php?order=downloads'>downloads</option>
		<option value='files.php?order=votes'>votes</option>
		<option value='files.php?order=views'>views</option>
		<option value='files.php?order=replies'>responses</option>
		<option value='files.php?order=date'>date posted</option>
		<option value='files.php?order=edited'>last edited</option>
		</select></form>";
} elseif (isset($_GET['order']) && $_GET['order'] == "views") {
	$listMods = $_SQL->query("SELECT m.*, COUNT(v.id) AS views FROM files AS m LEFT JOIN views AS v ON v.mod_id=m.id GROUP BY m.id ORDER BY views DESC") or die($_SQL->error);
	$oForm = "<form>Order by: <select name='orderBY' onchange=\"location = this.value + '&type=".$filter."';\">
		<option value='files.php?order=views'>views</option>
		<option value='files.php?order=updated'>last acitivty</option>
		<option value='files.php?order=downloads'>downloads</option>
		<option value='files.php?order=votes'>votes</option>
		<option value='files.php?order=replies'>responses</option>
		<option value='files.php?order=date'>date posted</option>
		<option value='/files.php?order=edited'>last edited</option>
		</select></form>";
}
$filterForm = "<form method='post' name='f'>File Type: 
<select name='filter' onchange=\"location.href='/files.php?&order=".$orderBY."&type=' + this.value;\">
<option value=''>All</option>
<option value='config' title='Files used to edit the game, usually useful for console commands through rcon, & used to bind keys'>Configuration</option>
<option value='variants' title='This mainly exists as a way to submit gametypes, or variant patches.'>Variants</option>
<option value='app' title='External tools used to modify the game, example would be FMM, and the way it handles mod installation'>Application</option>
<option value='mod' title='Usually a tag modification to the game, almost always used with Foundation Mod Manager'>Tag Edit</option>
<option value='game' title='Contains the full Halo Online downloadable game.'>Game</option>
</select></form>";
if (isset($_POST['filter']) &&  $_POST['filter'] == 'config' OR $_GET['type'] == 'config') {
	$filterForm = "<form method='post' name='f'>File Type: 
	<select name='filter' onchange=\"location.href='/files.php?&order=".$orderBY."&type=' + this.value;\">
	<option value='config' title='Files used to edit the game, usually useful for console commands through rcon, & used to bind keys'>Configuration</option>
	<option value='mod' title='Usually a tag modification to the game, almost always used with Foundation Mod Manager'>Tag Edit</option>
	<option value='app' title='External tools used to modify the game, example would be FMM, and the way it handles mod installation'>Application</option>
	<option value='variants' title='This mainly exists as a way to submit gametypes, or variant patches.'>Variants</option>
	<option value='game' title='Contains the full Halo Online downloadable game.'>Game</option>
	<option>All</option>
	</select></form>";
} elseif (isset($_POST['filter']) && $_POST['filter'] == 'mod' OR $_GET['type'] == 'mod') {
	$filterForm = "<form method='post' name='f'>File Type: 
	<select name='filter' onchange=\"location.href='/files.php?&order=".$orderBY."&type=' + this.value;\">
	<option value='mod' title='Usually a tag modification to the game, almost always used with Foundation Mod Manager'>Tag Edit</option>
	<option value='config' title='Files used to edit the game, usually useful for console commands through rcon, & used to bind keys'>Configuration</option>
	<option value='app' title='External tools used to modify the game, example would be FMM, and the way it handles mod installation'>Application</option>
	<option value='variants' title='This mainly exists as a way to submit gametypes, or variant patches.'>Variants</option>
	<option value='game' title='Contains the full Halo Online downloadable game.'>Game</option>
	<option>All</option>
	</select></form>";
} elseif (isset($_POST['filter']) && $_POST['filter'] == 'app' OR $_GET['type'] == 'app') {
	$filterForm = "<form method='post' name='f'>File Type: 
	<select name='filter' onchange=\"location.href='/files.php?&order=".$orderBY."&type=' + this.value;\">
	<option value='app' title='External tools used to modify the game, example would be FMM, and the way it handles mod installation'>Application</option>
	<option value='config' title='Files used to edit the game, usually useful for console commands through rcon, & used to bind keys'>Configuration</option>
	<option value='mod' title='Usually a tag modification to the game, almost always used with Foundation Mod Manager'>Tag Edit</option>
	<option value='variants' title='This mainly exists as a way to submit gametypes, or variant patches.'>Variants</option>
	<option value='game' title='Contains the full Halo Online downloadable game.'>Game</option>
	<option>All</option>
	</select></form>";
} elseif (isset($_POST['filter']) && $_POST['filter'] == 'variant' OR $_GET['type'] == 'variants') {
	$filterForm = "<form method='post' name='f'>File Type: 
	<select name='filter' onchange=\"location.href='/files.php?&order=".$orderBY."&type=' + this.value;\">
	<option value='variants' title='This mainly exists as a way to submit gametypes, or variant patches.'>Variants</option>
	<option value='config' title='Files used to edit the game, usually useful for console commands through rcon, & used to bind keys'>Configuration</option>
	<option value='mod' title='Usually a tag modification to the game, almost always used with Foundation Mod Manager'>Tag Edit</option>
	<option value='app' title='External tools used to modify the game, example would be FMM, and the way it handles mod installation'>Application</option>
	<option value='game' title='Contains the full Halo Online downloadable game.'>Game</option>
	<option>All</option>
	</select></form>";
} elseif (isset($_POST['filter']) && $_POST['filter'] == 'game' OR $_GET['type'] == 'game') {
	$filterForm = "<form method='post' name='f'>File Type: 
	<select name='filter' onchange=\"location.href='/files.php?&order=".$orderBY."&type=' + this.value;\">
	<option value='game' title='Contains the full Halo Online downloadable game.'>Game</option>
	<option value='variants' title='This mainly exists as a way to submit gametypes, or variant patches.'>Variants</option>
	<option value='config' title='Files used to edit the game, usually useful for console commands through rcon, & used to bind keys'>Configuration</option>
	<option value='mod' title='Usually a tag modification to the game, almost always used with Foundation Mod Manager'>Tag Edit</option>
	<option value='app' title='External tools used to modify the game, example would be FMM, and the way it handles mod installation'>Application</option>
	<option>All</option>
	</select></form>";
} 
$listMods = $_SQL->query("SELECT * FROM files{$WHERE} ORDER BY ".$orderBY." DESC");
$modCount = $listMods->num_rows;
if ($modCount == 0 && !isset($_GET['id']) && !isset($_GET['new'])) {
	echo "There is currently no files archived. Please feel free to <a href='/files.php?new'>post new content</a>. <br /><br />";
} /* Edit & Delete Comment */
if (isset($_GET['ec']) && is_numeric($_GET['ec']) && is_numeric($_GET['id'])) {
	$grabcmnt=$_SQL->query("SELECT * FROM notifications WHERE id = '".$_GET['ec']."' AND type = 'mod'");
	$eCmnt = $grabcmnt->fetch_assoc();
	$modid = $_GET['id'];
	$grabMod = $_SQL->query("SELECT * FROM files WHERE id = '".$modid."'");
	$MOD = $grabMod->fetch_assoc();
	$grabUsercmnt = $_SQL->query("SELECT * FROM users WHERE id = '".$eCmnt['from_id']."'");
	$cUSER = $grabUsercmnt->fetch_assoc();
	if ($eCmnt['from_id'] == $_USER['id'] OR $_USER['group'] > 1) {
		echo "<a href='javascript:history.back();'>← <small>Go Back</small></a><br /><div class='h3' style='margin-bottom:-4px;'>".$MOD['title']."</div>
		<div id='contentHolder' class='contentHolder' style='margin-top:auto;'>
		<div class='comment' style='margin:0 auto;'><h5>".$cUSER['uname'].": Edit Response</h5><table align='center'>
		<tr><td><img src=\"".$cUSER['avatar']."\" height='120px' width='120px' align='left' style='padding-right:15px;' /></td><td><form method='post'>
		".$bbcode_buttons."<br /><textarea rows='7' cols='75%' name='editcmnt' id='edit' class='edit'>".$eCmnt['comment']."</textarea></td></tr>
		<tr><td></td><td><input type='submit' name='cmnteditSubmit' value='Save Changes' />&nbsp;
		<input type='submit' name='delCmnt' value='Delete Comment' onclick=\"return confirm('Are you sure you want to delete this item?');\" />
</td></tr></form></table><br /></div></div>";
		if (isset($_POST['cmnteditSubmit'])) {
			$cmntt = $_SQL->real_escape_string(htmlentities($_POST['editcmnt']));
			if (empty($cmntt)) { $cmntt = $eCmnt['comment']; }
			$_SQL->query("UPDATE notifications set comment='".$cmntt."' WHERE `id` ='".$_GET['ec']."'") or die($_SQL->error);
			echo "<script>alert(\"Response on ".$MOD['title']." has been modified!\");</script>"
				."<script>window.location.replace(\"/files.php?id=".$eCmnt['mod_id']."#".$eCmnt['id']."\");</script>";
		} elseif (isset($_POST['delCmnt'])) {
			$_SQL->query("DELETE FROM notifications WHERE `id` = '".$_GET['ec']."' AND type = 'mod'") or die($_SQL->error);
			$_SQL->query("DELETE FROM notifications WHERE `mod_id` = '".$_GET['id']."' AND comment = '{$_GET['ec']}' AND type = 'tag'") or die($_SQL->error);
			$rplies = $MOD['replies'] - 1;
			$_SQL->query("UPDATE files SET replies = '{$rplies}' WHERE id ='{$_GET['id']}'");
			echo "<script>alert(\"Response on ".$MOD['title']." has been deleted!\");</script>"
				."<script>window.location.replace(\"/files.php?id=".$MOD['id']."\");</script>";
		}
	} else { echo "<span style='color:red;'>You don't have permission to edit this comment. Only the responder, a moderator, or administrator may perform this action.</span>"; }
} // INDIVIDUAL FILE VIEW
if (isset($_GET['id']) && is_numeric($_GET['id']) && $modCount != 0 && !isset($_GET['ec']) && !isset($_GET['change'])) {
	$modid = $_GET['id'];
	$grabMod = $_SQL->query("SELECT * FROM files WHERE id = '".$modid."'");
	$MOD = $grabMod->fetch_assoc();
	$mCnt = $grabMod->num_rows;
	if ($mCnt < 1) { die("<script>alert('Sorry, the content you requested does not exist yet.'); location.href='/files.php';</script>"); }
	$getUser = $_SQL->query("SELECT * FROM users WHERE id = '".$MOD['uid']."'");
	$getUsr = $getUser->fetch_assoc();
	$MODuser = $getUsr['uname'];
	$cleanInfo = nl2br(bb_parse(htmlspecialchars($MOD['info'])));
	$checkifVoted = $_SQL->query("SELECT * FROM notifications WHERE mod_id = '".$_GET['id']."' AND type = 'vote' AND from_id = '".$_USER['id']."'") or die($_SQL->error);
	$voteCount = $checkifVoted->num_rows;
	$getAllVotes = $_SQL->query("SELECT * FROM notifications WHERE mod_id = '".$_GET['id']."' AND type = 'vote'") or die($_SQL->error);
	$totalVotes1 = $getAllVotes->num_rows;
	$totalVotes = "+".$totalVotes1."";
	$totalDLSQL = $_SQL->query("SELECT * FROM downloads WHERE mod_id = '{$_GET['id']}'");
	$totalDLs = $totalDLSQL->num_rows;
	/* Count Views */
	$loggedU = '0';
	if (isset($_USER['id'])) { $loggedU = $_USER['id']; }
	$grabViews = $_SQL->query("SELECT * FROM views WHERE mod_id = '{$modid}' AND (user = '{$loggedU}' OR ip='{$_SERVER['REMOTE_ADDR']}')") or die($_SQL->error);
	if (!isset($_USER['id'])) { $grabViews = $_SQL->query("SELECT * FROM views WHERE mod_id = '{$modid}' AND ip = '{$_SERVER['REMOTE_ADDR']}'") or die($_SQL->error); }
	$VIEW = $grabViews->fetch_assoc();
	$uVcount = $grabViews->num_rows;
	$th3n = $VIEW['last_viewed'];
	$now = time();
	$then = strtotime($th3n);
	$difference = $now - $then;
	if($difference > 43200 AND $uVcount < 1 AND $_USER['id'] != $MOD['uid']) { $_SQL->query("INSERT INTO views (mod_id, user, ip) VALUES ('{$_GET['id']}', '{$loggedU}', '{$_SERVER['REMOTE_ADDR']}')") or die($_SQL->error); }
	$totalViewsSQL = $_SQL->query("SELECT * FROM views WHERE mod_id = '{$_GET['id']}'") or die($_SQL->error);
	$totalViews = $totalViewsSQL->num_rows;

	if ($totalVotes1 == 0) { $totalVotes = "0"; }
	if (isset($_USER['id'])) {
		if ($_USER['group'] > 1 OR $MOD['uid'] == $_USER['id']) { echo"<small><a href='/files.php?change=".$MOD['id']."'>✎ Update Content</a></small><br /><br />"; }
	}
	$checkuserModCount = $_SQL->query("SELECT * FROM files WHERE uid = '".$_USER['id']."'");
	$userModCount = $checkuserModCount->num_rows;
	if ($voteCount == 0) { 
		$thumbs = "<style>
		#vote {
		display:block; 
		border:none; 
		width:120px; font-family:sans-serif; color:white; margin-right:20px;
		padding-bottom:3px;
		} 
		</style>
		<a href='/files.php?upvote&id=".$MOD['id']."'>
		<img onmouseover=\"this.src='/css/images/vote/".$_SESSION['theme'].".png';\" 
		onmouseout=\"this.src='//cdn.discordapp.com/attachments/227232976763748355/260872266219257856/VoteOff.png';\" 
		src='//cdn.discordapp.com/attachments/227232976763748355/260872266219257856/VoteOff.png' id='vote' type='submit' title='Vote on this content! Give this post a +1.' /></a>"; 
	}
	if ($voteCount > 0) { $thumbs = "<span style='color:white; font-family:sans-serif; font-size:small; color:grey;' title=\"You've already liked this post with a +1\">&#9733; Upvoted &nbsp;&nbsp;</span>"; }
	if ($MOD['uid'] == $_USER['id']) { $thumbs = ""; $onClick = " onclick=\"alert('You must login or register to download content!'); return false;\""; }
	if (!isset($_USER['id'])) { $thumbs = ''; }
	$invert = ''; if ($_SESSION['theme'] == 'b' OR $_SESSION['theme'] == 'o') { $invert="filter:invert(100%);"; }
	$modimg = "<img src=\"/css/images/file_icons/mod/".$_USER['theme'].".png\" style='margin-top:-3px;' width='38' />";
	if ($MOD['type'] == 'game') { 
		$modimg = "<img src=\"/css/images/file_icons/game/".$_USER['theme'].".png\" width='25' />"; 
	} elseif ($MOD['type'] == 'app') {
		$modimg = "<img src=\"/css/images/file_icons/app/".$_USER['theme'].".png\" width='28' style='padding-bottom:3px;' />";
	} elseif ($MOD['type'] == 'config') {
		$modimg = "<img src=\"/css/images/file_icons/config/".$_USER['theme'].".png\" width='28' style='padding-bottom:3px;".$invert."' />";
	} elseif ($MOD['type'] == 'variant') {
		$modimg = "<img src=\"/css/images/file_icons/variant/".$_USER['theme'].".png\" width='24' style='padding-bottom:3px;' />";
	} $useFMM = '';
	if ($MOD['type'] == 'mod') {
		$useFMM = " style='cursor:help;' title='DOUBLE CHECK IF THIS MOD IS AVAILABLE ON FMM\nTHIS VERSION MAY BE OUTDATED'";
	} $fmmecho= '';
	if ($_GET['id'] != 18 && $MOD['type'] == 'mod') { 
		$fmmecho = "<td style='color:black; text-align:center; max-width:15%; background:#fab4a5; border:1px solid red; font-size:8px; font-weight:bold;'>
<a href='/files.php?id=18' style='color:black!important;'>Use FMM to install Mods</a></td>"; 
	}
	$modTitle = preg_replace("/\.?\s*([^\.]+):/", "<span title='$1'>", $MOD['title']);
	$fType1 = str_replace('mod', 'Tag&nbsp;Edit', $MOD['type']);
	$fType2 = str_replace('app', 'Application', $fType1); $target="target='_blank'";
	$fType = str_replace('config', 'Configuration', $fType2); $support = ''; $dlt = "Download File";
	if ($_GET['id'] == 22) {$dlt = "Download Official MLG Pack";}
	if ($_GET['id'] == 30) {$target="title='This download is contained in the body text' onclick=\"return false;\" style=\"cursor:crosshair;\"";}
	if (!empty($MOD['support'])) { $support = "<td><a href=\"".$MOD['support']."\">[Support]</a></td>"; }
	echo "<h3>".$modimg."&nbsp;".$modTitle."<div style='float:right; margin-top:5px; margin-right:5px;'>".$thumbs."</div></h3>"
		."<div id='contentHolder' class='contentHolder'>
		<table id='modInfo' width='100%' style='dislay:block; position:relative:absolute; right:-20px;'><tr style='float:right;'>".$fmmecho.$support."";
			echo "<td><b>File Type:</b> <a href='/files.php?type=".preg_replace('/[^0-9a-zA-Z_-]/', '', $MOD['type'])."'>".ucwords($fType)."</a></td>
		<td><b>Creator:</b> <a href='/search.php?find=".$MOD['creator']."'>".$MOD['creator']."</a></td>
		<td><b title='Views are only counted once every 12 hours unless you are a unique visitor.'>Views:</b> ".$totalViews."</td>
		<td><b>Downloads:</b> ".$MOD['downloads']."</td>
		<td><b>Upvotes:</b> ".$totalVotes."</td></tr></table>
		<div class='row'><div class='col-md-12' style='margin-top:15px; max-height:900px; overflow:auto;'>".$cleanInfo;
		if (!empty($MOD['directURL']) && $MOD['type']=='variant') { print "<center><code><pre>"; print_r(file_get_contents('http://127.0.0.1/file_details.php?enc&variant='.$MOD['directURL'])); print "</pre></code></center>"; }
		echo"</div></div>
		<hr style='border:1px dashed; opacity:0.2;' />
		<div style='display:flex; line-height:10px; align-items:center;' class='row'>
		<div class='col-md-6' style='text-align:left;'><div class='dlMap' style='text-align:center;'>
		<small><a href='/files.php?dl&id=".$MOD['id']."' ".$target.">&#128190; <b".$useFMM.">".$dlt."</a></small>
		</b></div></div>"
		."<div style='text-align:right;' class='col-md-6'><small><img src=\"".$getUsr['avatar']."\" width='20' style='padding:-2px;' /> <a href='/users.php?id=".$MOD['uid']."'>".$MODuser."</a> submitted this <span title='".dateConvert2($MOD['date'])."'>".dateConvert($MOD['date'])."</span></small></div>"
		."</div></div>";
	/* List & Post Comments */
	$grabComments = $_SQL->query("SELECT * FROM notifications where mod_id = '".$_GET['id']."' AND type = 'mod' ORDER BY id DESC");
	echo "<br /><h4>&#128172; Responses</h4><div id='contentHolder' class='contentHolder'>";
	$cmntCount = $grabComments->num_rows;
	if ($cmntCount == 0) { echo "No responses yet.<br /><br />"; } else { echo "<span style='border:1px solid #666; padding:1px; float:right; font-size:small;'>Total Responses: ".$cmntCount."</span>"; }
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
					$mod_ut = trim(str_replace('@', '', $ut));
					$user_id = $_SQL->query("SELECT `id` FROM users where uname='{$mod_ut}'")->fetch_object()->id;
					if (!empty($user_id)) { $displayedCMNT = str_replace($ut, "<a href='users.php?id=".$user_id."'>".$ut."</a>", $displayedCMNT); }
					else { $displayedCMNT = str_replace($ut, "".$ut."", $displayedCMNT); }
				}
			}
			echo "<div class='comment' style='margin:0 auto;' id='".$cmnt['id']."'><h5><a href='/users.php?id=".$cmntUser['id']."'>".$cmntUser['uname']."</a>&nbsp; responded&nbsp; <span title='".dateConvert2($cmnt['date'])."'>".dateConvert($cmnt['date'])."</span>";
			if (isset($_USER['id'])) {
				if ($cmnt['from_id'] == $_USER['id'] OR $_USER['group'] > 1) { echo "<div style='float:right; min-height:20px; margin-right:15px;'><small><a href='/files.php?id=".$_GET['id']."&ec=".$cmnt['id']."'><b>✎</b> Edit</a></small></div>"; }
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
		$checkMapSpam = $_SQL->query("SELECT id FROM maps where uid = '{$_USER['id']}' AND `date` > date_sub(CURRENT_TIMESTAMP, INTERVAL 8 MINUTE)");
		$checkModSpam = $_SQL->query("SELECT id FROM files where uid = '{$_USER['id']}' AND `date` > date_sub(CURRENT_TIMESTAMP, INTERVAL 8 MINUTE)");
		$checkComSpam = $_SQL->query("SELECT id FROM community where uid = '{$_USER['id']}' AND `date` > date_sub(CURRENT_TIMESTAMP, INTERVAL 8 MINUTE)");
		$checkCmntSpam = $_SQL->query("SELECT id FROM notifications where from_id = '{$_USER['id']}' AND `date` > date_sub(CURRENT_TIMESTAMP, INTERVAL 3 MINUTE)");
		$checkModSpam = $checkModSpam->num_rows;
		$checkComSpam = $checkComSpam->num_rows;
		$checkMapSpam = $checkMapSpam->num_rows;
		$checkCmtSpam = $checkCmntSpam->num_rows;
		$checkSpam = $checkMapSpam + $checkModSpam + $checkComSpam + $checkCmtSpam;
		if ($checkSpam < 3) {  
			$_SQL->query("INSERT INTO notifications (comment, to_id, from_id, type, mod_id, forge_id) VALUES ('".$cmntBody."', '".$MOD['uid']."', '".$_USER['id']."', 'mod', '".$_GET['id']."', '0')") or die($_SQL->error);
			$grabcID = $_SQL->query("SELECT * FROM notifications WHERE type = 'mod' AND mod_id = '{$_GET['id']}' ORDER BY id DESC LIMIT 1"); } else { die("<script>alert('You are posting too often.');</script>"); }
		$c = $grabcID->fetch_assoc();
		$cID = $c['id'];
		if (!empty($username_matches)) {
			foreach($username_matches as $ut) {
				$ut = trim(str_replace('@', '', $ut));
				$user_id = $_SQL->query("SELECT `id` FROM users where uname='{$ut}'")->fetch_object()->id;
				if (!empty($user_id) && $user_id != $getUsr['id']) { $_SQL->query("INSERT INTO notifications (to_id, from_id, mod_id, forge_id, type, comment) values ('{$user_id}', '{$_USER['id']}', '{$MOD['id']}', '0', 'tag', '{$cID}')"); }
			}
		}
		$commentAmnt = $cmntCount + 1;
		$_SQL->query("FROM `files` files SET replies = '{$commentAmnt}' WHERE id = '{$_GET['id']}'");
		if ($_USER['id'] != $MOD['uid']) { echo "<script>alert(\"Response posted. ".$MODuser." has been informed of your response. If any users have been tagged, they have also been notified.\");</script>"; }
		if ($_USER['id'] == $MOD['uid']) { echo "<script>alert(\"Response posted. If any users have been tagged, they have been notified.\");</script>"; }
		echo "<META HTTP-EQUIV=\"Refresh\" Content=\"0;#comments\" />";
	} if (isset($_POST['postcmnt']) && empty($_POST['cmnt'])) { 
		echo "<script>alert(\"It seems you have left the comment field blank. Try Again!\");</script>";
	} echo "</div>";
	/* Mods Voting System */
	if (isset($_GET['upvote']) && isset($_USER['id'])) { 
		if ($_USER['id'] != $MOD['uid']) {
			if ($voteCount > 0 && $_USER['id'] != $MOD['uid']) { 	
				echo "<script>alert(\"You can only vote once!\");</script>"; 
				echo "<meta http-equiv='refresh' content='0;/files.php?id=".$MOD['id']."' /> ";
			} else {
				$IntotalVotes = $totalVotes + 1;
				$_SQL->query("UPDATE `files` files set votes='".$IntotalVotes."' WHERE `id` ='".$_GET['id']."'") or die($_SQL->error);
				$_SQL->query("INSERT INTO notifications (from_id, to_id, comment, type, mod_id, forge_id) VALUES ('".$_USER['id']."', '".$MOD['uid']."', '+1', 'vote', '".$MOD['id']."', '0')") or die($_SQL->error);
				echo "<script>alert(\"You've upvoted the mod: ".$MOD['title'].". +1 point.\");</script>"; 
				echo "<meta http-equiv='refresh' content='0;/files.php?id=".$MOD['id']."' /> ";
			}
		} else { 
			echo "<script>alert(\"You can't vote on your own content!\");</script>"; 
			echo "<meta http-equiv='refresh' content='0;/files.php?id=".$MOD['id']."' /> ";
		}
	} elseif (isset($_GET['upvote']) && !isset($_USER['id'])) {
		echo "<script>alert(\"You must login first to vote on content!\");</script>"; 
		echo "<meta http-equiv='refresh' content='0;/files.php?id=".$MOD['id']."' /> ";
	} /* Download Mod */
	if (isset($_GET['dl'])) {
		if (isset($_USER['id'])) {
			$grabDLs = $_SQL->query("SELECT * FROM downloads WHERE mod_id = '{$modid}' AND (user = '{$loggedU}' OR ip='{$_SERVER['REMOTE_ADDR']}')") or die($_SQL->error);
			$DL = $grabDLs->fetch_assoc();
			$uDcount = $grabDLs->num_rows;
			$Dth3n = $DL['last_viewed'];
			$Dthen = strtotime($Dth3n);
			$Ddifference = $now - $Dthen;
			if($Ddifference > 21600 AND $uDcount < 1 AND $_USER['id'] != $MOD['uid']) { $_SQL->query("INSERT INTO downloads (mod_id, user, ip, last_viewed) VALUES ('{$_GET['id']}', '{$loggedU}', '{$_SERVER['REMOTE_ADDR']}', CURRENT_TIMESTAMP)") or die($_SQL->error); }
			$totalDownloads = $totalDLs + 1;
			$_SQL->query("UPDATE `files` set downloads='".$totalDLs."' WHERE id = '".$_GET['id']."'") or die($_SQL->error);
			
			if ($_GET['id'] == -1) {
				if ($_USER['group'] > -3 && $_USER['group'] < 1) { 
					die("<script>alert(\"Only official beta testers approved from discord may access this download. Use the public versions of EnhancedForge & Forge Improvements tool in the meantime, or login with an authenticated account\");
					close();</script>"); 
				} else { echo "<script>location='mfga.php';</script>"; }
			} else {
				die("<h1 style='zIndex:0;'>Please Wait while we fetch your download.</h1><script>window.location.replace('".$MOD['url']."');</script>");
			}
		} else { echo "<script>alert(\"You must login or register to download this content.\"); window.location.replace('/files.php?id=".$DL['mod_id']."');</script>"; }
	}
} // LIST ALL FILES
if (!isset($_GET['new']) && !isset($_GET['id']) && !isset($_GET['uid']) && !isset($_GET['change']) && !isset($_GET['creator']) && $modCount != 0) {
	echo "In-game modifications, tools, variants, & configuration!<br /> <h3>💾 Downloadable Content</h3><div id='contentHolder' class='contentHolder'>";
	$pst=''; if (isset($_USER['id'])) { $pst = "<a href='/files.php?new'>☲ Post New</a>"; }
	echo "<div class='row' style='font-size:small; display:flex; align-items:center; text-align:right; min-width:100%;'> 
<div class='col-md-6' style='font-size:large; text-align:left;'>".$pst."</div>
<div class='col-md-3'>".$filterForm."</form></div>
<div class='col-md-3'>".$oForm."</div>
</div><hr style='opacity:0.2;' />
<div class='row' id='row' style='text-align:center; font-size:small;'><div class='col-md-1''></div><div class='col-md-5' style='text-align:left; padding-left:20px;'><b>Name</b></div><div class='col-md-2'><b>Creator</b></div><div class='col-md-2'><b>Date</b></div><div class='col-md-2'></div></div><br />"
		."<div id='forgeList' data-load-more='20' class='forgeList' style='min-width:100%;'>";
	while ($MODS = $listMods->fetch_assoc()) {
		$modDate = dateConvert($MODS['date']);
		$uSQL = $_SQL->query("SELECT * FROM users WHERE id = '".$MODS['uid']."'");
		$views = $_SQL->query("SELECT id FROM views WHERE `mod_id`='{$MODS['id']}'")->num_rows;
		$sub = $uSQL->fetch_assoc();
		$submitter = $sub['uname'];
		$creator = $MODS['creator'];
		$invert = '';
		$replies = $MODS['replies'];
		$votez = $_SQL->query("SELECT id FROM notifications WHERE type='vote' AND mod_id='{$MODS['id']}'")->num_rows;
		$MODSt = preg_replace("/\.?\s*([^\.]+):/", "</a><sup style='display:block; font-size:8px; font-weight:normal;'>$1</sup><a href=\"/files.php?id=".$MODS['id']."\">", $MODS['title']."</a>");
		if ($MODS['type'] == 'config') {
			$type = "<img src='/css/images/file_icons/config/".$_SESSION['theme'].".png' width='38' />";
		} elseif ($MODS['type'] == 'mod') {
			$type = "<img src='/css/images/file_icons/mod/".$_SESSION['theme'].".png' width='43' />";
		} elseif ($MODS['type'] == 'app') {
			$type = "<img src='/css/images/file_icons/app/".$_SESSION['theme'].".png' width='40' height='40' />";
		} elseif ($MODS['type'] == 'game') {
			$type = "<img src='/css/images/file_icons/game/".$_SESSION['theme'].".png' width='40' />";
		} elseif ($MODS['type'] == 'variant') {
			$type = "<img src='/css/images/file_icons/variant/".$_SESSION['theme'].".png' width='40' />";
		}
		if ($submitter == $MODS['creator']) { $creator = "<a href='users.php?id=".$MODS['uid']."'>".$submitter."</a>"; }
?>
<div class="row" style="min-height:70px; padding:5px; text-align:center; font-size:small; display:flex; align-items:center;">
	<div class="col-md-1" title="File Type: <?=ucwords($MODS['type']);?>"><a href="/files.php?id=<?=$MODS['id'];?>"><span style='font-size:xx-large; font-weight:bold;'><?=$type;?></span></a></div>
	<div class="col-md-5" title="File Type: <?=ucwords($MODS['type']);?>" style="text-align:left; padding-left:20px;"><b><a href="/files.php?id=<?=$MODS['id'];?>"><?=$MODSt;?></a></b></div>
	<div class="col-md-2"><a href="search.php?find=<?=$MODS['creator'];?>"><?=$MODS['creator'];?></a></div>
	<div class="col-md-2" style="font-size:x-small;"><em><?=$modDate;?></em></div>
	<div class="col-md-2" title='Views: <?=$views;?>' style="font-size:xx-small; float:right; text-align:left;">
		👍 Upvotes: <?=$votez;?><br />
		💬 Replies: <?=$replies;?><br />
		💾 Downloads: <?=$MODS['downloads'];?></div>
</div>
<?php
	}
	echo "<!-- end load-more --></div><br />";
	echo "<div id='loadMoreF' class='loadMore' data-action='load-more' data-bound='forgeList'><a>&#x21bb; <small>Load More</small></a></div>"; 
	if (isset($_USER['id']) && $modCount > 8) { echo "<div style='float:right; margin-right:20px;'><a href='/files.php?new'>☲ Post New</a></div><br /><br />"; }	echo "</div>";
} // LIST FILES BASED ON SUBMITTED USER
if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {
	$listMods = $_SQL->query("SELECT * FROM files WHERE uid = '{$_GET['uid']}' ORDER BY ".$orderBY." DESC");
	$modUcount = $listMods->num_rows;
	$grabU = $_SQL->query("SELECT * FROM users WHERE id ='{$_GET['uid']}'");
	$userr = $grabU->fetch_assoc();
	$sName = $userr['uname']; $alias = '';
	if (!empty($userr['alias'])) { $alias = "also known as ".$userr['alias'].""; }
	echo "In-game modifications, tools, variants, & configuration!<br /> <h3>💾 Files submitted by <span title='".$alias."'>".$sName."</span></h3><div id='contentHolder' class='contentHolder'>";
	if (isset($_USER['id'])) { echo "<a href='/files.php?new'>☲ Post New</a> "; }
	echo $oForm;
	echo "<br /><br /><div class='row' id='row' style='text-align:center; font-size:small;'><div class='col-md-1''></div><div class='col-md-5' style='text-align:left; padding-left:20px;'><b>Name</b></div><div class='col-md-2'><b>Creator</b></div><div class='col-md-2'><b>Date</b></div><div class='col-md-2'></div></div><br />"
		."<div id='forgeList' data-load-more='20' class='forgeList' style='min-width:100%;'>";
	while ($MODS = $listMods->fetch_assoc()) {
		$modDate = dateConvert($MODS['date']);
		$uSQL = $_SQL->query("SELECT * FROM users WHERE id = '".$MODS['uid']."'");
		$views = $_SQL->query("SELECT id FROM views WHERE `mod_id`='{$MODS['id']}'")->num_rows;
		$sub = $uSQL->fetch_assoc();
		$submitter = $sub['uname'];
		$creator = $MODS['creator'];
		$invert = '';
		if ($_SESSION['theme'] == 'b' OR $_SESSION['theme'] == 'o') { $invert="style='filter:invert(100%);' "; }
		$replies = $MODS['replies'];
		$MODSt = preg_replace("/\.?\s*([^\.]+):/", "</a><sup style='display:block; font-size:8px; font-weight:normal;'>$1</sup><a href=\"/files.php?id=".$MODS['id']."\">", $MODS['title']."</a>");
		if ($MODS['type'] == 'config') {
			$type = "<img src='https://cdn4.iconfinder.com/data/icons/mosaicon-08/512/data_settings-512.png' width='40' ".$invert."/>";
		} elseif ($MODS['type'] == 'mod') {
			$type = "<img src='https://cdn.discordapp.com/attachments/242170775921098753/270086498659991552/ModsIcon2.png' width='43' ".$invert."/>";
		} elseif ($MODS['type'] == 'app') {
			$type = "<img src='/css/images/app.png' width='40' />";
		} elseif ($MODS['type'] == 'game') {
			$type = "<img src='//i.imgur.com/R3B2moA.png' width='40' />";
		} elseif ($MODS['type'] == 'variant') {
			$type = "<img src='/css/images/haloshare.png' width='40' />";
		}
		if ($submitter == $MODS['creator']) { $creator = "<a href='users.php?id=".$MODS['uid']."'>".$submitter."</a>"; }
?>
<div class="row" style="min-height:70px; padding:5px; text-align:center; font-size:small; display:flex; align-items:center;">
	<div class="col-md-1"><a href="/files.php?id=<?=$MODS['id'];?>"><span style='font-size:xx-large; font-weight:bold;'><?=$type;?></span></a></div>
	<div class="col-md-5" style="text-align:left; padding-left:20px;"><b><a href="/files.php?id=<?=$MODS['id'];?>"><?=$MODSt;?></a></b></div>
	<div class="col-md-2"><a href="search.php?find=<?=$MODS['creator'];?>"><?=$MODS['creator'];?></a></div>
	<div class="col-md-2" style="font-size:x-small;"><i><?=$modDate;?></i></div>
	<div class="col-md-2" title='Views: <?=$views;?>' style="font-size:xx-small; float:right; text-align:left;">Replies: <?=$replies;?><br />Upvotes: <?=$MODS['votes'];?><br />Downloads: <?=$MODS['downloads'];?></div>
</div>
<?php
	}
	echo "<!-- end load-more --></div><br />";
	echo "<div id='loadMoreF' class='loadMore' data-action='load-more' data-bound='forgeList'><a>&#x21bb; <small>Load More</small></a></div>"; 
	if (isset($_USER['id']) && $modCount > 8) { echo "<div style='float:right; margin-right:20px;'><a href='/files.php?new'>☲ Post New</a></div><br /><br />"; }	echo "</div>";

} // POST NEW MOD
if (isset($_GET['new'])) {
	if (isset($_USER['id'])) {
		if (!isset($_POST['postsubmit'])) {
			echo $html;
		} else {
			$modtitle = $_SQL->real_escape_string(htmlentities($_POST['title']));
			$modauthor = $_SQL->real_escape_string(htmlentities($_POST['author']));
			$modsup = $_SQL->real_escape_string(htmlentities($_POST['support']));
			$moddlink = $_SQL->real_escape_string(htmlentities($_POST['url']));
			$ftype = $_SQL->real_escape_string(preg_replace('/[^ \w0-9a-zA-Z_-]/', '', $_POST['type']));
			$modinfo = $_SQL->real_escape_string($_POST['info']);
			$modposter = $_USER['id'];
			$checkMapSpam = $_SQL->query("SELECT id FROM maps where uid = '{$_USER['id']}' AND `date` > date_sub(CURRENT_TIMESTAMP, INTERVAL 8 MINUTE)");
			$checkModSpam = $_SQL->query("SELECT id FROM files where uid = '{$_USER['id']}' AND `date` > date_sub(CURRENT_TIMESTAMP, INTERVAL 8 MINUTE)");
			$checkComSpam = $_SQL->query("SELECT id FROM community where uid = '{$_USER['id']}' AND `date` > date_sub(CURRENT_TIMESTAMP, INTERVAL 8 MINUTE)");
			$checkCmntSpam = $_SQL->query("SELECT id FROM notifications where uid = '{$_USER['id']}' AND `date` > date_sub(CURRENT_TIMESTAMP, INTERVAL 3 MINUTE)");
			$checkModSpam = $checkModSpam->num_rows;
			$checkComSpam = $checkComSpam->num_rows;
			$checkMapSpam = $checkMapSpam->num_rows;
			$checkCmtSpam = $checkCmntSpam->num_rows;
			$checkSpam = $checkMapSpam + $checkModSpam + $checkComSpam + $checkCmtSpam;
			if (empty($modauthor)) { $modauthor = $_USER['name']; }
			if (empty($modtitle) OR empty($moddlink) OR empty($modinfo) OR $checkSpam > 2) {
				echo $html;
				echo "<script>alert(\"Either you are postng too often, or have left a required field blank.\");</script>";
			} else {
				$p='y'; if (isset($_POST['public'])) {$p='n';}
				$_SQL->query("INSERT into `files` (uid, title, creator, url, support, info, `date`, type, public) VALUES ('".$modposter."', '".$modtitle."', '".$modauthor."', '".$moddlink."', '".$modsup."', '".$modinfo."', CURRENT_TIMESTAMP, '{$ftype}', '{$p}')") or die($_SQL->error);
				$getmodID = $_SQL->query("SELECT * FROM files where title = '".$modtitle."' AND uid = '{$_USER['id']}'") or die($_SQL->error);
				$yourmod = $getmodID->fetch_assoc();
				echo "<b>".$modtitle."</b> has been posted! You can see your content <a href='/files.php?id=".$yourmod['id']."'>here</a>.
<span style='margin-top:40px; font-size:xx-small; text-align:center; display:block; width:100%;'>
<i>You will be automatically redirected</i></span>
<meta http-equiv=\"refresh\" content=\"3;url=/files.php?id=".$yourmod['id']."\" />";
			}
		}
	} else { echo "<span style='color:red;'>You must <a href='login.php'>login</a> or <a href='reg.php'>register</a> first in order to post new content!</span>"; }
} // EDIT FILE
if (isset($_GET['change']) && is_numeric($_GET['change']) && isset($_USER['id']) && $modCount != 0) {
	$modid = $_GET['change'];
	$grabMod = $_SQL->query("SELECT * FROM files WHERE id = '".$modid."'");
	$modMod = $grabMod->fetch_assoc();
	$fileType = $modMod['type'];
	if ($fileType == 'config') {
		$opType = "<select name='type'>
<option value='config' title='Files used to edit the game, usually useful for console commands through rcon, & used to bind keys'>Configuration</option>
<option value='mod' title='Usually a tag modification to the game, almost always used with Foundation Mod Manager'>Tag Edit</option>
<option value='app' title='External tools used to modify the game, example would be FMM, and the way it handles mod installation'>Application</option>
<option value='variants' title='This mainly exists as a way to submit gametypes, or variant patches.'>Variants</option>
</select>";
	} elseif ($fileType == 'app') {
		$opType = "<select name='type'>
<option value='app' title='External tools used to modify the game, example would be FMM, and the way it handles mod installation'>Application</option>
<option value='config' title='Files used to edit the game, usually useful for console commands through rcon, & used to bind keys'>Configuration</option>
<option value='mod' title='Usually a tag modification to the game, almost always used with Foundation Mod Manager'>Tag Edit</option>
<option value='app' title='External tools used to modify the game, example would be FMM, and the way it handles mod installation'>Application</option>
<option value='variants' title='This mainly exists as a way to submit gametypes, or variant patches.'>Variants</option>
</select>";
	} elseif ($fileType == 'game' && $_USER['group'] > 1) {
		$opType = "<select name='type'>
<option value='game' title='Actual game file. Can be prepackaged released etc. Must have elevated priveledges to post.'>Game</option>
<option value='app' title='External tools used to modify the game, example would be FMM, and the way it handles mod installation'>Application</option>
<option value='config' title='Files used to edit the game, usually useful for console commands through rcon, & used to bind keys'>Configuration</option>
<option value='mod' title='Usually a tag modification to the game, almost always used with Foundation Mod Manager'>Tag Edit</option>
<option value='app' title='External tools used to modify the game, example would be FMM, and the way it handles mod installation'>Application</option>
<option value='variants' title='This mainly exists as a way to submit gametypes, or variant patches.'>Variants</option>
</select>";
	} elseif ($fileType == 'mod') {
		$opType = "<select name='type'>
<option value='mod' title='Usually a tag modification to the game, almost always used with Foundation Mod Manager'>Tag Edit</option>
<option value='config' title='Files used to edit the game, usually useful for console commands through rcon, & used to bind keys'>Configuration</option>
<option value='mod' title='Usually a tag modification to the game, almost always used with Foundation Mod Manager'>Tag Edit</option>
<option value='app' title='External tools used to modify the game, example would be FMM, and the way it handles mod installation'>Application</option>
<option value='variants' title='This mainly exists as a way to submit gametypes, or variant patches.'>Variants</option>
</select>";
	} elseif ($fileType == 'variant') {
		$opType = "<select name='type'>
<option value='variants' title='This mainly exists as a way to submit gametypes, or variant patches.'>Variants</option>
<option value='config' title='Files used to edit the game, usually useful for console commands through rcon, & used to bind keys'>Configuration</option>
<option value='mod' title='Usually a tag modification to the game, almost always used with Foundation Mod Manager'>Tag Edit</option>
<option value='app' title='External tools used to modify the game, example would be FMM, and the way it handles mod installation'>Application</option>
</select>";
	} else {
		$opType = "<select name='type'>
<option value='config' title='Files used to edit the game, usually useful for console commands through rcon, & used to bind keys'>Configuration</option>
<option value='variants' title='This mainly exists as a way to submit gametypes, or variant patches.'>Variants</option>
<option value='mod' title='Usually a tag modification to the game, almost always used with Foundation Mod Manager'>Tag Edit</option>
<option value='app' title='External tools used to modify the game, example would be FMM, and the way it handles mod installation'>Application</option>
</select>";
	}
	if ($_USER['group'] > 1 OR $_USER['id'] == $modMod['uid']) { 
		$ch=''; if ($modMod['public'] == 'n') {$ch='checked';}
		$modhtml = "<h3>Edit File: ".$modMod['title']."</h3><div id='contentHolder' style='padding-left:60px; padding-right:60px;' class='contentHolder'>
⚙ <small>= Required field.</small><br />"
			."<small>We highly recommend using <a href='http://drive.google.com/'>Google Drive</a>,
as it gives you the quickest & easiest method of managing versions of your files without changing the download url.</small><br /><br />
<div style='float:center; border:1px dashed grey; padding:20px; border-radius:5px;'>"
			."<table style='min-width:100%;'><form method='post'>"
			."<tr><td>Title: </td><td><input type='text' name='title' value='".$modMod['title']."' required/> &nbsp;&nbsp;&nbsp;Type: ".$opType."<div style='font-size:x-small; color:grey; display:flex; align-items:center; float:right; padding:2px;' title='Add map to databse, but hide post from public view. This is useful if you want to save this for later.'><input type='checkbox' id='public' name='public' ".$ch." /> Leave Unpublished?</div></td></tr>"
			."<tr><td>Creator: </td><td><input type='text' name='author' value='".$modMod['creator']."' /></td></tr>"
			."<tr><td>Download: </td><td><input type='text' name='url' value='".$modMod['url']."' required/></td></tr>"
			."<tr><td>Support: </td><td><input type='text' name='support' value='".$modMod['support']."' /></td></tr>"
			."<tr><td>Info:</td><td><br />".$bbcode_buttons."<textarea cols='100%' rows='15' name='info' id='edit' required>".$modMod['info']."</textarea></td></tr>"
			."<tr><td></td><td><input type='submit' value='Save Changes' name='modsubmit' /> 
<input style='color:red; min-width:70px;' value='Cancel' type='button' onClick=\"location.href='/files.php?id=".$modMod['id']."';\" />
<div style='float:right; text-align:right;'>
<input style='min-width:110px;' type='submit' value='Delete File' name='deletemod' onclick=\"return confirm('Are you sure you want to delete this item? All relevant upvotes, downloads, views, & responses will also be removed!');\" />
</div></td></tr>"
			."</form></table><br /><br /></div>";
		if (!isset($_POST['modsubmit'])&& !isset($_POST['deletemod'])) {
			echo $modhtml;
		} elseif (isset($_POST['modsubmit'])) {
			$modtitle = $_SQL->real_escape_string(htmlentities($_POST['title']));
			$modauthor = preg_replace('/[^ \w0-9a-zA-Z_-]/', '', $_POST['author']);
			$moddlink = $_SQL->real_escape_string(htmlentities($_POST['url']));
			$modsup = $_SQL->real_escape_string(htmlentities($_POST['support']));
			$filetype = preg_replace('/[^0-9a-zA-Z_-]/', '', $_POST['type']);
			$modinfo = $_SQL->real_escape_string($_POST['info']);
			if (empty($modtitle) OR empty($moddlink) OR empty($modinfo)) {
				echo $modhtml;
				echo "<span style='color:red;'>Please ensure you haven't left any required fields blank.</span>";
			} else {
				$p='y'; if (isset($_POST['public'])) {$p='n';}
				$_SQL->query("UPDATE files set title='".$modtitle."', type='".$filetype."', creator='".$modauthor."', url='".$moddlink."', support='".$modsup."', info='".$modinfo."', public='{$p}', edited='".date("Y-m-d H:i:s")."' WHERE id = '".$_GET['change']."'") or die($_SQL->error);
				$getmodID = $_SQL->query("SELECT * FROM files where id = '".$_GET['change']."'");
				$yourmod = $getmodID->fetch_assoc();
				echo "<b>".$modtitle."</b> has been modified! You can see your changes <a href='/files.php?id=".$yourmod['id']."'>here</a>.
<span style='margin-top:40px; font-size:xx-small; text-align:center; display:block; width:100%;'>
<i>You will be automatically redirected</i></span>
<meta http-equiv=\"refresh\" content=\"3;url=/files.php?id=".$_GET['change']."\" />";
			}
		} elseif (isset($_POST['deletemod'])) {
			$_SQL->query("DELETE FROM files WHERE id = '".$_GET['change']."'") or die($_SQL->error);
			$_SQL->query("DELETE FROM notifications WHERE mod_id = '".$_GET['change']."'");
			echo "<script>alert(\"Your mod has been deleted! All relevant responses, upvotes, etc have also been removed!\"); location.replace(\"files.php\");</script>";
		}
	} else { echo "<span style='color:red;'>You are not authorized to modify this content. Only the original poster, a moderator, or an administrator may perform this action.</span><br />"; }
} echo "</div>";
include_once "inc/footer.php";
?>