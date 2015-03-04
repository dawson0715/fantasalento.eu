<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_jfantamanager&view=voto&tmpl=component'); ?>" method="post" name="adminForm">
        <label><?php echo JText::_('COM_FANTACALCIO_VOTO_INSERT_LABEL');?></label>
        <select name="filter_giornata" class="inputbox" onchange="this.form.submit()">
             <?php echo JHtml::_('select.options', $this->options, 'value', 'text', $this->state->get('filter.giornata'));?>
        </select>
        <label><?php echo JText::_('COM_FANTACALCIO_VOTO_POLITIC_SQUADRA');?></label>
        <select name="pSquadra" class="inputbox">
            <option value=""><?php echo JText::_('COM_FANTACALCIO_VOTO_FILTER_TEAMS');?></option>
             <?php echo JHtml::_('select.options', $this->squadra, 'text', 'text',0);?>
        </select>
        <button onclick="javascript:Joomla.submitbutton('voto.inserisci')"><?php echo JText::_('COM_FANTACALCIO_VOTO_INSERISCI');?></button>
	<table class="adminlist">
		<thead><?php echo $this->loadTemplate('head');?></thead>
		<tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
		<tbody><?php echo $this->loadTemplate('body');?></tbody>
	</table>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
