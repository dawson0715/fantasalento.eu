<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<th width="5">
		<?php echo JText::_('COM_JFANTAMANAGER_GIOCATORE_HEADING_ID'); ?>
	</th>
	<th width="20">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
	</th>
	<th>
		<?php echo JText::_('COM_JFANTAMANAGER_GIOCATORE_HEADING_NOME'); ?>
	</th>
        <th width="5">
		<?php echo JText::_('COM_JFANTAMANAGER_GIOCATORE_HEADING_VOTO'); ?>
	</th>
        <th>
		<?php echo JText::_('COM_JFANTAMANAGER_GIOCATORE_HEADING_POLITICO'); ?>
	</th>
</tr>
