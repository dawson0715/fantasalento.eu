<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
JHtml::_('behavior.tooltip');
JHtml::_('behavior.keepalive');
?>
<form action="<?php echo JRoute::_('index.php?option=com_jfantamanager&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm">
    <div class="width-60 fltlft">
	<fieldset class="adminform">
            <legend><?php echo JText::_( 'COM_FANTACALCIO_GLOBAL_DETAIL' ); ?></legend>
		<ul class="adminformlist">
                    <?php foreach($this->form->getFieldset() as $field): ?>
                    <li><?php echo $field->label;echo $field->input;?></li>
                    <?php endforeach; ?>
		</ul>
	</fieldset>
    </div>

    <div class="width-40 fltrt">
        <div class="pane-sliders" id="menu-sliders-">
            <div style="display:none;">
                <div>	</div>

            </div>
            <div class="panel">
                <h3 id="request-options" class="title pane-toggler-down">
                    <a href="javascript:void(0);"><span>Impostazioni richieste</span></a>
                </h3>
                <div class="pane-slider content pane-down" style="padding-top: 0px; border-top: medium none; padding-bottom: 0px; border-bottom: medium none; overflow: hidden; height: auto;">
                    <fieldset class="panelform">


                    </fieldset>
                </div>
            </div>
        </div>
        <div>
		<input type="hidden" name="task" value="lega.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</div>
</form>