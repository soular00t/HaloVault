<?php // Connect to database
$_SQL = new mysqli('localhost', 'root', ''.base64_decode(base64_decode("WVd4c01IVjBiMlpqYjI5c2NHRnpjMlZ6")).'', 'vault') or die($_SQL->error);

// Define sha512 encryption
function sha512($enc) { return hash('sha512', $enc); }

// Start User session
@session_start();

if(!empty($_SESSION['uid'])) {
	$grabCurrentUser = $_SQL->query("SELECT * FROM users WHERE id = '".$_SESSION['uid']."'");
	$currentUser = $grabCurrentUser->fetch_assoc();
	$_USER['id'] = $_SESSION['uid'];
	$_USER['name'] = $_SESSION['uname'];
	$_USER['group'] = $_SESSION['group'];
	$_USER['email'] = $_SESSION['email'];
	$_USER['password'] = $_SESSION['password'];
	$_USER['img'] = $currentUser['avatar'];
	$_USER['slogan'] = $currentUser['slogan'];
	$_USER['alias'] = $currentUser['alias'];
	$_USER['theme'] = $currentUser['theme'];
	$_SESSION['theme'] = $_USER['theme'];
} if (!isset($_SESSION['theme']) OR empty($_SESSION['theme'])) {	$_SESSION['theme'] = 'g'; }
$_USER['theme'] = $_SESSION['theme'];

// fmm auth
$fmmKEY = 'ab4895a8895acfc7c1d340248f970aaacecdd506';
if ( (isset($_GET['key']) && $_GET['key'] = $fmmKEY) OR (isset($_POST['key']) && $_POST['key'] = $fmmKEY) ) {
	$fmmUser = $_SQL->query("SELECT * FROM users WHERE sodium = '".sha1($fmmKEY)."'") or die($_SQL->error);
	$currentUser = $fmmUser->fetch_assoc();
	$_USER['id'] = $currentUser['id'];
	$_USER['name'] = $currentUser['uname'];
	$_USER['group'] = $currentUser['group'];
	$_USER['email'] = $currentUser['email'];
	$_USER['password'] = $currentUser['password'];
	$_USER['img'] = $currentUser['avatar'];
	$_USER['slogan'] = $currentUser['slogan'];
	$_USER['alias'] = $currentUser['alias'];
	$_USER['theme'] = $currentUser['theme'];
	$_SESSION['theme'] = $currentUser['theme'];
}

if(isset($_POST['login']) && !isset($_USER['id'])) {
	$uname = htmlspecialchars($_SQL->real_escape_string($_POST['uname']));
	$loginsql = $_SQL->query("SELECT * FROM users WHERE uname = '".$uname."' OR alias = '".$uname."' OR email = '".$uname."'") or die($_SQL->error);
;
	$USER = $loginsql->fetch_assoc(); $postPass=md5($_POST['pass']);
	$upass = $USER['sodium'].$postPass;
	$upassw0rd = sha512($upass);
	if($USER['password'] == $upassw0rd) {
		$_SESSION['uname'] = $uname;
		$_SESSION['uid'] = $USER['id'];
		$_SESSION['password'] = $upass;
		$_SESSION['group'] = $USER['group'];
		$_SESSION['email'] = $USER['email'];
		$_SESSION['site'] = $USER['site'];
		$_SESSION['alias'] = $USER['alias'];
		$_SESSION['avatar'] = $USER['avatar'];
		$_SESSION['slogan'] = $USER['slogan'];
		logIP();
		if (isset($_GET['shareLogin'])) die("<script>location.href='//127.0.0.1/upload.php';</script>");
		if (stripos($_SERVER['HTTP_REFERER'], "dewsha.re") !== FALSE) die("<script>location.href='//dewsha.re/';</script>");
		echo "<script>location = window.location;</script>";
	} 
}

elseif(array_key_exists('callback', $_GET) && !isset($_USER['id'])) {
	error_reporting(E_ALL & ~E_NOTICE);
	$uname = htmlspecialchars($_SQL->real_escape_string(base64_decode($_GET['a'])));
	$loginsql = $_SQL->query("SELECT * FROM users WHERE uname = '".$uname."' OR alias = '".$uname."' OR email = '".$uname."' LIMIT 1") or die($_SQL->error);;
	$USER = $loginsql->fetch_assoc(); $postPass=$_SQL->real_escape_string(base64_decode($_GET['z']));
	$upass = $USER['sodium'].$postPass;
	$upassw0rd = sha512($upass);
	if($USER['password'] == $upassw0rd) {
		$_SESSION['uname'] = $uname;
		$_SESSION['uid'] = $USER['id'];
		$_SESSION['password'] = $upass;
		$_SESSION['group'] = $USER['group'];
		$_SESSION['email'] = $USER['email'];
		$_SESSION['site'] = $USER['site'];
		$_SESSION['alias'] = $USER['alias'];
		$_SESSION['avatar'] = $USER['avatar'];
		$_SESSION['slogan'] = $USER['slogan'];
		header('Content-Type: text/javascript; charset=utf8');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Max-Age: 3628800');
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
		$callback = $_GET['callback'];
		print $callback.'(true);';
	} 
	else { 
		header('Content-Type: text/javascript; charset=utf8');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Max-Age: 3628800');
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
		$callback = $_GET['callback'];
		//print $callback.'(false);';
	}
} ?>