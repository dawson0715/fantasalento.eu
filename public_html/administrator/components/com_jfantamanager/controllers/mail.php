<?php
//        echo $_SERVER["SCRIPT_FILENAME"];
//        /var/www/vhosts/fantasalento.it/httpdocs/administrator/components/com_jfantamanager/controllers/mail.php
//        exit;
        $connessione = mysql_connect("localhost","localhost","dawson");
        $selezione = mysql_select_db('daniele_gabrieli_fanta',$connessione) or die (mysql_error());
        $data_fine = date('Y-m-d', mktime(0,0,0,date('m'),date('d'),date('Y')));
        
        function squadra($id,$giornata)
        {
            $lista = mysql_query("SELECT nome,pos
                        FROM jos_fanta_impiega 
                        LEFT JOIN jos_fanta_giocatore
                            ON (jos_fanta_impiega.giocatore_id = jos_fanta_giocatore.id)
                        WHERE giornata = $giornata AND squadra_id = $id
                        ORDER BY riserva ASC, pos DESC");
            $squadra = "<html><body><table class='sotto'>";
			$j=0;
            while($giocatore = mysql_fetch_object($lista))
            {
                $squadra .= ($j == 11)?"<tr><td><hr align=left width=70></td></tr>":"";
                $squadra .= "<tr><td class='row$giocatore->pos'>$giocatore->pos) $giocatore->nome</td></tr>";
                $j++;
            }
            $squadra .= "</table></body></html>";
            return $squadra;
        }
            
        $query      = mysql_query("SELECT MIN(`giornata`) as giornata FROM `jos_fanta_calendario` WHERE `data` >= '$data_fine'");
        $giornata       = mysql_fetch_object($query)->giornata;
        
        $result = mysql_query("SELECT name,email,jos_fanta_squadra.id,nome,data,ora
                FROM `jos_fanta_squadra`
                LEFT JOIN jos_fanta_voti_squadra ON (jos_fanta_squadra.id = jos_fanta_voti_squadra.squadra_id)
                LEFT JOIN jos_users ON (jos_fanta_squadra.created_by = jos_users.id)
                WHERE lega=1 AND giornata=$giornata");
        
        $header = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=iso-8859-1\r\n";
        //$header .= "To: Ricevente <daniele0715@gmail.com>\n";
        $header .= "From: FANTASALENTO <info@fantasalento.it>\n";
        $header .= "X-Mailer: Il nostro Php\n\n";
        $oggetto = "Formazioni ".$giornata."a giornata";
        //CLASSIFICA PRIMA DELLA GIORNATA
        $messaggio = "Classifica prima della ".$giornata."a giornata <br>";
        $classifica = mysql_query('SELECT nome, SUM( jos_fanta_voti_squadra.punti ) AS punti
                        FROM jos_fanta_squadra
                        LEFT JOIN jos_fanta_voti_squadra ON ( jos_fanta_squadra.id = jos_fanta_voti_squadra.squadra_id )
                        WHERE lega = 1
                        GROUP BY `id`
                        ORDER BY punti DESC');
        while($row = mysql_fetch_object($classifica))
            $messaggio.="<label>$row->nome</label> $row->punti <br>";
        //FORMAZIONI DELLA GIORNATA
        $messaggio .="<br>Formazioni ".$giornata."a giornata della lega FANTASALENTO <br>";
        $messaggio .= '<table class="consegnate" border="0" cellpadding="0" cellspacing="0"><tr>';
		$destinatari="";
		$j=0;
        while($row = mysql_fetch_object($result))
        {
            $j++;
            $messaggio .= ($j%2)?"</tr><tr>":""; 
            $messaggio .=   "<td>
                                <p style='background-color:lightgray;padding:7px 21px;margin-bottom:2px;'><b> $row->id) $row->nome </b>
                                    <br>". date('G:i',strtotime($row->ora)) ." &nbsp; ". $row->data . 
                                "</p>".  squadra($row->id,$giornata).
                            "</td>";
            $destinatari.=$row->email."; ";
        }
        $messaggio .= "<table>";
        $messaggio .= '
            <style type="text/css">
                .consegnate{
                    border-collapse: collapse;
                    border-spacing: 0;
                }
                .consegnate td{
                    padding:5px;
                    border: 1px solid black;
                    }
                .sotto{
                    border-collapse: collapse;
                    border-spacing: 0;
                    width:100%;
                }
                .sotto .rowP, .sotto .rowC {
                    background: none repeat scroll 0 0 #DCE6F1;
                    border: 0.5pt solid windowtext;
                    color: black;
                    font-family: Calibri,sans-serif;
                    font-size: 11pt;
                    font-style: normal;
                    font-weight: 700;
                    padding-left: 1px;
                    padding-right: 1px;
                    padding-top: 1px;
                    text-decoration: none;
                    vertical-align: bottom;
                    white-space: nowrap;
                }
                .sotto .rowA, .sotto .rowD {
                    background: none repeat scroll 0 0 #E6B8B7;
                    border: 0.5pt solid windowtext;
                    color: black;
                    font-family: Calibri,sans-serif;
                    font-size: 11pt;
                    font-style: normal;
                    font-weight: 700;
                    padding-left: 1px;
                    padding-right: 1px;
                    padding-top: 1px;
                    text-decoration: none;
                    vertical-align: bottom;
                    white-space: nowrap;
                }
                label {
                    float: left;
                    width: 200px;
}               }
        </style>';
        
        //mail("daniele0715@msn.com",$oggetto,$messaggio,$header);
        mail($destinatari,$oggetto,$messaggio,$header);
//        while($row = mysql_fetch_object($result))
//        mail($row->email,$oggetto,$messaggio,$header);
            mysql_free_result($result);
    echo  $messaggio;
	echo "<br>Destinatari: ".$destinatari;
?> 
