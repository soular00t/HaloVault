<?php include_once "inc/core.php"; error_reporting(E_ALL & ~E_NOTICE); $mediaJson="https://www.reddit.com/r/HaloOnline/search.json?q=flair%3Amedia&sort=new&restrict_sr=on&t=month"; include_once "inc/header.php"; ?>

<div class='content'>
	<div class='contentHeader'>Media</div>
	This is a WORK IN PROGRESS
	<h3>🔧 /r/HaloOnline</h3>
	<div id='contentHolder' class='contentHolder'>
<?php 
$filter = ''; $and = ''; $WHERE .= ""; $LIMIT = ''; $_PAGE[] =''; $ORDER = 'ORDER by `date` DESC'; $oBY = '';
if (isset($_GET['o']) && $_GET['o'] != 'views') {
	$oBY = preg_replace('/[^0-9a-zA-Z_-]/', '', $_GET['o']);
	$ORDER = "ORDER BY `{$oBY}` DESC";
}
if (isset($_GET['type']) && !empty($_GET['type'])) {
	$filter = preg_replace('/[^ \w0-9a-zA-Z_-]/', '', $_GET['type']);
	$WHERE .= " AND `type` = '{$filter}'";
}
if (isset($_GET['creator']) && !empty($_GET['creator'])) {
	$filter = preg_replace('/[^ \w0-9a-zA-Z_-]/', '', $_GET['creator']);
	$WHERE .= " AND `creator` = '{$filter}'";
}
if (isset($_GET['uid']) && !empty($_GET['uid'])) {
	$filter = preg_replace('/[^ \w0-9a-zA-Z_-]/', '', $_GET['uid']);
	$WHERE .= " AND `uid` = '{$filter}'";
}
if (isset($_GET['p']) && is_numeric($_GET['p']) && isset($_GET['r']) && is_numeric($_GET['r'])) {
	$p = (int) $_GET['p'] -1;
	$r = (int) $_GET['r'];
	$s = ($p) ?  ($p * $r) : 0;
	$LIMIT = "LIMIT {$s}, {$r}";
	$tcount = $_SQL->query("SELECT uid FROM `community` WHERE flair = 'media' {$WHERE}") or die($_SQL->error); 
	$total = $tcount->num_rows;
	$page['totalMaps'] = "$total";
	$page['currentPage'] = "".($p+1)."";
	$tc = $_SQL->query("SELECT uid FROM `community` WHERE flair = 'media' {$WHERE} {$LIMIT}") or die($_SQL->error); 
	$t = $tc->num_rows;
	$page['mediaOnPage'] = "$t";
	if ($page['mediaOnPage'] > 0 && $page['mediaOnPage'] < $r) {$page['pagesPossible'] = $page['currentPage'];}
	else { $page['pagesPossible'] = "".ceil($total / $r).""; }
	$_PAGE[] = $page;
}
/* if (!isset($_GET['map']) && !isset($_GET['creator']) && !isset($_GET['uid']) && !isset($_GET['gtype']) && isset($_GET['search']) && preg_match('/^[a-z0-9.\-\_]+$/i', $_GET['search'])) { 
	$sql = $_SQL->query("SELECT *, NULL as url FROM `community` WHERE `title` LIKE '%{$_GET['search']}%' OR `creator` LIKE '%{$_GET['search']}%' OR `map` LIKE '%{$_GET['search']}%' OR `gametype` LIKE '%{$_GET['search']}%' AND (public != 'n' {$WHERE}) {$ORDER} {$LIMIT}") or die($_SQL->error);	
	if ($sql->num_rows < 1) { $sql = $_SQL->query("SELECT *, NULL as url FROM `community` WHERE flair = 'media' {$WHERE} {$ORDER} {$LIMIT}") or die($_SQL->error); }
} else { $sql = $_SQL->query("SELECT *, NULL as url FROM `community` WHERE flair = 'media' {$WHERE} {$ORDER} {$LIMIT}") or die($_SQL->error); }
if (isset ($_GET['o']) && $_GET['o'] == 'views') {
	$sql = $_SQL->query("SELECT m.*, COUNT(v.id) AS views FROM community AS m LEFT JOIN views AS v ON v.map_id=m.id WHERE flair = 'media' {$WHERE} GROUP BY m.id ORDER BY views DESC {$LIMIT}") or die($_SQL->error);
}
while ($media = $sql->fetch_assoc()) {
	if ($media['type'] = 'album') { $thumb = ytubeThumb($media['link']); }
	if ($media['type'] = 'img') { $thumb = ytubeThumb($media['link']); }
	if ($media['type'] = 'video') { $thumb = ytubeThumb($media['link']); }
	if ($media['type'] = 'chan') { $thumb = ytubeThumb($media['link']); }
} */
	$getMedia = file_get_contents($mediaJson);
	$media = json_decode($getMedia, 1);
	$thumb0 = $media['data']['children']['0']['data']['thumbnail'];
	$thumb1 = $media['data']['children']['1']['data']['thumbnail'];
	$thumb2 = $media['data']['children']['2']['data']['thumbnail'];
	$thumb3 = $media['data']['children']['3']['data']['thumbnail'];
	$thumb4 = $media['data']['children']['4']['data']['thumbnail'];
	$thumb5 = $media['data']['children']['5']['data']['thumbnail'];
	$thumb6 = $media['data']['children']['6']['data']['thumbnail'];
	$thumb7 = $media['data']['children']['7']['data']['thumbnail'];
	$thumb8 = $media['data']['children']['8']['data']['thumbnail'];
	$thumb9 = $media['data']['children']['9']['data']['thumbnail'];
	$thumb10 = $media['data']['children']['10']['data']['thumbnail'];
	$thumb11 = $media['data']['children']['11']['data']['thumbnail'];


	$d0 = dateConvert(date('Y-m-d H:i:s', ceil($media['data']['children']['0']['data']['created'])));
	$d1 = dateConvert(date('Y-m-d H:i:s', ceil($media['data']['children']['1']['data']['created'])));
	$d2 = dateConvert(date('Y-m-d H:i:s', ceil($media['data']['children']['2']['data']['created'])));
	$d3 = dateConvert(date('Y-m-d H:i:s', ceil($media['data']['children']['3']['data']['created'])));
	$d4 = dateConvert(date('Y-m-d H:i:s', ceil($media['data']['children']['4']['data']['created'])));
	$d5 = dateConvert(date('Y-m-d H:i:s', ceil($media['data']['children']['5']['data']['created'])));
	$d6 = dateConvert(date('Y-m-d H:i:s', ceil($media['data']['children']['6']['data']['created'])));
	$d7 = dateConvert(date('Y-m-d H:i:s', ceil($media['data']['children']['7']['data']['created'])));
	$d8 = dateConvert(date('Y-m-d H:i:s', ceil($media['data']['children']['8']['data']['created'])));
	$d9 = dateConvert(date('Y-m-d H:i:s', ceil($media['data']['children']['9']['data']['created'])));
	$d10 = dateConvert(date('Y-m-d H:i:s', ceil($media['data']['children']['10']['data']['created'])));
	$d11 = dateConvert(date('Y-m-d H:i:s', ceil($media['data']['children']['11']['data']['created'])));


	$s0 = $media['data']['children']['0']['data']['score'];
	$s1 = $media['data']['children']['1']['data']['score'];
	$s2 = $media['data']['children']['2']['data']['score'];
	$s3 = $media['data']['children']['3']['data']['score'];
	$s4 = $media['data']['children']['4']['data']['score'];
	$s5 = $media['data']['children']['5']['data']['score'];
	$s6 = $media['data']['children']['6']['data']['score'];
	$s7 = $media['data']['children']['7']['data']['score'];
	$s8 = $media['data']['children']['8']['data']['score'];
	$s9 = $media['data']['children']['9']['data']['score'];
	$s10 = $media['data']['children']['10']['data']['score'];
	$s11 = $media['data']['children']['11']['data']['score'];

	$t0 = subString($media['data']['children']['0']['data']['title'], 50);
	$t1 = subString($media['data']['children']['1']['data']['title'], 50);
	$t2 = subString($media['data']['children']['2']['data']['title'], 50);
	$t3 = subString($media['data']['children']['3']['data']['title'], 50);
	$t4 = subString($media['data']['children']['4']['data']['title'], 50);
	$t5 = subString($media['data']['children']['5']['data']['title'], 50);
	$t6 = subString($media['data']['children']['6']['data']['title'], 50);
	$t7 = subString($media['data']['children']['7']['data']['title'], 50);
	$t8 = subString($media['data']['children']['8']['data']['title'], 50);
	$t9 = subString($media['data']['children']['9']['data']['title'], 50);
	$t10 = subString($media['data']['children']['10']['data']['title'], 50);
	$t11 = subString($media['data']['children']['11']['data']['title'], 50);

	$perma = $media['data']['children']['0']['data']['permalink'];
	$perma0 = $media['data']['children']['1']['data']['permalink'];
	$perma1 = $media['data']['children']['2']['data']['permalink'];
	$perma2 = $media['data']['children']['3']['data']['permalink'];
	$perma3 = $media['data']['children']['4']['data']['permalink'];
	$perma4 = $media['data']['children']['5']['data']['permalink'];
	$perma5 = $media['data']['children']['6']['data']['permalink'];
	$perma6 = $media['data']['children']['7']['data']['permalink'];
	$perma7 = $media['data']['children']['8']['data']['permalink'];
	$perma8 = $media['data']['children']['9']['data']['permalink'];
	$perma9 = $media['data']['children']['10']['data']['permalink'];
	$perma10 = $media['data']['children']['11']['data']['permalink'];
	$perma11 = $media['data']['children']['12']['data']['permalink'];

	$a0 = $media['data']['children']['0']['data']['author'];
	$a1 = $media['data']['children']['1']['data']['author'];
	$a2 = $media['data']['children']['2']['data']['author'];
	$a3 = $media['data']['children']['3']['data']['author'];
	$a4 = $media['data']['children']['4']['data']['author'];
	$a5 = $media['data']['children']['5']['data']['author'];
	$a6 = $media['data']['children']['6']['data']['author'];
	$a7 = $media['data']['children']['7']['data']['author'];
	$a8 = $media['data']['children']['8']['data']['author'];
	$a9 = $media['data']['children']['9']['data']['author'];
	$a10 = $media['data']['children']['10']['data']['author'];
	$a11 = $media['data']['children']['11']['data']['author'];

	$e0 = htmlspecialchars_decode($media['data']['children']['0']['data']['media']['oembed']['html']);
	$e1 = htmlspecialchars_decode($media['data']['children']['1']['data']['media']['oembed']['html']);
	$e2 = htmlspecialchars_decode($media['data']['children']['2']['data']['media']['oembed']['html']);
	$e3 = htmlspecialchars_decode($media['data']['children']['3']['data']['media']['oembed']['html']);
	$e4 = htmlspecialchars_decode($media['data']['children']['4']['data']['media']['oembed']['html']);
	$e5 = htmlspecialchars_decode($media['data']['children']['5']['data']['media']['oembed']['html']);
	$e6 = htmlspecialchars_decode($media['data']['children']['6']['data']['media']['oembed']['html']);
	$e7 = htmlspecialchars_decode($media['data']['children']['7']['data']['media']['oembed']['html']);
	$e8 = htmlspecialchars_decode($media['data']['children']['8']['data']['media']['oembed']['html']);
	$e9 = htmlspecialchars_decode($media['data']['children']['9']['data']['media']['oembed']['html']);
	$e10 = htmlspecialchars_decode($media['data']['children']['10']['data']['media']['oembed']['html']);
	$e11 = htmlspecialchars_decode($media['data']['children']['11']['data']['media']['oembed']['html']);

	$c0 = $media['data']['children']['0']['data']['num_comments'];
	$c1 = $media['data']['children']['1']['data']['num_comments'];
	$c2 = $media['data']['children']['2']['data']['num_comments'];
	$c3 = $media['data']['children']['3']['data']['num_comments'];
	$c4 = $media['data']['children']['4']['data']['num_comments'];
	$c5 = $media['data']['children']['5']['data']['num_comments'];
	$c6 = $media['data']['children']['6']['data']['num_comments'];
	$c7 = $media['data']['children']['7']['data']['num_comments'];
	$c8 = $media['data']['children']['8']['data']['num_comments'];
	$c9 = $media['data']['children']['9']['data']['num_comments'];
	$c10 = $media['data']['children']['10']['data']['num_comments'];
	$c11 = $media['data']['children']['11']['data']['num_comments'];
	?>
		<style>.row .col-md-6 .contentHolder {
			height:140px!important;
			border-bottom-left-radius:13px; 
		} 
		h5.redFeed {
			border-top-right-radius:13px; 
			overflow:hidden;
		}
		.row {
			max-width:95%; margin:0 auto;
		}
		.row .col-md-6 .contentHolder table tr td img { 
			display:block; margin:0 auto; width:139px; height:83px; border:1px solid rgba(255,255,255,0.6); 
		}
		.row .col-md-6 .contentHolder table tr td:first-child { 
			width:60%; text-align:center; background:url('/css/images/rendervideo_overlay.gif') 100% 100% no-repeat; background-position:center center; 
		} 
		.row .col-md-6 .contentHolder table tr td:last-child { width:40%; }
		div.icon_screenshot_overlay {
		    padding: 0;
		    margin: 4px 0 0 -160px;
		    width: 160px;
		    height: 90px;
		    float: left;
		    background: transparent url(/images/halo3stats/fileshareicons/screenshots/overlay.gif) no-repeat;
		}
		</style>
		<div class='row'>
			<div class='col-md-6'>
				<h5 class='redFeed'><a style='color:inherit;' href='//reddit.com<?=$perma;?>'><?=$t0;?></a></h5>
				<div id='contentHolder' class='contentHolder' style='border:1px solid #222; border-top:none; font-size:x-small;'>
					<table width="100%" height="100%">
						<tr>
							<td>
								<a href='//reddit.com<?=$perma;?>'><img onerror="this.src='/css/images/ho.png';" src="<?=$thumb0;?>" /></a>
							</td>
							<td>Author: <a href='//reddit.com/u/<?=$a0;?>'><?=$a0;?></a>
								<br />Posted: <?=$d0;?>
								<br />Comments: <?=$c0;?>
								<br />Score: +<?=$s0;?>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class='col-md-6'>
				<h5 class='redFeed'><a style='color:inherit;' href='//reddit.com<?=$perma0;?>'><?=$t1;?></a></h5>
				<div id='contentHolder' class='contentHolder' style='border:1px solid #222; border-top:none; font-size:x-small;'>
					<table width="100%" height="100%">
						<tr>
							<td>
								<a href='//reddit.com<?=$perma0;?>'><img onerror="this.src='/css/images/ho.png';" src="<?=$thumb1;?>" /></a>
							</td>
							<td>Author: <a href='//reddit.com/u/<?=$a1;?>'><?=$a1;?></a>
								<br />Posted: <?=$d1;?>
								<br />Comments: <?=$c1;?>
								<br />Score: +<?=$s1;?>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-6'>
				<h5 class='redFeed'><a style='color:inherit;' href='//reddit.com<?=$perma1;?>'><?=$t2;?></a></h5>
				<div id='contentHolder' class='contentHolder' style='border:1px solid #222; border-top:none; font-size:x-small;'>
					<table width="100%" height="100%">
						<tr>
							<td>
								<a href='//reddit.com<?=$perma1;?>'><img onerror="this.src='/css/images/ho.png';" src="<?=$thumb2;?>" /></a>
							</td>
							<td></a>Author: <a href='//reddit.com/u/<?=$a2;?>'><?=$a2;?></a>
								<br />Posted: <?=$d2;?>
								<br />Comments: <?=$c2;?>
								<br />Score: +<?=$s2;?>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class='col-md-6'>
				<h5 class='redFeed'><a style='color:inherit;' href='//reddit.com<?=$perma2;?>'><?=$t3;?></a></h5>
				<div id='contentHolder' class='contentHolder' style='border:1px solid #222; border-top:none; font-size:x-small;'>
					<table width="100%" height="100%">
						<tr>
							<td>
								<a href='//reddit.com<?=$perma2;?>'><img onerror="this.src='/css/images/ho.png';" src="<?=$thumb3;?>" /></a>
							</td>
							<td>Author: <a href='//reddit.com/u/<?=$a3;?>'><?=$a3;?></a>
								<br />Posted: <?=$d3;?>
								<br />Comments: <?=$c3;?>
								<br />Score: +<?=$s3;?>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>		
		<div class='row'>
			<div class='col-md-6'>
				<h5 class='redFeed'><a style='color:inherit;' href='//reddit.com<?=$perma3;?>'><?=$t4;?></a></h5>
				<div id='contentHolder' class='contentHolder' style='border:1px solid #222; border-top:none; font-size:x-small;'>
					<table width="100%" height="100%">
						<tr>
							<td>
								<a href='//reddit.com<?=$perma3;?>'><img onerror="this.src='/css/images/ho.png';" src="<?=$thumb4;?>" /></a>
							</td>
							<td>Author: <a href='//reddit.com/u/<?=$a4;?>'><?=$a4;?></a>
								<br />Posted: <?=$d4;?>
								<br />Comments: <?=$c4;?>
								<br />Score: +<?=$s4;?>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class='col-md-6'>
				<h5 class='redFeed'><a style='color:inherit;' href='//reddit.com<?=$perma4;?>'><?=$t5;?></a></h5>
				<div id='contentHolder' class='contentHolder' style='border:1px solid #222; border-top:none; font-size:x-small;'>
					<table width="100%" height="100%">
						<tr>
							<td>
								<a href='//reddit.com<?=$perma4;?>'><img onerror="this.src='/css/images/ho.png';" src="<?=$thumb5;?>" /></a>
							</td>
							<td>Author: <a href='//reddit.com/u/<?=$a5;?>'><?=$a5;?></a>
								<br />Posted: <?=$d5;?>
								<br />Comments: <?=$c5;?>
								<br />Score: +<?=$s5;?>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-6'>
				<h5 class='redFeed'><a style='color:inherit;' href='//reddit.com<?=$perma6;?>'><?=$t6;?></a></h5>
				<div id='contentHolder' class='contentHolder' style='border:1px solid #222; border-top:none; font-size:x-small;'>
					<table width="100%" height="100%">
						<tr>
							<td>
									<a href='//reddit.com<?=$perma5;?>'><img onerror="this.src='/css/images/ho.png';" src="<?=$thumb6;?>" /></a>
							</td>
							<td></a>Author: <a href='//reddit.com/u/<?=$a6;?>'><?=$a6;?></a>
								<br />Posted: <?=$d6;?>
								<br />Comments: <?=$c6;?>
								<br />Score: +<?=$s6;?>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class='col-md-6'>
				<h5 class='redFeed'><a style='color:inherit;' href='//reddit.com<?=$perma6;?>'><?=$t7;?></a></h5>
				<div id='contentHolder' class='contentHolder' style='border:1px solid #222; border-top:none; font-size:x-small;'>
					<table width="100%" height="100%">
						<tr>
							<td>
								<a href='//reddit.com<?=$perma6;?>'><img onerror="this.src='/css/images/ho.png';" src="<?=$thumb7;?>" /></a>
							</td>
							<td>Author: <a href='//reddit.com/u/<?=$a7;?>'><?=$a7;?></a>
								<br />Posted: <?=$d7;?>
								<br />Comments: <?=$c7;?>
								<br />Score: +<?=$s7;?>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-6'>
				<h5 class='redFeed'><a style='color:inherit;' href='//reddit.com<?=$perma7;?>'><?=$t8;?></a></h5>
				<div id='contentHolder' class='contentHolder' style='border:1px solid #222; border-top:none; font-size:x-small;'>
					<table width="100%" height="100%">
						<tr>
							<td>
								<a href='//reddit.com<?=$perma7;?>'><img onerror="this.src='/css/images/ho.png';" src="<?=$thumb8;?>" /></a>
							</td>
							<td></a>Author: <a href='//reddit.com/u/<?=$a8;?>'><?=$a8;?></a>
								<br />Posted: <?=$d8;?>
								<br />Comments: <?=$c8;?>
								<br />Score: +<?=$s8;?>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class='col-md-6'>
				<h5 class='redFeed'><a style='color:inherit;' href='//reddit.com<?=$perma8;?>'><?=$t9;?></a></h5>
				<div id='contentHolder' class='contentHolder' style='border:1px solid #222; border-top:none; font-size:x-small;'>
					<table width="100%" height="100%">
						<tr>
							<td>
								<a href='//reddit.com<?=$perma8;?>'><img onerror="this.src='/css/images/ho.png';" src="<?=$thumb9;?>" /></a>
							</td>
							<td>Author: <a href='//reddit.com/u/<?=$a9;?>'><?=$a9;?></a>
								<br />Posted: <?=$d9;?>
								<br />Comments: <?=$c9;?>
								<br />Score: +<?=$s9;?>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-6'>
				<h5 class='redFeed'><a style='color:inherit;' href='//reddit.com<?=$perma9;?>'><?=$t10;?></a></h5>
				<div id='contentHolder' class='contentHolder' style='border:1px solid #222; border-top:none; font-size:x-small;'>
					<table width="100%" height="100%">
						<tr>
							<td>
								<a href='//reddit.com<?=$perma9;?>'><img onerror="this.src='/css/images/ho.png';" src="<?=$thumb10;?>" /></a>
							</td>
							<td></a>Author: <a href='//reddit.com/u/<?=$a10;?>'><?=$a10;?></a>
								<br />Posted: <?=$d10;?>
								<br />Comments: <?=$c10;?>
								<br />Score: +<?=$s10;?>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class='col-md-6'>
				<h5 class='redFeed'><a style='color:inherit;' href='//reddit.com<?=$perma10;?>'><?=$t11;?></a></h5>
				<div id='contentHolder' class='contentHolder' style='border:1px solid #222; border-top:none; font-size:x-small;'>
					<table width="100%" height="100%">
						<tr>
							<td>
								<a href='//reddit.com<?=$perma10;?>'><img onerror="this.src='/css/images/ho.png';" src="<?=$thumb11;?>" /></a>
							</td>
							<td>Author: <a href='//reddit.com/u/<?=$a11;?>'><?=$a11;?></a>
								<br />Posted: <?=$d11;?>
								<br />Comments: <?=$c11;?>
								<br />Score: +<?=$s11;?>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
</div>
<?php include_once "inc/footer.php"; ?>