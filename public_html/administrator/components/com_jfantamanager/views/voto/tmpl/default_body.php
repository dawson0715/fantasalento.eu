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
                        <?php echo $item->pos .") ". $item->nome; ?>
		</td>
                <td>
			<?php echo $item->voto; ?>
		</td>
                <td>
                        <?php if ($item->presente) : ?>
                                <?php echo JHtml::_('grid.boolean', $i, $item->presente, 'voto.nonpolitico', 'voto.nonpolitico'); ?>
                        <?php else : ?>
                                <?php echo JHtml::_('grid.boolean', $i, $item->presente, 'voto.politico', 'voto.politico'); ?>
                        <?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
