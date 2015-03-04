<?php defined('_JEXEC') or die('Restricted access'); ?>
<table class="init">
    <tr style="height: 25px">
        <td onclick="cambia('porta')" id="selP">Portieri</td>
        <td onclick="cambia('difesa')" id="selD">Difensori</td>
        <td onclick="cambia('centro')" id="selC">Centrocampisti</td>
        <td onclick="cambia('attacco')" id="selA">Attaccanti</td>
        <td id="squadra" rowspan="3">
            <h3 class="title">La mia squadra</h3>
            <div class="body">
                <label>Valore rosa: </label><span class="valore" id="valore">€ 0</span>
                <hr align=left width=98%>
                <label>Giocatori: </label><span class="conta" id="conta">0</span><span class="conta"> su 25</span>
<!--                <hr align=left width=98%>-->
            </div>
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
    <tr>
        <td style="padding-left:0px;padding-right:7px;vertical-align: top" colspan="4">
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
                <?foreach ($this->posizione['P'] as $i => $value):?>
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
                <?foreach ($this->posizione['D'] as $i => $value):?>
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
                <?foreach ($this->posizione['C'] as $i => $value):?>
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
                <?foreach ($this->posizione['A'] as $i => $value):?>
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
<input type="hidden" name="rosa" />
<input type="hidden" name="resto" />
