<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_jfantamanager'); ?>" method="post" name="adminForm">
        Calcola voti della giornata:<select name="giornale" class="inputbox" >
             <?php echo JHtml::_('select.options', $this->options, 'value', 'text',$this->giorno);?>
        </select>
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
