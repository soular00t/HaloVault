<?php include_once "inc/core.php";  error_reporting(E_ALL & ~E_NOTICE); include_once "inc/header.php";
echo "<div class='content'>";
echo "<div class='contentHeader'>Community</div>";
$ORDER = 'last_action';
if (isset($_GET['order']) && !empty($_GET['order'])) { $ORDER = $_SQL->real_escape_string($_GET['order']); }
$uSQL =  $_SQL->query("SELECT * FROM users ORDER BY ".$ORDER." DESC");
$totalUsers = $uSQL->num_rows;
// LIST ALL USERS
if (!isset($_GET['id']) && !isset($_GET['edit'])) { 
	echo "Listings of all registered users since the beginning.<br /><h3>👤 User List <div style='font-family:arial; float:right; font-size:11px;'>Order by: <a href='/users.php'>Last Active</a> | <a href='?order=date'>Date Registered</a></div></h3>
<div id='contentHolder' class='contentHolder'>\n<div class='row' style='text-align:center; font-size:small;'><div class='col-md-1'></div><div class='col-md-4'><b>Username</b></div><div class='col-md-2'><b>Alias</b></div><div class='col-md-2'><b>Total Posts</b></div><div class='col-md-3'><b>Last Active</b></div></div>\n"
		."<br /><div id='forgeList' data-load-more='35' class='forgeList' style='min-width:100%;'>";
	while ($USERS = $uSQL->fetch_assoc()) {
		$regDate = dateConvert2($USERS['date']);
		$mapcountSQL = $_SQL->query("SELECT * FROM maps WHERE uid = '".$USERS['id']."'");
		$modcountSQL = $_SQL->query("SELECT * FROM `files` WHERE uid = '".$USERS['id']."'");
		$topcountSQL = $_SQL->query("SELECT * FROM community WHERE uid = '".$USERS['id']."'");
		$cmntcountSQL = $_SQL->query("SELECT * FROM notifications WHERE from_id = '".$USERS['id']."' AND (type = 'mod' OR type='map' OR type='com')");
		$totalCmnts = $cmntcountSQL->num_rows;
		$totalMaps = $mapcountSQL->num_rows;
		$totalMods = $modcountSQL->num_rows;
		$totalTops = $topcountSQL->num_rows;
		$totalPosts = $totalCmnts + $totalMaps + $totalMods + $totalTops;
		$uAlias = $USERS['alias'];
		$actDate = dateConvert($USERS['last_action']);
		if (empty($USERS['alias'])) { $uAlias = $USERS['uname']; }
		echo "<div class='row' style='text-align:center; display:flex; align-items:center;'><div class='col-md-1' style='text-align:left;'><img onerror=\"this.src='/css/images/grunt.png';\" src=\"".$USERS['avatar']."\" height='60' width='60' /></div><div class='col-md-4'><a href='/users.php?id=".$USERS['id']."'><b>".$USERS['uname']."</b></a></div><div class='col-md-2'><small>".$uAlias."</small></div><div class='col-md-2'><small>".$totalPosts."</small></div><div class='col-md-3' style='font-size:small;' title=\"Registered: ".$regDate."\nLast Active: ".dateConvert2($USERS['last_action'])."\"><i>".$actDate."</i></div></div>";
	}
	echo "</div>";
	if ($totalUsers > 35) { echo "<br /><div id='loadMore' class='loadMore' data-action='load-more' data-bound='forgeList'><a>&#x21bb; <small>Load More</small></a></div>"; }
	echo "</div>";
} // INDIVIDUAL USER 
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$grabUser = $_SQL->query("SELECT * FROM users where id = '".$_GET['id']."'");
	$USER = $grabUser->fetch_assoc();
	if ($grabUser->num_rows < 1) { die("<script>location.href = '/users.php';</script>"); }
	$userDate = dateConvert2($USER['date']);
	if (empty($USER['date'])) { $userDate = "Since The Beginning"; }
	$mapcountSQL = $_SQL->query("SELECT * FROM maps WHERE uid = '".$USER['id']."'");
	$mapSQL2 = $_SQL->query("SELECT * FROM maps WHERE creator = '".$USER['uname']."' OR creator = '".$USER['alias']."'");
	$mapCount = $mapcountSQL->num_rows;
	$mapCreatedCount = $mapSQL2->num_rows;
	$modcountSQL = $_SQL->query("SELECT * FROM `files` WHERE uid = '".$USER['id']."'");
	$modSQL2 = $_SQL->query("SELECT * FROM `files` WHERE creator = '".$USER['uname']."'");
	$modCount = $modcountSQL->num_rows;
	$modCreatedCount = $modSQL2->num_rows;
	$topicCount = $_SQL->query("SELECT * FROM community WHERE uid = '{$USER['id']}'");
	$topCount = $topicCount->num_rows;
	$cmntcountSQL = $_SQL->query("SELECT * FROM notifications WHERE from_id = '".$USER['id']."' AND (type = 'mod' OR type = 'map' OR type = 'com')");
	$cmntCount = $cmntcountSQL->num_rows;
	$votesRecSQL = $_SQL->query("SELECT * FROM notifications WHERE to_id = '".$USER['id']."' AND type = 'vote'");
	$votesRecieved = $votesRecSQL->num_rows;
	$TOTALPOSTS = $cmntCount + $topCount + $modCount + $mapCount;
	$PTG = 300; $TR = 42;
	$postDivide = $PTG / $TR; 
	if ($TOTALPOSTS <= $postDivide) { $rank = "Recruit"; }
	if ($TOTALPOSTS > $postDivide && $TOTALPOSTS < $postDivide * 2) { $rank = "Apprentice"; }
	if ($TOTALPOSTS > $postDivide * 2 && $TOTALPOSTS < $postDivide * 3) { $rank = "Apprentice_Grade_2"; }
	if ($TOTALPOSTS > $postDivide * 3 && $TOTALPOSTS < $postDivide * 4) { $rank = "Private"; }
	if ($TOTALPOSTS > $postDivide * 4 && $TOTALPOSTS < $postDivide * 5) { $rank = "Private_Grade_2"; }
	if ($TOTALPOSTS > $postDivide * 5 && $TOTALPOSTS < $postDivide * 6) { $rank = "Corperal"; }
	if ($TOTALPOSTS > $postDivide * 6 && $TOTALPOSTS < $postDivide * 7) { $rank = "Corperal_Grade_2"; }
	if ($TOTALPOSTS > $postDivide * 7 && $TOTALPOSTS < $postDivide * 8) { $rank = "Sergant"; }
	if ($TOTALPOSTS > $postDivide * 8 && $TOTALPOSTS < $postDivide * 9) { $rank = "Sergeant_Grade_2"; }
	if ($TOTALPOSTS > $postDivide * 9 && $TOTALPOSTS < $postDivide * 10) { $rank = "Sergeant_Grade_3"; }
	if ($TOTALPOSTS > $postDivide * 10 && $TOTALPOSTS < $postDivide * 11) { $rank = "Gunnery_Sergeant"; }
	if ($TOTALPOSTS > $postDivide * 11 && $TOTALPOSTS < $postDivide * 12) { $rank = "Gunnery_Sergeant_Grade_2"; }
	if ($TOTALPOSTS > $postDivide * 12 && $TOTALPOSTS < $postDivide * 13) { $rank = "Gunnery_Sergeant_Grade_3"; }
	if ($TOTALPOSTS > $postDivide * 13 && $TOTALPOSTS < $postDivide * 14) { $rank = "Gunnery_Sergeant_Grade_4"; }
	if ($TOTALPOSTS > $postDivide * 14 && $TOTALPOSTS < $postDivide * 15) { $rank = "Lieutenant"; }
	if ($TOTALPOSTS > $postDivide * 15 && $TOTALPOSTS < $postDivide * 16) { $rank = "Lieutenant_Grade_2"; }
	if ($TOTALPOSTS > $postDivide * 16 && $TOTALPOSTS < $postDivide * 17) { $rank = "Lieutenant_Grade_3"; }
	if ($TOTALPOSTS > $postDivide * 17 && $TOTALPOSTS < $postDivide * 18) { $rank = "Lieutenant_Grade_4"; }
	if ($TOTALPOSTS > $postDivide * 18 && $TOTALPOSTS < $postDivide * 19) { $rank = "Captain"; }
	if ($TOTALPOSTS > $postDivide * 19 && $TOTALPOSTS < $postDivide * 20) { $rank = "Captain_Grade_2"; }
	if ($TOTALPOSTS > $postDivide * 20 && $TOTALPOSTS < $postDivide * 21) { $rank = "Captain_Grade_3"; }
	if ($TOTALPOSTS > $postDivide * 21 && $TOTALPOSTS < $postDivide * 22) { $rank = "Captain_Grade_4"; }
	if ($TOTALPOSTS > $postDivide * 22 && $TOTALPOSTS < $postDivide * 23) { $rank = "Major"; }
	if ($TOTALPOSTS > $postDivide * 23 && $TOTALPOSTS < $postDivide * 24) { $rank = "Major_Grade_2"; }
	if ($TOTALPOSTS > $postDivide * 24 && $TOTALPOSTS < $postDivide * 25) { $rank = "Major_Grade_3"; }
	if ($TOTALPOSTS > $postDivide * 25 && $TOTALPOSTS < $postDivide * 26) { $rank = "Major_Grade_4"; }
	if ($TOTALPOSTS > $postDivide * 26 && $TOTALPOSTS < $postDivide * 27) { $rank = "Commander"; }
	if ($TOTALPOSTS > $postDivide * 27 && $TOTALPOSTS < $postDivide * 28) { $rank = "Commander_Grade_2"; }
	if ($TOTALPOSTS > $postDivide * 28 && $TOTALPOSTS < $postDivide * 29) { $rank = "Commander_Grade_3"; }
	if ($TOTALPOSTS > $postDivide * 29 && $TOTALPOSTS < $postDivide * 30) { $rank = "Commander_Grade_4"; }
	if ($TOTALPOSTS > $postDivide * 30 && $TOTALPOSTS < $postDivide * 31) { $rank = "Colonel"; }
	if ($TOTALPOSTS > $postDivide * 31 && $TOTALPOSTS < $postDivide * 32) { $rank = "Colonel_Grade_2"; }
	if ($TOTALPOSTS > $postDivide * 32 && $TOTALPOSTS < $postDivide * 33) { $rank = "Colonel_Grade_3"; }
	if ($TOTALPOSTS > $postDivide * 33 && $TOTALPOSTS < $postDivide * 34) { $rank = "Colonel_Grade_4"; }
	if ($TOTALPOSTS > $postDivide * 34 && $TOTALPOSTS < $postDivide * 35) { $rank = "Brigadier"; }
	if ($TOTALPOSTS > $postDivide * 35 && $TOTALPOSTS < $postDivide * 36) { $rank = "Brigadier_Grade_2"; }
	if ($TOTALPOSTS > $postDivide * 36 && $TOTALPOSTS < $postDivide * 37) { $rank = "Brigadier_Grade_3"; }
	if ($TOTALPOSTS > $postDivide * 37 && $TOTALPOSTS < $postDivide * 38) { $rank = "Brigadier_Grade_4"; }
	if ($TOTALPOSTS > $postDivide * 38 && $TOTALPOSTS < $postDivide * 39) { $rank = "General"; }
	if ($TOTALPOSTS > $postDivide * 39 && $TOTALPOSTS < $postDivide * 40) { $rank = "General_Grade_2"; }
	if ($TOTALPOSTS > $postDivide * 40 && $TOTALPOSTS < $postDivide * 41) { $rank = "General_Grade_3"; }
	if ($TOTALPOSTS > $postDivide * 41) { $rank = "General_Grade_4"; } 
	$pID = $USER['playerid'];
	$eMail = "<li>Email Address: <a href='mailto:".$USER['email']."'>".$USER['email']."</a></li><br />";
	if ($USER['hmail'] == 'y') { $eMail = ''; }
	$sendOption = "<div style='float:right; font-size:x-small; padding:6px; border:1px solid grey; background:black; color:white; border-radius:25px;'><a class='dialog_link' data-dialog='dialog' href='javascript:void();' title='Send this user a pesonal message.'>✉ Send Message</a></div>";
	if (!isset($_USER['id']) OR $_GET['id'] == $_USER['id']) {$sendOption = "";}
	if (isset($_USER['id'])) {
		if ($_GET['id'] == $_USER['id'] OR $_USER['group'] > 2) { 
			echo"<small><a href='/users.php?edit=".$USER['id']."'>✎ Update Profile</a></small>";
		}
		echo "<div class='dialog' id='dialog' title='Start conversation with ".$USER['uname']."'>
<form id='replyForm' method='post' style='display:block;'>
<div class='row'><div class='col-md-2' style='text-align:right;'><br /><img onerror=\"this.src='/css/images/grunt.png';\" src=\"".$_USER['img']."\" style='padding-right:20px;' height='100' /></div><div class='col-md-10'>".$bbcode_buttons."<textarea name='reply' id='edit' rows='10' style='font-size:10px;' placeholder='Write your message here.'></textarea></div></div>
<input type='submit' name='sendreply' value='Send' style='font-size:10px; position:absolute; right:18px;' /></form><br />
<br /></div>";
	}
	if (isset($_POST['sendreply'])) { 
		$msg = htmlspecialchars($_POST['reply']);
		$reply = "<div class='comment'><h5>Message from <a href='/users.php?id=".$_USER['id']."'>".$_USER['name']."</a></h5><div class='row'><div class='col-md-2' style='text-align:center;'><img onerror=\"this.src='/css/images/grunt.png';\" src=\"".$_USER['img']."\" width='60' /></div><div class='col-md-10' style='padding-right:20px;'>".$msg."</div></div><div style='font-size:xx-small; float:right; text-align:right; min-width:100px; margin-right:7px;'>".dateConvert2(date('Y-m-d G:i:s'))."</div></div>";
		$rply = $_SQL->real_escape_string($reply);
		if (!empty($msg)) {
			$_SQL->query("INSERT INTO notifications (from_id, to_id, type, comment) VALUES ('{$_USER['id']}', '{$USER['id']}', 'msg', '{$rply}');") or die($_SQL->error);
			echo "<script>alert(\"Your personal message has been sent to ".$USER['uname']."!\");</script>";
		}
	} $profileSite = "";
	if (empty($USER['slogan'])) { $USER['slogan'] = 'Build, Browse, Share'; }
	if (!empty($USER['site'])) { $nohttp = str_replace('http://', '', $USER['site']); $nohttp = str_replace('www.', '', $USER['site']); $profileSite = "<li>Website/Profile: <a href=\"".addScheme($USER['site'])."\" target='_blank'>".$USER['site']."</a></li><br />"; }
	$userGROUP = '👤 Registered User'; $handle = '';
	if ($USER['group'] == -1) { $userGROUP = "<img src='/css/images/subFlairs/fmmbutton.png' title='This user is the creator of the Foundation Mod Manager.' style='border-radius:10px; margin-top:-5px;' />"; }
	if ($USER['group'] == -2) { $userGROUP = "<img src='/css/images/subFlairs/devbutton.png' title='This user is a developer of the ElDewrito Halo Online mod client.' style='border-radius:10px; margin-top:-5px;' />"; }
	if ($USER['group'] == 3) { $userGROUP = "<span style='color:blue;' title='This user is an administrator of HaloVault.'>&#9819; Administrator</span>"; }
	if ($USER['id'] == 1) { $userGROUP = "<span style='color:green;' title=\"This user is the creator of HaloVault & TheDarkRoom dedicated server host.\">&#9819; Owner / Admin</span>"; }
	if ($USER['group'] == 2) { $userGROUP = "<span  style='color:orange;' title=\"This user is moderator on both TheDarkRoom dedicated servers and HaloVault.\">&#128295; Moderator</span>"; }
	if ($USER['group'] == 0) { $userGROUP = "<span style='color:red;' title=\"This user is BANNED from HaloVault\">&#8416; &nbsp;  Banned</span>"; }
	if ($USER['alias'] != $USER['uname'] && !empty($USER['alias'])) { $handle = "<li>Alternate Alias: ".$USER['alias']."</li><br />"; }
	$rankk = str_replace('_Grade_', ': Grade ', $rank);
	$rankk = str_replace('_', ' ', $rank);
	echo "<h3><img width='25' style='filter:grayscale(100%);' title='".$rankk."' src='/css/images/ranks/alt/".$rank.".ico' /> ".$USER['uname']."".$sendOption."</h3>
	<div id='contentHolder' class='contentHolder'>
	<div class='row' style='margin-right:10px;'>
<div class='col-md-7'><img onerror=\"this.src='/css/images/grunt.png';\" src=\"".$USER['avatar']."\" align='left' width='30%' style='margin-right:30px; display:block; float:left;' />
<span style='display:block; background:#111; max-width:60%; overflow:auto; text-align:center; float:right; color:white; opacity:0.6;'>".$USER['slogan']."</span><br /><br />
<ul style='margin-top:170px; display:block;'>".$profileSite."".$eMail."".$handle."<li>".$userGROUP."</li></ul></div>"
		."<div class='col-md-5' style='padding:15px; color:white!important; max-width:30%; float:right; background:black; opacity:0.4 !important;'>\n"
		."<a style='color:inherit; text-decoration:none;' href='/forg.e?creator=".$USER['uname']."'>⚒&nbsp;Maps&nbsp;Created:&nbsp;".$mapCreatedCount."</a><br />"	
		."<a style='color:inherit; text-decoration:none;' href='/forge.php?uid=".$USER['id']."'>⚒&nbsp;Maps&nbsp;Submitted:&nbsp;".$mapCount."</a><br />"
		."<a style='color:inherit; text-decoration:none;' href='/files.php?creator=".$USER['uname']."'>⚙ Files Accredited:&nbsp;".$modCreatedCount."</a><br />"
		."<a style='color:inherit; text-decoration:none;' href='/files.php?uid=".$USER['id']."'>⚙&nbsp;Files&nbsp;Submitted:&nbsp;".$modCount."</a><br />"
		."<a style='color:inherit; text-decoration:none;' href='/community.php?uid=".$USER['id']."'><span style='margin-top:-4px; font-size:14px;'>📰</span>&nbsp;Topics&nbsp;Posted:&nbsp;".$topCount."</a><br />"
		."💬 Replies&nbsp;Written:&nbsp;".$cmntCount."<br />"
		."👍 Votes&nbsp;Recieved:&nbsp;".$votesRecieved."<hr /><b title='Website Exp: ".$rankk."\n(Calculated out of 300 posts)'><center>☲&nbsp;Total&nbsp;Posts:&nbsp;".$TOTALPOSTS."</center></b>";
	echo "</div></div>";
	// GRAB HALOSTATS DATA
	if (!empty($pID)) {
		$queryStats = "http://halostats.click/privateapi/getStats?PlayerIndex=".$pID."";
		$statsJson = get_url($queryStats);
		$htmlEcho = '';
		if ($statsJson) {
			$pStats = json_decode($statsJson, 1);
			$pName = $pStats['ranked']['Name'];
			$onlineGrab = "http://fantalitystudios.com/private/api/player/online?Name=".$pName.""; 
			$onlineJson = get_url($onlineGrab);
			$Oplayer = json_decode($onlineJson, 1);
			if (isset($Oplayer['online'])) {
				$onlineServer = str_replace('HaloVault |', '', $Oplayer['online']['server']);
				$online = "<div title='Click to join.' style=\"cursor:url('/css/images/hoSmall_cursor.png'), pointer; overflow:auto; color:white; padding:2px; font-size:x-small; text-align:center;\" onclick=\"rcon.send('server.connect ".$Oplayer['online']['address']."');\">"
					."🎮 Playing in:<br /><b style='background:grey; color:lime;'>".htmlspecialchars($onlineServer)."</b><br /><small>(".$Oplayer['online']['address'].")</small></div>";
			} else { $online = "<div  style=\"color:; padding:2px; text-align:center; font-size:x-small; max-width:200px; float:center;\">🎮 Offline</div>"; }
			$deaths = $pStats['social']['Deaths'] + $pStats['ranked']['Deaths'];
			$suicides = $pStats['social']['Suicides'] + $pStats['ranked']['Suicides'];
			$assists = $pStats['social']['Assists'] + $pStats['ranked']['Assists'];
			$splatters = $pStats['social']['Splatters'] + $pStats['ranked']['Splatters'];
			$ksprees = $pStats['social']['KillingSprees'] + $pStats['ranked']['KillingSprees'];
			$kills = $pStats['social']['Kills'] + $pStats['ranked']['Kills'];
			$totalGames = $pStats['GamesPlayed'];
			$EXP = $pStats['EXP'];
			$globalRank = $pStats['Rank'];
			$doubleKills = $pStats['social']['DoubleKills'] + $pStats['ranked']['DoubleKills'];
			$tripleKills = $pStats['social']['TripleKills'] + $pStats['ranked']['TripleKills'];
			$overKills = $pStats['social']['OverKills'] + $pStats['ranked']['OverKills'];
			$fiveKills = $pStats['social']['Killtaculars'] + $pStats['ranked']['Killtaculars'];
			$beatdowns = $pStats['social']['MeleeKills'] + $pStats['ranked']['MeleeKills'];
			$zombieSpree = $pStats['social']['ZombieKillingSprees'] + $pStats['ranked']['ZombieKillingSprees'];
			$infectSpree = $pStats['social']['InfectionSprees'] + $pStats['ranked']['InfectionSprees'];
			$HeadSnipes = $pStats['social']['SniperHeadshots'] + $pStats['ranked']['SniperHeadshots'];
			$emblemColor = $pStats['EmblemData']['backgroundColor'];
			$emblemBG = $pStats['EmblemData']['backgroundImage'];
			$emblem = $pStats['EmblemData']['profilePicture']; $kdr = '';
			if ($kills > 0 && $deaths > 0) { $kdr = $kills / $deaths; $kdr = substr($kdr, 0, 4); }
			$unscIMG = "<img title='Uniquely calculated by RabidSquabbit' src='//halostats.click/img/halo3stats/ranks/".$globalRank.".png' style='margin-top:-3px;' width='35' />";
			$infoColor = 'white'; if ($emblemColor == '#dedede') { $infoColor = '#fff'; $emblemColor = '#999'; }
			$htmlEcho = "<div class='uStats' style='margin-top:20px; float:center; max-width:100%; border:1px solid ".$emblemColor.";'>
<div class='row' style=\"display:flex; align-items:center; float:center; margin:0 auto; background-color:".$emblemColor."; background-size:cover; background-image:url(http://pre03.deviantart.net/2c06/th/pre/i/2013/136/3/e/free_hexagon_pattern_02_by_black_light_studio-d65g32i.png); font-size:x-small; background-position:center center; color:".$infoColor.";\">
<div class='col-md-3'>
<a style='color:inherit; font-weight:bold; margin:0 auto;' title='Brought to you by HaloStats.click' href=\"//halostats.click/Player/".$pID."\" target='_blank'>
<img src='".$emblem."' width='29' />&nbsp;".$pName."</a>
<br /><span style='font-size:xx-small; font-weight:bold;'><i>Experience Points: ".$EXP."</i></span><br />
</div>
<div class='col-md-1' style='text-align:center; font-size:xx-small; font-weight:bold;'>".$unscIMG."
<br />Global Rank: ".$globalRank."</div>
<div class='col-md-1' style='text-align:center; border-left:1px solid white;'><img title='Double Kill!' src='//halostats.click/img/halo3stats/medals/literals/doubleKillsSmall.gif' width='24' />
<br />".$doubleKills."</div>
<div class='col-md-1' style='text-align:center; border-left:1px solid white;'><img title='Triple Kill!' src='//halostats.click/img/halo3stats/medals/literals/tripleKillsSmall.gif' width='24' />
<br />".$tripleKills."</i></div>
<div class='col-md-1' style='text-align:center; border-left:1px solid white;'><img title='Overkill!' src='//halostats.click/img/halo3stats/medals/literals/OverKillsSmall.gif' width='24' />
<br />".$overKills."</div>
<div class='col-md-1' style='text-align:center; border-left:1px solid white; border-right:1px solid white;'><img title='Killtacular!' src='//halostats.click/img/halo3stats/medals/literals/KilltacularsSmall.gif' width='24' />
<br />".$fiveKills."</div>
<div class='col-md-4'>".$online."</div>
</div><br />"
				."<small><div style='padding:10px; margin:0 auto;'><div class='row'>
<div class='col-md-5'>Total Games:</div>
<div class='col-md-1'>".$totalGames."</div>
<div class='col-md-5'><img src='//halostats.click/img/halo3stats/medals/literals/SniperHeadshotsSmall.gif' width='21' align='left' />
&nbsp; Snipes:</div>
<div class='col-md-1'>".$HeadSnipes."</div></div>"
				."<div class='row'>
<div class='col-md-5'>Kills</div>
<div class='col-md-1'>".$kills."</div>
<div class='col-md-5'><img src='//halostats.click/img/halo3stats/medals/literals/MeleeKillsSmall.gif' width='21' align='left' />
&nbsp; Beat Downs:</div>
<div class='col-md-1'>".$beatdowns."</div></div>"
				."<div class='row'>
<div class='col-md-5'>Deaths:</div>
<div class='col-md-1'>".$deaths."</div>
<div class='col-md-5'><img src='//halostats.click/img/halo3stats/medals/literals/KillingSprees.gif' width='21' align='left' />
&nbsp; Killing Sprees:</div>
<div class='col-md-1'>".$ksprees."</div></div>"
				."<div class='row'>
<div class='col-md-5'>K/D Ratio:</div>
<div class='col-md-1'>".$kdr."</div>
<div class='col-md-5'><img src='//halostats.click/img/halo3stats/medals/literals/SplattersSmall.gif' width='21' align='left' />
&nbsp; Splatters:</div>
<div class='col-md-1'>".$splatters."</div></div>"
				."<div class='row'>
<div class='col-md-5'>Suicides:</div>
<div class='col-md-1'>".$suicides."</div>
<div class='col-md-5'><img src='//halostats.click/img/halo3stats/medals/literals/InfectionSpreesSmall.gif' width='21' align='left' />
&nbsp; Infection Sprees:</div>
<div class='col-md-1'>".$infectSpree."</div></div>"
				."<div class='row'>
<div class='col-md-5'>Assists:</div>
<div class='col-md-1'>".$assists."</div>
<div class='col-md-5'><img src='//halostats.click/img/halo3stats/medals/literals/ZombieKillingSpreesSmall.gif' width='21' align='left' />
&nbsp; Zombie Killing Sprees:</div>
<div class='col-md-1'>".$zombieSpree."</div>"
				."</div></small></div></div>"; 
		}
		echo $htmlEcho;
	}
	echo "<div class='row' style='margin-top:30px; position:relative; top:0px; width:100%; border-top:1px dashed grey; padding-top:5px;'>"
		."<div class='col-md-5' style='font-size:small; float:left;' title='".dateConvert2($USER['last_action'])."'>Last Active: ".dateConvert($USER['last_action'])."</div><div class='col-md-7' style='font-size:small; text-align:right;'>Registered ".$userDate."</div></div>";
	echo "</div>";
} // EDIT PROFILE
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
	$grabUser = $_SQL->query("SELECT * FROM users where id = '".$_GET['edit']."'");
	$USER = $grabUser->fetch_assoc();
	$USERav = $USER['avatar'];
	if ($USERav == "/css/images/grunt.png") { $USERav = ''; }
	$Ualias = $USER['alias'];	
	if ($Ualias == $USER['uname']) { $Ualias = ''; }
	$userDate = $USER['date'];
	$ch = '';
	if ($USER['hmail'] == 'y') { $ch = ' checked'; }
	echo "<h3>Edit Profile: ".$USER['uname']."</h3><div id='contentHolder' class='contentHolder'>";
	$editForm = "&#9874;<small> = Required field.</small><br /><br /><form method='post'><table>"
		."<tr><td>Edit Username:</td><td><input type='text' value=\"".$USER['uname']."\" name='uname' /> &#9874;</td></tr>"
		."<tr title='Just enter HaloStats Player ID for now'><td>HaloStats PlayerID:</td>
<td><input type='text' list='pQuery' id='piQuery' value=\"".$USER['playerid']."\" placeholder='ex: Walla Walla' name='playerID' datalist />
<datalist id='pQuery'></datalist></td></tr>"
		."<tr><td>Change Slogan:</td><td><input type='text' value=\"".$USER['slogan']."\" name='slogan' /></td></tr>"
		."<tr title='An alias is an alternative name that you go by. This could be your reddit account, steam profile, etc.'><td>Modify Alias:</td><td><input type='text' value=\"".$Ualias."\" name='alias' /></td></tr>"
		."<tr><td>Website URL:</td><td><input type='text' value=\"".$USER['site']."\" name='site' /></td></tr>"
		."<tr><td>Display Image:</td><td><input type='text' value=\"".$USERav."\" name='avatar' /></td></tr>"
		."<tr><td>Update Email:</td><td><input type='text' value=\"".$USER['email']."\" name='email' /> &#9874; &nbsp; &nbsp;<div style='font-size:x-small; color:grey; display:flex; align-items:center; float:right; margin-right:40%; padding:2px;' title='Hide your email from public view.'><input type='checkbox' name='hmail'".$ch."/> Hide?</div></td></tr>"
		."<tr><td></td><td><hr /></td></tr>"
		."<tr><td style='text-align:top;'>Password Change:</td><td><input type='password' name='cpass' placeholder='Current Password' /> <input type='password' name='npass' placeholder='New Password' /> <input type='password' name='rnpass' placeholder='New Pass Again' /></td></tr>"
		."<tr><td></td><td><input type='submit' name='usersubmit' value='Save Changes' /></td></tr></table></form>";
	if (empty($USER['date'])) { $userDate = "Since The Beginning"; }
	if ($_USER['id'] == $_GET['edit'] OR $_USER['group'] > 2) { 
		if (!isset($_POST['usersubmit'])) {
			echo $editForm;
		} else {
			$username = preg_replace('/[^ \w0-9a-zA-Z_-]/', '', $_POST['uname']);
			$slogan = htmlspecialchars($_SQL->real_escape_string($_POST['slogan']));
			$alias = htmlspecialchars($_SQL->real_escape_string($_POST['alias']));
			$site = htmlspecialchars($_SQL->real_escape_string($_POST['site']));
			$site = str_replace('http://', '', $site);
			$email = htmlspecialchars($_SQL->real_escape_string($_POST['email']));
			$avatar = htmlspecialchars($_SQL->real_escape_string($_POST['avatar']));
			$playerID = (int) $_POST['playerID'];
			if (empty($avatar) OR !isImage($avatar)) { $avatar = '/css/images/grunt.png'; }
			$cpass = sha512($USER['sodium'] . md5($_POST['cpass']));
			$npass = sha512($USER['sodium'] . md5($_POST['npass']));
			$rnpass = sha512($USER['sodium'] . md5($_POST['rnpass'])); 
			$all_good = true;
			if (!empty($_POST['avatar']) AND !isImage($avatar)) { 
				$all_good = false; 
				echo "<span style='color:red;'>Please enter a proper image URL.</span> <small>JPG/JPEG, GIF, & PNG only.</small><br />"; 
				echo $editForm;
			} if (empty($username) OR strlen($username) > 20 OR strlen($username) < 3) { 
				$all_good = false; 
				echo "<span style='color:red;'>Please enter a proper username. </span><small>(Must be 3 characters minimum & 20 characters maximum)</small><br />"; 
				echo $editForm;
			} if (!empty($_POST['cpass'])) {
				if($cpass != $USER['password'] OR $rnpass != $npass) {
					$all_good = false; 
					echo "<span style='color:red;'>Please make sure your passwords are valid & match.<a href=''></a></span><br />"; 
					echo $editForm;
				}
			} if (empty($email) OR !isEmail($email) OR strlen($email) < 4) {
				$all_good = false; 
				echo "<span style='color:red;'>Please enter a valid email. SMTP check is performed </span><small>(example@example.com)</small><br />"; 
				echo $editForm;
			}
			$queryHmail = ", hmail='n'";
			if (isset($_POST['hmail'])) { $queryHmail = ", hmail='y'"; }
			if ($all_good == true && empty($_POST['cpass'])) {
				$_SQL->query("UPDATE users set uname='".str_replace(' ','',$username)."', slogan='".$slogan."', alias='".$alias."', playerid='".$playerID."', avatar='".$avatar."', site='".$site."', email='".$email."'".$queryHmail." WHERE id = '".$_GET['edit']."'") or die($_SQL->error);
				echo "Profile updated! Click <a href='/users.php?id=".$_GET['edit']."'>here</a> to see your changes.";
			} elseif ($all_good == true && !empty($_POST['cpass'])) {
				$_SQL->query("UPDATE users set uname='".$username."', slogan='".$slogan."', alias='".$alias."', avatar='".$avatar."', site='".$site."', email='".$email."', playerid='".$playerID."', password='".$npass."'".$queryHmail." WHERE id = '".$_GET['edit']."'") or die($_SQL->error);
				echo "Passwords changed & profile updated! Click <a href='/users.php?id=".$_GET['edit']."'>here</a> to see your changes.";
			} 
		}
	} else { echo "<span style='color:red;'>You are not authorized to modify this user's information. Only ".$USER['uname']." or an administrator may perform this action.</span><br />"; }
	echo "</div>";
}
echo "<br /></div>";
include_once "inc/footer.php";
?>