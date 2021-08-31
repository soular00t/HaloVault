<?php require_once "inc/core.php"; include_once "inc/header.php"; error_reporting(E_ALL & ~E_NOTICE);
echo "<div class='content'>"
	."<div class='contentHeader'>Forge</div>
	<div class='row' style='margin-bottom:35px;'><div class='col-md-6' style='text-align:left;'>Build, browse, & share maps created in Halo Online!</div>
<div class='col-md-6' style='text-align:right;'><span style='border:1px dotted black; padding:2px; background:#333; opacity:0.7;'>
<a href='community.php?id=82' title='Click here for further clarification.'>📋 Upload & Install Instructions</a>
</span></div></div>";

if (isset($_POST['orderBY'])) { $orderData = htmlentities($_POST['orderBY']); }
elseif (isset($_GET['orderBY'])) { $orderData = htmlentities($_GET['orderBY']); }
if (isset($_POST['gtype'])) { $variantData = htmlentities($_POST['gtype']); }
elseif (isset($_GET['gtype'])) { $variantData = htmlentities($_GET['gtype']); }
if (isset($_POST['map'])) { $mapData = htmlentities($_POST['map']); }
elseif (isset($_GET['map'])) { $mapData = htmlentities($_GET['map']); }


$WHERE = ""; $ORDER = 'ORDER by `date` DESC'; $oBY = '';
if (isset($_GET['orderBY']) && !empty($_GET['orderBY']) && $_GET['orderBY'] != 'views') {
	$oBY = preg_replace('/[^0-9a-zA-Z_-]/', '', $_GET['orderBY']);
	$ORDER = "ORDER BY `{$oBY}` DESC, updated DESC";
} if (isset($_GET['orderBY']) && !empty($_GET['orderBY']) && $_GET['orderBY'] == 'title') {
	$oBY = preg_replace('/[^0-9a-zA-Z_-]/', '', $_GET['orderBY']);
	$ORDER = "ORDER BY `{$oBY}` ASC";
} 
if (isset($_GET['gtype']) && !empty($_GET['gtype'])) {
	$filter = preg_replace('/[^ \w0-9a-zA-Z_-]/', '', $_GET['gtype']);
	$WHERE .= " AND `gametype` = '{$filter}'";
	$submsg = " designed for ".ucwords($filter)."";
}
if (isset($_GET['map']) && !empty($_GET['map'])) {
	$filter = preg_replace('/[^ \w0-9a-zA-Z_-]/', '', $_GET['map']);
	$WHERE .= " AND `map` = '{$filter}'";
	$submsg = " on ".ucwords($filter)."";
}
if (isset($_GET['creator']) && !empty($_GET['creator'])) {
	$filter = preg_replace('/[^ \w0-9a-zA-Z_-]/', '', $_GET['creator']);
	$filter1 = str_replace('TheDarkConduit', 'soular00t', $_GET['creator']);
	$filter = str_replace('bush_did_911', 'Bush Did 911', $filter1);
	$WHERE .= " AND `creator` = '{$filter}'";
	$submsg = " by ".$filter."";
}
if (isset($_GET['uid']) && !empty($_GET['uid'])) {
	$filter = (int) $_GET['uid'];
	$WHERE .= " AND `uid` = '{$filter}'";
}
$filter = ''; $and = ''; $LIMIT = ''; $_PAGE[] ='';
$p = 0;
$r = 20;
$s = ($p) ?  ($p * $r) : 0;
$LIMIT = "LIMIT {$s}, {$r}";
$tcount = $_SQL->query("SELECT id FROM `maps` WHERE public != 'n' {$WHERE}") or die($_SQL->error); 
$total = $tcount->num_rows;
$page['totalMaps'] = "$total";
$page['currentPage'] = 1;
$begResult = $s + 1;
$endResult = $s + $r; if ($endResult > $total) { $endResult = $total; }
$page['results'] = "".$begResult."-".$endResult." out of ".$page['totalMaps'];
$tc = $_SQL->query("SELECT id FROM `maps` WHERE public != 'n' {$WHERE} {$LIMIT}") or die($_SQL->error); 
$t = $tc->num_rows;
$page['mapsOnPage'] = "$t";
if ($page['mapsOnPage'] > 0 && $page['mapsOnPage'] < $r) {$page['pagesPossible'] = $page['currentPage'];}
else { $page['pagesPossible'] = "".ceil($total / $r).""; }
if (isset($_GET['p']) && is_numeric($_GET['p']) && isset($_GET['r']) && is_numeric($_GET['r'])) {
	$p = (int) $_GET['p'] -1;
	$r = (int) $_GET['r'];
	$s = ($p) ?  ($p * $r) : 0;
	$LIMIT = "LIMIT {$s}, {$r}";
	$tcount = $_SQL->query("SELECT id FROM `maps` WHERE public != 'n' {$WHERE}") or die($_SQL->error); 
	$total = $tcount->num_rows;
	$page['totalMaps'] = "$total";
	$page['currentPage'] = "".($p+1)."";
	$begResult = $s + 1;
	$endResult = $s + $r; if ($endResult > $total) { $endResult = $total; }
	$page['results'] = "".$begResult."-".$endResult." out of ".$page['totalMaps'];
	$tc = $_SQL->query("SELECT id FROM `maps` WHERE public != 'n' {$WHERE} {$LIMIT}") or die($_SQL->error); 
	$t = $tc->num_rows;
	$page['mapsOnPage'] = "$t";
	if ($page['mapsOnPage'] > 0 && $page['mapsOnPage'] < $r) {$page['pagesPossible'] = $page['currentPage'];}
	else { $page['pagesPossible'] = "".ceil($total / $r).""; }
	$_PAGE[] = $page;
}
if (!isset($_GET['map']) && !isset($_GET['creator']) && !isset($_GET['uid']) && !isset($_GET['gtype']) && isset($_GET['search']) && preg_match('/^[a-z0-9.\-\_]+$/i', $_GET['search'])) { 
	$sql = $_SQL->query("SELECT *, NULL as url FROM `maps` WHERE `title` LIKE '%{$_GET['search']}%' OR `creator` LIKE '%{$_GET['search']}%' OR `map` LIKE '%{$_GET['search']}%' OR `gametype` LIKE '%{$_GET['search']}%' AND (public != 'n' {$WHERE}) {$ORDER} {$LIMIT}") or die($_SQL->error);	
	if ($sql->num_rows < 1) { $sql = $_SQL->query("SELECT *, NULL as url FROM `maps` WHERE public != 'n' {$WHERE} {$ORDER} {$LIMIT}") or die($_SQL->error); }
} else { $sql = $_SQL->query("SELECT *, NULL as url FROM `maps` WHERE public != 'n' {$WHERE} {$ORDER} {$LIMIT}") or die($_SQL->error); }
if (isset($_GET['orderBY']) && $_GET['orderBY'] == 'views') {
	$sql = $_SQL->query("SELECT m.*, COUNT(v.id) AS views FROM maps AS m LEFT JOIN views AS v ON v.map_id=m.id WHERE public != 'n' {$WHERE} GROUP BY m.id ORDER BY views DESC {$LIMIT}") or die($_SQL->error);
}
$oFormStart="<form method='POST'>
<select title='Change order priority' name='orderBY' onchange=\"location.href = 'forg.e?p=".$page['currentPage']."&r=".$r."&gtype=".$variantData."&map=".$mapData."&orderBY=' + this.value;\">"; 
$gFormStart="<form method='POST'>
<span title='Filter by gametype'><select name='gtype' onchange=\"location.href = 'forg.e?p=1&r=".$r."&orderBY=".$orderData."&map=".$mapData."&gtype=' + this.value;\">";
$mFormStart="<form method='POST'>
<span title='Filter by original map'><select name='map' onchange=\"location.href = 'forg.e?p=1&r=".$r."&orderBY=".$orderData."&gtype=".$variantData."&map=' + this.value;\">";

$oForm = "".$oFormStart."
<option>☵ date posted</option>
<option value='edited'>last edited</option>
<option value='updated'>last activity</option>
<option value='votes'>votes</option>
<option value='views'>views</option>
<option value='downloads'>downloads</option>
<option value='replies'>responses</option>
<option value='title'>alphabetical</option>
<input type='submit' style='display:none;' name='order' />"
	."</select></form>";
if (isset($_POST['orderBY']) && $_POST['orderBY'] == 'views' OR $_GET['orderBY'] == 'views') { 
	$oForm = "".$oFormStart."
<option>☵ views</option>
<option value='votes'>votes</option>
<option value='downloads'>downloads</option>
<option value='edited'>last edited</option>
<option value='updated'>last activity</option>
<option value='date'>date posted</option>
<option value='replies'>responses</option>
<option value='title'>alphabetical</option>
<input type='submit' style='display:none;' name='order' />"
		."</select></form>";
} else {
	if (isset($_POST['orderBY']) && $_POST['orderBY'] == 'votes' OR $_GET['orderBY'] == 'votes') { 
		$oForm = "".$oFormStart."
<option>☵ votes</option>
<option value='views'>views</option>
<option value='downloads'>downloads</option>
<option value='edited'>last edited</option>
<option value='updated'>last activity</option>
<option value='date'>date posted</option>
<option value='replies'>responses</option>
<option value='title'>alphabetical</option>
<input type='submit' style='display:none;' name='order' />"
			."</select></form>";
	} if (isset($_POST['orderBY']) && $_POST['orderBY'] == 'downloads' OR $_GET['orderBY'] == 'downloads') {
		$oForm = "".$oFormStart."
<option>☵ downloads</option>
<option value='views'>views</option>
<option value='votes'>votes</option>
<option value='edited'>last edited</option>
<option value='updated'>last activity</option>
<option value='replies'>responses</option>
<option value='date'>date posted</option>
<option value='title'>alphabetical</option>
<input type='submit' style='display:none;' name='order' />"
			."</select></form>";
	} if (isset($_POST['orderBY']) && $_POST['orderBY'] == 'replies' OR $_GET['orderBY'] == 'replies') {
		$oForm = "".$oFormStart."
<option>☵ responses</option>
<option value='views'>views</option>
<option value='votes'>votes</option>
<option value='downloads'>downloads</option>
<option value='updated'>last activity</option>
<option value='edited'>last edited</option>
<option value='date'>date posted</option>
<option value='title'>alphabetical</option>
<input type='submit' style='display:none;' name='order' />"
			."</select></form>";
	} if (isset($_POST['orderBY']) && $_POST['orderBY'] == 'updated' OR $_GET['orderBY'] == 'updated') {
		$oForm = "".$oFormStart."
<option>☵ last activity</option>
<option value='edited'>last edited</option>
<option value='views'>views</option>
<option value='votes'>votes</option>
<option value='replies'>responses</option>
<option value='downloads'>downloads</option>
<option value='date'>date posted</option>
<option value='title'>alphabetical</option>
<input type='submit' style='display:none;' name='order' />"
			."</select></form>";
	} if (isset($_POST['orderBY']) && $_POST['orderBY'] == 'edited' OR $_GET['orderBY'] == 'edited') {
		$oForm = "".$oFormStart."
<option>☵ last edited</option>
<option value='updated'>last activity</option>
<option value='views'>views</option>
<option value='votes'>votes</option>
<option value='replies'>responses</option>
<option value='downloads'>downloads</option>
<option value='date'>date posted</option>
<option value='title'>alphabetical</option>
<input type='submit' style='display:none;' name='order' />"
			."</select></form>";
	} if (isset($_POST['orderBY']) && $_POST['orderBY'] == 'title' OR $_GET['orderBY'] == 'title') {
		$oForm = "".$oFormStart."
<option value='title'>☵ alphabetical</option>
<option>last edited</option>
<option value='updated'>last activity</option>
<option value='views'>views</option>
<option value='votes'>votes</option>
<option value='replies'>responses</option>
<option value='downloads'>downloads</option>
<option value='date'>date posted</option>
<input type='submit' style='display:none;' name='order' />"
			."</select></form>";
	}
}
$gForm = "".$gFormStart."
<option value=''>&#127918; All Gametypes</option>
<option value='multiple'>Multiple Types</option>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='juggernaut'>Juggernaut</option>
<option value='vip'>VIP</option>
<option value='territories'>Territories</option>
<option value='assault'>Assault</option>
<option value='ctf'>Capture The Flag</option>
<option value='oddball'>Oddball</option>
<option value='koth'>King of The Hill</option>
</select>
<input type='submit' style='display:none;' /></span></form>";
if (isset($_GET['gtype']) && $_GET['gtype'] == 'multiple') { 
	$gForm = "".$gFormStart."
<option value='multiple'>&#127918; Multiple Gametypes</option>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='juggernaut'>Juggernaut</option>
<option value='vip'>VIP</option>
<option value='territories'>Territories</option>
<option value='assault'>Assault</option>
<option value='ctf'>Capture The Flag</option>
<option value='oddball'>Oddball</option>
<option value='koth'>King of The Hill</option>
<option value=''>All</option>
</select>
<input type='submit' style='display:none;' /></span></form>";
} if (isset($_GET['gtype']) && $_GET['gtype'] == 'infection') {
	$gForm = "".$gFormStart."
<option value='infection'>&#127918; Infection</option>
<option value='multiple'>Multiple</option>
<option value='slayer'>Slayer</option>
<option value='juggernaut'>Juggernaut</option>
<option value='vip'>VIP</option>
<option value='territories'>Territories</option>
<option value='assault'>Assault</option>
<option value='ctf'>Capture The Flag</option>
<option value='oddball'>Oddball</option>
<option value='koth'>King of The Hill</option>
<option value=''>All</option>
</select>
<input type='submit' style='display:none;' /></span></form>";
} if (isset($_GET['gtype']) && $_GET['gtype'] == 'slayer') {
	$gForm = "".$gFormStart."
<option value='slayer'>&#127918; Slayer</option>
<option value='multiple'>Multiple</option>
<option value='infection'>Infection</option>
<option value='juggernaut'>Juggernaut</option>
<option value='vip'>VIP</option>
<option value='territories'>Territories</option>
<option value='assault'>Assault</option>
<option value='ctf'>Capture The Flag</option>
<option value='oddball'>Oddball</option>
<option value='koth'>King of The Hill</option>
<option value=''>All</option>
</select>
<input type='submit' style='display:none;' /></span></form>";
} if (isset($_GET['gtype']) && $_GET['gtype'] == 'juggernaut') {
	$gForm = "".$gFormStart."
<option value='juggernaut'>&#127918; Juggernaut</option>
<option value='multiple'>Multiple</option>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='vip'>VIP</option>
<option value='territories'>Territories</option>
<option value='assault'>Assault</option>
<option value='ctf'>Capture The Flag</option>
<option value='oddball'>Oddball</option>
<option value='koth'>King of The Hill</option>
<option value=''>All</option>
</select>
<input type='submit' style='display:none;' /></span></form>";
} if (isset($_GET['gtype']) && $_GET['gtype'] == 'vip') {
	$gForm = "".$gFormStart."
<option value='vip'>&#127918; VIP</option>
<option value='multiple'>Multiple</option>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='juggernaut'>Juggernaut</option>
<option value='territories'>Territories</option>
<option value='assault'>Assault</option>
<option value='ctf'>Capture The Flag</option>
<option value='oddball'>Oddball</option>
<option value='koth'>King of The Hill</option>
<option value=''>All</option>
</select>
<input type='submit' style='display:none;' /></span></form>";
} if (isset($_GET['gtype']) && $_GET['gtype'] == 'territories') {
	$gForm = "".$gFormStart."
<option value='territories'>&#127918; Territories</option>
<option value='multiple'>Multiple</option>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='juggernaut'>Juggernaut</option>
<option value='vip'>VIP</option>
<option value='assault'>Assault</option>
<option value='ctf'>Capture The Flag</option>
<option value='oddball'>Oddball</option>
<option value='koth'>King of The Hill</option>
<option value=''>All</option>
</select>
<input type='submit' style='display:none;' /></span></form>";
} if (isset($_GET['gtype']) && $_GET['gtype'] == 'assault') {
	$gForm = "".$gFormStart."
<option value='assault'>&#127918; Assault</option>
<option value='multiple'>Multiple</option>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='juggernaut'>Juggernaut</option>
<option value='vip'>VIP</option>
<option value='territories'>Territories</option>
<option value='ctf'>Capture The Flag</option>
<option value='oddball'>Oddball</option>
<option value='koth'>King of The Hill</option>
<option value=''>All</option>
</select>
<input type='submit' style='display:none;' /></span></form>";
} if (isset($_GET['gtype']) && $_GET['gtype'] == 'ctf') {
	$gForm = "".$gFormStart."
<option value='ctf'>&#127918; Capture The Flag</option>
<option value='multiple'>Multiple</option>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='juggernaut'>Juggernaut</option>
<option value='vip'>VIP</option>
<option value='territories'>Territories</option>
<option value='assault'>Assault</option>
<option value='oddball'>Oddball</option>
<option value='koth'>King of The Hill</option>
<option value=''>All</option>
</select>
<input type='submit' style='display:none;'/></span></form>";
} if (isset($_GET['gtype']) && $_GET['gtype'] == 'oddball') {
	$gForm = "".$gFormStart."
<option value='oddball'>&#127918; Oddball</option>
<option value='multiple'>Multiple</option>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='juggernaut'>Juggernaut</option>
<option value='vip'>VIP</option>
<option value='territories'>Territories</option>
<option value='assault'>Assault</option>
<option value='ctf'>Capture The Flag</option>
<option value='koth'>King of The Hill</option>
<option value=''>All</option>
</select>
<input type='submit' style='display:none;' /></span></form>";
} if (isset($_GET['gtype']) && $_GET['gtype'] == 'koth') {
	$gForm = "".$gFormStart."
<option value='koth'>&#127918; King of The Hill</option>
<option value='multiple'>Multiple</option>
<option value='infection'>Infection</option>
<option value='slayer'>Slayer</option>
<option value='juggernaut'>Juggernaut</option>
<option value='vip'>VIP</option>
<option value='territories'>Territories</option>
<option value='assault'>Assault</option>
<option value='ctf'>Capture The Flag</option>
<option value='oddball'>Oddball</option>
<option value=''>All</option>
</select>
<input type='submit' style='display:none;' /></span></form>";
}
$mForm = "".$mFormStart."
<option value=''>🗺 All Maps</option>
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
if (isset($_GET['map']) && $_GET['map'] == "guardian") {
	$mForm = "".$mFormStart."
<option value='guardian'>🗺 Guardian</option>
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
<option value=''>All Maps</option>
</select>";
} if (isset($_GET['map']) && $_GET['map'] == "the pit") {
	$mForm = "".$mFormStart."
<option value='the pit'>🗺 The Pit</option>
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
<option value=''>All Maps</option>
</select>";
} if (isset($_GET['map']) && $_GET['map'] == "standoff") {
	$mForm = "".$mFormStart."
<option value='standoff'>🗺 Standoff</option>
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
<option value=''>All Maps</option>
</select>";
} if (isset($_GET['map']) && $_GET['map'] == "valhalla") {
	$mForm = "".$mFormStart."
<option value='valhalla'>🗺 Valhalla</option>
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
<option value=''>All Maps</option>
</select>";
} if (isset($_GET['map']) && $_GET['map'] == "reactor") {
	$mForm = "".$mFormStart."
<option value='reactor'>🗺 Reactor</option>
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
<option value=''>All Maps</option>
</select>";
} if (isset($_GET['map']) && $_GET['map'] == "icebox") {
	$mForm = "".$mFormStart."
<option value='icebox'>🗺 Icebox</option>
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
<option value=''>All Maps</option>
</select>";
} if (isset($_GET['map']) && $_GET['map'] == "sandtrap") {
	$mForm = "".$mFormStart."
<option value='sandtrap'>🗺 Sandtrap</option>
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
<option value=''>All Maps</option>
</select>";
} if (isset($_GET['map']) && $_GET['map'] == "diamondback") {
	$mForm = "".$mFormStart."
<option value='diamondback'>🗺 Diamondback</option>
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
<option value=''>All Maps</option>
</select>";
} if (isset($_GET['map']) && $_GET['map'] == "last resort") {
	$mForm = "".$mFormStart."
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
<option value=''>All Maps</option>
</select>";
} if (isset($_GET['map']) && $_GET['map'] == "narrows") {
	$mForm = "".$mFormStart."
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
<option value=''>All Maps</option>
</select>";
} if (isset($_GET['map']) && $_GET['map'] == "high ground") {
	$mForm = "".$mFormStart."
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
<option value=''>All Maps</option>
</select>";
} if (isset($_GET['map']) && $_GET['map'] == "edge") {
	$mForm = "".$mFormStart."
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
<option value=''>All Maps</option>
</select>";
} if (isset($_GET['map']) && $_GET['map'] == "flatgrass") {
	$mForm = "".$mFormStart."
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
<option value=''>All Maps</option>
</select>";
} 

echo "<h3>⚒ Map Creations".$submsg."</h3><div id='contentHolder' class='contentHolder'>";
if ($sql->num_rows == 0) { 
	echo "<script> alert('There are no results for the given search criteria, or have reached the end of the page list.'); history.back();</script>"; 
} $pst=''; if (isset($_USER['id'])) { $pst = "<a href='/forge.php?new'>☲ Post New</a>"; }
echo "<div class='row' style='font-size:small; display:flex; align-items:center; text-align:right; min-width:100%;'> 
<div class='col-md-3' style='font-size:large; text-align:left;'>".$pst."</div>
<div class='col-md-3'>".$mForm."</div>
<div class='col-md-3'>".$gForm."</div>
<div class='col-md-3'>".$oForm."</div>
</div><hr style='opacity:0.2;' />
<div class=\"forgeList\">";
echo "<div class='row' id='row' style='background:rgba(0,0,0,0.0); text-align:center; font-size:small;'>
<div class='col-md-2'></div>
<div class='col-md-3' style='text-align:left;'><b>Title</b></div>
<div class='col-md-2'><b>Artist</b></div>
<div class='col-md-1'><b>Variant</b></div>
<div class='col-md-2'><b>Date</b></div>
<div class='col-md-2'></div></div>";
while ($MAPS = $sql->fetch_assoc()) {
	$forgeDate = dateConvert($MAPS['date']);
	$uSQL = $_SQL->query("SELECT * FROM users WHERE id = '{$MAPS['uid']}'");
	$viewSQL = $_SQL->query("SELECT * FROM views WHERE map_id = '{$MAPS['id']}'");
	$Views = $viewSQL->num_rows;
	$sub = $uSQL->fetch_assoc();
	$submitter = $sub['uname'];
	//$creator = preg_match('/^[a-z0-9.\-\_]+$/i', $MAPS['creator']);
	$replies = $MAPS['replies'];
	$sub = $_SQL->query("SELECT uname FROM users WHERE id='{$MAPS['uid']}'")->fetch_assoc();
	//$oMap = preg_replace('/[^ \w0-9a-zA-Z_-]/', '', $MAPS['map']);
	$omapNS = strtolower(preg_replace('/[^0-9a-zA-Z_-]/', '', $MAPS['map']));
	$mapTitle = preg_replace("/\.?\s*([^\.]+):/", "</a><sup style='display:block; font-size:8px; padding:1px; font-weight:normal;'>$1</sup><a href=\"forge.php?id=".$MAPS['id']."\"title=\"Submitted by {$sub['uname']}\">", $MAPS['title']);
	if ($submitter == $MAPS['creator']) { $creator = "<a href='users.php?id=".$MAPS['uid']."'>".$submitter."</a>"; }
	$mapimg = $MAPS['img'];
	$gt1 = str_replace("multple", "forge", $MAPS['gametype']);
	$gt = str_replace("king of the hill", "koth", $gt1);
	$alrdyDL=''; if(isset($_USER['id']) && $_USER['name'] == "snowman") {
		$isDL = $_SQL->query("SELECT * FROM downloads WHERE map_id= '{$MAPS['id']}' AND user='{$_USER['id']}'");
		if ($isDL->num_rows > 0) { $alrdyDL = "<b title='You have already downloaded this content.'>✓</a>"; }
	} ?>
<div class="row" style="animation:background-image 1s ease-in-out; min-height:70px; padding:5px; text-align:center; font-size:medium; display:flex; align-items:center; " onmouseover="this.style.textShadow = '5px 5px 5px black'; this.style.backgroundImage = 'url(/css/images/hbg/<?=$omapNS;?>.jpg)'; this.style.backgroundRepeat = 'no-repeat'; this.style.backgroundSize = '100% 100%'; this.style.color = 'white';" onmouseout="this.style.textShadow = 'none'; this.style.color = 'inherit'; this.style.backgroundImage = 'none';">
	<div class="col-md-2" title="Submitted by <?=$sub['uname'];?>"><?=$alrdyDL;?>
	<a href="forge.php?id=<?=$MAPS['id'];?>">
	<img height="70" style='padding:0px;' width="115" align="left" src="<?=Thumb($mapimg);?>" onerror="this.src='/css/images/maps/<?=getOmapName(preg_replace('/\s+/','',$omapNS));?>.jpg';" />
	</a></div>
	<div class="col-md-3" style="text-align:left;"><b><a href="forge.php?id=<?=$MAPS['id'];?>" title="Submitted by <?=$sub['uname'];?>"><?=$mapTitle;?></a></b></div>
	<div class="col-md-2"><a href="/search.php?find=<?=$MAPS['creator'];?>"><?=str_replace(' ', '&nbsp;', $MAPS['creator']);?></a></div>
	<div class="col-md-1"><a href="/forg.e?gtype=<?=$gt;?>" title="<?=ucwords($gt);?>"><img src="/css/images/variants/<?=$gt;?>.png" onerror="this.onerror=null;this.src='/css/images/forge.png';" height="50" style="opacity:0.8;" /></a></div>
	<div class="col-md-2" style="font-size:x-small;"><i><?=$forgeDate;?></i></div>
	<div class="col-md-2" style="font-size:x-small; float:right; text-align:left;" title="Views: <?=$Views;?>">
		👍 Upvotes: <?=$MAPS['votes'];?><br />
		💬 Replies: <?=$replies;?><br />
		💾 Downloads: <?=$MAPS['downloads'];?></div>
</div>
<?php } ?> 
<center><hr style='opacity:0.5;' /><div id="pagination" style="font-weight:bold; margin:0 auto; font-size:small;">
	<?php if ($page['currentPage'] != 1) { ?>
	<a href="forg.e?p=<?=$page['currentPage']-1;?>&r=20&orderBY=<?=$orderData;?>&gtype=<?=$variantData;?>&map=<?=$mapData;?>"> ◀ </a>
	<?php } ?>
	Page <?=$page['currentPage'];?> of <?=$page['pagesPossible'];?>  
	<?php if ($page['currentPage'] != $page['pagesPossible']) { ?>
	<a href="forg.e?p=<?=$page['currentPage']+1;?>&r=<?=$r;?>&orderBY=<?=$orderData;?>&gtype=<?=$variantData;?>&map=<?=$mapData;?>"> ▶ </a>
	<?php } ?> <br />
	<small>Displaying <?=$page['results'];?></small>

	</div><?php if (isset($_USER['name'])) { echo "<div style='float:right; margin-top:-30px;'><a href='/forge.php?new'>☲ Post New</a></div>"; } ?></center>
</div><br /></div>
<?php include_once "inc/footer.php"; ?>