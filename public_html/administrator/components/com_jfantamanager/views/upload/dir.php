<html>
<!-- Creation date: 04/09/02 -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title></title>
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="Unregistered user">
<meta name="generator" content="AceHTML 5 Pro">
<meta http-equiv="refresh" content="10">
<style>
A {
	color: #000000;
	text-decoration: none;
	}
</style>
</head>
<body>
<table border=0 cellpadding=1 cellspacing=0 width=500>
<?
include ("config.php");

$files_in_dir = array();
$folders_in_dir = array();

if (!isset($percorso)){ $percorso = "share"; }
$dir = opendir($percorso);

while (($file = readdir($dir)) !== false){
	if (!in_array ($file, $unshow_names)){
		if (is_dir("$percorso/$file")) {
			echo "<tr><td width=16><img src='images/folder.gif'></td><td width=500 onClick=\"var path = top.menu.ChDir('$file'); top.view_file.location='properties.php?percorso='+path; location='$PHP_SELF?percorso='+path;\" style=\"cursor:hand;\">".$file."</td></tr>";
			$folders_in_dir[count($folders_in_dir)] = $file;
		} else {
			echo "<tr><td width=16><img src='images/file_icon.gif'></td><td width=500><a href='properties.php?percorso=$percorso/$file' title='".number_format(filesize("..$percorso/$file"))." bytes' target='view_file'>$file</a></td></tr>";
			$files_in_dir[count($files_in_dir)] = $file;
		}
	}
}
closedir($dir);

$total_bytes = 0;
for ($i=0;$i<count($files_in_dir);$i++){
	$total_bytes += filesize("$percorso/".$files_in_dir[$i]);
}
?>
</table>

<script language="JavaScript1.3">
defaultStatus = "Cartelle: <?=count($folders_in_dir)-1 ?>; Files: <?=count($files_in_dir) ?>; Bytes totali: <?=$total_bytes ?>";
</script>
</body>
</html>