<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<th width="5">
		<?php echo JText::_('COM_JFANTAMANAGER_SQUADRAS_HEADING_ID'); ?>
	</th>
	<th width="20">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
	</th>
        <th>
		<?php echo JText::_('COM_JFANTAMANAGER_SQUADRAS_HEADING_LOGO'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_JFANTAMANAGER_SQUADRAS_HEADING_NOME'); ?>
	</th>
        <th width="5">
		<?php echo JText::_('COM_JFANTAMANAGER_SQUADRAS_HEADING_PERMESSO'); ?>
	</th>
        <th>
		<?php echo JText::_('COM_JFANTAMANAGER_SQUADRAS_HEADING_CAMBI'); ?>
	</th>
        <th>
		<?php echo JText::_('COM_JFANTAMANAGER_SQUADRAS_HEADING_BILANCIO'); ?>
	</th>

</tr>
