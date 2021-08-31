<?php $_URL="http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; $_DOMAIN="http://haloshare.org/"; require_once "authorize.php"; 

function bswap($u) {
		return $u[14].$u[15].$u[12].$u[13].$u[10].$u[11].$u[8].$u[9].$u[6].$u[7].$u[4].$u[5].$u[2].$u[3].$u[0].$u[1];
}

// BANS 
if ($_SERVER['REMOTE_ADDR'] == "158.69.202.195"
 OR $_SERVER['REMOTE_ADDR'] == "192.99.182.118"
 OR $_SERVER['REMOTE_ADDR'] == "192.95.23.181"
 OR stripos($_SERVER['REMOTE_ADDR'], "149.56.")
 OR stripos($_SERVER['REMOTE_ADDR'], "79.68.")
 OR stripos($_SERVER['REMOTE_ADDR'], "62.24.")
 OR stripos($_SERVER['REMOTE_ADDR'], "24.245.")) {
	die("<script>alert(\"No shady shit allowed. Considered yourself banned.\");
location.href = '//thelair.me/wp-content/uploads/2013/06/banHammer.jpg';</script><h1>Ban Hammer is Strong.</h1>"); 
} if (isset($_USER['group']) && $_USER['group'] == 0) { 
	die("<script>alert(\"No shady shit allowed. Considered yourself banned.\");
	location.href = '//thelair.me/wp-content/uploads/2013/06/banHammer.jpg';</script><h1>Ban Hammer is Strong.</h1>");
}
/*
if (stripos($_URL, "/users.php?id=") !== FALSE) { $head = "Location: /u/".(int) $_GET['id'].""; header($head); }
if (stripos($_URL, "/forge.php?id=") !== FALSE) { $head = "Location: /map/".(int) $_GET['id'].""; header($head); }
if (stripos($_URL, "/community.php?id=") !== FALSE) { $head = "Location: /topic/".(int) $_GET['id'].""; header($head); }
if (stripos($_URL, "/files.php?id=") !== FALSE) { $head = "Location: /file/".(int) $_GET['id'].""; header($head); }

if (stripos($_URL, "/users.php?edit=") !== FALSE) { $head = "Location: /u/edit/".(int) $_GET['edit'].""; header($head); }
if (stripos($_URL, "/forge.php?mod=") !== FALSE) { $head = "Location: /map/edit/".(int) $_GET['mod'].""; header($head); }
if (stripos($_URL, "/community.php?change=") !== FALSE) { $head = "Location: /topic/edit/".(int) $_GET['change'].""; header($head); }
if (stripos($_URL, "/files.php?change=") !== FALSE) { $head = "Location: /file/edit/".(int) $_GET['change'].""; header($head); } */
function get_url($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	if ($data == FALSE or empty($data)) {
		return false;
	} else { return $data; }
}

function subString($text, $maxchar, $end='...') {
	if (strlen($text) > $maxchar || $text == '') {
		$words = preg_split('/\s/', $text);      
		$output = '';
		$i      = 0;
		while (1) {
			$length = strlen($output)+strlen($words[$i]);
			if ($length > $maxchar) {
				break;
			} 
			else {
				$output .= " " . $words[$i];
				++$i;
			}
		}
		$output .= $end;
	} 
	else {
		$output = $text;
	}
	return $output;
}


// Apply Time Zone
date_default_timezone_set('America/New_York'); 

// parse URI
function addScheme($url, $scheme = 'http://') {
	return parse_url($url, PHP_URL_SCHEME) === null ?
		$scheme . $url : $url;
}

// Check if email is actually real without using mail()
function isEmail($email) {
    $request = "https://apilayer.net/api/check?access_key=1a55424588eed8d06217785fd98e688b&email=".$email;
	$rquest = file_get_contents($request);
    $decode = json_decode($rquest, true);
    $smtp = $decode['smtp_check'];
    if ($smtp !== TRUE) { return FALSE; }
    else { return TRUE; }
}

// Check if external image is actually an image
function isImage($url) {
	if(!@exif_imagetype($url)) { return false; }
	else { return true; }
}

// Turn date into full readable format
function dateConvert2($string) {
	return date('l jS \of F Y h:i:s A', strtotime($string));
}

// Calculate how long ago something happened
function dateConvert($datetime, $full = false) {
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
			unset($string[$k]);
		}
	}

	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' ago' : 'just now';
}

// Transform discord emoji's into images
function emojify($string) { 
	$string = str_ireplace('[hr]', '<hr style="opacity:0.3;" />', $string);
	$string0 = str_ireplace(':forge', ':oracle', $string);
	$string1 = str_ireplace(':tips:', ':fedora:', $string0);
	$string2 = str_ireplace(':controller:', '🎮', $string1); 
	$string3 = str_ireplace(':vault:', '<img title="\:vault\:" src="/favicon.ico" width="25" style="padding:2px;" />', $string2); 
	$string4 = str_ireplace(':trump:', '<img title="\:trump\:" src="//cdn.discordapp.com/attachments/227232976763748355/280447659813371906/trump.png" width="25" style="padding:2px;" />', $string3); 
	$string5 = str_ireplace(':oracle:', '<img title="\:oracle1\:" src="//cdn.discordapp.com/attachments/227232976763748355/280447610417053697/forge.png" width="25" style="padding:2px;" />', $string4); 
	$string6 = str_ireplace(':oracle2:', '<img title="\:oracle2\:" src="//cdn.discordapp.com/attachments/227232976763748355/280447611188674561/forge2.png" width="25" style="padding:2px;" />', $string5); 
	$string7 = str_ireplace(':kek:', '<img title="\:kek\:" src="//cdn.discordapp.com/attachments/227232976763748355/280447614766284800/kek.png" width="25" style="padding:2px;" />', $string6); 
	$string8 = str_ireplace(':marge:', '<img title="\:marge\:" src="//cdn.discordapp.com/attachments/227232976763748355/280447616582680577/marge.png" width="25" style="padding:2px;" />', $string7); 
	$string9 = str_ireplace(':ytho:', '<img title="\:ytho\:" src="//cdn.discordapp.com/attachments/227232976763748355/280447681657044993/ytho.png" width="25" style="padding:2px;" />', $string8); 
	$string10 = str_ireplace(':datboi:', '<img title="\:datboi\:" src="//cdn.discordapp.com/attachments/227232976763748355/280447599725641729/datboi.png" width="25" style="padding:2px;" />', $string9); 
	$string11 = str_ireplace(':pepe:', '<img title="\:pepe\:" src="//cdn.discordapp.com/attachments/227232976763748355/280447597578289152/bucc.png" width="25" style="padding:2px;" />', $string10); 
	$string12 = str_ireplace(':dab:', '<img title="\:dab\:" src="//cdn.discordapp.com/attachments/227232976763748355/280447597054001152/dab.png" width="25" style="padding:2px;" />', $string11); 
	$string13 = str_ireplace(':fedora:', '<img title="\:fedora\:" src="//cdn.discordapp.com/attachments/227232976763748355/280447653081514004/tips.png" width="25" style="padding:2px;" />', $string12); 
	$string14 = str_ireplace(':sayan:', '<img title="\:sayan\:" src="//cdn.discordapp.com/attachments/227232976763748355/280447649075691524/sayan.png" width="25" style="padding:2px;" />', $string13); 
	$string15 = str_ireplace(':fak:', '<img title="\:fak\:" src="//cdn.discordapp.com/attachments/227232976763748355/280447610433568769/fak.png" width="25" style="padding:2px;" />', $string14); 
	$string16 = str_ireplace(':stats:', '<img title="\:stats\:" src="//cdn.discordapp.com/attachments/227232976763748355/280447651789406208/stats3shadow.png" width="25" style="padding:2px;" />', $string15); 
	$string17 = str_ireplace(':ganja:', '<img title="\:ganja\:" src="//cdn.discordapp.com/attachments/227232976763748355/280453896487436289/upsideDownCan.png" width="25" style="padding:2px;" />', $string16); 
	$string18 = str_ireplace(':head:', '<img title="\:head\:" src="//cdn.discordapp.com/attachments/227232976763748355/280454347220058115/v.ico" width="25" style="padding:2px;" />', $string17); 
	$string19 = str_ireplace(':dew_red:', '<img title="\:dew_red\:" src="//cdn.discordapp.com/attachments/227232976763748355/280447602296750090/dewbutton2.png" width="25" style="padding:2px;" />', $string18); 
	$string20 = str_ireplace(':banned:', '<img title="\:banned\:" src="//cdn.discordapp.com/attachments/224783572391690250/245465635360997377/FuckingBanned2.jpg" width="70" style="padding:2px;" />', $string19);
	$string21 = str_ireplace(':anvil:', '<img title="\:anvil\:" src="//halovau.lt/css/images/variants/forge.png" width="25" style="padding:2px;" />', $string20);  
	$STRING = str_ireplace(':wew:', '<img title="\:wew\:" src="//cdn.discordapp.com/attachments/227232976763748355/280447673826541588/wewladtoast.png" width="25" style="padding:2px;" />', $string21);
	return $STRING;
}

// Transform BBcode into HTML
function bb_parse($string) { 
	$string = str_replace('[u]', '[underline]', $string);
	$string = str_replace('[/u]', '[/underline]', $string);
	$tags = 'b|underline|i|strike|size|color|font|center|quote|code|url|img|media'; 
	while (preg_match_all('/\[('.$tags.')=?(.*?)\](.+?)\[\/\1\]/is', $string, $matches)) foreach ($matches[0] as $key => $match) { 
		list($tag, $param, $innertext) = array($matches[1][$key], $matches[2][$key], $matches[3][$key]); 
		switch ($tag) { 
			case 'b': $replacement = "<strong>$innertext</strong>"; break; 
			case 'underline': $replacement = "<span style='text-decoration:underline;'>$innertext</span>"; break; 
			case 'i': $replacement = "<em>$innertext</em>"; break; 
			case 'strike': $replacement = "<del>$innertext</del>"; break; 
			case 'size': $replacement = "<span style=\"font-size: $param;\">$innertext</span>"; break; 
			case 'color': $replacement = "<span style=\"color: $param;\">$innertext</span>"; break; 
			case 'font': $replacement = "<span style=\"font-family: $param;\">$innertext</span>"; break; 
			case 'center': $replacement = "<center>$innertext</center>"; break; 
			case 'quote': $replacement = "<blockquote>$innertext</blockquote>"; break; 
			case 'code': $replacement = "<code>$innertext</code>"; break; 
			case 'url': $replacement = '<a href="' . ($param? $param : $innertext) . "\" target='_blank'>$innertext</a>"; $replacement = str_replace('javascript:', '', $replacement); break; 
			case 'img': 
			list($width, $height) = preg_split('`[Xx]`', $param); 
			$replacement = "<a href=\"$innertext\" target='_blank'><img " .(isImage($innertext)? "src=\"$innertext\" " : '') . (is_numeric($width)? "width=\"$width\" " : '') . (is_numeric($height)? "height=\"$height\" " : '') . 'style="max-width:80%;" /></a>'; 
			break; 
			case 'media': 
			$mediaURL = parse_url($innertext); 
			parse_str($mediaURL['query'], $videoquery); 
			if (stripos($mediaURL['host'], 'vid.me') !== FALSE) {
				$vidme = substr($innertext, strrpos($innertext, '/') + 1);
				$replacement = '<iframe src="//vid.me/e/' . $vidme . '" width="70%" height="350" frameborder="0" allowfullscreen></iframe>'; 
			} elseif (stripos($mediaURL['host'], 'imgur.com') !== FALSE) {
				$album = substr($innertext, strrpos($innertext, '/') + 1);
				$replacement = '<blockquote class="imgur-embed-pub" style="color:white; background-color:black;" lang="en" data-id="a/' . $album . '"></blockquote><script async src="//s.imgur.com/min/embed.js" charset="utf-8\"></script>';
			} elseif (stripos($mediaURL['host'], 'gfycat.com') !== FALSE) {
				$gyf = substr($innertext, strrpos($innertext, '/') + 1);
				$replacement = '<div style="position:relative;padding:10px;"><iframe src="https://gfycat.com/ifr/'.$gyf.'" frameborder="0" scrolling="no" width="70%" height="350" allowfullscreen></iframe></div>';
			} elseif (stripos($mediaURL['host'], 'youtube.com') !== FALSE) {
				$replacement = '<iframe src="http://www.youtube.com/embed/' . $videoquery['v'] . '" width="70%" height="350" frameborder="0" allowfullscreen></iframe>'; 
			} elseif (stripos($mediaURL['host'], 'google.com') !== FALSE) {
				$replacement = '<embed src="http://video.google.com/googleplayer.swf?docid=' . $videoquery['docid'] . '" width="70%" height="350" type="application/x-shockwave-flash"></embed>';
			} 
			break; 
		} $string = str_ireplace($match, $replacement, $string); 
	} 
	return emojify($string);
}

// log every single page reload, lol
function captureLog() {
	$register_globals = (bool) ini_get('register_gobals');
	if ($register_globals) $ip = getenv(REMOTE_ADDR);
	else $ip = $_SERVER['REMOTE_ADDR']; 
	$_INJECT = new mysqli('localhost', 'root', ''.base64_decode(base64_decode("WVd4c01IVjBiMlpqYjI5c2NHRnpjMlZ6")).'', 'vault') or die($_SQL->error);
	$isGuest = '-=[Guest]=-';
	if (isset($_SESSION['uname'])) { $isGuest = $_SESSION['uname']; }
	$_INJECT->query("INSERT INTO `access_logs` (`user`, `ip`, `unique_id`, `server_details`) VALUES 
	('".$_INJECT->real_escape_string($isGuest)."', '".$_INJECT->real_escape_string($ip)."', '".$_INJECT->real_escape_string($_GET['h'])."', 
	'[REFERER] => ".$_INJECT->real_escape_string($_SERVER['HTTP_REFERER'])."
	[COOKIE] => ".$_INJECT->real_escape_string($_SERVER['HTTP_COOKIE'])."
	[AGENT] => ".$_INJECT->real_escape_string($_SERVER['HTTP_USER_AGENT'])."
	[URI] => ".$_INJECT->real_escape_string($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])."')") or die($_INJECT->error);
}

// convert base map name to engine-name counterpart
function getOmapName($map) {
	$map = strtolower($map);
	if ($map == 'diamondback')     return 's3d_avalanche';
	elseif ($map == 'edge')        return 's3d_edge';
	elseif ($map == 'guardian')    return 'guardian';
	elseif ($map == 'icebox')      return 's3d_turf';
	elseif ($map == 'narrows')     return 'chill';
	elseif ($map == 'reactor')     return 's3d_reactor';
	elseif ($map == 'standoff')    return 'bunkerworld';
	elseif ($map == 'the pit')     return 'cyberdyne';
	elseif ($map == 'valhalla')    return 'riverworld';
	elseif ($map == 'last resort') return 'zanzibar';
	elseif ($map == 'high ground') return 'deadlock';
	elseif ($map == 'sandtrap')    return 'shrine';
	elseif ($map == 'flatgrass')   return 'flatgrass';
	elseif ($map == 'station')     return 'station';
	elseif ($map == 'lockout')     return 'lockout';
	elseif ($map=="hang 'em high") return 'hangem-high';
	else                           return 'unknown';
} 

// IP logging function by Dave Lauderdale; Originally published at: www.digi-dl.com
function logIP() {
	$ipLog = "../r00t/loginLogs.txt";
	$register_globals = (bool) ini_get('register_gobals');
	if ($register_globals) { $ip = getenv(REMOTE_ADDR); }  
	else { $ip = $_SERVER['REMOTE_ADDR']; }
	$date = date("l jS \of F Y h:i:s A");
	$log = fopen("$ipLog", "a+");
	fputs($log, "".$_SESSION['uname']." - Logged IP: $ip - Date: $date 
"); fclose($log);
} 

// Removes BBcode
function stripBB($str) {
	$pattern = '|[[\/\!]*?[^\[\]]*?]|si'; $replace = '';
	$return1 = preg_replace($pattern, $replace, $str);
	$return = str_replace(PHP_EOL, '', $str);
	return $return;
}
// Update user's last action
if (isset($_USER['id'])) { $_SQL->query("UPDATE users SET last_action=CURRENT_TIMESTAMP WHERE id = '{$_USER['id']}'") or die($_SQL->error); }	

// CSRF PREVENTION
$_TKN=md5(microtime());
if (!isset($_SESSION['tok3n'])) { $_SESSION['tok3n'] = $_TKN; }
$_TOKEN=''; $_TOKEN=$_SESSION['tok3n'];
if (( !empty($_SERVER['HTTP_REFERER']) ) && ( stripos($_SERVER['HTTP_REFERER'], "dewsha.re")==FALSE && stripos($_SERVER['HTTP_REFERER'], "127.0.0.1"==FALSE)) ) {
	if (!empty($_POST)) {
		$parts = parse_url($_SERVER['HTTP_REFERER']); $prevDom = $parts[ "scheme" ] . "://" . $parts[ "host" ]; 
		$parts1 = parse_url($_SERVER['HTTP_HOST']);
		$curDom = "http://".$parts1[ "path" ]."";
		if ($prevDom != $curDom) { 
			die("<script>alert(\"No cross site request forgery allowed!\");</script>"); 
		} 
		if ($_POST['_TOKEN'] != $_TOKEN) {
			die("<script>alert(\"No cross site request forgery allowed! \n sessionData- ".$_POST['_TOKEN']." \n postData- ".$_TOKEN.");</script>");  
		}
	}
}
function removeBB($string) { 
	$string = str_replace('[hr]', '', $string); $replacement='';
	$tags = 'b|u|i|size|color|font|center|quote|code|url|img|media|B|U|I|SIZE|COLOR|FONT|CENTER|QUOTE|CODE|URL|IMG|MEDIA'; 
	while (preg_match_all('/\[('.$tags.')=?(.*?)\](.+?)\[\/\1\]/is', $string, $matches)) foreach ($matches[0] as $key => $match) { 
		list($tag, $param, $innertext) = array($matches[1][$key], $matches[2][$key], $matches[3][$key]); 
		switch ($tag) { 
			case 'b': $replacement = $innertext; break; 
			case 'u': $replacement = $innertext; break; 
			case 'i': $replacement = $innertext; break; 
			case 'size': $replacement = $innertext; break; 
			case 'color': $replacement = $innertext; break; 
			case 'font': $replacement = $innertext; break; 
			case 'center': $replacement = $innertext; break; 
			case 'media': $replacement = ''; break; 
			case 'img': $replacement = ''; break; 
			case 'quote': $replacement = $innertext; break; 
			case 'code': $replacement = $innertext; break; 
			case 'url': $replacement = $innertext; break; 
			break; 
		} $string = str_ireplace($match, $replacement, $string); 
	} 
	return $string; 
}
function Thumb($video) {
	$mediaURL = parse_url($video); 
	if (@stripos($mediaURL['host'], 'youtube.com') !== FALSE) {
		parse_str($mediaURL['query'], $videoquery); 
		$_thumb = "//i1.ytimg.com/vi/".$videoquery['v']."/mqdefault.jpg";
	} elseif (stripos($video, 'imgur.com') !== false) {
		$image1 = str_replace('.jpg','m.jpg', $video);
		$image2 = str_replace('.png','m.png', $image1);
		$image3 = str_replace('.gif','m.gif', $image2);
		$image4 = str_replace('.svg','m.svg', $image3);
		$_video = str_replace('.jpeg','m.jpeg', $image4);
		$_thumb=$_video;
	} else { $_thumb=$video; } return $_thumb;
}
function imgurLargeThumb($url) {
	if (stripos($url, 'imgur.com') !== false) {
		$image1 = str_replace('.jpg','l.jpg', $url);
		$image2 = str_replace('.png','l.png', $image1);
		$image3 = str_replace('.gif','l.gif', $image2);
		$image4 = str_replace('.svg','l.svg', $image3);
		$_thumb = str_replace('.jpeg','l.jpeg', $image4);
	} else { $_thumb=$url; } return $_thumb;
}
// Indents a flat JSON string to make it more human-readable.
function indent($json, $html = false, $tabspaces = null) {
	$tabcount = 0;
	$result = '';
	$inquote = false;
	$ignorenext = false;
	if ($html) {
		$tab = str_repeat("&nbsp;", ($tabspaces == null ? 4 : $tabspaces));
		$newline = "<br/>";
	} else {
		$tab = ($tabspaces == null ? "\t" : str_repeat(" ", $tabspaces));
		$newline = "\n";
	}
	for($i = 0; $i < strlen($json); $i++) {
		$char = $json[$i];
		if ($ignorenext) {
			$result .= $char;
			$ignorenext = false;
		} else {
			switch($char) {
				case ':':
				$result .= $char . (!$inquote ? " " : "");
				break;
				case '{':
				if (!$inquote) {
					$tabcount++;
					$result .= $char . $newline . str_repeat($tab, $tabcount);
				}
				else {
					$result .= $char;
				}
				break;
				case '}':
				if (!$inquote) {
					$tabcount--;
					$result = trim($result) . $newline . str_repeat($tab, $tabcount) . $char;
				}
				else {
					$result .= $char;
				}
				break;
				case ',':
				if (!$inquote) {
					$result .= $char . $newline . str_repeat($tab, $tabcount);
				}
				else {
					$result .= $char;
				}
				break;
				case '"':
				$inquote = !$inquote;
				$result .= $char;
				break;
				case '\\':
				if ($inquote) $ignorenext = true;
				$result .= $char;
				break;
				default:
				$result .= $char;
			}
		}
	}

	return $result;
}
// Convert RSS feeds into JSON API's
class XmlToJson { 
	public function rssTojson($url) {
		$fileContents= get_url($url);
		$fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
		$fileContents = trim(str_replace('"', "'", $fileContents));
		$simpleXml = simplexml_load_string($fileContents);
		$json = json_encode($simpleXml, JSON_PRETTY_PRINT);
		return $json;
	}
} function rss2Json($data) {
	return XmlToJson::rssTojson($data);
}
// BBCode Buttons
$bbcode_buttons = "<div class='bbb'><button title='Bold' type=\"button\" onclick=\"wrapText('edit','[b]','[/b]');\"> &#119809; </button>
<button title='Italic' type=\"button\" onclick=\"wrapText('edit','[i]','[/i]');\"> <i style='font-family:Times New Roman;'>I</i> </button>
<button title='Underline' type=\"button\" onclick=\"wrapText('edit','[u]','[/u]');\"> <u style='font-family:Times New Roman;'>U</u> </button>
<button title='Strikethrough' type=\"button\" onclick=\"wrapText('edit','[strike]','[/strike]');\"> <strike>S</strike> </button>
<button title='Font size' type=\"button\" onclick=\"wrapText('edit','[size=]','[/size]');\"> <large>A</large><small>z</small> </button>
<button title='Font color' type=\"button\" onclick=\"wrapText('edit','[color=]','[/color]');\"> <span stye='color:blue;'>🎨</span> </button> &nbsp;&nbsp;
<button title='Code' type=\"button\" onclick=\"wrapText('edit','[code]','[/code]');\"> # </button>
<button title='Quote' type=\"button\" onclick=\"wrapText('edit','[quote]','[/quote]');\"> &#10077; </button>
<button title='Hyperlink' type=\"button\" onclick=\"wrapText('edit','[url=]','[/url]');\"> &#128206; </button>
<button title='Center Align' type=\"button\" onclick=\"wrapText('edit','[center]','[/center]');\"> &#9776; </button>
<button title='Image URL' type=\"button\" onclick=\"wrapText('edit','[img]','[/img]');\"> &#128247; </button>
<button title='Video/Slideshow' type=\"button\" onclick=\"wrapText('edit','[media]','[/media]');\"> &#127916; </button></div>";

$bbcode_buttons2 = "<div class='bbb'><button type=\"button\" onclick=\"wrapText('multi-users','[b]','[/b]');\">	&#119809; </button>
<button title='Italic' type=\"button\" onclick=\"wrapText('multi-users','[i]','[/i]');\"> <i style='font-family:Times New Roman;'>I</i> </button>
<button title='Underline' type=\"button\" onclick=\"wrapText('multi-users','[u]','[/u]');\"> <u style='font-family:Times New Roman;'>U</u> </button>
<button title='Strikethrough' type=\"button\" onclick=\"wrapText('multi-users','[strike]','[/strike]');\"> <strike>S</strike> </button>
<button title='Font size' type=\"button\" onclick=\"wrapText('multi-users','[size=]','[/size]');\"> <large>A</large><small>z</small> </button>
<button title='Font color' type=\"button\" onclick=\"wrapText('multi-users','[color=]','[/color]');\"> <span stye='color:blue;'>🎨</span> </button> &nbsp;&nbsp;
<button title='Code' type=\"button\" onclick=\"wrapText('multi-users','[code]','[/code]');\"> # </button>
<button title='Quote' type=\"button\" onclick=\"wrapText('multi-users','[quote]','[/quote]');\"> &#10077; </button>
<button title='Hyperlink' type=\"button\" onclick=\"wrapText('multi-users','[url=]','[/url]');\"> &#128206; </button>
<button title='Center Align' type=\"button\" onclick=\"wrapText('multi-users','[center]','[/center]');\"> &#9776; </button>
<button title='Image URL' type=\"button\" onclick=\"wrapText('multi-users','[img]','[/img]');\"> &#128247; </button>
<button title='Video/Slideshow' type=\"button\" onclick=\"wrapText('multi-users','[media]','[/media]');\"> &#127916; </button></div>";

$bbcodeBan = "<div class='bbb'><button type=\"button\" onclick=\"wrapText('banReason','[b]','[/b]');\">	&#119809; </button>
<button title='Italic' type=\"button\" onclick=\"wrapText('banReason','[i]','[/i]');\"> <i style='font-family:Times New Roman;'>I</i> </button>
<button title='Underline' type=\"button\" onclick=\"wrapText('banReason','[u]','[/u]');\"> <u style='font-family:Times New Roman;'>U</u> </button>
<button title='Strikethrough' type=\"button\" onclick=\"wrapText('banReason','[strike]','[/strike]');\"> <strike>S</strike> </button>
<button title='Font size' type=\"button\" onclick=\"wrapText('banReason','[size=]','[/size]');\"> <large>A</large><small>z</small> </button>
<button title='Font color' type=\"button\" onclick=\"wrapText('banReason','[color=]','[/color]');\"> <span stye='color:blue;'>🎨</span> </button> &nbsp;&nbsp;
<button title='Code' type=\"button\" onclick=\"wrapText('banReason','[code]','[/code]');\"> # </button>
<button title='Quote' type=\"button\" onclick=\"wrapText('banReason','[quote]','[/quote]');\"> &#10077; </button>
<button title='Hyperlink' type=\"button\" onclick=\"wrapText('banReason','[url=]','[/url]');\"> &#128206; </button>
<button title='Center Align' type=\"button\" onclick=\"wrapText('banReason','[center]','[/center]');\"> &#9776; </button>
<button title='Image URL' type=\"button\" onclick=\"wrapText('banReason','[img]','[/img]');\"> &#128247; </button>
<button title='Video/Slideshow' type=\"button\" onclick=\"wrapText('banReason','[media]','[/media]');\"> &#127916; </button></div>"; ?>