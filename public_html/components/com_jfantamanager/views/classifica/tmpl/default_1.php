<?php defined('_JEXEC') or die('Restricted access');?>

<script type="text/javascript" src="/models/mod_top/js/jquery-1.4.2.min.js"></script>
<link href="/components/com_jfantamanager/css/classifica.css" rel="stylesheet" type="text/css" />
<!--<img src="images/iscritti.png">-->
<script type="text/javascript">
    //$('#lista').fadeOut(1000,function(){$('#lista').load('components/com_chiedi/include/show_last.php','',$(this).fadeIn(1000))});
    function Hide(idcontent)
    {
        $('.risultati'+idcontent).hide("slow");
        $('#lista'+idcontent).load('/components/com_jfantamanager/include/show_last.php?id='+idcontent,'',$(this).fadeIn('slow'));
    }
</script>
<table width="100%" style="line-height: 100%;">
    <tr style="vertical-align: top">
        <td width="75%">
            <table width="50%" class="visualizza" border="0" cellpadding="0" cellspacing="0">
                <thead><tr style="height: 25px"><th colspan='4'><b>SQUADRE PARTECIPANTI</b></th></tr></thead>
                <?php
                $i = 0;
                echo "<tr>";
                foreach($this->items as $row)
                {
                    $i++;
                    $classe= ($classe=="") ? "azzurro" : "";
                    $tabella.="<tr class='$classe'><td>$i</td><td class='centro'>$row->squadra_nome<br><span class='nick'>$row->username</span></td><td class='c1z'>$row->totale</td></tr>";
                    echo "<td>
                            <img src='/components/com_fanta/images/loghi/$row->squadra_logo' ><br><span class='squadra_nome'>$row->squadra_nome</span>
                            <div class='squadra'>
                                   <span class='risultati$row->squadra_id' onClick='Hide($row->squadra_id)'>Risultati squadra</span>
                                   <div id='lista$row->squadra_id' style='display:inline' class='elenco'></div>
                                   <div id='Punti'>Punti: <b>$row->totale</b></div>
                            </div>
                         </td>";
                    if (($i % 4) == 0)
                        echo "</tr><tr>";
                }
                ?>
            </table>
        </td>
        <td>
            <table cellspacing="1" id="claz">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome Squadra</th>
                        <th>Punti</th>
                    </tr>
                </thead>
                <tbody>
                    <?=$tabella?>
                </tbody>
            </table>
        </td>
    </tr>
</table>
