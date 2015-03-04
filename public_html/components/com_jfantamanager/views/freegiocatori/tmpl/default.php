<?php defined('_JEXEC') or die('Restricted access'); ?>
    <table>  
        <tr>
            <td colspan="4">
                <h2 style="float: none;width: 670px;margin-bottom: 5px">LISTA GIOCATORI LIBERI</h2>
                <dl class="legenda-2">
                    <dt>Legenda</dt>
                    <dd>
                        <strong>P</strong> = Partite Giocate</dd>
                    <dd>
                        <strong>M</strong> = Media Voto</dd>
                    <dd>
                        <strong>F</strong> = Fanta Media</dd>
                    <dd>
                        <strong>Gs</strong> = Gol Subit</dd>
                    <dd>
                        <strong>G</strong> = Gol Segnato</dd>
                    <dd>
                        <strong>Rs</strong> = Rigore Sbagliato</dd>
                    <dd>
                        <strong>Rp</strong> = Rigore Parato</dd>
                    <dd>
                        <strong>As</strong> = Assist</dd>
                    <dd>
                        <strong>A</strong> = Ammonizione</dd>
                    <dd>
                        <strong>E</strong> = Espulsione</dd>
                </dl>
            </td>
        </tr>
        <tr  style="height: 25px;margin-top: 5px">
            <td onclick="cambia('porta')" id="selP">Portieri</td>
            <td onclick="cambia('difesa')" id="selD">Difensori</td>
            <td onclick="cambia('centro')" id="selC">Centrocampisti</td>
            <td onclick="cambia('attacco')" id="selA">Attaccanti</td>
        </tr>
        <tr>
            <td style="padding-left:0px;padding-right:7px;width: 100%" colspan="4">
                <table id="porta" class="lista">
                    <tr>
                        <th colspan='2'>PORTIERI
                        <select id="squadre" onchange="filter(this, 1,'porta')">
                                <option value=""><?php echo JText::_('Tutte le squadre');?></option>
                                <?php echo JHTML::_('select.options', $this->options, 'text', 'text',"0"); ?>
                        </select>
                        </th><th>P</th><th>M</th><th>FM</th><th>Gs</th><th>Rp</th><th>As</th><th>A</th><th>E</th>
                    </tr>
                    <?foreach ($this->portieri as $i => $row)
                        echo "<tr class='riga".($i % 2)."'>
                                <td class='squadra_nome'>$row->nome</td>
                                <td class='squadra'>$row->squadra</td>
                                <td class='N'>".SP($row->P)."</td>
                                <td class='N'>".round($row->V/$row->P,2)."</td>
                                <td class='N'>".round($row->T/$row->P,2)."</td>
                                <td ".(($row->pos=='P')?"class='Gs'>".SP($row->Gs):"class='G'>".SP($row->G))."</td>
                                <td ".(($row->pos=='P')?"class='Rp'>".SP($row->Rp):"class='Rs'>".SP($row->Rs))."</td>
                                <td class='As'>".SP($row->Ass)."</td>
                                <td class='A'>".SP($row->A)."</td>
                                <td class='E'>".SP($row->E)."</td>                            
                            </tr>";
                    ?>
                </table>
                <table id="difesa" class="lista">
                    <tr>
                        <th colspan='2'>DIFENSORI
                        <select id="squadre" onchange="filter(this, 1,'difesa')">
                                <option value=""><?php echo JText::_('Tutte le squadre');?></option>
                                <?php echo JHTML::_('select.options', $this->options, 'text', 'text',"0"); ?>
                        </select>
                        </th><th>P</th><th>M</th><th>FM</th><th>Gs</th><th>Rp</th><th>As</th><th>A</th><th>E</th>
                    </tr>
                    <?foreach ($this->difensori as $i => $row)
                        echo "<tr class='riga".($i % 2)."'>
                                <td class='squadra_nome'>$row->nome</td>
                                <td class='squadra'>$row->squadra</td>
                                <td class='N'>".SP($row->P)."</td>
                                <td class='N'>".round($row->V/$row->P,2)."</td>
                                <td class='N'>".round($row->T/$row->P,2)."</td>
                                <td ".(($row->pos=='P')?"class='Gs'>".SP($row->Gs):"class='G'>".SP($row->G))."</td>
                                <td ".(($row->pos=='P')?"class='Rp'>".SP($row->Rp):"class='Rs'>".SP($row->Rs))."</td>
                                <td class='As'>".SP($row->Ass)."</td>
                                <td class='A'>".SP($row->A)."</td>
                                <td class='E'>".SP($row->E)."</td>                            
                            </tr>";
                    ?>
                </table>
                <table id="centro" class="lista">
                    <tr>
                        <th colspan='2'>CENTROCAMPISTI
                        <select id="squadre" onchange="filter(this, 1,'centro')">
                                <option value=""><?php echo JText::_('Tutte le squadre');?></option>
                                <?php echo JHTML::_('select.options', $this->options, 'text', 'text',"0"); ?>
                        </select>
                        </th><th>P</th><th>M</th><th>FM</th><th>Gs</th><th>Rp</th><th>As</th><th>A</th><th>E</th>
                    </tr>
                    <?foreach ($this->centrocampisti as $i => $row)
                        echo "<tr class='riga".($i % 2)."'>
                                <td class='squadra_nome'>$row->nome</td>
                                <td class='squadra'>$row->squadra</td>
                                <td class='N'>".SP($row->P)."</td>
                                <td class='N'>".round($row->V/$row->P,2)."</td>
                                <td class='N'>".round($row->T/$row->P,2)."</td>
                                <td ".(($row->pos=='P')?"class='Gs'>".SP($row->Gs):"class='G'>".SP($row->G))."</td>
                                <td ".(($row->pos=='P')?"class='Rp'>".SP($row->Rp):"class='Rs'>".SP($row->Rs))."</td>
                                <td class='As'>".SP($row->Ass)."</td>
                                <td class='A'>".SP($row->A)."</td>
                                <td class='E'>".SP($row->E)."</td>                            
                            </tr>";
                    ?>
                </table>
                <table id="attacco" class="lista">
                    <tr>
                        <th colspan='2'>ATTACCANTI
                        <select id="squadre" onchange="filter(this, 1,'attacco')">
                                <option value=""><?php echo JText::_('Tutte le squadre');?></option>
                                <?php echo JHTML::_('select.options', $this->options, 'text', 'text',"0"); ?>
                        </select>
                        </th><th>P</th><th>M</th><th>FM</th><th>Gs</th><th>Rp</th><th>As</th><th>A</th><th>E</th>
                    </tr>
                    <?foreach ($this->attaccanti as $i => $row)
                        echo "<tr class='riga".($i % 2)."'>
                                <td class='squadra_nome'>$row->nome</td>
                                <td class='squadra'>$row->squadra</td>
                                <td class='N'>".SP($row->P)."</td>
                                <td class='N'>".round($row->V/$row->P,2)."</td>
                                <td class='N'>".round($row->T/$row->P,2)."</td>
                                <td ".(($row->pos=='P')?"class='Gs'>".SP($row->Gs):"class='G'>".SP($row->G))."</td>
                                <td ".(($row->pos=='P')?"class='Rp'>".SP($row->Rp):"class='Rs'>".SP($row->Rs))."</td>
                                <td class='As'>".SP($row->Ass)."</td>
                                <td class='A'>".SP($row->A)."</td>
                                <td class='E'>".SP($row->E)."</td>                            
                            </tr>";
                    ?>
                </table>
            </td>
        </tr>
    </table>
<?
function SP($n)
{
    if($n > 0)
        return $n;
    else 
        return "-";
}
function cmp($P)
{
    if ($P=="D")
        return "DIFENSORI";
    if ($P=="C")
        return "CENTROCAMPISTI";
    if ($P=="A")
        return "ATTACCANTI";
}
?>