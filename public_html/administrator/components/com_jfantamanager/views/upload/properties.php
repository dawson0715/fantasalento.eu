<?
include ("config.php");
include ("functions.php");
?>

<html>
<!-- Creation date: 04/09/02 -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title></title>
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="Unregistered user">
<meta name="generator" content="AceHTML 5 Pro">
</head>
<body>
<? if (is_file($percorso)) { ?>

<b>Nome del file:</b> <?=$percorso ?><br>
<b>Grandezza del file:</b> <?=number_format(filesize($percorso)) ?> bytes<br>


<br><b>
<a href="<?=$percorso ?>" target="_blank">Apri questo file</a> |
<a href="actions.php?action=delete&file=<?=$percorso ?>">Elimina il file</a>
</b><br>
<br>
<b>Tipo:</b> <?=$d_types[ret_type($percorso)] ?><br><br>
<b>Descrizione:</b> <?=str_replace("\'", "'", str_replace("\\\"", "\"", get_description($percorso))) ?>

<?
if ("vimage" == ret_type($percorso)) {
	echo "<br><br><b>Anteprima:</b><br><img src=\"$percorso\" border=1>";
}

} elseif (is_dir($percorso) && $percorso != "share") { ?>

<b>Nome della cartella:</b> /<?=$percorso ?><br>
<br>

<b>
<a href="upload.php?percorso=<?=$percorso ?>" target="_blank">Carica un file in questa cartella</a>
</b>

<? } ?>
</body>
</html>