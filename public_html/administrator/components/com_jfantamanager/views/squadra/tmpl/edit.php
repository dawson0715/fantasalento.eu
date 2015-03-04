<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

JHtml::_('behavior.tooltip');

?>
<form action="<?php echo JRoute::_('index.php?option=com_jfantamanager&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="squadra-form">
    <div class="width-50 fltlft">
        <fieldset class="adminform">
            <legend><?php echo JText::_( 'COM_FANTACALCIO_SQUADRA_DETAILS' ); ?></legend>
            <ul class="adminformlist">
                <?php foreach($this->form->getFieldset() as $field): ?>
                <li><?php echo $field->label;echo $field->input;?></li>
                <?php endforeach; ?>
            </ul>
	</fieldset>
    </div>
    <div class="width-50 fltrt">
        <div class="pane-sliders" id="contact-slider">
            <div class="panel">
                <h3 id="publishing-details" class="title pane-toggler-down"><a href="javascript:void(0);"><span><?php echo JText::_( 'COM_FANTACALCIO_SQUADRA_LIST' ); ?></span></a></h3>
                <div class="pane-slider content pane-down" style="padding-top: 0px; border-top: medium none; padding-bottom: 0px; border-bottom: medium none; overflow: hidden; height: auto;">
                    <fieldset class="panelform">
                              <?
                              if($this->isnew)
                                  echo $this->loadTemplate('new');
                              else
                                  echo $this->loadTemplate('edit');
                              ?>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    <div>   <input type="hidden" name="news" value="<?=$this->isnew?>" />
            <input type="hidden" name="task" value="squadra.edit" />
            <?php echo JHtml::_('form.token'); ?>
    </div>
</form>
