<?php
if (isset($_SESSION['theme']) && $_SESSION['theme'] == 'y') {
	$themeForm = "<form method='post'><select name='theme' id='th3me' onchange=\"javascript: setTimeout('__processURL(\'th3me\')', 1)\">
<option value='y'>YellowSlate</option>
<option value='b'>Cyanite </option>	
<option value='bb'>Naval Expansion</option>	
<option value='o'>HaloWeen</option>
<option value='g'>GreenSlate</option>
<option value='sm'>Icebound</option>
<option value='' data-url='//dewsha.re'>Bungie</option></select>
<input type='submit' name='tswitch' value='Switch Theme' />
</form>";
} elseif (isset($_SESSION['theme']) && $_SESSION['theme'] == 'b') {
	$themeForm = "<form method='post'><select name='theme' id='th3me' onchange=\"javascript: setTimeout('__processURL(\'th3me\')', 1)\">
<option value='b'>Cyanite </option>	
<option value='bb'>Naval Expansion</option>	
<option value='y'>YellowSlate</option>
<option value='o'>HaloWeen</option>
<option value='g'>GreenSlate</option>
<option value='sm'>Icebound</option>
<option value='' data-url='//dewsha.re'>Bungie</option></select>
<input type='submit' name='tswitch' value='Switch Theme' />
</form>";
} elseif (isset($_SESSION['theme']) && $_SESSION['theme'] == 'g') {
	$themeForm = "<form method='post'><select name='theme' id='th3me' onchange=\"javascript: setTimeout('__processURL(\'th3me\')', 1)\">
<option value='g'>GreenSlate</option>
<option value='o'>HaloWeen</option>
<option value='b'>Cyanite </option>	
<option value='bb'>Naval Expansion</option>	
<option value='y'>YellowSlate</option>
<option value='sm'>Icebound</option>
<option value='' data-url='//dewsha.re'>Bungie</option></select>
<input type='submit' name='tswitch' value='Switch Theme' />
</form>";
} elseif (isset($_SESSION['theme']) && $_SESSION['theme'] == 'sm') {
	$themeForm = "<form method='post'><select name='theme' id='th3me' onchange=\"javascript: setTimeout('__processURL(\'th3me\')', 1)\">
<option value='sm'>Icebound</option>
<option value='g'>GreenSlate</option>
<option value='o'>HaloWeen</option>
<option value='b'>Cyanite </option>	
<option value='bb'>Naval Expansion</option>	
<option value='y'>YellowSlate</option>
<option value='' data-url='//dewsha.re'>Bungie</option></select>
<input type='submit' name='tswitch' value='Switch Theme' />
</form>";
} elseif (isset($_SESSION['theme']) && $_SESSION['theme'] == 'bb') {
	$themeForm = "<form method='post'><select name='theme' id='th3me' onchange=\"javascript: setTimeout('__processURL(\'th3me\')', 1)\">
<option value='bb'>Naval Expansion</option>	
<option value='sm'>Icebound</option>
<option value='o'>HaloWeen</option>
<option value='g'>GreenSlate</option>
<option value='b'>Cyanite </option>	
<option value='y'>YellowSlate</option>
<option value='' data-url='//dewsha.re'>Bungie</option></select>
<input type='submit' name='tswitch' value='Switch Theme' />
</form>";
} elseif (isset($_SESSION['theme']) && $_SESSION['theme'] == 'o') {
	$themeForm = "<form method='post'><select name='theme' id='th3me' onchange=\"javascript: setTimeout('__processURL(\'th3me\')', 1)\">	
<option value='o'>HaloWeen</option>
<option value='bb'>Naval Expansion</option>	
<option value='sm'>Icebound</option>
<option value='g'>GreenSlate</option>
<option value='b'>Cyanite </option>	
<option value='y'>YellowSlate</option>
<option value='' data-url='//dewsha.re'>Bungie</option></select>
<input type='submit' name='tswitch' value='Switch Theme' />
</form>";
} else { 
	$themeForm = "<form method='post'><select name='theme' id='th3me' onchange=\"javascript: setTimeout('__processURL(\'th3me\')', 1)\">
<option value='bb'>Naval Expansion</option>	
<option value='sm'>Icebound</option>
<option value='o'>HaloWeen</option>
<option value='g'>GreenSlate</option>
<option value='b'>Cyanite </option>
<option value='y'>YellowSlate</option>
<option value='' data-url='//dewsha.re'>Bungie</option></select>
<input type='submit' name='tswitch' value='Switch Theme' />
</form>";
}
?>
</div><div style="clear:both;"></div>
<div class='footer'><br />	<div class='row'>
	<div class='col-md-4' style='text-align:center;'><?php include"quotes.php"; ?></div>	
	<div class='col-md-4' style='text-align:center; align-items:center;'><?=$themeForm;?><div style='margin-top:10px; font-size:xx-small; text-align:center;'>Not operated by ElDewrito developers.</div></div>
	<div class='col-md-4' style='text-align:center;'><small title='aka TheDarkConduit'>© Coded by soular00t</small><small><br /><small>with help from the ElDewrito community</small></small></div></div>
	<hr style='border:1px dashed grey; opacity:0.2;' />
	<div style='text-align:center; font-size:small; margin-top:-10px; padding-bottom:5px; font-weight:bold; display:flex; align-items:center;' width='100%' class='row'>
		<div class='col-md-3'><a class='footlinks' href='//eldewrito.com' class='anvil' target='_blank'><img src='http://pre00.deviantart.net/e7f6/th/pre/f/2015/150/c/a/eldewrito_logo_blue_by_floodgrunt-d8vd5q5.png' height='12' style=';padding-right:4px;' /> ElDewrito.com</a></div>
		<div class='col-md-3'><a class='footlinks' href='//reddit.com/r/haloonline' target='_blank'><img class='reddit' src='//icons.iconarchive.com/icons/uiconstock/socialmedia/512/Reddit-icon.png' style='height:19px;padding-right:3px;' /> /r/HaloOnline</a></div>
		<div class='col-md-3'><a class='footlinks' href='//facebook.com/HaloOnline' class='anvil' target='_blank'><img src='http://pre00.deviantart.net/e7f6/th/pre/f/2015/150/c/a/eldewrito_logo_blue_by_floodgrunt-d8vd5q5.png' height='12' style=';padding-right:4px;filter:grayscale(100%);' /> HO Facebook</a></div>
		<div class='col-md-3'><a href='http://halostats.click/' class='footlinks' target='_blank'><img src='/css/images/rank/stats3shadow.png' height='15' style='padding-right:4px;' /> HaloStats.click</a></div>
	</div></div>
</div>
<script src='/js/thescript.php'></script>
</body>
</html>