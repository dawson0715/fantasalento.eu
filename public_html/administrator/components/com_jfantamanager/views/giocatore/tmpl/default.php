<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_jfantamanager&view=giocatore&layout=edit'); ?>" method="post" name="adminForm" id="helloworld-form">
    <div class="width-100 fltlft">
        <fieldset class="panelform">
            <legend><?php echo JText::_( 'SQUADRA' ); ?></legend>
            <ul class="adminformlist">
                    <?php foreach($this->form->getFieldset('squadra') as $field): ?>
                    <li><?php echo $field->label;echo $field->input;?></li>
                    <?php endforeach; ?>
            </ul>
        </fieldset>
    </div>
    <div class="fltlft" style="width: 280px;background-image: url('<?=JURI::root();?>components/com_jfantamanager/images/scambia.png')">
        <fieldset class="panelform">
            <legend><?php echo JText::_( 'OUT' ); ?></legend>
            <ul class="adminformlist">
                    <?php foreach($this->form->getFieldset('giocatore_in') as $field): ?>
                    <li><?php echo $field->label;echo $field->input;?></li>
                    <?php endforeach; ?>
            </ul>
        </fieldset>
    </div>
    <div class="fltlft" style="width: 280px;background-image: url('<?=JURI::root();?>components/com_jfantamanager/images/scambia.png');background-position: 280px 0">
        <fieldset class="panelform"><!-- COM_FANTACALCIO_GIOCATORE_CHANGE -->
            <legend><?php echo JText::_( 'IN' ); ?></legend>
            <ul class="adminformlist">
                <?php foreach($this->form->getFieldset('giocatore_out') as $field): ?>
                <li><?php echo $field->label;echo $field->input;?></li>
                <?php endforeach; ?>
            </ul>
            <div class="button2-left" style="margin-left: 70px;height: 28px;">
                <div class="blank">
                    <a onclick="javascript:Joomla.submitbutton('giocatore.save')" href="#">
                        Scambia</a>
                </div>
            </div>
            <div class="button2-left">
                <div class="blank">
                    <a onclick="chiudi()" href="#">
                        Annulla</a>
                </div>
            </div>
	</fieldset>
    </div>
    <div class="width-100 fltlft">
        <fieldset class="panelform">
            <legend><?php echo JText::_( 'TABLE' ); ?></legend>
            <? echo $this->loadTemplate('new'); ?>
	</fieldset>
    </div>
    <div>
            <input type="hidden" name="task" value="giocatore.edit" />
            <input type="hidden" name="squadra_id" value="<?=$this->item->squadra_id?>" />
            <?php echo JHtml::_('form.token'); ?>
    </div>
</form>
<script type="text/javascript">
    function chiudi()
    {
        parent.SqueezeBox.close();
    }
</script>
<?
//   print_r($this);
?>