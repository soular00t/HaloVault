<?php include_once "inc/core.php";
include_once "inc/header.php"; ?>
<style>div.comment {margin-bottom:-20px!important; margin:0 auto;}</style>
<?php echo "<div class='content'>";
echo "<div class='contentHeader'>Notification Center</div>";
if (!isset($_USER['id'])) { die("<script>alert(\"Uhm... maybe you should login first.. lol\");</script>"); }
// SHOW ALL NOTIFICATIONS
if (!isset($_GET['id']) && !isset($_GET['msgs']) && !isset($_GET['votes']) && !isset($_GET['reactions'])) {
	$grabNot = $_SQL->query("SELECT * FROM notifications WHERE to_id = '".$_USER['id']."' AND from_id != '".$_USER['id']."' ORDER BY date DESC");
	$notAMT = $grabNot->num_rows;
	if ($notAMT == 0) { 
		echo "<br /><br />You have no notifications.";
	} else {
		echo "<h3>⚠ Feed</h3><div id='contentHolder' class='contentHolder'><div id='notList' data-load-more='35' class='notList' style='min-width:100%; font-size:small;'>";
		while ($notify = $grabNot->fetch_assoc()) {
			$grabFROM = $_SQL->query("SELECT * FROM users WHERE id = '".$notify['from_id']."'");
			$uG = $grabFROM->fetch_assoc();
			$from_user = $uG['uname'];
			$fIMG = $uG['avatar'];
			$type = $notify['type'];
			$modSelect = $_SQL->query("SELECT * FROM `files` WHERE id = '".$notify['mod_id']."'");
			$mod = $modSelect->fetch_assoc();
			$mapSelect = $_SQL->query("SELECT * FROM maps WHERE id = '".$notify['forge_id']."'");
			$map = $mapSelect->fetch_assoc();
			$comSelect = $_SQL->query("SELECT * FROM community WHERE id = '".$notify['com_id']."'");
			$com = $comSelect->fetch_assoc();
			$modMap = $map['title'];
			$unread1 = ''; $unread2 = '';
			if ($notify['seen'] != "y") { $unread1 = "<span title='Unread, click to view contents & mark this notifcation as seen.' style='color:black; text-align:center; font-size:xx-large; font-weight:bold;'>⚠</span> "; $unread2 = ""; }
			if ($type == 'com') { $modMap = $com['title']; $type = 'topic'; }
			if ($type == 'mod') { $modMap = $mod['title']; }
			if ($type == 'vote' && $notify['com_id'] != '0') { $type1 = 'topic'; $modMap = $com['title']; }
			if ($type == 'vote' && $notify['forge_id'] != '0') { $type1 = 'map'; $modMap = $map['title']; }
			if ($type == 'vote' && $notify['mod_id'] != '0') { $type1 = 'file'; $modMap = $mod['title']; }
			if ($type == 'tag' && $notify['com_id'] != '0') { $type1 = 'topic'; $modMap = $com['title']; }
			if ($type == 'tag' && $notify['forge_id'] != '0') { $type1 = 'map'; $modMap = $map['title']; }
			if ($type == 'tag' && $notify['mod_id'] != '0') { $type1 = 'file'; $modMap = $mod['title']; }
			if ($type != 'tag' && $type != 'vote' && $type != 'msg' && $type != 'msgR' && !empty($notify['comment'])) {
					echo "<div class='row' style='min-width:100%; padding:10px;".$unread2."'><div class='col-md-10' style='float:left;'><a href='notifications.php?id=".$notify['id']."'><img src='".$uG['avatar']."' height='30' style='padding-right:30px;' />".$unread1."".$from_user." left a comment on your ".$type.": <b>".$modMap."</b></div><div class='col-md-2' style='float:right; text-align:right;'><small title='".dateConvert2($notify['date'])."'> ".dateConvert($notify['date'])."</small></a></div></div>\n";
			} if ($type == 'tag') {
				echo "<div class='row' style='min-width:100%; padding:10px;".$unread2."'><div class='col-md-10' style='float:left;'><a href='notifications.php?id=".$notify['id']."'><img src='".$uG['avatar']."' height='30' style='padding-right:30px;' />".$unread1."".$from_user." tagged you in a comment on <b>".$modMap."</b></div><div class='col-md-2' style='float:right; text-align:right;'><small title='".dateConvert2($notify['date'])."'> ".dateConvert($notify['date'])."</small></a></div></div>\n";
			} if ($notify['type'] == 'vote') {
				echo "<div class='row' style='min-width:100%; padding:10px;".$unread2."'><div class='col-md-10' style='float:left;'><a href='notifications.php?id=".$notify['id']."'><img src='".$uG['avatar']."' height='30' style='padding-right:30px;' />".$unread1."".$from_user." upvoted your ".$type1.": <b>".$modMap."</b></div><div class='col-md-2' style='float:right; text-align:right;'><small title='".dateConvert2($notify['date'])."'> ".dateConvert($notify['date'])."</small></a></div></div>\n";
			} if ($type == 'msg' OR $type == 'msgR') {
				$bbcode_buttons = "<div class='bbb'><button title='Bold' type=\"button\" onclick=\"wrapText('edit".$notify['id']."','[b]','[/b]');\"> 𝗕 </button>
				<button title='Italic' type=\"button\" onclick=\"wrapText('edit".$notify['id']."','[i]','[/i]');\"> 𝘐 </button>
				<button title='Underline' type=\"button\" onclick=\"wrapText('edit".$notify['id']."','[u]','[/u]');\"> U̲ </button>
				<button title='Strikethrough' type=\"button\" onclick=\"wrapText('edit".$notify['id']."','[strike]','[/strike]');\"> <strike>S</strike> </button>
				<button title='Font size' type=\"button\" onclick=\"wrapText('edit".$notify['id']."','[size=]','[/size]');\"> <large>A</large><small>z</small> </button> &nbsp;&nbsp;
				<button title='Code' type=\"button\" onclick=\"wrapText('edit".$notify['id']."','[code]','[/code]');\"> # </button>
				<button title='Quote' type=\"button\" onclick=\"wrapText('edit".$notify['id']."','[quote]','[/quote]');\"> ❝ </button>
				<button title='Hyperlink' type=\"button\" onclick=\"wrapText('edit".$notify['id']."','[url=]','[/url]');\"> &#128206; </button>
				<button title='Center Align' type=\"button\" onclick=\"wrapText('edit".$notify['id']."','[center]','[/center]');\"> ☰ </button>
				<button title='Image URL' type=\"button\" onclick=\"wrapText('edit".$notify['id']."','[img]','[/img]');\"> &#128247; </button>
				<button title='Video/Slideshow' type=\"button\" onclick=\"wrapText('edit".$notify['id']."','[media]','[/media]');\"> 🎬 </button></div>";
				$notifyMSG = "".$from_user." sent you a personal message.";
				$personalMSG = str_replace("Message from ".$_USER['name']."", "Message from you", $notify['comment']);
				$personalMSG = str_replace("/n", "<br />", $notify['comment']);
				$personalMSG = str_replace("/r", " ", $notify['comment']);
				if (stripos($notify['comment'], 'requesting to download') !== FALSE) {
					$notifyMSG = "New file has been requested by ".$from_user.".";
				}
				if ($type == 'msgR') {$notifyMSG="".$from_user." replied to your personal message.";}
				$dialog = "<div class='dialog' id='dialog".$notify['id']."' title='Conversation with ".$from_user."'>
				<span style='display:block; min-width:900px; font-size:12px;'>".bb_parse(nl2br($personalMSG))."</span><br /><hr /><input type='button' onclick=\"toggle_visibility('replyForm".$notify['id']."'); toggle_visibility('replyButton".$notify['id']."');\" style='font-size:11px; display:block;' value='Reply' id='replyButton".$notify['id']."' />
				<form id='replyForm".$notify['id']."' method='post' style='display:none;'>".$bbcode_buttons."
				<textarea name='reply".$notify['id']."' id='edit".$notify['id']."' rows='3' style='font-size:10px;'></textarea>
				<input type='submit' name='sendreply".$notify['id']."' value='Send' style='font-size:10px; position:absolute; right:18px;' /></form><br />
				<br /></div>";
				echo "<div class='row' style='min-width:100%; padding:10px;".$unread2."'><div class='col-md-10' style='float:left;'><a class='dialog_link' data-dialog='dialog".$notify['id']."' href='/notifications.php?id=".$notify['id']."' target='_blank' title='Conversation with ".$from_user."'><img src='".$uG['avatar']."' height='30' style='padding-right:30px;' />".$unread1."".$notifyMSG."</div><div class='col-md-2' style='float:right; text-align:right;'><small title='".dateConvert2($notify['date'])."'> ".dateConvert($notify['date'])."</small></a></div>".$dialog."</div>\n";
				if (isset($_POST['sendreply'.$notify['id']])) { 
					$pMsg = $notify['comment'];
					$msg = htmlspecialchars($_POST['reply'.$notify['id']]);
					$from = $notify['to_id'];
					$to = $notify['from_id'];
					$toU = $from_user;
					$graTO = $_SQL->query("SELECT * FROM users WHERE id = '".$notify['to_id']."'");
					$tr = $grabFROM->fetch_assoc();
					$tIMG = $tr['avatar'];
					$reply = "<div class='comment'><h5>Message from <a href='/users.php?id=".$_USER['id']."'>".$_USER['name']."</a></h5>\n<div class='row'><div class='col-md-2' style='text-align:center;'><img src='".$_USER['img']."' width='60' /></div><div class='col-md-10' style='padding-right:20px;'>".$msg."</div></div>\n<div style='font-size:xx-small; float:right; text-align:right; min-width:100px; margin-right:7px;'>".dateConvert2(date('Y-m-d G:i:s'))."</div><br /></div>
					".$pMsg."";
					$rply = $_SQL->real_escape_string($reply);
					$checkMSGSpam = $_SQL->query("SELECT * FROM notifications where from_id = '{$_USER['id']}' AND (type = 'msgR' OR type = 'msg') AND `date` > date_sub(CURRENT_TIMESTAMP, INTERVAL 8 MINUTE)");
					$checkMSGSpam = $checkMSGSpam->num_rows;
					if (!empty($msg) && $checkMSGSpam < 2) {
						$_SQL->query("INSERT INTO notifications (from_id, to_id, type, comment) VALUES ('{$from}', '{$to}', 'msgR', '{$rply}');") or die($_SQL->error);
						echo "<script>alert(\"Reply has been sent!\"); location = window.location;</script>";
					}  else { echo "<script>alert(\"Reply has NOT been sent! TRY AGAIN!\n\n (Note: Spam Filter only permits 3 messages per 8 minutes)\"); location = window.location;</script>"; } 
				}
			}
		}
		echo "</div>";
		if ($notAMT > 35) { echo "<br /><div id='loadMore' class='loadMore' data-action='load-more' data-bound='notList'><a>&#x21bb; <small>Load More</small></a></div>"; }
		echo "</div>";
	}
} // MARK NOTIFICATION AS SEEN AND REDIRECT TO CONTENT 
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$grabNotifications = $_SQL->query("SELECT * FROM notifications WHERE to_id = '".$_USER['id']."' AND id = '".$_GET['id']."'");
	$NOT = $grabNotifications->fetch_assoc();
	$_SQL->query("UPDATE notifications set seen='y' WHERE id = '".$_GET['id']."' AND to_id = '".$_USER['id']."'") or die($_SQL->error);
	$tagID = $NOT['comment'];
	if ($NOT['type'] == 'mod') {
		echo "<script>window.location.replace(\"files.php?id=".$NOT['mod_id']."#".$NOT['id']."\");</script>";
	} elseif ($NOT['type'] == 'map') {
		echo "<script>window.location.replace(\"forge.php?id=".$NOT['forge_id']."#".$NOT['id']."\");</script>";
	} elseif ($NOT['type'] == 'com') {
		echo "<script>window.location.replace(\"community.php?id=".$NOT['com_id']."#".$NOT['id']."\");</script>";
	} elseif ($NOT['type'] == 'tag' && $NOT['mod_id'] != 0) {
		echo "<script>window.location.replace(\"files.php?id=".$NOT['mod_id']."#".$tagID."\");</script>";
	}  elseif ($NOT['type'] == 'tag' && $NOT['forge_id'] != 0) {
		echo "<script>window.location.replace(\"forge.php?id=".$NOT['forge_id']."#".$tagID."\");</script>";
	}  elseif ($NOT['type'] == 'tag' && $NOT['com_id'] != 0) {
		echo "<script>window.location.replace(\"community.php?id=".$NOT['com_id']."#".$tagID."\");</script>";
	}  elseif ($NOT['type'] == 'vote' && $NOT['forge_id'] != 0) {
		echo "<script>window.location.replace(\"forge.php?id=".$NOT['forge_id']."\");</script>";
	}  elseif ($NOT['type'] == 'vote' && $NOT['mod_id'] != 0) {
		echo "<script>window.location.replace(\"files.php?id=".$NOT['mod_id']."\");</script>";
	}  elseif ($NOT['type'] == 'vote' && $NOT['com_id'] != 0) {
		echo "<script>window.location.replace(\"community.php?id=".$NOT['com_id']."\");</script>";
	}  elseif ($NOT['type'] == 'msg' OR $NOT['type'] == 'msgR') {
		echo "<script>window.close();</script>";
	}
}
echo "</div>"; include_once "inc/footer.php";
?>