<h2>Notification</h2>

<table class="table-striped table-bordered table-condensed table-hover">
	<tr>
		<td>Id</td>
		<td><?php echo h($notification['Notification']['id']); ?></td>
	</tr>
	<tr>
		<td>Title</td>
		<td><?php echo h($notification['Notification']['title']); ?></td>
	</tr>
	<tr>
		<td>Content</td>
		<td><?php echo h($notification['Notification']['content']); ?></td>
	</tr>
	<tr>
		<td>Image</td>
		<td><?php echo h($notification['Notification']['image_url']); ?></td>
	</tr>
	<tr>
		<td>Created</td>
		<td><?php echo h($notification['Notification']['created']); ?></td>
	</tr>
	<tr>
		<td>Modified</td>
		<td><?php echo h($notification['Notification']['modified']); ?></td>
	</tr>
</table>

<br />
<br />

<h3>Actions</h3>

<?php echo $this->Html->link('Edit Notification', array('action' => 'edit', $notification['Notification']['id']), array('class' => 'btn btn-default')); ?> </li>

<br />
<br />

<?php echo $this->Form->postLink('Delete Notification', array('action' => 'delete', $notification['Notification']['id']), array('class' => 'btn btn-danger'), __('Are you sure you want to delete # %s?', $notification['Notification']['id'])); ?>

<br />
<br />
