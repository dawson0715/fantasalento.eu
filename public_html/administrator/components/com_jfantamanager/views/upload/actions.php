<?
if ($action == "delete"){
	unlink ($file);
	$percorso = $file;
	$percorso = explode("/", $percorso);
	$dati = "";
	for ($i=0;$i<count($percorso)-1;$i++){
		$dati .= $percorso[$i]."/";
	}
	$dati .= "dati.txt";
	$files = file($dati);
	$percorso = $percorso[count($percorso)-1];
	$stream = fopen ($dati, "w");
	for ($i=0;$i<count($files);$i++){
		$files[$i] = explode ("|", $files[$i]);
		if ($files[$i][0] != $percorso && $files[$i][0] != "") {
			fwrite ($stream, implode("|", $files[$i]));
		}
	}
}
?>

<script language="JavaScript">top.dir.reload();location="about:blank";</script>