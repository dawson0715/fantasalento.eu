<?defined('_JEXEC') or die('Restricted access');?>
<h2 class="item-page-title"><img align="left" src="<?=$this->root?>components/com_jfantamanager/images/soccer_1_32.png">Formazioni consegnate</h2>
<hr width=100 /><br>
<form action="index.php?option=com_jfantamanager&view=all&lega=1" method="post" name="adminForm">
    <label>Controlla le formazioni della giornata: </label>
    <select name="giornata" class="inputbox" onchange="this.form.submit()">
         <?php echo JHtml::_('select.options', $this->options, 'value', 'text',$this->giornata);?>
    </select>
</form>
<?
function bonus($gio,$root)
{
    for($i=0;$i<$gio->rigore_parato;$i++)
        $bonus.= '<img src="'.$root.'components/com_jfantamanager/images/parato_2.png" alt="P">';
    if(($gio->goal + $gio->rigore_segnato)>0)
        $bonus .= '<img src="'.$root.'components/com_jfantamanager/images/ball_'.($gio->goal + $gio->rigore_segnato).'.png" alt="O">';
    for($i=0;$i<$gio->assist;$i++)
        $bonus .= '<img src="'.$root.'components/com_jfantamanager/images/assist.png" alt="As">';
//    for($i=0;$i<$gio->rigore_segnato;$i++)
//        $bonus.= '<img src="/components/com_fanta/images/Ball.png" alt="O">';
    return $bonus;
}

function malus($gio,$root)
{
    if($gio->espulsione)
        $malus.= '<img src="'.$root.'components/com_jfantamanager/images/red.png" alt="E">';
    else if($gio->ammonizione)
        $malus.= '<img src="'.$root.'components/com_jfantamanager/images/yellow.png" alt="A">';
    for($i=0;$i<$gio->rigore_sbagliato;$i++)
        $malus.= '<img src="'.$root.'components/com_jfantamanager/images/unball.png" alt="X">';
    for($i=0;$i<$gio->autorete;$i++)
        $malus.= '<img src="'.$root.'components/com_jfantamanager/images/autogoal.png" alt="Ar">';
//    for($i=0;$i<$gio->goal_subito ;$i++)
    if($gio->goal_subito>0)
        $malus .= '<img src="'.$root.'components/com_jfantamanager/images/sball_'.$gio->goal_subito.'.png" alt="O">';
    return $malus;
}
?>
<? if(!$this->ufficiale): ?>
<div class="msg">
    I voti di questa giornata non sono ancora ufficiali <br>potrebbero mancare gli assist della giornata
</div>
<? endif; ?>
<?
//    print_r($this);
//    exit;
?>
<table border="0" cellpadding="0" cellspacing="0" class="consegnate">
    <tr>
        <?
        foreach ($this->squadre as $i => $squadra)
        {
            if(count($this->giocatori[$i])>0):
                if(($i%2)==0 && $i>0)
                    echo "</tr><tr>";
                echo  " <td>
                            <p class='nome'><a href='index.php?option=com_jfantamanager&view=profile&id=$squadra->id'>$squadra->nome</a>
                                <br>". date('d/m/Y',strtotime($squadra->data)) . ", alle ore: ". date('G:i',strtotime($squadra->ora)). 
                            "</p><div class=bordo>";
                echo "<table class='sotto'>
                        <thead>
                            <th>R</th><th>Giocatore</th><th>Voto<br>giornale</th><th>Bonus</th><th>Malus</th><th>Fanta<br>voto</th>
                        </thead>";
                foreach ($this->giocatori[$i]->rosa as $j => $giocatore)
                {   
                    $seconda = ($j == 10)?" class='linea'":"";
//                    echo "<tr $seconda". (($j%2)?"class='bianco'":"")  . (($this->giocatori[$i]->stato[$j]=='' && $this->ufficiale)?"id='left'":"")."><td>$giocatore->pos</td><td id='giocatore_".((!$this->ufficiale)?"":$this->giocatori[$i]->stato[$j])."'>$giocatore->nome</td><td>$giocatore->voto</td><td>".bonus($giocatore)."</td><td></td><td>$giocatore->totale</td></tr>";
                  echo "<tr $seconda". (($j%2)?"class='bianco'":"")  . (($this->giocatori[$i]->stato[$j]=='' && $this->ufficiale)?"id='left'":"")."><td>$giocatore->pos</td><td id='giocatore_".((!$this->ufficiale)?"":$this->giocatori[$i]->stato[$j])."'>$giocatore->nome</td><td>$giocatore->voto</td><td>".bonus($giocatore,$this->root)."</td><td>".malus($giocatore,$this->root)."</td><td>$giocatore->totale</td></tr>";
                    
                }
                if($this->giocatori[$i]->modificatore!='') 
                    echo"<tr><td></td><td>Modificatore</td><td></td><td></td><td></td><td>".$this->giocatori[$i]->modificatore."</td></tr>";
                else
                    echo"<tr><td></td><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>";
                echo "</table>";
                if($this->ufficiale)
                    echo "<div class='result'><span id='goal'>".$this->giocatori[$i]->goal."</span>".$this->giocatori[$i]->punti."</div>
                    </div>";
                echo "</td>";
            endif;
        }
        ?>
    </tr>
</table>

<?
//print_r($this->squadre);
?>
<br><br>
<?
//print_r($this->ufficiale);
?>