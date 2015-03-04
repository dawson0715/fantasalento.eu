<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_jfantamanager&view=squadras'); ?>" method="post" name="adminForm">
        <label><?php echo JText::_('COM_FANTACALCIO_LEGA_FILTER_LABEL');?></label>
        <select name="filter_lega" class="inputbox" onchange="this.form.submit()">
             <option value=""><?php echo JText::_('COM_FANTACALCIO_LEGA_FILTER_PAGE');?></option>
             <?php echo JHtml::_('select.options', $this->options, 'value', 'text', $this->state->get('filter.lega'));?>
        </select>
	<table class="adminlist">
		<thead><?php echo $this->loadTemplate('head');?></thead>
		<tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
		<tbody><?php echo $this->loadTemplate('body');?></tbody>
	</table>
	<div>
                <input type="hidden" name="filter_lega" value="<?=$_GET['filter_lega']?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
