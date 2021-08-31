<?php include("inc/core.php"); $path = '../MFGA.zip'; $type = "application/zip";
if (isset($_USER['id']) && ($_USER['group'] == -3 OR $_USER['group'] > 1)) { 
	header("Expires: 0");
	header("Pragma: no-cache");
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: pre-check=0, post-check=0, max-age=0');
	header("Content-Description: File Transfer");
	header("Content-Type: " . $type);
	header("Content-Length: " .(string)(filesize($path)) );
	header('Content-Disposition: attachment; filename="'.basename($path).'"');
	header("Content-Transfer-Encoding: binary\n");

	readfile($path); // outputs the content of the file

	exit();
} else { 
	die("<script>alert(\"Only official beta testers approved from discord may access this download. Use the public versions of EnhancedForge & Forge Improvements tool in the meantime, or login with an authenticated account\");
	close();</script>"); 
} ?>