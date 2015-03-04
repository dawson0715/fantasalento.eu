<?php defined('_JEXEC') or die('Restricted access'); ?>
<form action="#" method="post" name="squadraForm" id="squadra-form" onsubmit="return validate()">
<?
//print_r($this);
if ($this->msg != ''):
//    print_r($this);
    echo JText::_($this->msg);
    echo "<br>";
elseif (!$this->salvato):
?>
    <table>
        <tr>
            <td colspan="4" id="info">
                <ul>
                    <li>
                        <label>Nome squadra:</label><input type="text" maxlength="50" name="nome"><br>
                    </li>
                    <li>
                        <label>Immagine squadra:</label><input type="file" name="logo">
                    </li>
                    <li>
                        <div style="height: 88px;width: 100px"><img src="<?=$this->root?>components/com_jfantamanager/images/logo/nologo.png" height="88px"></div>
                        <div class="bottoni">
                             <input type="button" value="Reset" onclick="resetta()"/>
                             <input type="button" value="Selezione casuale" onclick="casuale()"/><br>
                             <input type="submit" value="Accetta"/>
                        </div>
                    </li>
                </ul>
            </td>
            <td id="squadra" rowspan="3">
                <h3 class="title">La mia squadra</h3>
                <table class="body" CELLSPACING="0" CELLPADDING="0">
                    <tr><td>Budget restante: </td><td><span class="valore" id="resto">€ <?=$this->parametri->crediti?></span></td></tr>
                    <tr><td colspan="2"><hr align=left width=100%></td></tr>
                    <tr><td>Valore rosa: </td><td><span class="valore" id="valore">€ 0</span></td></tr>
                    <tr><td colspan="2"><hr align=left width=100%></td></tr>
                    <tr><td>Giocatori: </td><td><span class="conta" id="conta">0</span><span class="conta" id="conta"> su 25</span></td></tr>
                    <tr><td colspan="2"><hr align=left width=100%></td></tr>
                </table>
                <script type="text/javascript">var resto=<?=$this->parametri->crediti?>;var back=resto</script>
                <ul class="main_list">
                <h4>Portieri</h4>
                    <li id="p1" name="p[]"></li>
                    <li id="p2" name="p[]"></li>
                    <li id="p3" name="p[]"></li>
                <h4>Difensori</h4>
                    <li id="p4"  name="p[]"></li>
                    <li id="p5"  name="p[]"></li>
                    <li id="p6"  name="p[]"></li>
                    <li id="p7"  name="p[]"></li>
                    <li id="p8"  name="p[]"></li>
                    <li id="p9"  name="p[]"></li>
                    <li id="p10" name="p[]"> </li>
                    <li id="p11" name="p[]"></li>
                <h4>Centrocampisti</h4>
                    <li id="p12"  name="p[]"></li>
                    <li id="p13"  name="p[]"></li>
                    <li id="p14"  name="p[]"></li>
                    <li id="p15"  name="p[]"></li>
                    <li id="p16"  name="p[]"></li>
                    <li id="p17"  name="p[]"></li>
                    <li id="p18"  name="p[]"></li>
                    <li id="p19"  name="p[]"></li>
                <h4>Attaccanti</h4>
                    <li id="p20"  name="p[]"></li>
                    <li id="p21"  name="p[]"></li>
                    <li id="p22"  name="p[]"></li>
                    <li id="p23"  name="p[]"></li>
                    <li id="p24"  name="p[]"></li>
                    <li id="p25"  name="p[]"></li>
                </ul>
            </td>
        </tr>
        <tr  style="height: 25px;">
            <td onclick="cambia('porta')" id="selP">Portieri</td>
            <td onclick="cambia('difesa')" id="selD">Difensori</td>
            <td onclick="cambia('centro')" id="selC">Centrocampisti</td>
            <td onclick="cambia('attacco')" id="selA">Attaccanti</td>
        </tr>
        <tr>
            <td style="padding-left:0px;padding-right:7px" colspan="4">
                <table id="porta" style="display: block" class="elenco">
                    <tr>
                        <th width="40%">Nome<br>
                            <input type="text" onkeyup="filter(this, 0,'porta')" style="color:black"/>
                        </th>
                        <th width="30%">Squadra<br>
                            <select id="squadre" onchange="filter(this, 1,'porta')">
                                 <option value=""><?php echo JText::_('Tutte le squadre');?></option>
                                 <?php echo JHTML::_('select.options', $this->options, 'text', 'text',"0"); ?>
                            </select>
                        </th>
                        <th width="10%">Valore</th>
                        <th width="20%">Scegli</th>
                    </tr>
                    <?foreach ($this->portieri as $i => $value):?>
                        <tr class="row<?php echo $i % 2; ?>">
                            <td><?=$value->nome?></td>
                            <td><?=$value->squadra?></td>
                            <td align="center"><?=$value->valore_att?></td>
                            <td><input type="button" value="Aggiungi" onclick="inserisci(<? echo "$value->id,'". addslashes($value->nome) ."','$value->pos',$value->valore_att" ?>)"/></td>
                        </tr>
                    <?endforeach;?>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                </table>
                <table id="difesa" style="display: none" class="elenco">
                    <tr>
                        <th width="40%">Nome<br>
                            <input type="text" onkeyup="filter(this, 0,'difesa')" style="color:black"/>
                        </th>
                        <th width="30%">Squadra<br>
                            <select id="squadre" onchange="filter(this, 1,'difesa')">
                                 <option value=""><?php echo JText::_('Tutte le squadre');?></option>
                                 <?php echo JHTML::_('select.options', $this->options, 'text', 'text',"0"); ?>
                            </select>
                        </th>
                        <th width="10%">Valore</th>
                        <th width="20%">Scegli</th>
                    </tr>
                    <?foreach ($this->difensori as $i => $value):?>
                        <tr class="row<?php echo $i % 2; ?>">
                            <td><?=$value->nome?></td>
                            <td><?=$value->squadra?></td>
                            <td align="center"><?=$value->valore_att?></td>
                            <td><input type="button" value="Aggiungi" onclick="inserisci(<? echo "$value->id,'". addslashes($value->nome) ."','$value->pos',$value->valore_att" ?>)"/></td>
                        </tr>
                    <?endforeach;?>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                </table>
                <table id="centro" style="display: none" class="elenco">
                    <tr>
                        <th width="40%">Nome<br>
                            <input type="text" onkeyup="filter(this, 0,'centro')" style="color:black"/>
                        </th>
                        <th width="30%">Squadra<br>
                            <select id="squadre" onchange="filter(this, 1,'centro')">
                                 <option value=""><?php echo JText::_('Tutte le squadre');?></option>
                                 <?php echo JHTML::_('select.options', $this->options, 'text', 'text',"0"); ?>
                            </select>
                        </th>
                        <th width="10%">Valore</th>
                        <th width="20%">Scegli</th>
                    </tr>
                    <?foreach ($this->centrocampisti as $i => $value):?>
                        <tr class="row<?php echo $i % 2; ?>">
                            <td><?=$value->nome?></td>
                            <td><?=$value->squadra?></td>
                            <td align="center"><?=$value->valore_att?></td>
                            <td><input type="button" value="Aggiungi" onclick="inserisci(<? echo "$value->id,'". addslashes($value->nome) ."','$value->pos',$value->valore_att" ?>)"/></td>
                        </tr>
                    <?endforeach;?>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                </table>
                <table id="attacco" style="display: none" class="elenco">
                    <tr>
                        <th width="40%">Nome<br>
                            <input type="text" onkeyup="filter(this, 0,'attacco')" style="color:black"/>
                        </th>
                        <th width="30%">Squadra<br>
                            <select id="squadre" onchange="filter(this, 1,'attacco')">
                                 <option value=""><?php echo JText::_('Tutte le squadre');?></option>
                                 <?php echo JHTML::_('select.options', $this->options, 'text', 'text',"0"); ?>
                            </select>
                        </th>
                        <th width="10%">Valore</th>
                        <th width="20%">Scegli</th>
                    </tr>
                    <?foreach ($this->attaccanti as $i => $value):?>
                        <tr class="row<?php echo $i % 2; ?>">
                            <td><?=$value->nome?></td>
                            <td><?=$value->squadra?></td>
                            <td align="center"><?=$value->valore_att?></td>
                            <td><input type="button" value="Aggiungi" onclick="inserisci(<? echo "$value->id,'". addslashes($value->nome) ."','$value->pos',$value->valore_att" ?>)"/></td>
                        </tr>
                    <?endforeach;?>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <input type="hidden" name="lega" value="<?=$this->lega?>"/>
    <input type="hidden" name="rosa" />
    <input type="hidden" name="resto" />
    <?endif?>
</form>

