<?defined('_JEXEC') or die('Restricted access');?>
<style type="text/css">
    .sotto {
        width: 90%;
    }
    .sotto .rowP,.sotto .rowC{
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
    .sotto .rowA,.sotto .rowD{
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
    .sotto thead{
        height: 15pt;
        width: 181pt;
        background: none repeat scroll 0 0 red;
        border: 0.5pt solid windowtext;
        color: white;
        font-family: Calibri,sans-serif;
        font-size: 11pt;
        font-style: normal;
        font-weight: 700;
        padding-left: 1px;
        padding-right: 1px;
        padding-top: 1px;
        text-align: center;
        text-decoration: none;
        vertical-align: bottom;
        white-space: nowrap;
    }
    .spazio{
        height: 25px;
    }
</style>
<h2 class="item-page-title"><img align="middle" src="/components/com_jfantamanager/images/rosa.jpeg">Formazioni</h2>
<hr width=100 /><br>
<table border="0" cellpadding="0" cellspacing="0">
    <tr>
        <?
        foreach ($this->squadre as $i => $squadra)
        {
            
            if(count($this->giocatori[$squadra->id])>0):
                if(($i%2)==0 && $i>0)
                    echo "</tr><tr class='spazio'><td colspan='2'><hr width=80></td></tr><tr>";
                echo "<td>";
                    echo "<table class='sotto'><thead><tr><td colspan='4'>$squadra->nome</td></tr></thead>";
                    foreach ($this->giocatori[$squadra->id] as $j => $giocatore)
                    {
                        echo "<tr class='row$giocatore->pos'>
                                <td>$giocatore->pos</td>
                                <td>$giocatore->nome</td>
                                <td>$giocatore->squadra</td>
                                <td>$giocatore->valore_acq</td>
                            </tr>";
                    }
                    echo "</table>";
                echo "</td>";
            endif;
        }
        ?>
    </tr>
</table>
