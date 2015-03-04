<?defined('_JEXEC') or die('Restricted access');?>
<? echo JText::_($this->msg); ?>
<table class="consegnate" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <?
    foreach ($this->consegnate as $i => $item)
    {
        
        if(($i%4)==0 && $i>0)
            echo "</tr><tr>";
        echo  " <td>
                    <p><b>". $item['dati']->nome ."</b>
                        <br>". date('G:i',strtotime($item['dati']->ora)) ." &nbsp; ". $item['dati']->data . 
                    "</p>";   
            echo "<table class='sotto'>";
            foreach ($item['lista'] as $j => $list)
            {   
                echo ($j == 11)?"<tr><td><hr align=left width=70></td></tr>":"";
                echo "<tr class='$list->pos'><td>$list->nome</td></tr>";
            }
            echo "</table>";
        echo "</td>";
    }

//        $result = mysql_query("SELECT * FROM fanta_impiega, fanta_squadra, #__users WHERE #__users.id=fanta_squadra.squadra_iduser AND fanta_impiega.squadra_id=fanta_squadra.squadra_id  AND impiega_numgiornata=$giornata GROUP BY fanta_squadra.squadra_id");
//        $i=0;
//        while($row = mysql_fetch_object($result))
//        {
//            $i++;
//            if(($i%5)==0)
//                $scaduto.= "</tr><tr>";
//            //echo "<td><img src='/components/com_fanta/images/loghi/$row->squadra_logo' width='80px' ><br>$row->squadra_nome ($row->squadra_punti)</td>";
//            $scaduto.= "<td><p><b>$row->squadra_nome</b>
//                        <br>$row->username
//                        <br>12:53 &nbsp; 27-09-2010
//                    </p>";
//            if($vero)
//            {
////                $scaduto.= "<div id='lista'>";
//
//                $scaduto.= "<table class='sotto'>";
//                $result_lista = mysql_query("SELECT * FROM fanta_impiega, fanta_giocatori WHERE fanta_impiega.giocatore_id = fanta_giocatori.giocatore_id AND  squadra_id = " . $row->squadra_id . " AND impiega_numgiornata=$giornata ORDER BY impiega_riserva ASC, giocatore_pos DESC");
//                while($sotto = mysql_fetch_object($result_lista))
//                    $scaduto.= "<tr class='$sotto->giocatore_pos'><td>$sotto->giocatore_nome</td></tr>";
//                $scaduto.= "</table>";
//
////                $scaduto.= "</div>";
//            }
//            $scaduto.="</td>";
//        }
    ?>
    </tr>
</table>
<?
//print_r($this);
?>
 