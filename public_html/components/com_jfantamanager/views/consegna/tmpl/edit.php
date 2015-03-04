<?php defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript" language="JavaScript">
    var modificatore    = <?=$this->parametri->modificatore?>;
    var panchina        = <?=$this->parametri->p_fissa?>;
    var formazione      = new Array(<?=($this->permessi['inserita']>0)?$this->lista:"18"?>)
    var draw_in         = new Array("portiere","difesa","centro","attacco")
    var vet_mod = new Array (new Array (1,3,4,3),new Array (1,3,5,2),new Array (1,4,3,3),new Array (1,4,4,2),new Array (1,5,3,2),new Array (1,5,4,1),new Array (1,6,3,1))
    var modulo_scelto;
    //     var trova = new Array ({ "D": 0, "C": 1,"A":2});

</script>
<div style=" border-top: 1px solid #999999;height: 5px"></div>
<form name="f1" id="scelte" action="index.php?option=com_jfantamanager&view=consegna&layout=edit" style="color: black; line-height: 100%" method="post" target="_self" onsubmit="return inviaform()">
    <table class="intesta">
        <tr>
            <td style="width: 195px" rowspan="2"><b><?=$this->dati['nome']?></b><br/><img src="/<?=$this->dati['logo']?>"><br/></td>
            <td><span class='titolo'>CONSEGNA FORMAZIONE PER LA <?=$this->permessi['giornata']?>° GIORNATA</span></td>
        </tr>
        <tr>
            <td style="vertical-align: bottom">
                Modulo:
                <select id="modulo" onchange="show_mod(this.selectedIndex)" name="sc_formazione">
                    <option value="0">Seleziona</option>
                    <option value="1">3-4-3</option>
                    <option value="2">3-5-2</option>
                    <option value="3">4-3-3</option>
                    <option value="4">4-4-2</option>
                    <option value="5">5-3-2</option>
                    <option value="6">5-4-1</option>
                    <option value="7">6-3-1</option>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="reset" value="Reset" onclick="resetta()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" value="Accetta">
            </td>
        </tr>
    </table>
    <div style=" border-top: 1px solid #999999;height: 5px"></div>
    <table><tr>
        <td>
            <div style="color: white; background-color: black; padding: 5px 0 0 5px">
                <input type="checkbox" name="vis" onclick="mostra()"><label>Probabili formazioni</label>
                <input type="checkbox" name="help"><label>Help</label>
            </div>
            <div class="ext_top" style="color:white"><span>LA TUA ROSA</span></div>
            <div class="ext_mid" >
                <div class="int_mid">
                    <table style="width:155px" id="lista">
                        <?php
                            $i=0;
                            foreach($this->squadra as $row)
                            {
                        ?>
                                <tr>

                                    <td class="giocatore" onclick="scrivi(<?=$row->id?>,'<?=$row->pos?>','<?=  addslashes($row->nome)?>','<?=  addslashes($row->squadra)?>')" id="list_<?=$row->id?>"><?echo "$row->pos - $row->nome";?></td>
                                </tr>
                        <?php
                                $i++;
                            }
                        ?>
                    </table>
                </div>
            </div>
        </td>
        <td valign="top">
            <div style="background-image:URL('<?=$this->root?>components/com_jfantamanager/images/campo.jpg');width:450px;height:400px"><center>
                <table class="campo">
                    <tr>
                        <td>
                    <!--<td class="modulo_ext">

                            Modulo:
                            <select id="modulo" onchange="show_mod(this.selectedIndex)" name="sc_formazione">
                                <option value="0">Seleziona</option>
                                <option value="1">3-4-3</option>
                                <option value="2">3-5-2</option>
                                <option value="3">4-3-3</option>
                                <option value="4">4-4-2</option>
                                <option value="5">5-3-2</option>
                                <option value="6">5-4-1</option>
                                <option value="7">6-3-1</option>
                            </select><br><br>
                            <input type="reset" value="Reset" onclick="resetta()">
                            <input type="submit" value="Accetta">-->
                        </td>
                        <td id="portiere" width="150px">
                        </td>
                        <td width="150px">
                            <div id="mod_active" style="display: none"><img src="" alt="O">Modificatore attivo</div>
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
            </table></center>
            </div>
            <div style="background-color: black; color:white; padding: 5px 0px 0px 10px;font-size: 15px;width: 440px">PANCHINA</div>
            <div class="panchina_out">
                <table class="panchina_in">
    <!--                    <tr class="campo">
                        <td id="portiere1" width="65px"></td>
                        <td id="difesa1" width="65px"></td>
                        <td id="centro1" width="65px"></td>
                        <td id="attacco1" width="65px"></td>
                    </tr>
                    <tr class="campo">
                        <td id="portiere2"></td>
                        <td id="difesa2"></td>
                        <td id="centro2"></td>
                        <td id="attacco2"></td>
                    </tr>-->
                    <tr>
                        <td id="panchina0" width="65px"></td>
                        <td id="panchina1" width="65px"></td>
                        <td id="panchina2" width="65px"></td>
                        <td id="panchina3" width="65px"></td>
                    </tr>
                    <tr>
                        <td id="panchina"></td>
                        <td id="panchina4"></td>
                        <td id="panchina5"></td>
                        <td id="panchina6"></td>
                    </tr>
                </table>
                <div  class="panchina_foot">
                </div>
            </div>
        </td>
    </tr>
    </table>
</form>
<div style=" border-bottom: 1px solid #999999;height: 5px"></div>