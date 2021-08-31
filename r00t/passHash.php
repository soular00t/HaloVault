<?php include_once "../inc/core.php";
include_once "../inc/header.php";
echo "<div class='content'><div class='contentHeader'>Administration</div><a href='javascript:history.back();'><- Back</a>";
$xhtml = "<h3>Change User Password</h3><div class='contentHolder'>
<center><form method='post'><input type='text' name='userp' placeholder='Username' id='multi-users' value='' /><br />
<input type='text' name='tempPass' placeholder='New Password' /><br />
<input type='submit' name='tempPassSubmit' /> 
<input style='display:none; float:right;' onClick=\"return confirm('Are you sure you want to do this? This will re-encode all passwords stored in the database. You may break the user table!'); return confirm('You sure? 100% positive you want to do this?');\" type='submit' name='submitPasses' value='Update Password Encryption' /></form></center>";
if (isset($_POST['submitPasses'])) {
	$grabusers = $_SQL->query("SELECT * FROM users") or die($_SQL->error);
	foreach ($grabusers as $user) {
		$salt = md5(rand(1,999999) * microtime());
		$saltPLUSpass = $salt . $user['password'];
		$saltNpass = sha512($saltPLUSpass);
		echo "<b>".$user['uname']."</b><br /";
		echo "Old Pass: ".$user['password']."<br />";
		echo "New Pass: ".$saltNpass."<br />";
		echo "Salt: ".$salt."<br /><br />";
		
		$_SQL->query("update users set sodium='".$salt."', password='".$saltNpass."' where id='".$user['id']."'") or die($_SQL->error);
		echo "passwords and salts have been applied successfully<hr /><Br />";
	} 
} elseif (isset($_POST['tempPassSubmit'])) {
	$uname = $_SQL->real_escape_string($_POST['userp']);
	$grabusers = $_SQL->query("SELECT * FROM users WHERE uname = '".$uname."'") or die($_SQL->error);
	$user = $grabusers->fetch_assoc();
	$uNUM = $grabusers->num_rows;
	$salt = md5(rand(1,999999) * microtime());
	$saltPLUSpass = $salt . md5($_POST['tempPass']);
	$saltNpass = sha512($saltPLUSpass);
	if ($uNUM > 0) {
		$_SQL->query("update users set sodium='".$salt."', password='".$saltNpass."' where id='".$user['id']."'") or die($_SQL->error);
		echo "Password and salt have been changed successfully. New temporary password for <u>".$uname."</u>: 
		<pre>".htmlspecialchars($_POST['tempPass'])."</pre><hr /><br />";
	} else {
		echo "<b>That username was NOT found in our database, please try again.</b><br />";
		echo $xhtml;
	}
} else { echo $xhtml; }
echo "</div></div>";
include_once "../inc/footer.php"; ?>