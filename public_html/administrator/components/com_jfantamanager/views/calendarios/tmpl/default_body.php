<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->giornata); ?>
		</td>
		<td>
			<?php echo $item->giornata; ?>
		</td>
                <td>
                        <?php if ($item->giocata) : ?>
                                <?php echo JHtml::_('grid.boolean', $i, $item->giocata, 'legas.nongiocata', 'legas.nongiocata'); ?>
                        <?php else : ?>
                                <?php echo JHtml::_('grid.boolean', $i, $item->giocata, 'legas.giocata', 'legas.giocata'); ?>
                        <?php endif; ?>
		</td>
                <td>
			<?php echo $item->data; ?>
		</td>
                <td>
			<?php echo $item->ora; ?>
		</td>
	</tr>
<?php endforeach; ?>
