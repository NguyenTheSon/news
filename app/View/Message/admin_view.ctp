<h2>Message</h2>

<table class="table-striped table-bordered table-condensed table-hover">
	<tr>
		<td>Id</td>
		<td><?php echo h($message['Message']['id']); ?></td>
	</tr>
	<tr>
		<td>Nick Name</td>
		<td><?php echo h($message['Message']['nickname']); ?></td>
	</tr>
	<tr>
		<td>Message Subject</td>
		<td><?php echo h($message['Message']['subject']); ?></td>
	</tr>
	<tr>
		<td>Message Content</td>
		<td><?php echo h($message['Message']['body']); ?></td>
	</tr>
	<tr>
		<td>Image</td>
		<td><?php echo h($message['Message']['image_url']); ?></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><?php echo h($message['Message']['password']); ?></td>
	</tr>
	<tr>
		<td>Read Count</td>
		<td><?php echo h($message['Message']['read_count']); ?></td>
	</tr>
		<tr>
		<td>End Time</td>
		<td><?php echo h($message['Message']['end_time']); ?></td>
	</tr>
	</tr>
		<tr>
		<td>User ID</td>
		<td><?php echo h($message['Message']['login_id']); ?></td>
	</tr>
	<tr>
		<td>Created</td>
		<td><?php echo h($message['Message']['created']); ?></td>
	</tr>
	<tr>
		<td>Modified</td>
		<td><?php echo h($message['Message']['modified']); ?></td>
	</tr>
</table>

<br />
<br />

<h3>Actions</h3>

<?php echo $this->Html->link('Edit Message', array('action' => 'edit', $message['Message']['id']), array('class' => 'btn btn-default')); ?> </li>

<br />
<br />

<?php echo $this->Form->postLink('Delete Message', array('action' => 'delete', $message['Message']['id']), array('class' => 'btn btn-danger'), __('Are you sure you want to delete # %s?', $message['Message']['id'])); ?>

<br />
<br />
