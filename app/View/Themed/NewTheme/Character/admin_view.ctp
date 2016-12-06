<h2>Character</h2>

<table class="table-striped table-bordered table-condensed table-hover">
	<tr>
		<td>Id</td>
		<td><?php echo h($character['Character']['id']); ?></td>
	</tr>
	<tr>
		<td>Name</td>
		<td><?php echo h($character['Character']['name']); ?></td>
	</tr>
	<tr>
		<td>Rarity</td>
		<td><?php echo h($character['Character']['rarity']); ?></td>
	</tr>
	<tr>
		<td>Story</td>
		<td><?php echo h($character['Character']['story']); ?></td>
	</tr>
	<tr>
		<td>Illustrator</td>
		<td><?php echo h($character['Character']['illustrator']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv1-1</td>
		<td><?php echo h($character['Character']['serif_lv1_1']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv1-2</td>
		<td><?php echo h($character['Character']['serif_lv1_2']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv1-3</td>
		<td><?php echo h($character['Character']['serif_lv1_3']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv1-4</td>
		<td><?php echo h($character['Character']['serif_lv1_4']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv1-5</td>
		<td><?php echo h($character['Character']['serif_lv1_5']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv10-1</td>
		<td><?php echo h($character['Character']['serif_lv10_1']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv10-2</td>
		<td><?php echo h($character['Character']['serif_lv10_2']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv10-3</td>
		<td><?php echo h($character['Character']['serif_lv10_3']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv10-4</td>
		<td><?php echo h($character['Character']['serif_lv10_4']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv10-5</td>
		<td><?php echo h($character['Character']['serif_lv10_5']); ?></td>
	</tr>
		<tr>
		<td>セリプ Lv40-1</td>
		<td><?php echo h($character['Character']['serif_lv40_1']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv40-2</td>
		<td><?php echo h($character['Character']['serif_lv40_2']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv40-3</td>
		<td><?php echo h($character['Character']['serif_lv40_3']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv40-4</td>
		<td><?php echo h($character['Character']['serif_lv40_4']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv40-5</td>
		<td><?php echo h($character['Character']['serif_lv40_5']); ?></td>
	</tr>
		<tr>
		<td>セリプ Lv80-1</td>
		<td><?php echo h($character['Character']['serif_lv80_1']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv80-2</td>
		<td><?php echo h($character['Character']['serif_lv80_2']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv80-3</td>
		<td><?php echo h($character['Character']['serif_lv80_3']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv80-4</td>
		<td><?php echo h($character['Character']['serif_lv80_4']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv80-5</td>
		<td><?php echo h($character['Character']['serif_lv80_5']); ?></td>
	</tr>
		<tr>
		<td>セリプ Lv100-1</td>
		<td><?php echo h($character['Character']['serif_lv100_1']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv100-2</td>
		<td><?php echo h($character['Character']['serif_lv100_2']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv100-3</td>
		<td><?php echo h($character['Character']['serif_lv100_3']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv100-4</td>
		<td><?php echo h($character['Character']['serif_lv100_4']); ?></td>
	</tr>
	<tr>
		<td>セリプ Lv100-5</td>
		<td><?php echo h($character['Character']['serif_lv100_5']); ?></td>
	</tr>
	<tr>
		<td>Evolution1_image</td>
		<td><?php echo h($character['Character']['evolution1_image']); ?></td>
	</tr>
	<tr>
		<td>Evolution10_image</td>
		<td><?php echo h($character['Character']['evolution10_image']); ?></td>
	</tr>
	<tr>
		<td>Evolution40_image</td>
		<td><?php echo h($character['Character']['evolution40_image']); ?></td>
	</tr>
	<tr>
		<td>Evolution80_image</td>
		<td><?php echo h($character['Character']['evolution80_image']); ?></td>
	</tr>
	<tr>
		<td>Evolution100_image</td>
		<td><?php echo h($character['Character']['evolution100_image']); ?></td>
	</tr>
</table>

<br />
<br />

<h3>Actions</h3>

<?php echo $this->Html->link('Edit Character', array('action' => 'edit', $character['Character']['id']), array('class' => 'btn btn-default')); ?> </li>

<br />
<br />

<?php echo $this->Form->postLink('Delete Character', array('action' => 'delete', $character['Character']['id']), array('class' => 'btn btn-danger'), __('Are you sure you want to delete # %s?', $character['Character']['id'])); ?>

<br />
<br />
