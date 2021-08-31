<?php require_once "../../inc/core.php"; error_reporting(E_ALL & ~E_NOTICE); include_once "../../inc/header.php";
$bPopMap = $_SQL->query("SELECT `map`, COUNT(`map`) AS `popular_map` FROM `game_stats` WHERE `name` LIKE '%games%'  GROUP BY `map` ORDER BY `popular_map` DESC") or die($_SQL->error);
$bPop = $bPopMap->fetch_assoc();
$bCount = $bPopMap->num_rows;
$mPopMap = $_SQL->query("SELECT `map`, COUNT(`map`) AS `popular_map` FROM `game_stats` WHERE `name` LIKE '%Infection%'  GROUP BY `map` ORDER BY `popular_map` DESC") or die($_SQL->error);
$mPop = $mPopMap->fetch_assoc();
$mCount = $mPopMap->num_rows;
$sPopMap = $_SQL->query("SELECT `map`, COUNT(`map`) AS `popular_map` FROM `game_stats` WHERE `name` LIKE '%action%' GROUP BY `map` ORDER BY `popular_map` DESC") or die($_SQL->error);
$sPop = $sPopMap->fetch_assoc();
$sCount = $sPopMap->num_rows;

$p = 0;
$r = 50;
$s = ($p) ?  ($p * $r) : 0;
$LIMIT = "LIMIT {$s}, {$r}";
$tcount = $_SQL->query("SELECT id from `game_stats` {$WHERE}") or die($_SQL->error); 
$total = $tcount->num_rows;
$page['totalStats'] = "$total";
$page['currentPage'] = 1;
$begResult = $s + 1;
$endResult = $s + $r; if ($endResult > $total) { $endResult = $total; }
$page['results'] = "".$begResult."-".$endResult." out of ".$page['totalStats'];
$tc = $_SQL->query("SELECT id from `game_stats` {$WHERE} {$LIMIT}") or die($_SQL->error); 
$t = $tc->num_rows;
$page['statsOnPage'] = "$t";
if ($page['statsOnPage'] > 0 && $page['statsOnPage'] < $r) {$page['pagesPossible'] = $page['currentPage'];}
else { $page['pagesPossible'] = "".ceil($total / $r).""; }
if (isset($_GET['p']) && is_numeric($_GET['p']) && isset($_GET['r']) && is_numeric($_GET['r'])) {
	$p = (int) $_GET['p'] -1;
	$r = (int) $_GET['r'];
	$s = ($p) ?  ($p * $r) : 0;
	$LIMIT = "LIMIT {$s}, {$r}";
	$tcount = $_SQL->query("SELECT id from `game_stats` {$WHERE}") or die($_SQL->error); 
	$total = $tcount->num_rows;
	$page['totalStats'] = "$total";
	$page['currentPage'] = "".($p+1)."";
	$begResult = $s + 1;
	$endResult = $s + $r; if ($endResult > $total) { $endResult = $total; }
	$page['results'] = "".$begResult."-".$endResult." out of ".$page['totalStats'];
	$tc = $_SQL->query("SELECT id from `game_stats` {$WHERE} {$LIMIT}") or die($_SQL->error); 
	$t = $tc->num_rows;
	$page['statsOnPage'] = "$t";
	if ($page['statsOnPage'] > 0 && $page['statsOnPage'] < $r) {$page['pagesPossible'] = $page['currentPage'];}
	else { $page['pagesPossible'] = "".ceil($total / $r).""; }
	$_PAGE[] = $page;
}

echo "<div class='content'>
<div class='contentHeader'>Statistics</div>
Most Popular <i>Classical Infection</i> Map: <u title='Played ".$mCount." times'>".$mPop['map']."</u> <br />
Most Popular <i>Slayer & Objective</i> Map: <u title='Played ".$sCount." times'>".$sPop['map']."</u> <br />
Most Popular <i>Brains & Mini-Games</i> Map: <u title='Played ".$bCount." times'>".$bPop['map']."</u>
<h3>HaloVault Dedicated Stats</h3><div class='contentHolder'>"; ?>
	<div class='row'>
	<div class='col-md-4'><span style='font-weight:bold; font-size:large;'>Map & Variant</span></div>
	<div class='col-md-4'><span style='font-weight:bold; font-size:large;'>Details:</span></div>
	<div class='col-md-3'><span style='font-style:italic;'>Server</span></div>
	<div class='col-md-1'></div>
	</div>
<div class='forgeList'>
<?php $sql = $_SQL->query("SELECT * FROM game_stats ORDER BY id DESC {$LIMIT}") or die($_SQL->error);
while ($d = $sql->fetch_assoc()) {
	$dateTime = dateConvert($d['time_log']);
	$dName = str_replace('brains1', 'Brains & Mini-Games', $d['srvr']);
	$name1 = str_replace('brains2', 'Mini-Games & Brains', $dName);
	$name2 = str_replace('mlg', 'Major League Gaming', $name1);
	$name = str_replace('slayer_obj', 'Slayer & Objective', $name2);
	if ($d['time_log'] == "0000-00-00 00:00:00") {$dateTime = "<i>Not Logged</i>";}
	echo "<div class='row' style='font-size:12pt;'>
	<div class='col-md-4'><a>".$d['variant']." on ".$d['map']."</a></div>
	<div class='col-md-4'>".$d['gametype']." on ".$d['base_map']."</div>
	<div class='col-md-3' style='font-size:x-small;'>".$d['name']."</div>
	<div class='col-md-1' style='font-size:xx-small;'>".str_replace(' ','&nbsp;',$dateTime)."</div>
	</div>";
} ?>
<center><hr style='opacity:0.5;' /><div id="pagination" style="font-weight:bold; margin:0 auto; font-size:small;">
	<?php if ($page['currentPage'] != 1) { ?>
	<a href="/stats.php?p=<?=$page['currentPage']-1;?>&r=<?=$r;?>"> â—€ </a>
	<?php } ?>
	Page <?=$page['currentPage'];?> of <?=$page['pagesPossible'];?>  
	<?php if ($page['currentPage'] != $page['pagesPossible']) { ?>
	<a href="/stats.php?p=<?=$page['currentPage']+1;?>&r=<?=$r;?>"> â–¶ </a>
	<?php } ?> <br />
	<small>Displaying <?=$page['results'];?></small>
	</div></center>
</div></div>
<?php echo "</div>"; include_once "../../inc/footer.php"; ?>