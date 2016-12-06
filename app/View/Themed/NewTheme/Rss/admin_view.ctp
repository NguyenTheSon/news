<h2>Rss</h2>

<table class="table-striped table-bordered table-condensed table-hover">
	<tr>
		<td>Id</td>
		<td><?php echo h($rss['Rss']['id']); ?></td>
	</tr>
	<tr>
		<td>Name</td>
		<td><?php echo h($rss['Rss']['name']); ?></td>
	</tr>
	<tr>
		<td>Url</td>
		<td><?php echo h($rss['Rss']['url']); ?></td>
	</tr>
	<tr>
		<td>Active</td>
		<td><?php echo h($rss['Rss']['active']); ?></td>
	</tr>
	<tr>
		<td>Created</td>
		<td><?php echo h($rss['Rss']['created']); ?></td>
	</tr>
	<tr>
		<td>Modified</td>
		<td><?php echo h($rss['Rss']['modified']); ?></td>
	</tr>
</table>

<br />
<br />

<h3>Actions</h3>

<?php echo $this->Html->link('Edit Rss', array('action' => 'edit', $rss['Rss']['id']), array('class' => 'btn btn-default')); ?> </li>

<br />
<br />

<?php echo $this->Form->postLink('Delete Rss', array('action' => 'delete', $rss['Rss']['id']), array('class' => 'btn btn-danger'), __('Are you sure you want to delete # %s?', $rss['Rss']['id'])); ?>

<br />
<br />
