<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_jfantamanager&layout=edit&giornata='.(int) $this->item->giornata); ?>" method="post" name="adminForm" id="helloworld-form">
    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend><?php echo JText::_( 'COM_FANTACALCIO_CALENDARIO_DETAILS' ); ?></legend>
            <ul class="adminformlist">
                <?php foreach($this->form->getFieldset() as $field): ?>
                <li><?php echo $field->label;echo $field->input;?></li>
                <?php endforeach; ?>
            </ul>
	</fieldset>
    </div>
    <div class="width-40 fltrt">
        <fieldset class="panelform">
                <ul class="adminformlist">
                    
		</ul>
        </fieldset>
    </div>
    <div>
            <input type="hidden" name="task" value="calendario.edit" />
            <?php echo JHtml::_('form.token'); ?>
    </div>
</form>
<?
//print_r($this);
?>