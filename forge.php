<?php include_once "inc/core.php"; error_reporting(E_ALL & ~E_NOTICE);
include_once "inc/header.php";
echo "<div class='content'>"
	."<div class='contentHeader'>Forge</div>
	<div class='row' style='margin-bottom:35px;'><div class='col-md-6' style='text-align:left;'>Build, browse, & share maps created in Halo Online!</div>
<div class='col-md-6' style='text-align:right;'><span style='border:1px dotted black; padding:2px; background:#333; opacity:0.7;'>
<a href='community.php?id=82' title='Click here for further clarification.'>📋 Upload & Install Instructions</a>
</span></div></div>";
$selectGame = "<span title='Leave untouched if map is compatible with multiple gametypes.'><select name='gametype'>
<option value='multiple'>&#127918; Gametype</option>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='juggernaut'>Juggernaut</option>
<option value='vip'>VIP</option>
<option value='territories'>Territories</option>
<option value='assault'>Assault</option>
<option value='ctf'>Capture The Flag</option>
<option value='oddball'>Oddball</option>
<option value='koth'>King of The Hill</option>
</select></span>";
$selectMap = "<select name='map' required>
<option value=''>&#9874; Original Map</option>
<option value='guardian'>Guardian</option>
<option value='the pit'>The Pit</option>
<option value='standoff'>Standoff</option>
<option value='valhalla'>Valhalla</option>
<option value='reactor'>Reactor</option>
<option value='icebox'>Icebox</option>
<option value='sandtrap'>Sandtrap</option>
<option value='diamondback'>Diamondback</option>
<option value='last resort'>Last Resort</option>
<option value='narrows'>Narrows</option>
<option value='high ground'>High Ground</option>
<option value='edge'>Edge*</option>
<option value='flatgrass'>Flatgrass*</option>
</select>";
$Ztitle='';
$Zcreator='';
$Zimg='';
$Zdl='';
$Zbody='';
if (isset($_POST['postsubmit'])) {
	$Ztitle = htmlspecialchars($_POST['title']);
	$Zcreator = htmlspecialchars($_POST['author']);
	$Zimg= htmlspecialchars($_POST['img']);
	$Zdl = htmlspecialchars($_POST['url']);
	$Zbody = htmlspecialchars($_POST['info']);
}
$postNew = "<span style='font-size:small;'><a href='javascript:history.back();'>← Go Back</a></span>"
	."<h3>⚒ Post New Map</h3><div id='contentHolder' class='contentHolder'>"
	."&#9874; <span style='font-size:small;'>= Required field.</span>"
	."<div style='font-size:x-small; float:right; max-width:20%; border:1px solid grey; padding:3px; text-align:center;'><a href='http://drive.google.com/'>Google Drive</a> recommended for quick and easy file version managment.</div>"
	."<br /><br /><div style='font-size:x-small; float:right; max-width:20%; border:1px solid grey; padding:3px; text-align:center;'>We encourage new content, just please be respectful and make sure to reference the correct author.<br /><br />Also, try to follow the basic <a href='community.php?id=82' title='Click here for further clarification.'>uploading and downloading guidelines.</a><br /></div>"
	."If the map has a specific variant under a certain gametype please try to include it in the title.<br />
<span style='font-size:small;'><span style='font-size:small;'><u>Examples:</u><br /><b>Fatkid:</b> Fatkid Fort<br />
<b>Drive or Die</b>: Zombie Roadrage<br />
<b>Ghostbusters</b>: Haunted House <br /></span></span><br /><br />\n"
	."<br /><table><form method='post'>"
	."<tr><td>".$selectMap." ".$selectGame."</td></tr>"
	."<tr><td><input value=\"".$Ztitle."\" type='text' name='title' style='font-size:small;' placeholder='&#9874; Forge Title' required /></td></tr>"
	."<tr><td><input value=\"".$Zcreator."\" type='text' name='author' style='font-size:small;' placeholder='Creator (if not you)' /></td></tr>"
	."<tr><td><input value='".$Zimg."' type='text' name='img' style='font-size:small;' placeholder='📷 Image Preview URL' /></td></tr>"
	."<tr><td><input value='".$Zdl."' title='Google Drive recommended for quick and easy file version managment.' type='text' name='url' style='font-size:small;' placeholder='💾 Download URL' required /><br /><div style='font-size:x-small; color:grey; display:flex; align-items:center; padding:2px;' title='Add map to databse, but hide the download link; requiring all download requests be approved first.'><input type='checkbox' id='public' name='public' value='r' /> Restrict Access?</div></td></tr>"
	."<tr><td><br />".$bbcode_buttons."<textarea id='edit' cols='100%' rows='15' name='info' placeholder='&#9874; Please include a short description of how the map is played, and its associated gametype. You may leave the gametype field blank if its for multiple gametypes. If the map requires its own special gametype, please include a link to the download here in the body text.' required>".$Zbody."</textarea></td></tr>"
	."<tr><td style='max-width:30%;'><input type='submit' value='Post Content' name='postsubmit' /><div style='font-size:x-small; color:grey; display:flex; align-items:center; float:right; padding:2px;' title='Add map to databse, but hide post from public view. This is useful if you want to save this for later.'><input type='checkbox' id='public' name='public' value='n' /> Leave Unpublished?</div></td></tr>"
	."</form></table></div><br /><br />";
$mapsC = $_SQL->query("SELECT id FROM maps WHERE public != 'n'");
$mapCount = $mapsC->num_rows;
if ($mapCount == 0 && !isset($_GET['new'])) {
	echo "There is currently no Forge content uploaded. Please feel free to <a href='/forge.php?new'>post new content</a>. <br /><br />";
} /* Edit & Delete Comment */
if (isset($_GET['ec']) && is_numeric($_GET['ec']) && is_numeric($_GET['id'])) {
	$grabcmnt=$_SQL->query("SELECT * FROM notifications WHERE id = '".$_GET['ec']."' AND type = 'map'");
	$eCmnt = $grabcmnt->fetch_assoc();
	$mapid = $_GET['id'];
	$grabMap = $_SQL->query("SELECT * FROM maps WHERE id = '".$mapid."'");
	$MAP = $grabMap->fetch_assoc();
	$mapimg = $MAP['img'];
	$oMAP = preg_replace('/[^0-9a-zA-Z_-]/', '', $MAP['map']);
	if (empty($mapimg) or !isImage($mapimg)) { $mapimg = "/css/images/maps/".getOmapName(preg_replace('/\s+/', '', $oMAP)).".jpg"; }
	$grabUsercmnt = $_SQL->query("SELECT * FROM users WHERE id = '".$eCmnt['from_id']."'");
	$cUSER = $grabUsercmnt->fetch_assoc();
	if ($eCmnt['from_id'] == $_USER['id'] OR $_USER['group'] > 1) {
		echo "<a href='javascript:history.back();'>← <span style='font-size:small;'>Go Back</span></a><br /><h3>⚒ ".$MAP['title']."</h3>
<div id='contentHolder' class='contentHolder' style=\"margin-top:auto; background-image:url('".$mapimg."'); bottom;\"><div class='comment' style='margin:0 auto; opacity:0.9;'><h5>".$cUSER['uname'].": Edit Response</h5><table align='center'>
<tr><td><img src=\"".$cUSER['avatar']."\" height='120px' width='120px' align='left' style='padding-right:15px;' /></td><td><form method='post'>
".$bbcode_buttons."<br /><textarea rows='7' cols='75%' name='editcmnt' id='edit' class='edit'>".$eCmnt['comment']."</textarea></td></tr>
<tr><td></td><td><input type='submit' name='cmnteditSubmit' value='Save Changes' /> <input type='submit' name='delCmnt' value='Delete Comment' onclick=\"return confirm('Are you sure you want to delete this item?');\" />
</td></tr></form></table><br /></div></div>";
		if (isset($_POST['cmnteditSubmit'])) {
			$cmntt = $_SQL->real_escape_string(htmlentities($_POST['editcmnt']));
			if (empty($cmntt)) { $cmntt = $eCmnt['comment']; }
			$_SQL->query("UPDATE notifications set comment='".$cmntt."' WHERE `id` ='".$_GET['ec']."'") or die($_SQL->error);
			echo "<script>alert(\"Response on ".$MAP['title']." has been modified!\");</script>"
				."<meta http-equiv='refresh' content='0;/forge.php?id=".$eCmnt['forge_id']."#".$eCmnt['id']."' />";
		} elseif (isset($_POST['delCmnt'])) {
			$_SQL->query("DELETE FROM notifications WHERE `id` = '".$_GET['ec']."' AND type = 'map'") or die($_SQL->error);
			$_SQL->query("DELETE FROM notifications WHERE `forge_id` = '".$_GET['id']."' AND comment = '{$_GET['ec']}' AND type = 'tag'") or die($_SQL->error);
			$rplies = $MAP['replies'] - 1;
			$_SQL->query("UPDATE maps SET replies = '{$rplies}' WHERE id ='{$_GET['id']}'");
			echo "<script>alert(\"Response on ".$MAP['title']." has been deleted!\");</script>"
				."<meta http-equiv='refresh' content='0;/forge.php?id=".$MAP['id']."' />";
		}
	} else { echo "<span style='color:red;'>You don't have permission to edit this comment. Only the responder, a moderator, or administrator may perform this action.</span>"; }
} // INDIVIDUAL FORGE VIEW
if (isset($_GET['id']) && is_numeric($_GET['id']) && $mapCount != 0 && !isset($_GET['ec'])) {
	$mapid = $_GET['id'];
	$grabMap = $_SQL->query("SELECT * FROM maps WHERE id = '".$mapid."'");
	$MAP = $grabMap->fetch_assoc();
	$mCnt = $grabMap->num_rows;
	if ($mCnt < 1) { die("<script>alert('Sorry, the content you requested does not exist yet.'); location.href='/forge.php';</script>"); }
	$getUser = $_SQL->query("SELECT * FROM users WHERE id = '".$MAP['uid']."'");
	$getUsr = $getUser->fetch_assoc();
	$MAPuser = $getUsr['uname'];
	$cleanInfo = nl2br(bb_parse(htmlspecialchars($MAP['info'])));
	$mapimg = $MAP['img'];
	$MAPgt = preg_replace('/[^ \w0-9a-zA-Z_-]/', '', $MAP['gametype']);
	$gIMG = "/css/images/variants/".$MAPgt.".png";
	$mapName = preg_replace('/[^ \w0-9a-zA-Z_-]/', '', $MAP['map']);
	$mapNameL = strtolower($mapName);
	$invert = "";
	if ($_SESSION['theme'] == "o" OR $_USER['theme'] == "b") { $invert = " filter:invert(100%);"; }
	$checkifVoted = $_SQL->query("SELECT * FROM notifications WHERE forge_id = '".$_GET['id']."' AND type = 'vote' AND from_id = '".$_USER['id']."'") or die($_SQL->error);
	$voteCount = $checkifVoted->num_rows;
	$getAllVotes = $_SQL->query("SELECT * FROM notifications WHERE forge_id = '".$_GET['id']."' AND type = 'vote'") or die($_SQL->error);
	$totalVotes1 = $getAllVotes->num_rows;
	$totalVotes = "+".$totalVotes1."";	
	/* Count Views */
	$loggedU = '0';
	if (isset($_USER['id'])) { $loggedU = $_USER['id']; }
	$grabViews = $_SQL->query("SELECT * FROM views WHERE map_id = '{$mapid}' AND (user = '{$loggedU}' OR ip='{$_SERVER['REMOTE_ADDR']}')");
	if (!isset($_USER['id'])) { 
		$grabViews = $_SQL->query("SELECT * FROM views WHERE map_id = '{$mapid}' AND ip = '{$_SERVER['REMOTE_ADDR']}'"); 
		$grabDLs = $_SQL->query("SELECT * FROM downloads WHERE map_id = '{$mapid}' AND ip = '{$_SERVER['REMOTE_ADDR']}'");
	} 
	$now = time();

	$VIEW = $grabViews->fetch_assoc();
	$uVcount = $grabViews->num_rows;
	$Vth3n = $VIEW['last_viewed'];
	$Vthen = strtotime($Vth3n);
	$Vdifference = $now - $Vthen;
	if($Vdifference > 21600 AND $uVcount < 1 AND $_USER['id'] != $MAP['uid']) { 
		$_SQL->query("INSERT INTO views (map_id, user, ip, last_viewed) VALUES ('{$_GET['id']}', '{$loggedU}', '{$_SERVER['REMOTE_ADDR']}', CURRENT_TIMESTAMP)"); 
	}
	$totalViewsSQL = $_SQL->query("SELECT * FROM views WHERE map_id = '{$_GET['id']}'");
	$totalViews = $totalViewsSQL->num_rows;



	if ($totalVotes1 == 0) { $totalVotes = "0"; }
	if (empty($mapimg) OR !isImage($mapimg)) $mapimg = "/css/images/maps/".getOmapName(str_replace(' ', '', $mapNameL)).".jpg";
	if ($MAP['gametype'] == "multiple" OR $MAP['gametype'] == "- Gametype") { $gIMG = "/css/images/variants/forge.png"; }
	if (isset($_USER['id'])) {
		if ($_USER['group'] > 1 OR $MAP['uid'] == $_USER['id']) { echo"<span style='font-size:small;'><a href='/forge.php?mod=".$MAP['id']."'>✎ Update Content</a></span><br /><br />"; }
	}
	$checkuserMapCount = $_SQL->query("SELECT * FROM maps WHERE uid = '".$_USER['id']."'");
	$userMapCount = $checkuserMapCount->num_rows; $fgLink = '';
	if ($voteCount == 0) { 
		$thumbs = "<style>
		#vote {
		display:block; 
		border:none; 
		width:120px; font-family:sans-serif; color:white; margin-right:20px;
		padding-bottom:3px;
		} 
		</style>
<a href='/forge.php?upvote&id=".$_GET['id']."'>
<img onmouseover=\"this.src='/css/images/vote/".$_SESSION['theme'].".png';\" onmouseout=\"this.src='//cdn.discordapp.com/attachments/227232976763748355/260872266219257856/VoteOff.png';\" src='//cdn.discordapp.com/attachments/227232976763748355/260872266219257856/VoteOff.png' id='vote' type='submit' title='Vote on this map! Give this map a +1.' />
</a>"; 
	} 
	$onClick = ''; $lastAction = ''; $r3 = " &#x1f4be; ";
	if ($voteCount > 0) { $thumbs = "<span style='color:white; font-family:sans-serif; font-size:small; color:grey;' title=\"You've already liked this post with a +1\">&#9733; Upvoted</span>"; }
	if ($MAP['uid'] == $_USER['id']) { $thumbs = ""; }
	if ($MAP['map'] == 'diamondback') { $mapQuote = "Hot winds blow over what should be a dead moon. A reminder of the power Forerunners once wielded."; }
	if ($MAP['map'] == 'edge') { $mapQuote = "The remote frontier world of Partition has provided this ancient databank with the safety of seclusion."; }
	if ($MAP['map'] == 'guardian') { $mapQuote = "Millennia of tending has produced trees as ancient as the Forerunner structures they have grown around."; }
	if ($MAP['map'] == 'icebox') { $mapQuote = "Downtown Tyumen's Precinct 13 offers an ideal context for urban combat training."; }
	if ($MAP['map'] == 'narrows') { $mapQuote = "Without cooling systems such as these, excess heat from the Ark's forges would render the construct uninhabitable."; }
	if ($MAP['map'] == 'reactor') { $mapQuote = "Being constructed just prior to the Invasion, its builders had to evacuate before before it was completed."; }
	if ($MAP['map'] == 'standoff') { $mapQuote = "Once, nearby telescopes listened for a message from the stars. Now, these silos contain our prepared response."; }
	if ($MAP['map'] == 'the pit') { $mapQuote = "Software simulations are held in contempt by the veteran instructors who run these training facilities."; }
	if ($MAP['map'] == 'valhalla') { $mapQuote = "The crew of V-398 barely survived their unplanned landing in this gorge, but they know they are not alone."; }
	if ($MAP['map'] == 'last resort') { $mapQuote = "Remote industrial sites like this one are routinely requisitioned & used as part of Spartan training exercises."; }
	if ($MAP['map'] == 'high ground') { $mapQuote = "A relic of older conflicts, this base was reactivated after the New Mombasa Slipspace Event."; }
	if ($MAP['map'] == 'sandtrap') { $mapQuote = "Although the Brute occupiers have been driven from this ancient structure, they left plenty to remember them by."; }
	if ($MAP['map'] == 'flatgrass') {
		$mapQuote = "Modders offering a plain flat map with an extended pallet of items ideal for Forge."; 
		$fgLink = "<div style='margin:0 auto; color:black; text-align:center; max-width:25%; font-weight:bold; background:#fab4a5; border:1px solid red; border-radius:10px; padding:2px; font-size:xx-small;'><a href='/mods.php?id=14' title='The Flatgrass mod is needed to play this map, click to view Flatgrass R09 by Xe_CREATURE' style='color:black!important;'>Flatgrass Required!</a></div><br />"; 
	} if (stripos($MAP['info'], 'enhanced forge') !== FALSE OR stripos($MAP['info'], 'enhancedforge') !== FALSE) {
		$fgLink = "<div style='margin:0 auto; color:black; text-align:center; max-width:25%; font-weight:bold; background:#fab4a5; border:1px solid red; border-radius:10px; padding:2px; font-size:xx-small;'><a href='/files.php?id=33' title='EnhancedForge mod is needed to host this map' style='color:black!important;'>EnhancedForge Required!</a></div><br />"; 
	} if (stripos($MAP['info'], 'mfga') !== FALSE OR stripos($MAP['info'], 'make forge great again') !== FALSE OR stripos($MAP['info'], 'scenfix') !== FALSE OR stripos($MAP['info'], 'scen_fix') !== FALSE) {
			$fgLink = "<div style='margin:0 auto; color:black; text-align:center; max-width:25%; font-weight:bold; background:#fab4a5; border:1px solid red; border-radius:10px; padding:2px; font-size:xx-small;'><a href='files.php?id=-1' title='EnhancedForge mod is needed to host this map' style='color:black!important;'>MFGA Required!</a></div><br />"; 
			if ((isset($_USER['id'])) && ($_USER['group'] != "-3" OR $_USER['group'] > "1")) { $onClick = " onclick=\"return confirm('This map is made using MFGA which is an unreleased mod. Please be patient, this map will be available when testing is complete.'); return false;\""; }
	}
	$gTYPE = ucwords($MAP['gametype']);
	$gTYPE = str_replace('Koth', 'King of The Hill', $gTYPE);
	$gTYPE = str_replace('Ctf', 'Capture The Flag', $gTYPE);
	$gTYPE = str_replace('Vip', 'VIP', $gTYPE);
	$xtra = null; //die($MAP['directURL']);
	// if the map was manually uploaded prior to dewshare uploader, use unencrypted method
	if (stripos($MAP['directURL'], "content/maps") !== FALSE && !empty($MAP['directURL'])) { 
		$path = str_ireplace('content/maps', '', $MAP['directURL']);
		$Link = "http://files.dewsha.re/src/scripts/php/file_details.php?map=".str_ireplace('/','',$path);
		$xtra = json_decode(file_get_contents($Link));
		echo "\n<!-- {$Link} -->\n";
	} 
	// otherwise, if the map was uploaded using the dewshare uploader, use encrypted method
	elseif (stripos($MAP['directURL'], "content/maps") !== TRUE && !empty($MAP['directURL'])) {
		$Link = "http://files.dewsha.re/src/scripts/php/file_details.php?enc&map=".$MAP['directURL'];
		$xtra = json_decode(file_get_contents($Link));
		echo "\n<!-- {$Link} -->\n";
	}
	$mapTITLE = preg_replace("/\.?\s*([^\.]+):/", "<span title='Designed specifically for the $1 ".$MAP['gametype']." variant.'>", $MAP['title']);
	if ($MAP['updated'] != '0000-00-00 00:00:00' AND $MAP['updated'] != $MAP['date'] AND $MAP['edited'] != '') { $lastAction = "<b>Last Modified:</b> <span title='Last edited: ".dateConvert2($MAP['edited'])."'>".dateConvert($MAP['edited'])."</span><br /><br />"; }
	if (!isset($_USER['id'])) { $thumbs = ''; $onClick = " onclick=\"alert('You must login or register to download content!'); return false;\""; }
	if ($MAP['public'] !== "y") { $onClick = " onclick=\"return confirm('This map is locked & only distributed with the creators permission. Would you like to request access?');\""; }
	if ($MAP['public'] == 'r' || $MAP['public'] == 'n') { $r3 = '🔒 '; $curs = "cursor:no-drop; "; $pubTit = "title='This map is LOCKED/EXCLUSIVE! Click to request access to this content.'"; }
	echo "<h3>⚒ ".$mapTITLE."<div style='float:right; margin-top:5px;'>".$thumbs."</div></h3>"
		."<div id='contentHolder' class='contentHolder'>".$fgLink.""
		."<table style='min-width:100%; margin-top:-15px;'><tr><td><div class='mapimg' style=\"display:block; background-image:url(".$mapimg."); background-size: 100% 100%; padding-bottom:30px; min-height:415px; max-height:500px; margin-right:40px; min-width:95%!important;\"><blockquote>".$mapQuote."</blockquote></div></td>"
		."<td halign='left' valign='top' style='padding-bottom:30px; float:center;'><div style='float:center;'><br /><br /><center><a href=\"/forg.e?gtype=".$MAP['gametype']."\"><b><span style='font-size:small;'>".$gTYPE."</span></b><br /><img src=\"".$gIMG."\" style='margin-top:5px;".$invert."' width='150' /></a></center><br />"
		."<span style='font-size:small;'><b>Votes:</b> ".$totalVotes."<br />
		<b>Downloads:</b> ".$MAP['downloads']."<br />
		<b title='Views are only counted once every 12 hours unless you are a unique visitor.'>Unique Views:</b> ".$totalViews."<br />
		<b>Map:</b> <a href=\"/forg.e?map=".$mapName."\">".ucwords($mapName)."</a><br />
		<b>Forge Artist:</b> <a href=\"/forg.e?creator=".preg_replace('/[^ \w0-9a-zA-Z_-]/','',$MAP['creator'])."\">".preg_replace('/[^ \w0-9a-zA-Z_-]/','',$MAP['creator'])."</a><br />";
		if (!empty($MAP['directURL'])) {
			echo "<b>Objects Placed: </b>{$xtra->UserObjectsPlaced}<br />";
			echo "<b>Objects Remaining: </b>{$xtra->TotalObjectsLeft}<br />";
		}
		echo $lastAction."</span></div></td></tr></table><br />{$cleanInfo}<br /><br /><div style='border-top:1px dashed grey;'></div><br />
		<div class='row' style='min-width:100%;'>
		<div class='col-md-4'><div class='dlMap' ".$pubTit."><a ".$onClick." href='/forge.php?dl&id=".$MAP['id']."' target='_blank' style='".$curs."'>".$r3."Download Map</a></div></div>
		<div class='col-md-8' style='align-items:center; font-size:small; text-align:right;'>
		 <a href='/users.php?id=".$MAP['uid']."'><img src=\"".$getUsr['avatar']."\" width='40' style='padding:-2px;' /> ".$MAPuser."</a>&nbsp;submitted this <span title='".dateConvert($MAP['date'])."'> ".dateConvert2($MAP['date'])."</span>
		</div></div></div>";
	/* List & Post Comments */
	$grabComments = $_SQL->query("SELECT * FROM notifications where forge_id = '".$_GET['id']."' AND type = 'map' ORDER BY date DESC");
	echo "<br /><h4>&#128172; Responses</h4><div id='contentHolder' class='contentHolder'>";
	$cmntCount = $grabComments->num_rows;
	if ($cmntCount == 0) { echo "No responses yet.<br /><br />"; } else { echo "<span style='border:1px solid #666; padding:1px; float:right; font-size:xx-small;'>Total Responses: ".$cmntCount."</span>"; }
	if (isset($_USER['id'])) {
		echo "<form method='post'><table><tr>"
			."<td style='padding-right:20px;'><img src=\"".$_USER['img']."\" width='84' height='84' /></td>"
			."<td title='You can tag users by typing @ following the persons username or alias.'>".$bbcode_buttons2."<textarea id='multi-users' name='cmnt' cols='80%' rows='3' placeholder='Post a comment'></textarea></td></tr>"
			."<tr><td></td><td><input type='submit' value='Leave Response' name='postcmnt' /></td></tr></table></form><br />";
	} else { echo "<span style='font-size:small;'>Login first to respond.</span><br /><br />"; }
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
			echo "<div class='comment' style='margin:0 auto;' id='".$cmnt['id']."'><h5><a href='/users.php?id=".$cmntUser['id']."'>".$cmntUser['uname']."</a>&nbsp;responded&nbsp;<span title='".dateConvert2($cmnt['date'])."'>".dateConvert($cmnt['date'])."</span>";
			if (isset($_USER['id'])) {
				if ($cmnt['from_id'] == $_USER['id'] OR $_USER['group'] > 1) { echo "<div style='float:right; margin-right:15px;'><span style='font-size:small;'><a href='/forge.php?ec=".$cmnt['id']."&id=".$_GET['id']."'><b>✎</b> Edit</a></span></div>"; }
			}
			echo "</h5>"
				."<div><table><tr><td valign='top' style='min-width:100px;'><img src=\"".$cmntUser['avatar']."\" height='60' style='max-width:100px; padding-right:20px; padding-left:10px;' /></td><td></td><td>".$displayedCMNT."</td></tr></table><br /></div>\n";
			echo "</div>";
		} 
	} if ($cmntCount > 10) { echo "<br /></div><div class=\"loadMore\" data-action=\"load-more\" data-bound=\"comments\"><a>↻ <span style='font-size:small;'>Load More</span></a>"; }
	echo "</div>";
	if (isset($_POST['postcmnt']) && !empty($_POST['cmnt'])) {
		$checkCmtSpam = $_SQL->query("SELECT id FROM notifications where from_id = '{$_USER['id']}' AND (type = 'map' OR type = 'mod' OR type= 'com') AND `date` > date_sub(CURRENT_TIMESTAMP, INTERVAL 8 MINUTE)")->num_rows;
		if ($checkCmtSpam < 4) {
			$cmntBody = $_SQL->real_escape_string(htmlentities($_POST['cmnt']));
			preg_match_all("/@[a-zA-Z0-9._-]+/", $cmntBody, $username_matches);
			$username_matches = $username_matches[0];
			$_SQL->query("INSERT INTO notifications (`date`, comment, to_id, from_id, type, forge_id, mod_id) VALUES (CURRENT_TIMESTAMP, '".$cmntBody."', '".$MAP['uid']."', '".$_USER['id']."', 'map', '".$_GET['id']."', '0')") or die($_SQL->error);
			$grabcID = $_SQL->query("SELECT * FROM notifications WHERE type = 'map' AND forge_id = '{$_GET['id']}' ORDER BY id DESC LIMIT 1");
			$c = $grabcID->fetch_assoc();
			$cID = $c['id'];
			if (!empty($username_matches)) {
				foreach($username_matches as $ut) {
					$ut = trim(str_replace('@', '', $ut));
					$user_id = $_SQL->query("SELECT `id` FROM users where uname='{$ut}'")->fetch_object()->id;
					if (!empty($user_id) && $user_id != $getUsr['id']) { $_SQL->query("INSERT INTO notifications (to_id, from_id, forge_id, mod_id, type, comment, `date`) values ('{$user_id}', '{$_USER['id']}', '{$MAP['id']}', '0', 'tag', '{$cID}', CURRENT_TIMESTAMP)"); }
				}
			}
			$commentAmnt = $cmntCount + 1;
			$_SQL->query("UPDATE maps SET replies = '{$commentAmnt}' WHERE id = '{$_GET['id']}'");
			if ($_USER['id'] != $MAP['uid']) { echo "<script>alert(\"Response posted. ".$MAPuser." has been informed of your response. If any users have been tagged, they have also been notified.\");</script>"; }
			if ($_USER['id'] == $MAP['uid']) { echo "<script>alert(\"Response posted. If any users have been tagged, they have been notified.\");</script>"; }
			echo "<META HTTP-EQUIV=\"Refresh\" Content=\"0;\" />";
		} else { echo "<script>alert('Spam Filter Activated! Try again in a little while.');</script>"; }
	} if (isset($_POST['postcmnt']) && empty($_POST['cmnt'])) { 
		echo "<script>alert('It seems you have left the comment field blank. Try Again!');</script>";
	} echo "</div>";
	/* Forge Voting System */
	if (isset($_GET['upvote']) && isset($_USER['id'])) { 
		if ($_USER['id'] != $MAP['uid']) {
			if ($voteCount > 0 && $_USER['id'] != $MAP['uid']) { 	
				echo "<script>alert(\"You can only vote once!\");</script>"; 
				echo "<meta http-equiv='refresh' content='0;/forge.php?id=".$MAP['id']."' /> ";
			} else {
				$IntotalVotes = $totalVotes + 1;
				$_SQL->query("UPDATE maps set votes='".$IntotalVotes."' WHERE `id` ='".$_GET['id']."'") or die($_SQL->error);
				$_SQL->query("INSERT INTO notifications (from_id, to_id, comment, type, forge_id, mod_id, `date`) VALUES ('".$_USER['id']."', '".$MAP['uid']."', '+1', 'vote', '".$MAP['id']."', '0', CURRENT_TIMESTAMP)") or die($_SQL->error);
				echo "<script>alert(\"You've upvoted ".$MAP['title'].". +1 point.\");</script>"; 
				echo "<meta http-equiv='refresh' content='0;/forge.php?id=".$MAP['id']."' /> ";
			}
		} else { 
			echo "<script>alert(\"You can't vote on your own content!\");</script>"; 
			echo "<meta http-equiv='refresh' content='0;/forge.php?id=".$MAP['id']."' /> ";
		}
	} elseif (isset($_GET['upvote']) && !isset($_USER['id'])) {
		echo "<script>alert(\"You must login or register to vote on content!\");</script>"; 
		echo "<meta http-equiv='refresh' content='0;/forge.php?id=".$MAP['id']."' /> ";
	} /* Download Map */
	if (isset($_GET['dl']) && !stripos($_SERVER['HTTP_REFERER'],'dewsha.re')) {
		if (isset($_USER['id'])) {
			$grabDLs = $_SQL->query("SELECT * FROM downloads WHERE map_id = '{$mapid}' AND (user = '{$loggedU}' OR ip='{$_SERVER['REMOTE_ADDR']}')") or die($_SQL->error);
			$DL = $grabDLs->fetch_assoc();
			$uDcount = $grabDLs->num_rows;
			$Dth3n = $DL['last_viewed'];
			$Dthen = strtotime($Dth3n);
			$Ddifference = $now - $Dthen;
			if($Ddifference > 43200 AND $uDcount < 1 AND $_USER['id'] != $MAP['uid']) { 
				$_SQL->query("INSERT INTO downloads (map_id, user, ip, last_viewed) VALUES ('{$_GET['id']}', '{$loggedU}', '{$_SERVER['REMOTE_ADDR']}', CURRENT_TIMESTAMP)"); 
			}
			$totalDLSQL = $_SQL->query("SELECT * FROM downloads WHERE map_id = '{$_GET['id']}'");
			$totalDLs = $totalDLSQL->num_rows;
			$totalDownloads = $totalDLs;
			$url = $MAP['url'];
			if ($MAP['public'] == 'n' OR $MAP['public'] == 'r' && $_USER['group'] < 2 && $_USER['id'] != $MAP['uid']) {  
				$welcomeMSG1 = "<div class='comment'><h5>Download link requested from <a href='/users.php?id=".$_USER['id']."'>".$_USER['name']."</a></h5>\n<div class='row'><div class='col-md-2' style='text-align:center;'><img src=\"".$_USER['img']."\" width='60' /></div><div class='col-md-10' style='padding-right:20px;'><b>Automated message from <a href='users.php?id=11'>vaultBot</a></b>\n<code>The user <u>".$_USER['name']."</u> is requesting to download the file: <a href='/forge.php?id=".$MAP['id']."'>".$MAP['title']."</a></code></div></div>\n<div style='font-size:xx-small; float:right; text-align:right; min-width:100px; margin-right:7px;'>".dateConvert2(date('Y-m-d G:i:s'))."</div><br /></div>";
				$welcomeMSG = $_SQL->real_escape_string($welcomeMSG1);
				$_SQL->query("INSERT INTO notifications (from_id, to_id, comment, type) VALUES ('".$_USER['id']."', '".$MAP['uid']."', '".$welcomeMSG."', 'msg')") or die($_SQL->error);
				echo "<script>alert(\"This file is restricted for download by the submitter. Download URL has been requested & ".$MAPuser." notified! This member will reply to you personally.\"); close();</script>";
			} elseif ($MAP['public'] == 'y' && $_USER['id'] == 4) {
				$_SQL->query("INSERT INTO downloads (map_id, user, ip, last_viewed) VALUES ('{$_GET['id']}', '{$loggedU}', '{$_SERVER['REMOTE_ADDR']}', CURRENT_TIMESTAMP)"); 
				$_SQL->query("UPDATE maps set downloads='".$totalDownloads."' WHERE id = '".$_GET['id']."'") or die($_SQL->error);
				die("<script type='text/javascript'>close_window();</script>");
			}
			else {
				$_SQL->query("UPDATE maps set downloads='".$totalDownloads."' WHERE id = '".$_GET['id']."'") or die($_SQL->error);
				die("<h1 style='zIndex:100;'>Please Wait while we fetch your download.</h1><script>window.location.replace('".$MAP['url']."');</script>");
			}
		} else { echo "<script>alert(\"You must login or register to download this content.\"); window.location.replace('/forge.php?id=".$MAP['id']."');</script>"; }
	}
} // LIST ALL MAPS > FORGE INDEX
if (!isset($_GET['new']) && !isset($_GET['id']) && !isset($_GET['uid']) && !isset($_GET['mod']) && !isset($_GET['creator']) && !isset($_GET['gt']) && !isset($_GET['m']) && $mapCount != 0) { ?><script>location.href='forg.e';</script>
<h3>⚒ Map Creations</h3><div id='contentHolder' class='contentHolder'> 
<?php
	if (isset($_USER['id'])) { echo "<div style='float:left;'><a href='/forge.php?new'>☲ Post New</a></div>"; } ?>
<div class="forgeList"></div>
<script src="/js/page.js"></script>
<?php if ($mapCount > 8) { echo "<br />"; ?>
<center><div id="pagination" style="font-weight:bold;">
	<span class="load_more" id="prev" style="cursor:pointer; display:none;">◀</span>
	<span class="skip_to first" style="font-size:xx-small; font-family:tahoma;">1</span> <span style="font-size:xx-small; font-family:tahoma;">of</span> 
	<span class="skip_to last_page" style="font-size:xx-small; font-family:tahoma;"></span> 
	<span class="load_more" id="next" style="padding:2px; cursor:pointer;">▶</span>
	<input type="hidden" name="page_num" value="-1" />
	</div></center>
<?php echo "<div style='float:right; margin-right:20px; margin-top:-15px;'><a href='/forge.php?new'>☲ Post New</a></div><br /><br />"; }	echo "</div>";
}
// LIST MAPS BY SPECIFIC USERS
if (isset($_GET['uid']) OR isset($_GET['creator']) && $mapCount != 0) {
	$userSQL = $_SQL->query("SELECT * FROM users WHERE id = '".(int) $_GET['uid']."'");
	$userMap = $userSQL->fetch_assoc();
	$WHERE = "WHERE uid = '".$userMap['id']."'";
	$CS="submitted"; $person=$userMap['uname'];
	if (isset($_GET['creator'])) {
		$WHERE = "WHERE creator = '".$_SQL->real_escape_string($_GET['creator'])."'";
		$CS = "created";
		$person = htmlspecialchars($_GET['creator']);
	}
	$listSpecificMaps = $_SQL->query("SELECT * FROM maps {$WHERE} AND public != 'n' ORDER BY date DESC") or die($_SQL->error);
	if ((isset($_GET['uid']) && $_USER['id'] == $_GET['uid']) OR $_USER['group'] > 2) {
		$listSpecificMaps = $_SQL->query("SELECT * FROM maps WHERE uid = '".$userMap['id']."' ORDER BY public ASC, updated DESC"); 
	} $uMapNum = $listSpecificMaps->num_rows;
	echo "<h3>⚒ Maps ".$CS." by ".$person." </h3><div id='contentHolder' class='contentHolder'>";
	if (isset($_USER['id'])) { echo "<a href='/forge.php?new'>☲ Post New</a>"; }
	echo "<br /><br /><div class='row' id='row' style='text-align:center; font-size:small;'><div class='col-md-2'></div><div class='col-md-3' style='text-align:left;'><b>Title</b></div><div class='col-md-2'><b>Artist</b></div><div class='col-md-1'><b>Variant</b></div><div class='col-md-2'><b>Date</b></div><div class='col-md-2'></div></div><br />"
		."<input type='hidden' id='current_page' />
<input type='hidden' id='show_per_page' />
<div id='forgeList' data-load-more='15' class='forgeList' style='min-width:100%;'>";
	while ($userSubmittedMaps = $listSpecificMaps->fetch_assoc()) {
		$MAPS = $userSubmittedMaps;
		$forgeDate = dateConvert($userSubmittedMaps['date']);
		$uSQL = $_SQL->query("SELECT * FROM users WHERE id = '".$userSubmittedMaps['uid']."'");
		$sub = $uSQL->fetch_assoc();
		$submitter = $sub['uname'];
		$creator = $userSubmittedMaps['creator'];
		$replies = $MAPS['replies'];
		$mapTitle = preg_replace("/\.?\s*([^\.]+):/", "</a><sup style='display:block; font-size:8px; font-weight:normal;'>$1</sup><a href=\"/forge.php?id=".$userSubmittedMaps['id']."\">", $userSubmittedMaps['title']);
		$gt = str_replace(" Gametypes", "", $MAPS['gametype']);
		$gt = str_replace("koth", "King of the Hill", $MAPS['gametype']);
		if ($submitter == $userSubmittedMaps['creator']) { $creator = "<a href='users.php?id=".$userSubmittedMaps['uid']."'>".$submitter."</a>"; }
		$mapimg = $userSubmittedMaps['img'];
		if (empty($mapimg) or !isImage($mapimg)) { $mapimg =  "/css/images/maps/".preg_replace('/\s+/', '', $userSubmittedMaps['map']).".jpg"; }
		$r1 = ''; $r2 = ''; $r3 = '';
		if ($userSubmittedMaps['public'] == 'n') { 
			$r1 = " opacity:0.2!important;";
			$r2 = " title=\"This map is currently hidden from public view. Only yourself, a moderator, or administrator may view this post.\"";
		} if ($userSubmittedMaps['public'] == 'r') { 
			$r2 = " title=\"This map has restricted access, you will get notified of a request when a user attempts to download. Only yourself, a moderator, or an administrator may aquire this map without prior approval from you.\"";
			$r3 = " 🔒";
		}
?>
<div  onmouseover="this.style.textShadow = '5px 5px 5px black'; this.style.backgroundImage = 'url(/css/images/hbg/<?=str_replace(' ', '', $userSubmittedMaps['map']);?>.jpg)'; this.style.backgroundRepeat = 'no-repeat'; this.style.backgroundSize = '100% 100%'; this.style.color = 'white';" onmouseout="this.style.textShadow = 'none'; this.style.color = 'inherit'; this.style.backgroundImage = 'none';" class="row" style="min-height:70px;<?=$r1;?> padding:5px; text-align:center; font-size:small; display:flex; align-items:center;"<?=$r2;?>>
	<div class="col-md-2"><a href="/forge.php?id=<?=$MAPS['id'];?>" title="Forged on <?=ucwords($MAPS['map']);?>"><img height="70" style='padding:0px;' width="95" align="left" src="<?=Thumb($mapimg);?>" /></a></div>
	<div class="col-md-3" style="text-align:left;"><b><a href="/forge.php?id=<?=$MAPS['id'];?>"  title="<?=htmlentities(removeBB($MAPS['info']));?>"><?=$mapTitle;?><?=$r3;?></a></b></div>
	<div class="col-md-2"><a href="search.php?find=<?=$MAPS['creator'];?>"><?=$MAPS['creator'];?></a></div>
	<div class="col-md-1"><a href="forg.e?gtype=<?=$gt;?>" title="Designed for <?=ucwords($gt);?>"><img src="/css/images/variants/<?=$gt;?>.png" height="50" style="opacity:0.5;" /></a></div>
	<div class="col-md-2" style="font-size:x-small;"><?=$forgeDate;?></div>
	<div class="col-md-2" style="font-size:xx-small; float:right; text-align:left;">Replies: <?=$replies;?><br />Upvotes: <?=$MAPS['votes'];?><br />Downloads: <?=$MAPS['downloads'];?></div>
</div>
<?php
	}
	echo "<!-- end load-more --></div><br />";
	if ($uMapNum > 10) { echo "<div id='loadMoreF' class='loadMore' data-action='load-more' data-bound='forgeList'><a>&#x21bb; <span style='font-size:small;'>Load More</span></a></div>"; }
	if (isset($_USER['id']) && $uMapNum > 8) { echo "<br /><div style='float:right; margin-right:20px;'><a href='/forge.php?new'>&#9778; Post New</a></div><br /><br />"; }	echo "</div>";
}  
// CREATE NEW FORGE POST
if (isset($_GET['new'])) {
	if (isset($_USER['id'])) {
		if (!isset($_POST['postsubmit'])) {
			echo $postNew;
		} else { 
			$maptitle = $_SQL->real_escape_string(preg_replace("/[^ \w0-9a-zA-Z_\-':&]/", '', $_POST['title']));
			$mapauthor = $_SQL->real_escape_string(preg_replace('/[^ \w0-9a-zA-Z_-]/', '', $_POST['author']));
			$mapimg = $_SQL->real_escape_string(htmlentities($_POST['img']));
			$mapdlink = $_SQL->real_escape_string(htmlentities($_POST['url']));
			$gametype = $_SQL->real_escape_string(preg_replace('/[^ \w0-9a-zA-Z_-]/', '', $_POST['gametype']));
			$omap = $_SQL->real_escape_string($_POST['map']);
			$mapinfo = $_SQL->real_escape_string($_POST['info']);
			$pub = $_SQL->real_escape_string(htmlentities($_POST['public']));
			$mapposter = $_USER['id'];
			$checkMapSpam = $_SQL->query("SELECT * FROM maps where uid = '{$_USER['id']}' AND `date` > date_sub(CURRENT_TIMESTAMP, INTERVAL 8 MINUTE)");
			$checkModSpam = $_SQL->query("SELECT * FROM files where uid = '{$_USER['id']}' AND `date` > date_sub(CURRENT_TIMESTAMP, INTERVAL 8 MINUTE)");
			$checkComSpam = $_SQL->query("SELECT * FROM community where uid = '{$_USER['id']}' AND `date` > date_sub(CURRENT_TIMESTAMP, INTERVAL 8 MINUTE)");
			$checkModSpam = $checkModSpam->num_rows;
			$checkComSpam = $checkComSpam->num_rows;
			$checkMapSpam = $checkMapSpam->num_rows;
			$checkSpam = $checkMapSpam + $checkModSpam + $checkComSpam;
			if (empty($mapauthor)) { $mapauthor = $_USER['name']; }
			if (empty($gametype)) { $gametype = "multiple"; }
			if (empty($maptitle) OR empty($mapdlink) OR empty($mapinfo) OR empty($omap)) {
				echo $postNew;
				echo "<script>alert(\"Please ensure you haven't left any required fields blank. If you are the creator of this resource, you may leave 'Forge Creator' empty.\");</script>";
			} else {
				$urls=[]; $extLinks='';
				if (preg_match_all('/https?:\/\/drive.google.com.*?(id\=|folders\/|d\/)([0-9A-Za-z-_]+)/si', $mapinfo, $matches)) {
				    foreach(array_unique($matches[2]) as $match)
				        $urls[] = "https://drive.google.com/uc?export=download&id=" .$match;  
				}
				if (preg_match_all('/https?:\/\/mega.nz\/#!([0-9A-Za-z-_]+)/si', $mapinfo, $_matches)) {
				    foreach(array_unique($_matches[1]) as $_match)
				        $urls[] = "https://mega.nz/#!" .$_match;  
				} 
				if ($urls[0]) $extLinks = implode('; ', $urls);
				if ($_POST['public'] == 'n') {
					if ($checkSpam < 2) {
						$_SQL->query("INSERT INTO maps (`date`, uid, title, creator, url, img, info, gametype, map, public, `external_links`) VALUES (CURRENT_TIMESTAMP, '".$mapposter."', '".$maptitle."', '".$mapauthor."', '".$mapdlink."', '".$mapimg."', '".$mapinfo."', '".$gametype."', '".$omap."', 'n', '{$extLinks}')") or die($_SQL->error);
						$_SQL->query("UPDATE users SET last_post=CURRENT_TIMESTAMP WHERE id = '".$_USER['id']."'") or die($_SQL->error);
						$getmapID = $_SQL->query("SELECT * FROM maps where title = '".$maptitle."'");
						$yourmap = $getmapID->fetch_assoc();
						echo "<b>".$maptitle."</b> has been archived, and the entire post is currently hidden from public view. You can see your content <a href='/forge.php?id=".$yourmap['id']."'>here</a>.<span style='margin-top:40px; font-size:xx-small; text-align:center; display:block; width:100%;'><i>You will be automatically redirected</i></span><meta http-equiv=\"refresh\" content=\"3;url=/forge.php?id=".$yourmap['id']."\" />";		
					} else { echo "<b>Spam Filter Activated</b> Please try again in a little while."; }
				} elseif ($_POST['public'] == 'r') {		
					if ($checkSpam < 2) {
						$_SQL->query("INSERT INTO maps (`date`, uid, title, creator, url, img, info, gametype, map, public, `external_links`) VALUES (CURRENT_TIMESTAMP, '".$mapposter."', '".$maptitle."', '".$mapauthor."', '".$mapdlink."', '".$mapimg."', '".$mapinfo."', '".$gametype."', '".$omap."', 'r', '{$extLinks}')") or die($_SQL->error);
						$_SQL->query("UPDATE users SET last_post=CURRENT_TIMESTAMP WHERE id = '".$_USER['id']."'") or die($_SQL->error);
						$getmapID = $_SQL->query("SELECT * FROM maps where title = '".$maptitle."'");
						$yourmap = $getmapID->fetch_assoc();
						echo "<b>".$maptitle."</b> has been posted, but the download link has been hidden from public view and is only available by request. You can see your content <a href='/forge.php?id=".$yourmap['id']."'>here</a>.<span style='margin-top:40px; font-size:xx-small; text-align:center; display:block; width:100%;'><i>You will be automatically redirected</i></span><meta http-equiv=\"refresh\" content=\"3;url=/forge.php?id=".$yourmap['id']."\" />";		
					} else { echo "<b>Spam Filter Activated</b> Please try again in a little while."; }
				} else {
					if ($checkSpam < 2) {
						$_SQL->query("INSERT INTO maps (`date`, `uid`, `title`, `creator`, `url`, `img`, `info`, `gametype`, `map`, `external_links`) VALUES 
							(CURRENT_TIMESTAMP, '{$mapposter}', '{$maptitle}', '{$mapauthor}', '{$mapdlink}', '{$mapimg}', '{$mapinfo}', '{$gametype}', '{$omap}', '{$extLinks}')") or die($_SQL->error);
						$_SQL->query("UPDATE users SET last_post=CURRENT_TIMESTAMP WHERE id = '".$_USER['id']."'") or die($_SQL->error);
						$getmapID = $_SQL->query("SELECT * FROM maps where title = '".$maptitle."' AND uid = '".$_USER['id']."'");
						$yourmap = $getmapID->fetch_assoc();
						echo "<b>".$maptitle."</b> has been posted! You can see your content <a href='/forge.php?id=".$yourmap['id']."'>here</a>.<span style='margin-top:40px; font-size:xx-small; text-align:center; display:block; width:100%;'><i>You will be automatically redirected</i></span><meta http-equiv=\"refresh\" content=\"3;url=/forge.php?id=".$yourmap['id']."\" />";
					} else { echo "<b>Spam Filter Activated</b> Please try again in a little while. ".$checkSpam.""; }
				}
			}
		}
	} else { echo "<br /><br /><center>You must login or <a href='/reg.php'>register</a> first in order to post new content!</center>"; }
}
// EDIT FORGE POST
if (isset($_GET['mod']) && is_numeric($_GET['mod']) && isset($_USER['id']) && $mapCount != 0) {
	$mapid = $_GET['mod'];
	$grabMap = $_SQL->query("SELECT * FROM maps WHERE id = '".$mapid."'");
	$modMap = $grabMap->fetch_assoc();
	if ($_USER['group'] > 1 OR $_USER['id'] == $modMap['uid']) { 
		if ($modMap['gametype'] == "infection") {
			$selectGame = "<select name='gametype'>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='juggernaut'>Juggernaut</option>
<option value='vip'>VIP</option>
<option value='territories'>Territories</option>
<option value='assault'>Assault</option>
<option value='ctf'>Capture The Flag</option>
<option value='oddball'>Oddball</option>
<option value='koth'>King of The Hill</option>
<option value='multiple'>Multiple Gametypes</option>
</select>";
		} elseif ($modMap['gametype'] == "slayer") {
			$selectGame = "<select name='gametype'>
<option value='slayer'>Slayer</option>
<option value='infection'>Infection</option>
<option value='juggernaut'>Juggernaut</option>
<option value='vip'>VIP</option>
<option value='territories'>Territories</option>
<option value='assault'>Assault</option>
<option value='ctf'>Capture The Flag</option>
<option value='oddball'>Oddball</option>
<option value='koth'>King of The Hill</option>
<option value='multiple'>Multiple Gametypes</option>
</select>";
		} elseif ($modMap['gametype'] == "juggernaut") {
			$selectGame = "<select name='gametype'>
<option value='juggernaut'>Juggernaut</option>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='vip'>VIP</option>
<option value='territories'>Territories</option>
<option value='assault'>Assault</option>
<option value='ctf'>Capture The Flag</option>
<option value='oddball'>Oddball</option>
<option value='koth'>King of The Hill</option>
<option value='multiple'>Multiple Gametypes</option>
</select>";
		} elseif ($modMap['gametype'] == "vip") {
			$selectGame = "<select name='gametype'>
<option value='vip'>VIP</option>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='juggernaut'>Juggernaut</option>
<option value='territories'>Territories</option>
<option value='assault'>Assault</option>
<option value='ctf'>Capture The Flag</option>
<option value='oddball'>Oddball</option>
<option value='koth'>King of The Hill</option>
<option value='multiple'>Multiple Gametypes</option>
</select>";
		} elseif ($modMap['gametype'] == "territories") {
			$selectGame = "<select name='gametype'>
<option value='territories'>Territories</option>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='juggernaut'>Juggernaut</option>
<option value='vip'>VIP</option>
<option value='assault'>Assault</option>
<option value='ctf'>Capture The Flag</option>
<option value='oddball'>Oddball</option>
<option value='koth'>King of The Hill</option>
<option value='multiple'>Multiple Gametypes</option>
</select>";
		} elseif ($modMap['gametype'] == "assault") {
			$selectGame = "<select name='gametype'>
<option value='assault'>Assault</option>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='juggernaut'>Juggernaut</option>
<option value='vip'>VIP</option>
<option value='territories'>Territories</option>
<option value='ctf'>Capture The Flag</option>
<option value='oddball'>Oddball</option>
<option value='koth'>King of The Hill</option>
<option value='multiple'>Multiple Gametypes</option>
</select>";
		} elseif ($modMap['gametype'] == "ctf") {
			$selectGame = "<select name='gametype'>
<option value='ctf'>Capture The Flag</option>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='juggernaut'>Juggernaut</option>
<option value='vip'>VIP</option>
<option value='territories'>Territories</option>
<option value='assault'>Assault</option>
<option value='oddball'>Oddball</option>
<option value='koth'>King of The Hill</option>
<option value='multiple'>Multiple Gametypes</option>
</select>";
		} elseif ($modMap['gametype'] == "oddball") {
			$selectGame = "<select name='gametype'>
<option value='oddball'>Oddball</option>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='juggernaut'>Juggernaut</option>
<option value='vip'>VIP</option>
<option value='territories'>Territories</option>
<option value='assault'>Assault</option>
<option value='ctf'>Capture The Flag</option>
<option value='koth'>King of The Hill</option>
<option value='multiple'>Multiple Gametypes</option>
</select>";
		} elseif ($modMap['gametype'] == "koth") {
			$selectGame = "<select name='gametype'>
<option value='koth'>King of The Hill</option>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='juggernaut'>Juggernaut</option>
<option value='vip'>VIP</option>
<option value='territories'>Territories</option>
<option value='assault'>Assault</option>
<option value='ctf'>Capture The Flag</option>
<option value='oddball'>Oddball</option>
<option value='multiple'>Multiple Gametypes</option>
</select>";
		}  else {
			$selectGame = "<select name='gametype'>
<option value='multiple'>Multiple Gametypes</option>
<option value='koth'>King of The Hill</option>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='juggernaut'>Juggernaut</option>
<option value='vip'>VIP</option>
<option value='territories'>Territories</option>
<option value='assault'>Assault</option>
<option value='ctf'>Capture The Flag</option>
<option value='oddball'>Oddball</option>
</select>";
		}  

		if ($modMap['map'] == "guardian") {
			$selectMap = "<select name='map'>
<option value='guardian'>Guardian</option>
<option value='the pit'>The Pit</option>
<option value='standoff'>Standoff</option>
<option value='valhalla'>Valhalla</option>
<option value='reactor'>Reactor</option>
<option value='icebox'>Icebox</option>
<option value='sandtrap'>Sandtrap</option>
<option value='diamondback'>Diamondback</option>
<option value='last resort'>Last Resort</option>
<option value='narrows'>Narrows</option>
<option value='high ground'>High Ground</option>
<option value='edge'>Edge*</option>
<option value='flatgrass'>Flatgrass*</option>
</select>";
		} if ($modMap['map'] == "the pit") {
			$selectMap = "<select name='map'>
<option value='the pit'>The Pit</option>
<option value='guardian'>Guardian</option>
<option value='standoff'>Standoff</option>
<option value='valhalla'>Valhalla</option>
<option value='reactor'>Reactor</option>
<option value='icebox'>Icebox</option>
<option value='sandtrap'>Sandtrap</option>
<option value='diamondback'>Diamondback</option>
<option value='last resort'>Last Resort</option>
<option value='narrows'>Narrows</option>
<option value='high ground'>High Ground</option>
<option value='edge'>Edge*</option>
<option value='flatgrass'>Flatgrass*</option>
</select>";
		} if ($modMap['map'] == "standoff") {
			$selectMap = "<select name='map'>
<option value='standoff'>Standoff</option>
<option value='guardian'>Guardian</option>
<option value='the pit'>The Pit</option>
<option value='valhalla'>Valhalla</option>
<option value='reactor'>Reactor</option>
<option value='icebox'>Icebox</option>
<option value='sandtrap'>Sandtrap</option>
<option value='diamondback'>Diamondback</option>
<option value='last resort'>Last Resort</option>
<option value='narrows'>Narrows</option>
<option value='high ground'>High Ground</option>
<option value='edge'>Edge*</option>
<option value='flatgrass'>Flatgrass*</option>
</select>";
		} if ($modMap['map'] == "valhalla") {
			$selectMap = "<select name='map'>
<option value='valhalla'>Valhalla</option>
<option value='guardian'>Guardian</option>
<option value='the pit'>The Pit</option>
<option value='standoff'>Standoff</option>
<option value='reactor'>Reactor</option>
<option value='icebox'>Icebox</option>
<option value='sandtrap'>Sandtrap</option>
<option value='diamondback'>Diamondback</option>
<option value='last resort'>Last Resort</option>
<option value='narrows'>Narrows</option>
<option value='high ground'>High Ground</option>
<option value='edge'>Edge*</option>
<option value='flatgrass'>Flatgrass*</option>
</select>";
		} if ($modMap['map'] == "reactor") {
			$selectMap = "<select name='map'>
<option value='reactor'>Reactor</option>
<option value='guardian'>Guardian</option>
<option value='the pit'>The Pit</option>
<option value='standoff'>Standoff</option>
<option value='valhalla'>Valhalla</option>
<option value='icebox'>Icebox</option>
<option value='sandtrap'>Sandtrap</option>
<option value='diamondback'>Diamondback</option>
<option value='last resort'>Last Resort</option>
<option value='narrows'>Narrows</option>
<option value='high ground'>High Ground</option>
<option value='edge'>Edge*</option>
<option value='flatgrass'>Flatgrass*</option>
</select>";
		} if ($modMap['map'] == "icebox") {
			$selectMap = "<select name='map'>
<option value='icebox'>Icebox</option>
<option value='guardian'>Guardian</option>
<option value='the pit'>The Pit</option>
<option value='standoff'>Standoff</option>
<option value='valhalla'>Valhalla</option>
<option value='reactor'>Reactor</option>
<option value='sandtrap'>Sandtrap</option>
<option value='diamondback'>Diamondback</option>
<option value='last resort'>Last Resort</option>
<option value='narrows'>Narrows</option>
<option value='high ground'>High Ground</option>
<option value='edge'>Edge*</option>
<option value='flatgrass'>Flatgrass*</option>
</select>";
		} if ($modMap['map'] == "sandtrap") {
			$selectMap = "<select name='map'>
<option value='sandtrap'>Sandtrap</option>
<option value='guardian'>Guardian</option>
<option value='the pit'>The Pit</option>
<option value='standoff'>Standoff</option>
<option value='valhalla'>Valhalla</option>
<option value='reactor'>Reactor</option>
<option value='icebox'>Icebox</option>
<option value='diamondback'>Diamondback</option>
<option value='last resort'>Last Resort</option>
<option value='narrows'>Narrows</option>
<option value='high ground'>High Ground</option>
<option value='edge'>Edge*</option>
<option value='flatgrass'>Flatgrass*</option>
</select>";
		} if ($modMap['map'] == "diamondback") {
			$selectMap = "<select name='map'>
<option value='diamondback'>Diamondback</option>
<option value='guardian'>Guardian</option>
<option value='the pit'>The Pit</option>
<option value='standoff'>Standoff</option>
<option value='valhalla'>Valhalla</option>
<option value='reactor'>Reactor</option>
<option value='icebox'>Icebox</option>
<option value='sandtrap'>Sandtrap</option>
<option value='last resort'>Last Resort</option>
<option value='narrows'>Narrows</option>
<option value='high ground'>High Ground</option>
<option value='edge'>Edge*</option>
<option value='flatgrass'>Flatgrass*</option>
</select>";
		} if ($modMap['map'] == "last resort") {
			$selectMap = "<select name='map'>
<option value='last resort'>Last Resort</option>
<option value='guardian'>Guardian</option>
<option value='the pit'>The Pit</option>
<option value='standoff'>Standoff</option>
<option value='valhalla'>Valhalla</option>
<option value='reactor'>Reactor</option>
<option value='icebox'>Icebox</option>
<option value='sandtrap'>Sandtrap</option>
<option value='diamondback'>Diamondback</option>
<option value='narrows'>Narrows</option>
<option value='high ground'>High Ground</option>
<option value='edge'>Edge*</option>
<option value='flatgrass'>Flatgrass*</option>
</select>";
		} if ($modMap['map'] == "narrows") {
			$selectMap = "<select name='map'>
<option value='narrows'>Narrows</option>
<option value='guardian'>Guardian</option>
<option value='the pit'>The Pit</option>
<option value='standoff'>Standoff</option>
<option value='valhalla'>Valhalla</option>
<option value='reactor'>Reactor</option>
<option value='icebox'>Icebox</option>
<option value='sandtrap'>Sandtrap</option>
<option value='diamondback'>Diamondback</option>
<option value='last resort'>Last Resort</option>
<option value='high ground'>High Ground</option>
<option value='edge'>Edge*</option>
<option value='flatgrass'>Flatgrass*</option>
</select>";
		} if ($modMap['map'] == "high ground") {
			$selectMap = "<select name='map'>
<option value='high ground'>High Ground</option>
<option value='guardian'>Guardian</option>
<option value='the pit'>The Pit</option>
<option value='standoff'>Standoff</option>
<option value='valhalla'>Valhalla</option>
<option value='reactor'>Reactor</option>
<option value='icebox'>Icebox</option>
<option value='sandtrap'>Sandtrap</option>
<option value='diamondback'>Diamondback</option>
<option value='last resort'>Last Resort</option>
<option value='narrows'>Narrows</option>
<option value='edge'>Edge*</option>
<option value='flatgrass'>Flatgrass*</option>
</select>";
		} if ($modMap['map'] == "edge") {
			$selectMap = "<select name='map'>
<option value='edge'>Edge*</option>
<option value='guardian'>Guardian</option>
<option value='the pit'>The Pit</option>
<option value='standoff'>Standoff</option>
<option value='valhalla'>Valhalla</option>
<option value='reactor'>Reactor</option>
<option value='icebox'>Icebox</option>
<option value='sandtrap'>Sandtrap</option>
<option value='diamondback'>Diamondback</option>
<option value='last resort'>Last Resort</option>
<option value='narrows'>Narrows</option>
<option value='high ground'>High Ground</option>
<option value='flatgrass'>Flatgrass*</option>
</select>";
		} if ($modMap['map'] == "flatgrass") {
			$selectMap = "<select name='map'>
<option value='flatgrass'>Flatgrass*</option>
<option value='edge'>Edge*</option>
<option value='guardian'>Guardian</option>
<option value='the pit'>The Pit</option>
<option value='standoff'>Standoff</option>
<option value='valhalla'>Valhalla</option>
<option value='reactor'>Reactor</option>
<option value='icebox'>Icebox</option>
<option value='sandtrap'>Sandtrap</option>
<option value='diamondback'>Diamondback</option>
<option value='last resort'>Last Resort</option>
<option value='narrows'>Narrows</option>
<option value='high ground'>High Ground</option>
</select>";
		} 
		$checked = ''; if ($modMap['public'] == 'n') { $checked = 'checked'; }
		$checkd = ''; if ($modMap['public'] == 'r') { $checkd = 'checked'; }
		$modhtml = "<h3>⚒ Modify Forge Post</h3><div id='contentHolder' class='contentHolder'><form method='post'>
<div style='font-size:x-small; color:grey; display:flex; align-items:center; float:right; padding:2px;' title='Add map to databse, but hide from public view.'><input type='checkbox' id='public' name='public' value='n' ".$checked."/> Hide from Public?</div>"
			."Try to include the gametype in the Map title. <span style='font-size:small;'>(ie: <b>Fatkid:</b> Fatkid Fort | <b>Drive or Die:</b> Zombie Roadrage, etc)</span><br /><br />\n"
			."<table><tr><td>&#9874;<span style='font-size:small;'> = Required field.</span><br /><br /></td></tr>"
			."<tr><td><b>Map</b>:</td><td>".$selectMap." &#9874;</td></tr>"
			."<tr><td><b>Gametype</b>:</td><td>".$selectGame."</td></tr>"
			."<tr><td><b>Title</b>:</td><td><input type='text' name='title' value=\"".$modMap['title']."\" /> &#9874;</td></tr>"
			."<tr><td><b>Artist</b>:</td><td><input type='text' name='author' value=\"".$modMap['creator']."\" /></td></tr>"
			."<tr><td><b>Image</b>:</td><td><input type='text' name='img' value=\"".$modMap['img']."\" /></td></tr>"
			."<tr><td><b>Download:</b></td><td><input type='text' name='url' value=\"".$modMap['url']."\" /> &#9874;<br /><div style='font-size:x-small; color:grey; display:flex; align-items:center; padding:2px;' title='Add map to databse, but hide download URL from public view. Download link available by request only.'><input type='checkbox' id='public' name='public' value='r' ".$checkd."/> Restrict Access?</div></td></tr>"
			."<tr><td valign='top'><br /><br />&#9874; <b>Info</b>:</td><td><br /><br />".$bbcode_buttons."<textarea id='edit' cols='100%' rows='15' name='info'>".$modMap['info']."</textarea></td></tr>"
			."<tr><td></td><td><input type='submit' value='Save Changes' name='forgesubmit' /> <input type='submit' style='float:right;' value='Delete Map' name='deletemap' onclick=\"return confirm('Are you sure you want to delete this item? All relevant upvotes, downloads, & responses will also be removed!');\" /></td></tr>"
			."</form></table><br /><br />";

		if (!isset($_POST['forgesubmit']) && !isset($_POST['deletemap'])) {
			echo $modhtml;
			echo "</div>";
		} elseif (isset($_POST['forgesubmit'])) {
			$maptitle = $_SQL->real_escape_string(preg_replace("/[^ \w0-9a-zA-Z_\-':&]/", '', $_POST['title']));
			$mapauthor = $_SQL->real_escape_string(preg_replace("/[^ \w0-9a-zA-Z_\-':]/", '', $_POST['author']));
			$mapimg = $_SQL->real_escape_string(htmlentities($_POST['img']));
			$mapMap = $_SQL->real_escape_string(htmlentities($_POST['map']));
			$mapMap =  preg_replace('/[^ \w0-9a-zA-Z_-]/', '', $mapMap);
			// if (!isImage($mapimg)) { $mapimg = ""; }
			$mapdlink = $_SQL->real_escape_string(htmlentities($_POST['url']));
			$gametype = $_SQL->real_escape_string(htmlentities($_POST['gametype']));
			$mapinfo = $_SQL->real_escape_string($_POST['info']); 
			if (empty($gametype)) { $gametype = "multiple gametypes"; }
			if (empty($mapauthor)) { $mapauthor = $_USER['name']; }
			if (empty($maptitle) OR empty($mapdlink) OR empty($mapinfo) OR empty($mapMap) OR empty($mapauthor)) {		
				echo "<span style='color:red;'>Please ensure you haven't left any required fields blank. If you are the creator of this resource, you may leave 'Forge Creator' empty.</span><br /><br />";
				echo $modhtml;
			} else {
				$urls = [];
				if (preg_match_all('/https?:\/\/drive.google.com.*?(id\=|folders\/|d\/)([0-9A-Za-z-_]+)/si', $mapinfo, $matches)) {
				    foreach(array_unique($matches[2]) as $match)
				        $urls[] = "https://drive.google.com/uc?export=download&id=" .$match;  
				}
				if (preg_match_all('/https?:\/\/mega.nz\/#!([0-9A-Za-z-_]+)/si', $mapinfo, $_matches)) {
				    foreach(array_unique($_matches[1]) as $_match)
				        $urls[] = "https://mega.nz/#!" .$_match;  
				} 
				$extLinks = implode('; ', $urls);
				$_SQL->query("UPDATE `maps` SET `external_links`='{$extLinks}' WHERE id='{$mapid}'") or die($_SQL->error);
				if ($_POST['public'] == 'n') {
					$_SQL->query("UPDATE maps set title='".$maptitle."', creator='".$mapauthor."', url='".$mapdlink."', img='".$mapimg."', info='".$mapinfo."', gametype='".$gametype."', map='".$mapMap."', edited='".date("Y-m-d H:i:s")."', public='n' WHERE id = '".$_GET['mod']."'") or die($_SQL->error);
					echo "<b>".$maptitle."</b> has been modified & saved to your archive, but is currently hidden from public view. You can see your content <a href='/forge.php?id=".$modMap['id']."'>here</a>.<span style='margin-top:40px; font-size:xx-small; text-align:center; display:block; width:100%;'><i>You will be automatically redirected</i></span><meta http-equiv=\"refresh\" content=\"3;url=/forge.php?id=".$_GET['mod']."\" />";			
				} elseif ($_POST['public'] == 'r') {
					$_SQL->query("UPDATE maps set title='".$maptitle."', creator='".$mapauthor."', url='".$mapdlink."', img='".$mapimg."', info='".$mapinfo."', gametype='".$gametype."', edited='".date("Y-m-d H:i:s")."', map='".$mapMap."', public='r' WHERE id = '".$_GET['mod']."'") or die($_SQL->error);
					echo "<b>".$maptitle."</b> has been modified, but the download URL has hidden from public view. You can see your content <a href='/forge.php?id=".$modMap['id']."'>here</a>.<br /><span style='margin-top:50px; font-size:xx-small; text-align:center; display:block; width:100%;'><i>You will be automatically redirected</i></span><meta http-equiv=\"refresh\" content=\"3;url=/forge.php?id=".$_GET['mod']."\" />";			
				} else {
					$_SQL->query("UPDATE maps set title='".$maptitle."', creator='".$mapauthor."', url='".$mapdlink."', img='".$mapimg."', info='".$mapinfo."', gametype='".$gametype."', edited='".date("Y-m-d H:i:s")."', map='".$mapMap."', public='y' WHERE id = '".$_GET['mod']."'") or die($_SQL->error);
					echo "<b>".$maptitle."</b> has been modified! You can see your changes <a href='/forge.php?id=".$_GET['mod']."'>here</a>.<br /><span style='margin-top:50px; font-size:xx-small; text-align:center; display:block; width:100%;'><i>You will be automatically redirected</i></span><meta http-equiv=\"refresh\" content=\"3;url=/forge.php?id=".$_GET['mod']."\" />";
				}
			}
		} elseif (isset($_POST['deletemap'])) {
			$_SQL->query("DELETE FROM maps WHERE id = '".$_GET['mod']."'");
			$_SQL->query("DELETE FROM notifications WHERE forge_id = '".$_GET['mod']."'");
			$_SQL->query("DELETE FROM views WHERE map_id = '".$_GET['mod']."'");
			$_SQL->query("DELETE FROM downloads WHERE map_id = '".$_GET['mod']."'");
			echo "<script>alert(\"Your map has been deleted! All relevant responses, upvotes, etc have also been removed!\");\n"
				."location.replace(\"/forge.php\");</script>";
		}
	} else { echo "<span style='color:red;'>You are not authorized to modify this content. Only the original poster, a moderator, or an administrator may perform this action.</span><br />"; }
}
echo "<br /></div>";
include_once "inc/footer.php"; ?>