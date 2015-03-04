<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo $item->id; ?>
		</td>
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
			<?php echo "<img src='/$item->logo' height='50px' width='50px'/>"; ?>
		</td>
                <td>
                    <?php echo $item->nome; ?>
<!--                    <a href="index.php?option=com_jfantamanager&view=squadra&layout=edit&id=<?=$item->id?>" title="<?php echo JText::sprintf('COM_JFANTAMANAGER_EDIT_SQUADRAS_TEAM', $this->escape($item->nome)); ?>" >
			<?php echo $item->nome; ?>
                    </a>-->
		</td>
                <td>
                    <img src="<?=JURI::root();?>components/com_jfantamanager/images/permesso_<?=$item->permesso?>.gif" height="20px"/>
		</td>
                <td>
			<?php echo $item->cambi; ?>
		</td>
                <td>
			<?php echo $item->bilancio; ?>
		</td>
	</tr>
<?php endforeach; ?>
