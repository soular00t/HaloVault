<?php include_once "inc/core.php";
include_once "inc/header.php";
echo "<div class='content'><div class='contentHeader'>Search</div>";
if (isset($_GET['find'])) { $termsx = $_SQL->real_escape_string(htmlentities($_GET['find'])); }
elseif (isset($_GET['terms'])) { $termsx = $_SQL->real_escape_string(htmlentities($_GET['terms'])); }
else { $termsx = ''; }
$termsD = htmlentities(str_replace('\\', '', $termsx));
$termsD = htmlentities(str_replace("'", "", $termsD));
$terms1 = str_ireplace('thedarkconduit', 'soular00t', $termsD);
$terms2 = str_ireplace('speed halo', 'speedhalo', $terms1);
$terms3 = str_ireplace('fat kid', 'fatkid', $terms2);
$terms4 = str_ireplace('icecreamman', 'ice cream man', $terms3);
$terms5 = str_ireplace('hide and seek', 'hide & seek', $terms4);
$terms6 = str_replace('_', ' ', $terms5);
$terms = str_ireplace('duck hunt', 'duckhunt', $terms6);
$searchForm = "<form method='get' action='search.php'><input type='text' name='find' placeholder='Search terms.' value=\"{$termsD}\" /> <input type='submit' value='Find' /></form>";
$grabModResults = $_SQL->query("SELECT type,id,creator,title,`date`,uid FROM `files` WHERE public != 'n' 
	AND (title LIKE '%{$terms}%' OR creator LIKE '%{$terms}%') ORDER BY id DESC");
$grabModCnt = $grabModResults->num_rows;
$grabMapResults = $_SQL->query("SELECT id,`date`,title,img,map,creator FROM maps WHERE public != 'n' 
	AND (title LIKE '%{$terms}%' OR creator LIKE '%{$terms}%' OR gametype LIKE '%{$terms}%' OR map LIKE '%{$terms}%') ORDER BY id DESC");
$grabMapCnt = $grabMapResults->num_rows;
$grabUserResults = $_SQL->query("SELECT uname,id,last_action,`date` FROM users WHERE uname LIKE '%{$terms}%' OR alias LIKE '%{$terms}%' OR email LIKE '%{$terms}%' 
	ORDER BY last_action DESC");
$grabUserResults1 = $_SQL->query("SELECT id FROM users WHERE uname LIKE '%{$terms}%' OR alias LIKE '%{$terms}%' OR email LIKE '%{$terms}%' LIMIT 1");
$grabUsrCnt = $grabUserResults->num_rows;
$maybe = $grabUserResults1->fetch_object(); $maybeID='';
if ($grabUsrCnt > 0)  $maybeID= "OR uid = '{$maybe->id}'";
$grabTopicResults = $_SQL->query("SELECT id,date,title,flair,uid FROM community WHERE public != 'n' 
	AND (title LIKE '%{$terms}%' OR flair LIKE '%{$terms}%'{$maybeID}) ORDER BY id DESC");
$grabTopicCnt = $grabTopicResults->num_rows;
$rNum = $grabTopicCnt + $grabUsrCnt + $grabMapCnt + $grabModCnt;
$displayMods = "";
$dU = ""; 
$dT = ""; 
$dMaps = "";
$dMods = "";
if ($grabUsrCnt == 0) { $dU = " display:none;"; }
if ($grabTopicCnt == 0) { $dT = " display:none;"; }
if ($grabMapCnt == 0) { $dMaps = " display:none;"; }
if ($grabModCnt == 0) { $dMods = " display:none;"; }

echo $searchForm; echo "<i style='font-size:xx-small;'>Results processed significantly faster now -7/20/17</i><div style='float:right;'><b>Results Found: ".$rNum."</b></div>";
echo "<br /><a onclick=\"toggle_visibility('mapResults');\" style='cursor:cell;'><h3>Forge Maps</h3></a>"
	."<div class='contentHolder' id='mapResults' style='".$dMaps."'><div class='forgeList' id='forgeList' width='100%' data-load-more='8'>";
while ($mapResult = $grabMapResults->fetch_assoc()) {
	$mapIMG = $mapResult['img'];
	$mapTitle = preg_replace("/\.?\s*([^\.]+):/", "</a><sup style='display:block; font-size:6px; padding:0px; font-weight:normal;'>$1</sup><a href=\"forge.php?id=".$mapResult['id']."\">", $mapResult['title']);
	echo "<div class='row' style='display:flex; align-items:center; min-height:43px;'>
	<div class='col-md-1' style='text-align:left;'>
		<a href='/forge.php?id=".$mapResult['id']."'>
			<img src=\"".Thumb($mapIMG)."\" height='40' width='50' onerror=\"this.src='/css/images/maps/".str_ireplace(' ','',preg_replace('/\s+/','',$mapResult['map'])).".jpg';\" />
		</a>
	</div>
	<div class='col-md-5'><a href='forge.php?id=".$mapResult['id']."'>".$mapTitle."</a></div>
	<div class='col-md-4' style='font-size:small;'> created by ".$mapResult['creator']." on <a href='/forge.php?m=".$mapResult['map']."'>".ucwords($mapResult['map'])."</a></div>
	<div class='col-md-2' style='font-size:x-small;'>".dateConvert($mapResult['date'])."</div>
	</div>\n";
} if ($grabMapCnt == 0) { echo "<div class='row'><div class='col-md-12' style='text-align:center;'>No maps found for your search query: \"".$termsD."\"</div></div>"; }
echo "</div>";
if ($grabMapCnt > 5) { echo "<div id='loadMore' class='loadMore' data-action='load-more' data-bound='forgeList'><br /><a>&#x21bb; Load More</a></div>"; }
echo "</div>";

echo "<a onclick=\"toggle_visibility('modResults');\" style='cursor:cell;'><h3>Game Files</h3></a>"
	."<div id='contentHolder' class='contentHolder' id='modResults' style='".$dMods."'><div id='modList' class='modList' width='100%' data-load-more='5'>";
while ($modResult = $grabModResults->fetch_assoc()) {
	$ftype = ucwords($modResult['type']); $type='?';
	$type = "<img src=\"/css/images/file_icons/mod/".$_USER['theme'].".png\" style='margin-top:-3px;' width='38' />";
	if ($modResult['type'] == 'game') { 
		$type = "<img src=\"/css/images/file_icons/game/".$_USER['theme'].".png\" width='25' />"; 
	} elseif ($modResult['type'] == 'app') {
		$type = "<img src=\"/css/images/file_icons/app/".$_USER['theme'].".png\" width='28' style='padding-bottom:3px;' />";
	} elseif ($modResult['type'] == 'config') {
		$type = "<img src=\"/css/images/file_icons/config/".$_USER['theme'].".png\" width='28' style='padding-bottom:3px;".$invert."' />";
	} elseif ($modResult['type'] == 'variant') {
		$type = "<img src=\"/css/images/file_icons/variant/".$_USER['theme'].".png\" width='24' style='padding-bottom:3px;' />";
	}
	echo "<div class='row' style='display:flex; align-items:center; line-height:52px;'>
	<div class='col-md-1' style='text-align:left;'><span style='font-weight:bold; font-size:40px;'>".$type."</span></div>
	<div class='col-md-5' style='text-align:left;'><a href='files.php?id=".$modResult['id']."'>".$modResult['title']."</a></div>
	<div class='col-md-4' style='font-size:x-small;'>".$ftype." created by ".$modResult['creator']."</span></div>
	<div class='col-md-2' style='font-size:x-small;'>".dateConvert($modResult['date'])."</div>
	</div>\n";
} 
if ($grabModCnt == 0) { echo "<div class='row'><div class='col-md-12' style='text-align:center;'>No game modifications were found for your search: \"".$termsD."\"</div></div>"; } 
elseif ($grabModCnt > 5) { echo "<div id='loadMore' class='loadMore' data-action='load-more' data-bound='modList'><br /><a>&#x21bb; Load More</a></div>"; }
echo "</div></div>
<a onclick=\"toggle_visibility('topicResults');\" style='cursor:cell;'><h3>Community Topics</h3></a>
<div id='contentHolder' class='contentHolder' id='topicResults' style='".$dT."'><div id='topicList' class='modList' width='100%' data-load-more='5'>";
while ($comResult = $grabTopicResults->fetch_assoc()) {
	$grabcomU = $_SQL->query("SELECT * FROM users WHERE id = '{$comResult['uid']}'");
	$UnameC = $grabcomU->fetch_assoc();
	$name = $UnameC['uname'];
	if ($comResult['flair'] == 'general') { $f = "📰"; }
	if ($comResult['flair'] == 'help') { $f = "❔"; }
	if ($comResult['flair'] == 'suggestion') { $f = "&#128161;"; }
	if ($comResult['flair'] == 'media') { $f = "🎬"; }
	if ($comResult['flair'] == 'tutorial') { $f = "📋"; }
	echo "<div class='row' style='display:flex; align-items:center; line-height:52px;'>
	<div class='col-md-1' style='text-align:left;'><span style='font-size:27px;font-weight:bold;' title=\"Flair: ".ucwords($comResult['flair'])."\">".$f."</span></div>
	<div class='col-md-6' style='text-align:left;'><a href='community.php?id=".$comResult['id']."' style='font-size:medium;'>".$comResult['title']."</a></div>
	<div class='col-md-3'><span style='padding:1px; font-size:x-small;'>posted by <a href='users.php?id=".$comResult['uid']."'>".$name."</a></span></div>
	<div class='col-md-2' style='font-size:x-small;'>".dateConvert($comResult['date'])."</div>
	</div>\n";
} if ($grabTopicCnt == 0) { echo "<div class='row'><div class='col-md-12' style='text-align:center;'>No community topics were found for your search: \"".$termsD."\"</div></div>"; }
echo "</div>";
if ($grabTopicCnt > 5) { echo "<div id='loadMore' class='loadMore' data-action='load-more' data-bound='topicList'><br /><a>&#x21bb; Load More</a></div>"; }
echo "</div>";

echo "<a onclick=\"toggle_visibility('userResults');\" style='cursor:cell;'><h3>Registered Users</h3></a>"
	."<div id='contentHolder' class='contentHolder' id='userResults' style='".$dU."'><div id='userList' class='modList' width='100%' data-load-more='5'>";
while ($uResult = $grabUserResults->fetch_assoc()) {
	if (empty($uResult['alias'])) { $uAlias = ''; } else { $uAlias = "aka <a href='/users.php?id=".$uResult['id']."'>".$uResult['alias']."</a>"; }
	echo "<div class='row' style='display:flex; align-items:center; line-height:52px;'>
	<div class='col-md-1' style='text-align:left;'><span style='font-weight:bold; font-size:27px;'>👤</span></div>
	<div class='col-md-3' style='text-align:left;'><a href='users.php?id=".$uResult['id']."'>".$uResult['uname']."</a></div>
	<div class='col-md-5'>".$uAlias."</div><div class='col-md-3'><span style='font-size:x-small;'>Last Active: ".dateConvert($uResult['last_action'])."</span></div>
	</div>\n";
} if ($grabUsrCnt == 0) { echo "<div class='row'><div class='col-md-12' style='text-align:center;'>No members were found for your search: \"".$termsD."\"</div></div>"; }
echo "</div>";
if ($grabUsrCnt > 5) { echo "<div id='loadMore' class='loadMore' data-action='load-more' data-bound='userList'><br /><a>&#x21bb; Load More</a></div>"; }
echo "</div>";

echo "<br /><br /></div>";
include_once "inc/footer.php"; ?>
