<?
include ("config.php");

if (isset($userfile)){
	if (is_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'])){
		move_uploaded_file ($HTTP_POST_FILES['userfile']['tmp_name'], "$percorso/".$HTTP_POST_FILES['userfile']['name']);
		$stream = fopen($percorso."/dati.txt", "a+");
		fwrite($stream, $HTTP_POST_FILES['userfile']['name']."|".$descrizione."\n");
		fclose ($stream);		
		echo "File caricato con successo";
	} else {
		echo "Si è verificato un errore nel caricamento del file";
	}
}
?>

<form enctype="multipart/form-data" action="upload.php" method="post" target="_blank">
	<input type="hidden" name="MAX_FILE_SIZE" value="<?=$max_file_size ?>">
	<input type="hidden" name="percorso" value="<?=$percorso ?>">
	Carica <input name="userfile" type="file"><br>
	Descrizione: <input name="descrizione" type="text"><br>
	<input type="submit" value="Carica">
</form>