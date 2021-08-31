<?php include_once "inc/core.php";
include_once "inc/header.php";
echo "<div class='content'>"
."<div class='contentHeader'>Registration</div><h3>Account Creation</h3><div id='contentHolder' class='contentHolder'>";
$html = "<table width='100%'><form method=\"post\">
<tr><td>&#9874;<small> = Required field.</small></td><td align='right' style='valign:center;'><small>By registering you agree to the <a href='/tos.php'>Terms of Service</a></small></td></tr>
<tr><td><input placeholder=\"Username\" type=\"text\" name=\"uname\" required /> &#9874;</td></tr>
<tr><td><input type=\"password\" placeholder=\"Password\" name=\"pass\" required /> &#9874;</td></tr>
<tr><td><input type=\"password\" placeholder=\"Password Again\" name=\"rpass\" required /> &#9874;</td></tr>
<tr><td><input type=\"text\" title='You can hide this later in your profile settings.' placeholder=\"Email\" name=\"email\" required /> &#9874;</td></tr>
<tr><td><input type=\"text\" placeholder=\"Website\" name=\"site\" /></td></tr>
<tr><td><input type=\"text\" placeholder=\"Alias\" name=\"alias\" /></td></tr>
<tr><td><input type=\"text\" placeholder=\"HaloStats ID\" name=\"playerid\" /></td></tr>
<tr><td><input type=\"submit\" name=\"register\" value=\"Register\" /></td></tr>
</form></table>";
if (isset($_USER['name'])) {
	echo "<script>location.replace(\"index.php\");</script>";
} elseif (!isset($_POST['register'])) {
	echo $html;
} elseif (isset($_POST['register'])) {
	$REG_name = htmlspecialchars($_SQL->real_escape_string($_POST['uname']));
	$REG_pass = md5($_POST['pass']);
	$REG_rpass = md5($_POST['rpass']);
	$playerID = (int) $_POST['playerid'];
	if (empty($_POST['playerid'])) { $playerID = '0'; } 
	$REG_mail = htmlspecialchars($_SQL->real_escape_string($_POST['email']));
	$REG_site = htmlspecialchars($_SQL->real_escape_string($_POST['site']));
	$REG_alias = htmlspecialchars($_SQL->real_escape_string($_POST['alias']));
	$all_good = true;
	$sqlu = $_SQL->query("SELECT * FROM users WHERE uname = '".$REG_name."'");
	$sqle = $_SQL->query("SELECT * FROM users WHERE email = '".$REG_mail."'");
	$salt = md5(rand(1,999999) * microtime());
	$saltNpass = sha512($salt.$REG_pass);
	if (empty($REG_name) OR strlen($REG_name) > 20 OR strlen($REG_name) < 3 OR !preg_match('/^[a-z0-9.\-\_]+$/i', $REG_name)) { 
		$all_good = false; 
		echo "<span style='color:red;'><small>Please enter a proper username.</span></small> <small><small>(Must be  between 2-20 characters long, and contain only underscores, hyphens, periods, & alphanumeric characters)</small></small><br />"; 
	}
	if (empty($REG_pass) OR $REG_rpass != $REG_pass) {
		$all_good = false; 
		echo "<span style='color:red;'><small>Please make sure your passwords are valid & match.</small></span><br />"; 
	}
	if (empty($REG_mail) OR !isEmail($REG_mail) OR strlen($REG_mail) < 4) {
		$all_good = false; 
		echo "<span style='color:red;'>Please enter a proper email. SMTP check is performed </span><small>(example@example.com)</small><br />"; 
	}
	if ($all_good) {
		if ($sqlu->num_rows OR $sqle->num_rows) {
			echo "Sorry, there is already an account associated with that information. Please <a href='/reg.php'>try again</a>.<br />";
		} else {
			$_SQL->query("INSERT INTO users (uname, password, email, alias, site, date, sodium, last_post, playerid) VALUES ('".$REG_name."', '".$saltNpass."', '".$REG_mail."', '".$REG_alias."', '".$REG_site."', CURRENT_TIMESTAMP, '".$salt."', CURRENT_TIMESTAMP, '".$playerID."')") or die($_SQL->error);
			$regfindSQL  = $_SQL->query("SELECT * FROM users WHERE uname = '".$REG_name."'") or die($_SQL->error);
			$regUser = $regfindSQL->fetch_assoc();
			$welcomeMSG1 = "<div class='comment'><h5>Message from <a href='/users.php?id=11'>vaultBot</a></h5><div class='row'><div class='col-md-2' style='text-align:center;'><img src='https://upload.wikimedia.org/wikipedia/commons/thumb/c/c2/Gnome-stock_person_bot.svg/120px-Gnome-stock_person_bot.svg.png' width='60' /></div><div class='col-md-10' style='padding-right:20px;'>Welcome to HaloVault! Your source for Halo Online fileshare content! Please send all questions, bug reports, suggestions, & advice to this bot or directly to <a href='/users.php?id=1'>TheDarkConduit</a></div></div><div style='font-size:xx-small; float:right; text-align:right; min-width:100px; margin-right:7px;'>".dateConvert2(date('Y-m-d G:i:s'))."</div><br /></div>";
			$welcomeMSG = $_SQL->real_escape_string($welcomeMSG1);
			$_SQL->query("INSERT INTO notifications (from_id, to_id, comment, type) VALUES ('11', '".$regUser['id']."', '".$welcomeMSG."', 'msg')") or die($_SQL->error);
			echo "<br /><br />Account creation successful. You can now login as <a href='/users.php?id=".$regUser['id']."'><b>".$REG_name."</b></a> and add more details to your profile.";
		}
	} else {
		echo $html;
	}
}
echo "</div><br /></div>";
include_once "inc/footer.php";
?>
