<?php defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript" language="JavaScript">
    var modificatore    = <?=$this->parametri->modificatore?>;
    var panchina        = <?=$this->parametri->p_fissa?>;
    var formazione      = new Array(<?=($this->permessi['inserita']>0 || $this->salvato)?$this->lista:"18"?>)
    var draw_in         = new Array("portiere","difesa","centro","attacco")
    var vet_mod         = new Array (<?=$this->js_moduli?>)
    //var vet_mod = new Array (new Array (1,3,4,3),new Array (1,3,5,2),new Array (1,4,3,3),new Array (1,4,4,2),new Array (1,5,3,2),new Array (1,5,4,1),new Array (1,6,3,1))
    
    var modulo_scelto<?=($this->old_index!="")?"=vet_mod[$this->old_index]":"=''"?>;
    
    //     var trova = new Array ({ "D": 0, "C": 1,"A":2});
    
</script>
<div style=" border-top: 1px solid #999999;height: 5px"></div>
<form name="f1" id="scelte" action="index.php?option=com_jfantamanager&view=consegna" style="color: black; line-height: 100%" method="post" target="_self" onsubmit="return inviaform()">
    <table class="intesta" onload="riga()">
        <tr>
            <td style="width: 195px" rowspan="2"><b><?=$this->dati['nome']?></b><br/><img src="/<?=$this->dati['logo']?>" height="80px"><br/></td>
            <td>
                <?if($this->salvato && $this->dati['pagato']>0):?>                 
                    <div class="msg">
                        Ti ricordo che devi pagare ancora <?=(int)$this->dati['pagato']?>€ entro il 31/12/2011 
                        altrimenti morirai di dissenteria, soffrendo e urlando, e perderai anche 3 
                        punti per ogni giornata successiva in cui risulti inadempiente
                    </div><br/>
                <? endif;?>
                <span class='titolo'>CONSEGNA FORMAZIONE PER LA <?=$this->permessi['giornata']?>° GIORNATA</span>
                
            </td>
        </tr>
        <tr>
            <td style="vertical-align: bottom">
                Modulo:
                    <?php echo JHTML::_('select.genericlist', $this->options, 'sc_formazione', 'onchange="show_mod(this.selectedIndex)"', 'value', 'text'); ?>
                <input type="reset" value="Reset" onclick="resetta()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" value="Accetta">
<!--//                           INIZIO FACEBOOK SHARE-->



<div id='fb-root'></div>
    <script src='http://connect.facebook.net/en_US/all.js'></script>
    <p><a onclick='postToFeed(); return false;'>Post to Feed</a></p>
    <p id='msg'></p>

    <script> 
      FB.init({appId: "301448259962760	", status: true, cookie: true});

      function postToFeed() {

        // calling the API ...
        var obj = {
          method: 'feed',
          link: 'http://www.fantasalento.it',
//          picture: 'http://fbrell.com/f8.jpg',
          name: 'Fanatasalento',
          caption: 'Reference Documentation',
          description: 'Using Dialogs to interact with users.'
        };

        function callback(response) {
          document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
        }

        FB.ui(obj, callback);
      }
    
    </script>




<!--//                           FINE FACEBOOK SHARE-->
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
                            $indice=0;
                            $i=0;
                            foreach($this->squadra as $row)
                            {
                        ?>
                                <tr>
                                    <td class="giocatore" onclick="scrivi(<?=$row->id?>,'<?=$row->pos?>','<?=addslashes(substr($row->nome,0,13))?>','<?=  addslashes($row->squadra)?>')" id="list_<?=$row->id?>"><?echo "$row->pos - ".substr($row->nome,0,13) ;?></td>
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
                        <td width="150px"><input type="hidden" name="txt_formazione" value=""/>
                        </td>
                        <td id="portiere" width="150px"><?=$this->old_team[$indice]?>
                        </td>
                        <td width="150px">
                            <div id="mod_active" style="display: none">
                                <img src="<?=$this->root?>components/com_jfantamanager/images/modificatore.png" alt="Modificatore attivo" height="50px" width="60px">
                                <br>MODIFICATORE ATTIVO
                            </div>
                        </td>
                    </tr>
            </table>
            <table  class="campo" >
                <tr id="difesa">
                    <?
                        for($i=1;$i<=$this->old_modulo[1];$i++)
                        {
                            $indice++;
                            echo "<td>". $this->old_team[$indice] ."</td>";
                        }
                        
                    ?>
                </tr>
            </table>
            <table class="campo" >
                <tr id="centro">
                    <?
                        for($i=1;$i<=$this->old_modulo[2];$i++)
                        {
                            $indice++;
                            echo "<td>". $this->old_team[$indice] ."</td>";
                        }
                    ?>
                </tr>
            </table>
            <table  class="campo">
                <tr  id="attacco">
                    <?
                        for($i=1;$i<=$this->old_modulo[3];$i++)
                        {
                            $indice++;
                            echo "<td>". $this->old_team[$indice] ."</td>";
                        }
                    ?>
                </tr>
            </table></center>
            </div>
            <div style="background-color: black; color:white; padding: 5px 0px 0px 10px;font-size: 15px;width: 440px">PANCHINA</div>
            <div class="panchina_out">
                <table class="panchina_in">
                    <tr>
                        <td id="panchina0" width="65px"><?=$this->old_team[11]?></td>
                        <td id="panchina1" width="65px"><?=$this->old_team[12]?></td>
                        <td id="panchina2" width="65px"><?=$this->old_team[13]?></td>
                        <td id="panchina3" width="65px"><?=$this->old_team[14]?></td>
                    </tr>
                    <tr>
                        <td id="panchina"></td>
                        <td id="panchina4"><?=$this->old_team[15]?></td>
                        <td id="panchina5"><?=$this->old_team[16]?></td>
                        <td id="panchina6"><?=$this->old_team[17]?></td>
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
<script type="text/javascript">
<?if($this->salvato):?>
    alert("Formazione salvata correttamente");
<?endif;?>
<?if($this->old_index!=""):?>
    for(i=0;i<18;i++)
        {
            document.getElementById("list_"+formazione[i]).style.textDecoration="line-through"
            document.getElementById("list_"+formazione[i]).style.color="green"  
            document.forms.f1.sc_formazione.selectedIndex =<?=($this->old_index+1)?>
        }
<?endif;?>
</script>
