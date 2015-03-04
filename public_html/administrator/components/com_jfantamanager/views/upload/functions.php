<?
function ret_type ($percorso){
	global $el_types, $types;
	$percorso = explode(".", $percorso);
	$percorso = $percorso[count($percorso)-1];
	for ($i=0;$i<count($el_types);$i++){
		if (in_array($percorso, $types[$el_types[$i]])){
			return $el_types[$i];
		}
	}
	return "unknown";
}

function get_description ($percorso) {
	$percorso = explode("/", $percorso);
	$dati = "";
	for ($i=0;$i<count($percorso)-1;$i++){
		$dati .= $percorso[$i]."/";
	}
	$dati .= "dati.txt";
	$files = file($dati);
	$percorso = $percorso[count($percorso)-1];
	for ($i=0;$i<count($files);$i++){
		$files[$i] = explode ("|", $files[$i]);
		if ($files[$i][0] == $percorso) {
			return $files[$i][1];
		}
	}
}

?>