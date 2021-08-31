<?php 
$loginForm = "<h4>User Panel</h4><center><form method='post' id='login'>
\t<div class='row' style='margin:0 auto;'><div class='col-md-12'><input type='text' name='uname' placeholder='Username' /></div></div>
\t<div class='row' style='margin:0 auto;'><div class='col-md-12'><input type='password' placeholder='Password' name='pass' /></div></div>
\t<div class='row' style='margin:0 auto;'><div class='col-md-12'><input type='submit' name='login' value='Login' /> <a href='/reg.php'><input type='button' value='Register' /></a></div></div>
\t<a class='dialog_link' data-dialog='dialog999999' href='javascript:void();' style='font-size:xx-small;' title='Forgot your username or password? Click to send a password reset request to an administrator.'>Forgot?</a>
</center></form>";
if(isset($_USER['id'])) {
	$grabNots = $_SQL->query("SELECT * FROM notifications WHERE to_id = '".$_USER['id']."' AND seen = 'n' AND from_id != '".$_USER['id']."'");
	$notNum = $grabNots->num_rows;
	$PLURAL = 's';
	if ($notNum == 1) { $PLURAL = ""; }
	echo "<h4><center><a href='/users.php?id=".$_USER['id']."'>".$_USER['name']."</a></center><div style='float:right; margin-top:-13px; margin-right:10px; font-size:medium;'><a href='/notifications.php' title='".$notNum." new notification".$PLURAL."' style='color:white;'><b>&#128276;</b></a></div></h4>\n"
	."<center><a href='/users.php?id=".$_USER['id']."' title='Click to view your profile.'><img onerror=\"this.src='/css/images/grunt.png';\" height='150' width='150' src=\"".$_USER['img']."\" /></a>\n"
	."\n";
	if ($notNum > 0) { echo "<div class='row' style='margin-top:10px; margin-bottom:10px;'><div class='col-md-12'><b><span style='padding:3px;'><a href='/notifications.php'>&#9888; ".$notNum." new notification".$PLURAL."</a></b></span></div></div>"; }
	echo "<div class='row' style='margin-left:10%; margin-right:10%; text-align:center;'>
	<div class='col-md-6' style='font-weight:bold' title='Create New Post'>☲</div>
	<div class='col-md-6' style='font-weight:bold' title='View My Posts'>ಠ</div>
	<div class='col-md-6'><a href='/forge.php?new'>Post&nbsp;Map</a></div>
	<div class='col-md-6'><a href='/forge.php?uid=".$_USER['id']."'>My&nbsp;Forge</a></div>
	<div class='col-md-6'><a href='/files.php?new'>Post&nbsp;File</a></div>
	<div class='col-md-6'><a href='/files.php?uid=".$_USER['id']."'>My&nbsp;Files</a></div>
	<div class='col-md-6'><a href='/community.php?new'>Post&nbsp;Topic</a></div>
	<div class='col-md-6'><a href='/community.php?uid=".$_USER['id']."'>My&nbsp;Topics</a></div>
	</div>
	<hr width='50%' style='float:center; border:1px dashed grey;' />
	<div class='row' style='margin:0 auto;'><div class='col-md-12'><a href='//reddit.com/r/HaloOnline/submit'>🎬 Post&nbsp;Media</a></div></div>
	<div class='row' style='margin:0 auto;'><div class='col-md-12'><a href='/users.php'>👤 Member List</a></div></div>
	<div class='row' style='margin:0 auto;'><div class='col-md-12'><a href='/stats.php'>📈 Server Statistics</a></div></div>";
	if (isset($_SESSION['uid']) && $_USER['group'] == 3){ echo "<div class='row' style='margin:0 auto;'><div class='col-md-12'><a href='/r00t'>♛ Admin Panel</a></div></div>"; }
	elseif (isset($_SESSION['uid']) && $_USER['group'] > 1){ echo "<div class='row' style='margin:0 auto;'><div class='col-md-12'><a href='/m0d'>🔩 Mod Panel</a></div></div>"; }
	echo "<div class='row' style='margin:0 auto;'><div class='col-md-12'><a href='/logout.php'>&#128274; Logout</a></div></div></center>";
} elseif(!isset($_POST['login'])) {
	echo $loginForm;
} if(isset($_POST['login'])) {
	$uname = htmlspecialchars($_SQL->real_escape_string($_POST['uname']));	
	if ($uname == 'EtherSecAgent') { die("<script>alert(\"Ether, you are lying scum. How dare you steal my work.\"); location.href = 'http://meatspin.com/';</script>");  }
	$loginsql = $_SQL->query("SELECT * FROM users WHERE uname = '".$uname."'");
	$USER = $loginsql->fetch_assoc();
	$upass = $USER['sodium'] . md5($_POST['pass']);
	$upassw0rd = sha512($upass);

	if($_SQL->error) {
		die($_SQL->error);
	}
	if($USER['password'] != $upassw0rd) {
		echo $loginForm;
		echo "<br /><center><span style='border:1px solid red; background-color:#E8C1B9; text-align:center; padding:5px; color:black; font-size:small;'>Wrong details. Try again.</span></center>";
	}
}
?>
<br />
<div class='dialog' id='dialog999999' title='Account Recovery'><div style='margin-left:7px; margin-right:7px; margin-top:30px;'>
<?php if(!isset($_USER['id'])) {
	echo "<form method='post'><p style='float:right; width:30%; font-size:x-small; padding:2px; border:1px dotted grey;'>Use this service to reset your password in the event you've forgotten your details.</a></p>
	<input id='multi-users' type='text' name='forgotUE' placeholder='Username\Email' title=\"Please include a valid email to contact you. If you enter your username, we will use the email associated with that account. In the event your email doesn't work, contact TheDarkConduit on Steam or soular00t on reddit.\" />
	<br /><br />".$bbcodeBan."<textarea name='passMsg' id='banReason' cols='100%' rows='9' placeholder='Please include a complete description of who you are and why you need your password reset. Other methods of identification may be necessary later.'></textarea>
	<input type='submit' name='passRst' value='Request Reset' /></form>";
	if (isset($_POST['passRst'])) { 
		$grabUsers = $_SQL->query("SELECT * FROM users WHERE uname LIKE '".$_SQL->real_escape_string($_POST['forgotUE'])."' OR email LIKE '".$_SQL->real_escape_string($_POST['forgotUE'])."'") or die($_SQL->error);
		$forgotten = $grabUsers->fetch_assoc();
		$fNum = $grabUsers->num_rows;
		$msgP = htmlspecialchars($_POST['passMsg']);
		$snd = "<div class='comment'><h5>Account recovery requested from <a href='/search.php?find=".$_POST['forgotUE']."'>".$_POST['forgotUE']."</a></h5><div class='row'><div class='col-md-2' style='text-align:center;'><img onerror=\"this.src='/css/images/grunt.png';\" src=\"".$forgotten['avatar']."\" width='60' /></div><div class='col-md-10' style='padding-right:20px;'>".$msgP."</div></div><div style='font-size:xx-small; float:right; text-align:right; min-width:100px; margin-right:7px;'>".dateConvert2(date('Y-m-d G:i:s'))."</div><br /></div>";
		$rst = $_SQL->real_escape_string($snd);
		if (!empty($msgP) && $fNum > 0) {
			$_SQL->query("INSERT INTO notifications (from_id, to_id, type, comment) VALUES ('11', '1', 'msg', '{$rst}');") or die($_SQL->error);
			echo "<script>alert(\"Your request has been sent to the administation team! You will be contacted by email for further instructions.\");</script>";
		} else { echo "<script>alert('You have either left the body text blank, or we were unable to find an account associated with \"".htmlentities($_POST['forgotUE'])."\"');</script>"; }
	}
} else { echo "You are already logged in. If you'd like to change your password, you may do so in your profile settings."; }
	?></div></div>