<h2>Message</h2>

<div class="row">

<div class="col col-lg-3">

<?php echo $this->Form->create('Message', array('enctype' => 'multipart/form-data')); ?>
<?php echo $this->Form->input('nickname', array('label' => 'Nick Name', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('subject', array('label' => 'Message Subject', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('body', array('label' => 'Message Content', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('image_url', array('label' => 'Image Url', 'type' => 'file')); ?>
<br />
<?php echo $this->Form->input('password', array('label' => 'Password', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('read_count', array('label' => 'Read Count', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('end_time', array('label' => 'End Time', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('login_id', array('label' => 'User ID', 'class' => 'form-control', 'options' => $users)); ?>
<br />
<?php echo $this->Form->button('Register', array('class' => 'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>

<br />
<br />

<table class="table-striped table-bordered table-condensed table-hover">
	<tr>
		<th><?php echo $this->Paginator->sort('id'); ?></th>
		<th><?php echo $this->Paginator->sort('nickname'); ?></th>
		<th><?php echo $this->Paginator->sort('subject'); ?></th>
		<th><?php echo $this->Paginator->sort('body'); ?></th>
		<th><?php echo $this->Paginator->sort('image_url'); ?></th>
		<th><?php echo $this->Paginator->sort('password'); ?></th>
		<th><?php echo $this->Paginator->sort('read_count'); ?></th>
		<th><?php echo $this->Paginator->sort('end_time'); ?></th>
		<th><?php echo $this->Paginator->sort('login_id'); ?></th>
		<th><?php echo $this->Paginator->sort('created'); ?></th>
		<th><?php echo $this->Paginator->sort('modified'); ?></th>
		<th class="actions">Actions</th>
	</tr>
	<?php foreach ($messages as $message): ?>
	<tr>
		<td><?php echo h($message['Message']['id']); ?></td>
		<td><?php echo h($message['Message']['nickname']); ?></td>
		<td><?php echo h($message['Message']['subject']); ?></td>
		<td><?php echo h($message['Message']['body']); ?></td>
		<td><?php echo h($message['Message']['image_url']); ?></td>
		<td><?php echo h($message['Message']['password']); ?></td>
		<td><?php echo h($message['Message']['read_count']); ?></td>
		<td><?php echo h($message['Message']['end_time']); ?></td>
		<td><?php echo h($message['Message']['subject']); ?></td>
		<td><?php echo h($message['Message']['login_id']); ?></td>
		<td><?php echo h($message['Message']['created']); ?></td>
		<td><?php echo h($message['Message']['modified']); ?></td>
		<td class="actions">
			<?php echo $this->Html->link('View', array('action' => 'view', $message['Message']['id']), array('class' => 'btn btn-default btn-xs')); ?>
			<?php echo $this->Html->link('Edit', array('action' => 'edit', $message['Message']['id']), array('class' => 'btn btn-default btn-xs')); ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>

<br />

<?php echo $this->element('pagination-counter'); ?>

<?php echo $this->element('pagination'); ?>

<br />
<br />
</div>
