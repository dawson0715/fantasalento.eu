<?
// Sezione LOG
$log_file = "ips.dat";

// Sezione UPLOADS
$max_file_size = 10485760;	// Dimensione massima del file da caricare

// Sezione lista file e directory
$unshow_names = array(".", "dati.txt");	// Array dei nomi da non mostrare

$el_types = array ("vimage", "nimage", "video", "audio", "text", "html", "sssp", "archive", "exe");
$types = array(
	"vimage" => array ("jpg", "jpeg", "gif", "png"),
	"nimage" => array ("tif", "bmp"),
	"video" => array ("avi", "mpg", "mpeg"),
	"audio" => array ("mid", "mp3", "wav"),
	"text" => array ("txt"),
	"html" => array ("htm", "html"),
	"sssp" => array ("php", "php4", "php3", "asp"),
	"archive" => array ("zip", "rar", "arj", "cab"),
	"exe" => array ("exe", "com")
);
$d_types = array(
	"vimage" => "Immagine visualizzabile tramite il browser",
	"nimage" => "Immagine non visualizzabile tramite il browser",
	"video" => "File video",
	"audio" => "File audio",
	"text" => "File di testo",
	"html" => "Pagina web",
	"sssp" => "Pagina web contenente script server side",
	"archive" => "File archivio",
	"exe" => "File eseguibile per Windows",
	"unknown" => "Tipo di file sconosiuto"
);
?>
