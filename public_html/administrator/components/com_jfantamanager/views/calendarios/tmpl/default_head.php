<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<th width="20">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
	</th>			
	<th>
		<?php echo JText::_('COM_FANTACALCIO_CALENDARIOS_HEADING_GIORNATA'); ?>
	</th>
        <th width="5">
		<?php echo JText::_('COM_FANTACALCIO_CALENDARIOS_HEADING_GIOCATA'); ?>
	</th>
        <th>
		<?php echo JText::_('COM_FANTACALCIO_CALENDARIOS_HEADING_DATA'); ?>
	</th>
        <th>
		<?php echo JText::_('COM_FANTACALCIO_CALENDARIOS_HEADING_ORA'); ?>
	</th>
</tr>
