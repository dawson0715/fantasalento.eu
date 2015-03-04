<?php defined('_JEXEC') or die('Restricted access'); ?>
    <table>    
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