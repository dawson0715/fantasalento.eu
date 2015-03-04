<? defined('_JEXEC') or die('Restricted access'); ?>
<table class="giocatori">
    <tr>
        <th width="5">
		<?php echo JText::_('COM_FANTACALCIO_GIOCATORE_HEADING_POS'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_FANTACALCIO_GIOCATORE_HEADING_NOME'); ?>
	</th>
        <th>
		<?php echo JText::_('COM_FANTACALCIO_GIOCATORE_HEADING_SQUADRA'); ?>
	</th>
        <th>
		<?php echo JText::_('COM_FANTACALCIO_GIOCATORE_HEADING_VALORE_ATT'); ?>
	</th>
    </tr>
    <? foreach($this->table as $i => $riga): ?>
        <tr class="row<?php echo $i % 2; ?>">
                <td>
			<?php echo $riga->pos; ?>
		</td>
                <td>
                    <a href="#" onclick="seleziona(<? echo "$riga->id,'".addslashes($riga->nome)."','$riga->squadra',$riga->valore_att" ?>)">
                    	<?php echo $riga->nome; ?>
                    </a>
		</td>
		<td>
			<?php echo $riga->squadra; ?>
		</td>
                <td>
			<?php echo $riga->valore_att; ?>
		</td>
	</tr>
    <? endforeach; ?>
</table>
<script type="text/javascript">
    
//    window.addEvent('domready', function(){
//        $('jform_modifica').addEvent('click', function(event){
//            $('jform_valore_acq').set('readonly','').set('class','')
//            $('jform_data_acq').set('readonly','').set('class','')
//            
//        });
//    });
    
    function seleziona(id,nome,squadra,valore)
    {
        document.getElementById('jform_new_giocatore_id').value=id;
        document.getElementById('jform_new_nome').value=nome;
        document.getElementById('jform_new_squadra').value=squadra;
        document.getElementById('jform_new_valore_acq').value=valore;
        document.getElementById('jform_new_data_acq').value='<?=date('Y-m-d')?>';
    }
</script>
<style type="text/css">
    .giocatori{width: 100%}
</style>
<!--SELEZIONO UN GIOCATORE DALLA LISTA DEI DISPONIBILI MENO I MIEI
CONTROLLO SE NON HO RAGGIUNTO IL MASSIMO DELLA POSIZIONE
CONTROLLO SE NON HO RAGGIUNTO IL MASSIMO DEI GIOCATORI
ALTRIMENTI INSERISCO UNA NUOVA RIGA NELLA TABELLA fanta_possiede -->