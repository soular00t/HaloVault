<h4><a style="cursor:cell;" onclick="toggle_visibility('links');" title="Click to Show/Hide">More</a></h4>
<div style="padding-left:38px; padding-right:38px; display:block; float:center;" id="links" class="irc">
	<a href='//discord.gg/GycDpDj' target='_blank'>
		<div style='text-align:center; font-size:small; margin-bottom:3px;' title='Official HaloVault Discord: #TheDarkRoom' class='discordBtn'></div>	
	</a>
	<a target='_blank' href='//steamcommunity.com/groups/HaloVault' target='_blank' title='Official HaloVault Steam Group'>
		<div class='steamBtn' style='margin-bottom:3px;'><img src='/favicon.ico' width='34' align='right' style='display:block; position:relative; bottom:17px; right:0px;' /></div>
	</a>
	<a target='_blank' href='//discord.gg/rrVHjya' title='HaloEditingCommunity - In Development, Coming Soon.'>
		<div class='hecBtn'>HaloEditingCommunity</div>
	</a><br />
	<div style='text-align:center; font-size:small;'><B>Server Browsers</B><br />
		<a target='_blank' href='http://scooterpsu.github.io/'>ScooterPSU</a><br />
		<a target='_blank' href='http://halo.thefeeltra.in/'>TheFeelTrain</a><br />
		<a target='_blank' href='http://dewmenu.click/'>DewMenu</a><br />
		<a target='_blank' href='http://vicelio.github.io/menu/'>Vicelio</a><br />
		<a target='_blank' href='http://browser.halovau.lt/'>Vault-Menu <sup>beta</sup></a><br />
	</div><br />
	 <div style='text-align:center; font-size:small;'>
	<B>Services</B><br />
		<a href='/serverWidget.php'>ServerWidget Gen</a><br />
		 <a class='dialog_link' data-dialog='dialog888888' href='javascript:void();' title='Submit a player for review on one of the dedicated servers. This helps hosts to collaborate and prevent people from ruining the game for everyone.'>Report Player</a></div>
<br />
<div class='dialog' id='dialog888889' title='HALOVAULT DONATION'>
<center><img src='/css/images/bc.png' width='100' style="filter:invert(100%);" /><br /><span style='font-size:small;'>You may send funds using a client of your choice to the following bitcoin address:</span><br />
<br />
<code><center>1NAuE9LUL5SoGioMgVFW1NhyV1Qv8VbLji</center></code><hr />
	<div style="cursor:pointer;" onclick="window.open('https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XA8NAV9HL8MTA');">
		<img src='http://icons.iconarchive.com/icons/alecive/flatwoken/512/Apps-Paypal-icon.png' width='100' title='Donate using PayPal' />
		<br />Or you can donate using paypal here</div><span style='font-size:xx-small;'><br /><hr style="border:1px dashed grey; opacity:0.5;" />
	<b>This is NOT for official ElDewrito development!</b><br />
	Thank you for your donation! All proceeds are used towards dedicated server and web hosting services ($50/month)
	</span></center></div>

<div class='dialog' id='dialog888888' title='Report a Player'><div style='margin-left:7px; margin-right:7px; margin-top:30px;'>
<?php
	echo "<form method='post'><p style='float:right; width:30%; font-size:xx-small; padding:2px; border:1px dotted grey;'>Use this service to report abusive players. Multiple incidents will result in being added to the community banlist. A banlist.txt can be generated with the most up-to-date version <a>here.</a></p>
	<input id='multi-ban' type='text' name='reportPlayerName' placeholder='Player Name' title='Please include the players in game display name. If its in crazy unicode format, please just do your best to enter the name as similar as possible.' />
	<br /><br />".$bbcodeBan."<textarea name='bwhy' id='banReason' cols='100%' rows='9' placeholder='Please include a complete description of what the player was doing & any footage or screenshots of the incident(s) if any. Specify which servers in which you are reporting. You can report any player who is hacking, spamming, or abusing the game in any way.'></textarea>
	<input type='submit' name='reportBan' value='Report Player' /></form>";
	if (isset($_POST['reportBan'])) {
		$bPlayer = $_SQL->real_escape_string($_POST['reportPlayerName']);
		$bWhy = $_SQL->real_escape_string($_POST['bwhy']);
		if (!empty($bPlayer) AND !empty($bWhy)) {
			$_SQL->query("INSERT INTO dedibans (player, reason, uid) VALUES ('{$bPlayer}', '{$bWhy}', '{$_USER['id']}')") or die($_SQL->error);
			echo "<script>alert(\"You have reported: ".htmlentities($bPlayer)." for server abuse. The respective server hosts & moderators will review this information. Thank you.\");</script>";
		}
	}
?></div>

</div></div>