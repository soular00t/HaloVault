<!DOCTYPE html>
<html lang="en" dir="ltr">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta name="robots" content="noindex">
<meta name="referrer" content="origin-when-crossorigin">
<title>Login - Adminer</title>
<link rel="stylesheet" type="text/css" href="adminer.php?file=default.css&amp;version=4.3.0">
<script type="text/javascript" src="adminer.php?file=functions.js&amp;version=4.3.0"></script>
<link rel="shortcut icon" type="image/x-icon" href="adminer.php?file=favicon.ico&amp;version=4.3.0">
<link rel="apple-touch-icon" href="adminer.php?file=favicon.ico&amp;version=4.3.0">

<body class="ltr nojs" onkeydown="bodyKeydown(event);" onclick="bodyClick(event);">
<script type="text/javascript">
document.body.className = document.body.className.replace(/ nojs/, ' js');
var offlineMessage = 'You are offline.';
</script>

<div id="help" class="jush-sql jsonly hidden" onmouseover="helpOpen = 1;" onmouseout="helpMouseout(this, event);"></div>

<div id="content">
<h2>Login</h2>
<div id='ajaxstatus' class='jsonly hidden'></div>
<div class='error'>Access denied for user &#039;root&#039;@&#039;localhost&#039; (using password: NO)<br>Master password expired. <a href="https://www.adminer.org/en/extension/" target="_blank">Implement</a> <code>permanentLogin()</code> method to make it permanent.</div>
<form action='' method='post'>
<table cellspacing="0">
<tr><th>System<td><select name='auth[driver]'><option value="server" selected>MySQL<option value="sqlite">SQLite 3<option value="sqlite2">SQLite 2<option value="pgsql">PostgreSQL<option value="oracle">Oracle<option value="mssql">MS SQL<option value="firebird">Firebird (alpha)<option value="simpledb">SimpleDB<option value="mongo">MongoDB (beta)<option value="elastic">Elasticsearch (beta)</select><tr><th>Server<td><input name="auth[server]" value="" title="hostname[:port]" placeholder="localhost" autocapitalize="off">
<tr><th>Username<td><input name="auth[username]" id="username" value="root" autocapitalize="off">
<tr><th>Password<td><input type="password" name="auth[password]">
<tr><th>Database<td><input name="auth[db]" value="vault" autocapitalize="off">
</table>
<script type="text/javascript">
focus(document.getElementById('username'));
</script>
<p><input type='submit' value='Login'>
<label><input type='checkbox' name='auth[permanent]' value='1'>Permanent login</label>
<div></div>
</form>
</div>

<form action='' method='post'>
<div id='lang'>Language: <select name='lang' onchange="this.form.submit();"><option value="en" selected>English<option value="ar">??????????????<option value="bg">??????????????????<option value="bn">???????????????<option value="bs">Bosanski<option value="ca">Catal??<option value="cs">??e??tina<option value="da">Dansk<option value="de">Deutsch<option value="el">????????????????<option value="es">Espa??ol<option value="et">Eesti<option value="fa">??????????<option value="fi">Suomi<option value="fr">Fran??ais<option value="gl">Galego<option value="hu">Magyar<option value="id">Bahasa Indonesia<option value="it">Italiano<option value="ja">?????????<option value="ko">?????????<option value="lt">Lietuvi??<option value="nl">Nederlands<option value="no">Norsk<option value="pl">Polski<option value="pt">Portugu??s<option value="pt-br">Portugu??s (Brazil)<option value="ro">Limba Rom??n??<option value="ru">?????????????? ????????<option value="sk">Sloven??ina<option value="sl">Slovenski<option value="sr">????????????<option value="ta">??????????????????<option value="th">?????????????????????<option value="tr">T??rk??e<option value="uk">????????????????????<option value="vi">Ti???ng Vi???t<option value="zh">????????????<option value="zh-tw">????????????</select> <input type='submit' value='Use' class='hidden'>
<input type='hidden' name='token' value='1018932:527100'>
</div>
</form>
<div id="menu">
<h1>
<a href='https://www.adminer.org/' target='_blank' id='h1'>Adminer</a> <span class="version">4.3.0</span>
<a href="https://www.adminer.org/#download" target="_blank" id="version"></a>
</h1>
</div>
<script type="text/javascript">setupSubmitHighlight(document);</script>
