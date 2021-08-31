<h4>Overview</h4>
<center><h5 style='text-decoration:underline;'>Recent Content</h5></center>
<?php
$grabRecentMods = $_SQL->query("SELECT * from `files` WHERE public != 'n' AND public != 'p' ORDER BY `date` DESC LIMIT 3");
$grabRecentMaps = $_SQL->query("SELECT * FROM maps WHERE public != 'n' ORDER BY `date` DESC LIMIT 3");
$grabRecentTopics = $_SQL->query("SELECT * FROM community WHERE public != 'n' ORDER BY `date` DESC LIMIT 2");
$grabRecentCmnts = $_SQL->query("SELECT * FROM notifications WHERE type = 'mod' OR type = 'map' OR type = 'com' ORDER BY `date` DESC LIMIT 2");
echo "<small><table width='90%' style='margin-top:0px;' align='center' class='recent'>"; $invert ='';
if ($_SESSION['theme'] == 'o' OR $_SESSION['theme'] == 'b') { $invert = 'filter:invert(100%);'; }
while ($rMAP = $grabRecentMaps->fetch_assoc()) {
	$getUsername2 = $_SQL->query("SELECT * FROM users WHERE id = '".$rMAP['uid']."'");
	$getUser2 = $getUsername2->fetch_assoc();
	$mapDate = dateConvert($rMAP['date']);
	$mapTitle1 =  (strlen($rMAP['title']) > 45) ? substr($rMAP['title'], 0, 20) . '...' : $rMAP['title'];
	$mapTitle = preg_replace("/\.?\s*([^\.]+):/", "</a><a href=\"/forge.php?id=".$rMAP['id']."\" title=\"Designed specifically for the $1 ".$rMAP['gametype']." variant.\">", $mapTitle1);
	echo "<tr><td width='10%' style='padding:7px; text-align:center;'><a href='/forge.php?id=".$rMAP['id']."' title='' id='rPostTitle0".$rMAP['id']."'><center><img src='/css/images/variants/forge.png' width='33' style='".$invert."' /></center></a></td>
	<td><b style='font-size:90%;'><a href='/forge.php?id=".$rMAP['id']."' title='' id='rPostTitle0".$rMAP['id']."'>".$mapTitle."</a></b><br /><span style='font-size:9px;'>→ forged by <a href='search.php?terms=".$rMAP['creator']."' class='rLink'>".$rMAP['creator']."</a></span></td>
	<td><span style='font-size:9px;' title='".dateConvert2($rMAP['date'])."'>".$mapDate."</span></td></tr>";
} while ($rCOM = $grabRecentTopics->fetch_assoc()) {
	$getUsername3 = $_SQL->query("SELECT * FROM users WHERE id = '".$rCOM['uid']."'");
	$getUser3 = $getUsername3->fetch_assoc();
	$comDate = dateConvert($rCOM['date']);
	$comTitle = preg_replace("/\.?\s*([^\.]+):/", "</a><a href=\"/community.php?id=".$rCOM['id']."\" title=\"$1\">", $rCOM['title']);
	if ($rCOM['flair'] == 'general') { $f = "📰"; }
	if ($rCOM['flair'] == 'help') { $f = "❔"; }
	if ($rCOM['flair'] == 'suggestion') { $f = "&#128161;"; }
	if ($rCOM['flair'] == 'media') { $f = "🎬"; } 
	if ($rCOM['flair'] == 'tutorial') { $f = "📋"; }
	if ($rCOM['flair'] == 'download') { $f = "💾"; }
	echo "<tr><td width='10%' style='padding:7px;'><a href=\"/community.php?id=".$rCOM['id']."\"><span style='font-size:20px;'><b title='Community Topic: ".ucwords($rCOM['flair'])."'><center>".$f."</center></b></span></a></td><td><span style='font-size:90%; font-weight:bold;'><a href=\"/community.php?id=".$rCOM['id']."\" id=\"rPostTitle2".$rCOM['id']."\">".$comTitle."</a></span><br /><span style='font-size:9px;'>→ posted by <a href='/users.php?id=".$getUser3['id']."' class='rLink'>".$getUser3['uname']."</a></span></td><td><span style='font-size:9px;' title='".dateConvert2($rCOM['date'])."'>".$comDate."</span></td></tr>";
} while ($rMOD = $grabRecentMods->fetch_assoc()) {
	$getUsername = $_SQL->query("SELECT * FROM users WHERE id = '".$rMOD['uid']."'");
	$getUser = $getUsername->fetch_assoc();
	$modDate = dateConvert($rMOD['date']);
	$modTitle = preg_replace("/\.?\s*([^\.]+):/", "</a><a href=\"/files.php?id=".$rMOD['id']."\" title=\"$1\">", $rMOD['title']);
	$type = "<img src=\"/css/images/file_icons/".$rMOD['type']."/".$_SESSION['theme'].".png\" width='30' />";
	echo "<tr><td width='10%' style='padding:7px;'><span style='font-size:25px;'>
	<b title='Game File: ".ucwords($rMOD['type'])."'><center>".$type."</center></b></span></td>
	<td><b style='font-size:90%;'><a href='/files.php?id=".$rMOD['id']."' id='rPostTitle1".$rMOD['id']."'>".$modTitle."</a></b>
	<br /><span style='font-size:9px;'>→ created by <a href='/search.php?terms=".$rMOD['creator']."' class='rLink'>".$rMOD['creator']."</a></span>
	</td><td><span style='font-size:9px;' title='".dateConvert2($rMOD['date'])."'>".$modDate."</span></td></tr>";
} while ($rCMNT = $grabRecentCmnts->fetch_assoc()) {
	$getUsernameC = $_SQL->query("SELECT * FROM users WHERE id = '".$rCMNT['from_id']."'");
	$getUserC = $getUsernameC->fetch_assoc();
	$cmntDate = dateConvert($rCMNT['date']);
	if ($rCMNT['type'] == 'mod') { 
		$checkMtitle = $_SQL->query("SELECT * from `files` WHERE id = '".$rCMNT['mod_id']."'");
		$checkM = $checkMtitle->fetch_assoc();
		$cmntMtitle = $checkM['title'];
		$modORmap = "<a href='/files.php?id=".$checkM['id']."#".$rCMNT['id']."'>".$cmntMtitle."</a>"; 
	} if ($rCMNT['type'] == 'com') { 
		$checkCtitle = $_SQL->query("SELECT * FROM community WHERE id = '".$rCMNT['com_id']."'");
		$checkC = $checkCtitle->fetch_assoc();
		$cmntCtitle = $checkC['title'];
		$modORmap = "<a href='/community.php?id=".$checkC['id']."#".$rCMNT['id']."'>".$cmntCtitle."</a>"; 
	} if ($rCMNT['type'] == 'map') { 
		$checkFtitle = $_SQL->query("SELECT * FROM maps WHERE id = '".$rCMNT['forge_id']."'");
		$checkF = $checkFtitle->fetch_assoc();
		$cmntFtitle = $checkF['title'];
		$modORmap = "<a href='/forge.php?id=".$checkF['id']."#".$rCMNT['id']."'>".$cmntFtitle."</a>"; 
	} echo "<tr><td width='10%' style='padding:7px;'>
<span style='font-size:22px;'><center title='Written Response'>💬</center></span></td>
<td><span style='font-size:90%; font-weight:bold;' id='rPostTitle3".$rCMNT['id']."'>".$modORmap."</span><br />
<span style='font-size:9px;'>→ <a href='/users.php?id=".$getUserC['id']."' class='rLink'>".$getUserC['uname']."</a> left a response</span></center></td><td><span style='font-size:9px;' title='".dateConvert2($rCMNT['date'])."'>".dateConvert($rCMNT['date'])."</span></td></tr>";
} echo "</table></small>";
$grabMaps = $_SQL->query("SELECT id FROM maps WHERE public != 'n'");
$forgeCount = $grabMaps->num_rows;
$grabMods = $_SQL->query("SELECT id from `files` WHERE public != 'n'");
$fileCount = $grabMods->num_rows;;
$grabCommunity = $_SQL->query("SELECT id FROM community WHERE `flair` != 'media' AND `flair` != 'download' AND  public != 'n'");
$comCount = $grabCommunity->num_rows;
$grabMedia = $_SQL->query("SELECT id FROM community WHERE `flair` = 'media'");
$mediaCount = $grabMedia->num_rows;
$threadCount = $forgeCount + $fileCount + $comCount;
$grabComments = $_SQL->query("SELECT id FROM notifications WHERE type = 'map' OR type = 'com' OR type = 'mod' OR type = 'media'");
$cmtCount = $grabComments->num_rows;
$totCount = $threadCount + $cmtCount;
$usrCount = $_SQL->query("SELECT id FROM users"); $usrCnt = $usrCount->num_rows;
$userThread = $_SQL->query("SELECT posts.uid, COUNT(*) AS posts_num, users.uname FROM (SELECT uid from maps WHERE uid != '11' UNION ALL SELECT uid FROM `files` WHERE uid != '11' UNION ALL SELECT uid FROM community) AS posts LEFT JOIN users ON users.id=posts.uid GROUP BY uid ORDER BY posts_num DESC LIMIT 1");
$ut = $userThread->fetch_assoc();
$userArtist = $_SQL->query("SELECT creator, COUNT(*) AS forge_num FROM maps GROUP BY creator ORDER BY forge_num DESC LIMIT 1") or die($_SQL->error);
$uf = $userArtist->fetch_assoc();
$userModz = $_SQL->query("SELECT creator, COUNT(*) AS mod_num FROM `files` GROUP BY creator ORDER BY mod_num DESC LIMIT 1") or die($_SQL->error);
$um = $userModz->fetch_assoc();
$userNew = $_SQL->query("SELECT * FROM `users` ORDER BY `id` DESC LIMIT 1");
$userTop = $_SQL->query("SELECT topics.uid, COUNT(*) AS topics_num, users.uname FROM (SELECT uid FROM community) AS topics LEFT JOIN users ON users.id=topics.uid GROUP BY uid ORDER BY topics_num DESC LIMIT 1");
$grabMonth = $_SQL->query("SELECT id FROM `users` WHERE  `last_action` > date_sub(CURRENT_TIMESTAMP, INTERVAL 1 MONTH) ORDER BY `last_action` DESC");
$grabWeek = $_SQL->query("SELECT id FROM `users` WHERE  `last_action` > date_sub(CURRENT_TIMESTAMP, INTERVAL 1 WEEK) ORDER BY `last_action` DESC");
$uTop = $userTop->fetch_assoc();
$uRct = $grabMonth->num_rows;
$uRWct = $grabWeek->num_rows;
$uNew = $userNew->fetch_assoc();

?><br />
<h5 style='text-decoration:underline;'><center>Site Stats</center></h5>
<table width='90%' align='center' class='recent' style='font-size:small;'>
	<tr><td>Maps Posted: </td><td style='text-align:right;'><a href='/forge.php'><?=$forgeCount;?></a></td></tr>
	<tr><td>Files Posted: </td><td style='text-align:right;'><a href='/files.php'><?=$fileCount;?></a></td></tr>
	<tr><td>Media Shared: </td><td style='text-align:right;'><a href='/media.php'><?=$mediaCount;?></a></td></tr>
	<tr><td>Community Topics: </td><td style='text-align:right;'><a href='/community.php'><?=$comCount;?></a></td></tr>
	<tr><td title='Maps/Mods/Topics are all considered threads.'>Total Threads: </td><td style='text-align:right;'><?=$threadCount;?></td></tr>
	<tr><td>Total Responses: </td><td style='text-align:right;'><?=$cmtCount;?></td></tr>
	<tr><td style='font-weight:bold;'>Posts In-Total: </td><td style='text-align:right;'><?=$totCount;?></td></tr></table>

<br />

<h5 style='padding-bottom:2px; text-decoration:underline;'><center>User Stats</center></h5>
<table align='center' style='font-size:small;' onmouseover="toggle_tr('moreAct');toggle_tr('moreAct2');toggle_tr('moreAct3');toggle_tr('moreAct4');" onmouseout="toggle_tr('moreAct');toggle_tr('moreAct2');toggle_tr('moreAct3');toggle_tr('moreAct4');" class='recent'>
	<tr>
		<td>Newest&nbsp;Recruit: </td>
		<td style='text-align:right;'><a href='/users.php?id=<?=$uNew['id'];?>'><?=$uNew['uname'];?></a></td>
	</tr>
	<tr id='moreAct' style='display:none; min-width:90%;'>
		<td>Most&nbsp;Maps: </td>
		<td style='text-align:right;'><a href='/search.php?find=<?=$uf['creator'];?>'><?=$uf['creator'];?></a></td>
	</tr>
	<tr id='moreAct2' style='display:none; min-width:90%;'>
		<td>Most&nbsp;Files: </td>
		<td style='text-align:right;'><a href='/search.php?find=<?=$um['creator'];?>'><?=$um['creator'];?></a></td>
	</tr>
	<tr id='moreAct3' style='display:none; min-width:90%;'>
		<td>Most&nbsp;Topics: </td>
		<td style='text-align:right;'><a href='/community.php?uid=<?=$uTop['uid']?>'><?=$uTop['uname'];?></a></td>
	</tr> 
	<tr id='moreAct4' style='display:none; min-width:90%;'>
		<td>Top&nbsp;Poster: </td>
		<td style='text-align:right;'><a href='/users.php?id=<?=$ut['uid'];?>'><?=$ut['uname'];?></a></td>
	</tr>
	<tr>
		<td>Active This Week: </td>
		<td style='text-align:right;'><a href='/users.php'><?=$uRWct;?></a></td>
	</tr>
	<tr>
		<td>Active This Month: </td>
		<td style='text-align:right;'><a href='/users.php'><?=$uRct;?></a></td>
	</tr>
	<tr>
		<td>Registered&nbsp;Members: </td>
		<td style='text-align:right;'><a href='/users.php'><?=$usrCnt;?></a></td>
	</tr>
</table><br />