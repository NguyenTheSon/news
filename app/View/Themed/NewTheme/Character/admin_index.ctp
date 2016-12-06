<h2>Characters</h2>

<table class="table-striped table-bordered table-condensed table-hover">
	<tr>
		<th><?php echo $this->Paginator->sort('id'); ?></th>
		<th><?php echo $this->Paginator->sort('name'); ?></th>
		<th><?php echo $this->Paginator->sort('rarity'); ?></th>
		<th><?php echo $this->Paginator->sort('story'); ?></th>
		<th><?php echo $this->Paginator->sort('illustrator'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv1_1'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv1_2'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv1_3'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv1_4'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv1_5'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv10_1'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv10_2'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv10_3'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv10_4'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv10_5'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv40_1'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv40_2'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv40_3'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv40_4'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv40_5'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv80_1'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv80_2'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv80_3'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv80_4'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv80_5'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv100_1'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv100_2'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv100_3'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv100_4'); ?></th>
		<th><?php echo $this->Paginator->sort('serif_lv100_5'); ?></th>
		<th><?php echo $this->Paginator->sort('evolution1_image'); ?></th>
		<th><?php echo $this->Paginator->sort('evolution1_image_small'); ?></th>
		<th><?php echo $this->Paginator->sort('evolution10_image'); ?></th>
		<th><?php echo $this->Paginator->sort('evolution10_image_small'); ?></th>
		<th><?php echo $this->Paginator->sort('evolution40_image'); ?></th>
		<th><?php echo $this->Paginator->sort('evolution40_image_small'); ?></th>
		<th><?php echo $this->Paginator->sort('evolution80_image'); ?></th>
		<th><?php echo $this->Paginator->sort('evolution80_image_small'); ?></th>
		<th><?php echo $this->Paginator->sort('evolution100_image'); ?></th>
		<th><?php echo $this->Paginator->sort('evolution100_image_small'); ?></th>
		<th class="actions">Actions</th>
	</tr>
	<?php foreach ($Characters as $character): ?>
	<tr>
		<td><?php echo h($character['Character']['id']); ?></td>
		<td><?php echo h($character['Character']['name']); ?></td>
		<td><?php echo h($character['Character']['rarity']); ?></td>
		<td><?php echo h($character['Character']['story']); ?></td>
		<td><?php echo h($character['Character']['illustrator']); ?></td>
		<td><?php echo h($character['Character']['serif_lv1_1']); ?></td>
		<td><?php echo h($character['Character']['serif_lv1_2']); ?></td>
		<td><?php echo h($character['Character']['serif_lv1_3']); ?></td>
		<td><?php echo h($character['Character']['serif_lv1_4']); ?></td>
		<td><?php echo h($character['Character']['serif_lv1_5']); ?></td>
		<td><?php echo h($character['Character']['serif_lv10_1']); ?></td>
		<td><?php echo h($character['Character']['serif_lv10_2']); ?></td>
		<td><?php echo h($character['Character']['serif_lv10_3']); ?></td>
		<td><?php echo h($character['Character']['serif_lv10_4']); ?></td>
		<td><?php echo h($character['Character']['serif_lv10_5']); ?></td>
		<td><?php echo h($character['Character']['serif_lv40_1']); ?></td>
		<td><?php echo h($character['Character']['serif_lv40_2']); ?></td>
		<td><?php echo h($character['Character']['serif_lv40_3']); ?></td>
		<td><?php echo h($character['Character']['serif_lv40_4']); ?></td>
		<td><?php echo h($character['Character']['serif_lv40_5']); ?></td>
		<td><?php echo h($character['Character']['serif_lv80_1']); ?></td>
		<td><?php echo h($character['Character']['serif_lv80_2']); ?></td>
		<td><?php echo h($character['Character']['serif_lv80_3']); ?></td>
		<td><?php echo h($character['Character']['serif_lv80_4']); ?></td>
		<td><?php echo h($character['Character']['serif_lv80_5']); ?></td>
		<td><?php echo h($character['Character']['serif_lv100_1']); ?></td>
		<td><?php echo h($character['Character']['serif_lv100_2']); ?></td>
		<td><?php echo h($character['Character']['serif_lv100_3']); ?></td>
		<td><?php echo h($character['Character']['serif_lv100_4']); ?></td>
		<td><?php echo h($character['Character']['serif_lv100_5']); ?></td>
		<td><?php echo h($character['Character']['evolution1_image']); ?></td>
		<td><?php echo h($character['Character']['evolution1_image_small']); ?></td>
		<td><?php echo h($character['Character']['evolution10_image']); ?></td>
		<td><?php echo h($character['Character']['evolution10_image_small']); ?></td>
		<td><?php echo h($character['Character']['evolution40_image']); ?></td>
		<td><?php echo h($character['Character']['evolution40_image_small']); ?></td>
		<td><?php echo h($character['Character']['evolution80_image']); ?></td>
		<td><?php echo h($character['Character']['evolution80_image_small']); ?></td>
		<td><?php echo h($character['Character']['evolution100_image']); ?></td>
		<td><?php echo h($character['Character']['evolution100_image_small']); ?></td>
		<td class="actions">
			<?php echo $this->Html->link('View', array('action' => 'view', $character['Character']['id']), array('class' => 'btn btn-default btn-xs')); ?>
			<?php echo $this->Html->link('Edit', array('action' => 'edit', $character['Character']['id']), array('class' => 'btn btn-default btn-xs')); ?>
			<?php echo $this->Form->postLink('Delete', array('action' => 'delete', $character['Character']['id']), array('class' => 'btn btn-danger btn-xs'), __('Are you sure you want to delete # %s?', $character['Character']['id'])); ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>

<br />

<?php echo $this->element('pagination-counter'); ?>

<?php echo $this->element('pagination'); ?>

<br />
<br />

<h3>Actions</h3>

<?php echo $this->Html->link('New Character', array('action' => 'add'), array('class' => 'btn btn-default')); ?>

<br />
<br />