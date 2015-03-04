<?php
defined('_JEXEC') or die('Restricted access');

$result = mysql_query("SELECT * FROM fanta_calendario WHERE cal_giornata=$giornata");
$row = mysql_fetch_object($result);
?>
<center>
<?
$modulo = Array(1=>"3-4-3",2=>">3-5-2",3=>"4-3-3",4=>"4-4-2",5=>"5-3-2",6=>"5-4-1",7=>"6-3-1");
echo "Modulo scelto ". $modulo[$_POST['sc_formazione']];
$posizioni = split("-", $modulo[$_POST['sc_formazione']]);
$count=0;
$query = mysql_query("SELECT * FROM `fanta_giocatori` WHERE `giocatore_id` = " .$_POST["g".$count]. ";");
$riga = mysql_fetch_object($query);
?>
<div style="background-image:URL(/images/mie/campo.jpg);width:500px;height:400px">
    <table class="campo">
        <tr>
            <td id="portiere" width="200px">
                <?=$riga->giocatore_nome?>
            </td>
        </tr>
    </table>
<?
    $insert="INSERT INTO `daniele_gabrieli_fanta`.`fanta_impiega` (
            `squadra_id` ,
            `giocatore_id` ,
            `impiega_numgiornata` ,
            `impiega_riserva`)
            VALUES (" .$_POST["id_squadra"] . "," . $_POST["g".$count] . ",$giornata,0)";
    for($j=0;$j<=count($posizioni)-1;$j++)
    {
        echo "<table class='campo'><tr>";
        for($i=1;$i<=$posizioni[$j];$i++)
        {
            echo "<td>";
            $count++;
//            echo $_POST["g".$i] . "<br>";
            $query = mysql_query("SELECT * FROM `fanta_giocatori` WHERE `giocatore_id` = " .$_POST["g".$count]. ";");
            $riga = mysql_fetch_object($query);
            echo $riga->giocatore_nome;
            $insert.=",(" .$_POST["id_squadra"] . "," . $_POST["g".$count] . ",$giornata,0)";
            echo "</td>";
        }
        echo "</tr></table>";
    }
    echo "<div style=\"height: 270px; background-image: url(/images/mie/p_left.png); background-repeat: no-repeat;\" >
                <table width=\"445px\" style=\"background-image: url(/images/mie/p_mid.png); height: 270px; margin-left: 15px; float: left;width:468px\">
                    <tr tr class=\"campo\">
                        <td colspan='4'>PANCHINA</td></tr><tr>";

    //$result = mysql_query("INSERT INTO `daniele_gabrieli_fanta`.`fanta_impiega` (`squadra_id`, `giocatore_id`, `impiega_numgiornata`, `impiega_riserva`, `voto_finale`, `fatto`, `subito`, `rig_parato`, `rig_sbagliato`, `rig_segnato`, `autorete`, `ammonizione`, `espulsione`, `assist`, `giocato`) VALUES (" .$_POST["id_squadra"]. ", " .$_POST["g".$i]. ", " .$giornata. ", 2,0,0,0,0,0,0,0,0,0,0,0);");
    for($i=11;$i<=14;$i++)
    {
        $query = mysql_query("SELECT * FROM `fanta_giocatori` WHERE `giocatore_id` = " .$_POST["g".$i]. ";");
        $riga = mysql_fetch_object($query);
        echo "<td> $riga->giocatore_nome </td>";
        $insert.=",(" .$_POST["id_squadra"] . "," . $_POST["g".$i] . ",$giornata,1)";
    }
    echo "</tr><tr tr class=\"campo\"><td></td>";
    for($i=15;$i<=17;$i++)
    {
        $query = mysql_query("SELECT * FROM `fanta_giocatori` WHERE `giocatore_id` = " .$_POST["g".$i]. ";");
        $riga = mysql_fetch_object($query);
        echo "<td> $riga->giocatore_nome </td>";
        $insert.=",(" .$_POST["id_squadra"] . "," . $_POST["g".$i] . ",$giornata,2)";
    }
    echo "</tr></table>
        <div style=\"float: left; background-image: url(/images/mie/p_right.png); width: 15px; height: 270px;\">
        </div>";
    
    // se sto modificando calcello quella vecchia e inserisco quella nuova
    $conse="IMPOSSIBILE CONSEGNARE/MODIFICARE LA FORMAZIONE";
    $c_ora = date("G:i");
    $c_data = date('Y-m-d');
    if($_GET['modifica']=='1')
    {
        $esito = mysql_query("DELETE FROM `fanta_impiega` WHERE `fanta_impiega`.`squadra_id` = " .$_POST["id_squadra"] . " AND `fanta_impiega`.`impiega_numgiornata` = $giornata ");
        $esito2 = mysql_query("DELETE FROM  `daniele_gabrieli_fanta`.`fanta_voti_squadra` WHERE  `cal_giornata` = $giornata AND  `squadra_id` = " .$_POST["id_squadra"]);
        if ($esito && $esito2)
            $conse="Vecchia formazione modificata";
    }
    $esito = mysql_query($insert);
    $esito = mysql_query("INSERT INTO fanta_voti_squadra (cal_giornata, squadra_id, consegna_data, consegna_ora)
        VALUES ($giornata, " . $_POST["id_squadra"] . "$c_date ,$c_ora)");
    if ($esito && $esito2)
        $conse="<br>Nuova formazione consegnata con successo";
    
    ?>
    </div>
    </center>
    <?echo "<div> $conse </div>"?>
<!--<div style="background-image:URL(/images/mie/campo.jpg);width:500px;height:400px"><center>
<table class="campo">
    <tr>
        <td id="portiere" width="200px">
        </td>
        <td width="150px">
        </td>
    </tr>
</table>
<table  class="campo" >
    <tr id="difesa">
    </tr>
</table>
<table class="campo" >
    <tr id="centro">
    </tr>
</table>
<table  class="campo">
    <tr  id="attacco">
    </tr>

<div style="height: 270px; background-image: url(&quot;/images/mie/p_left.png&quot;); background-repeat: no-repeat;">
                            <table width="445px" style="background-image: url(&quot;/images/mie/p_mid.png&quot;); height: 270px; margin-left: 15px; float: left;">
                                <tbody><tr class="campo">
                                    <td width="65px" id="portiere1"><img height="75" width="75" alt="INTER" src="/images/maglie/inter.png"><br><span>JULIO CESAR</span></td>
                                    <td width="65px" id="difesa1"><img height="75" width="75" alt="LAZIO" src="/images/maglie/lazio.png"><br><span>LICHTSTEINER</span></td>
                                    <td width="65px" id="centro1"><img height="75" width="75" alt="PARMA" src="/images/maglie/parma.png"><br><span>MORRONE</span></td>
                                    <td width="65px" id="attacco1"><img height="75" width="75" alt="MILAN" src="/images/maglie/milan.png"><br><span>IBRAHIMOVIC</span></td>
                                </tr>
                                <tr class="campo">
                                    <td id="portiere2"></td>
                                    <td id="difesa2"><img height="75" width="75" alt="CATANIA" src="/images/maglie/catania.png"><br><span>TERLIZZI</span></td>
                                    <td id="centro2"><img height="75" width="75" alt="MILAN" src="/images/maglie/milan.png"><br><span>SEEDORF</span></td>
                                    <td id="attacco2"><img height="75" width="75" alt="NAPOLI" src="/images/maglie/napoli.png"><br><span>BUCCHI</span></td>
                                </tr>
                            </tbody></table>
                            <div style="float: left; background-image: url(&quot;/images/mie/p_right.png&quot;); width: 15px; height: 270px;">
                            </div>
                        </div>

-->
