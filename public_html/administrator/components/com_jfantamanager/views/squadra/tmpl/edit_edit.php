<table class="Giocatorilist" cellspacing="0">
    <thead>
        <tr><th>#</th><th>Giocatore</th><th>Val.</th><th>Data</th></tr>
    </thead>
    <tr><th class='tit' colspan='4'>PORTIERI</th></tr>
<?php
foreach ($this->lista as $i => $giocatore)
{
  echo ($i==3)?"<tr><th class='tit' colspan='4'>DIFENSORI</th></tr>":"";
  echo ($i==11)?"<tr><th class='tit' colspan='4'>CENTROCAMPISTI</th></tr>":"";
  echo ($i==19)?"<tr><th class='tit' colspan='4'>ATTACCANTI</th></tr>":"";
  echo ($i==25)?"<tr><th class='tit' colspan='4'>VENDUTI</th></tr>":"";
  echo "<tr class='row".($i % 2)."'>
              <td width=5>";
              if($i>=25)
                  echo "<img height='20px' src='".JURI::root()."/components/com_jfantamanager/images/out.png'>";
              else
                  echo "  <a id='data' class='modal' href='index.php?option=com_jfantamanager&view=giocatore&tmpl=component&giocatore_id=$giocatore->id&squadra_id=$this->squadra_id' rel=\"{handler: 'iframe', size: {x: 600, y: 450}}\">
                            <span class='hasTip' title=\"tip title::tip text\"><img height='20px' src='".JURI::root()."/components/com_jfantamanager/images/in.png'></span>
                        </a>";
              echo "</td>
              <td>
                    $giocatore->nome
              </td>
              <td>
                    $giocatore->valore_acq
              </td>
              <td>
                    $giocatore->data_acq
              </td>
        </tr>";
}
?>
</table>
<style type="text/css">
    .Giocatorilist{width: 350px;border: 1px solid #DEDEDE}
    .Giocatorilist thead tr th{background-image: url("/images/header.gif")}
    .Giocatorilist td{padding: 1px 3px;}
    .Giocatorilist tr.row1{background-color: #DEDEDE}
    .Giocatorilist .tit {background-color: lightblue;padding: 2px 0px;font-size: 14px;font-weight: bold;height: 18px;text-indent: 10px;}
</style>
<!-- <input type='text' value='$giocatore->valore_acq' name='rosa[$giocatore->id]' READONLY />
<select name='scelto[$giocatore->id]'>
    ".JHtml::_('select.options', $this->posizione[$giocatore->pos], 'value', 'text', $giocatore->id)."
</select>
-->