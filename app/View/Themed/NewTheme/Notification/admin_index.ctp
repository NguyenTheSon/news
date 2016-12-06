<h2>お知らせ</h2>

<div class="row">

<div class="col col-lg-3">

<?php echo $this->Form->create('Notification', array('enctype' => "multipart/form-data")); ?>
<?php echo $this->Form->input('title', array('label' => '題名', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('content', array('label' => 'お知らせ記入事項', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('image_url', array('label' => 'abc', 'type' => 'file')); ?>
<br />
<?php echo $this->Form->button('登録', array('class' => 'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>

<br />
<br />

<table class="table-striped table-bordered table-condensed table-hover">
	<tr>
		<th><?php echo $this->Paginator->sort('id'); ?></th>
		<th><?php echo $this->Paginator->sort('title'); ?></th>
		<th><?php echo $this->Paginator->sort('content'); ?></th>
		<th><?php echo $this->Paginator->sort('image_url'); ?></th>
		<th><?php echo $this->Paginator->sort('created'); ?></th>
		<th><?php echo $this->Paginator->sort('modified'); ?></th>
		<th class="actions">Actions</th>
	</tr>
	<?php foreach ($notifications as $notification): ?>
	<tr>
		<td><?php echo h($notification['Notification']['id']); ?></td>
		<td><?php echo h($notification['Notification']['title']); ?></td>
		<td><?php echo h($notification['Notification']['content']); ?></td>
		<td><?php echo h($notification['Notification']['image_url']); ?></td>
		<td><?php echo h($notification['Notification']['created']); ?></td>
		<td><?php echo h($notification['Notification']['modified']); ?></td>
		<td class="actions">
			<?php echo $this->Html->link('View', array('action' => 'view', $notification['Notification']['id']), array('class' => 'btn btn-default btn-xs')); ?>
			<?php echo $this->Html->link('Edit', array('action' => 'edit', $notification['Notification']['id']), array('class' => 'btn btn-default btn-xs')); ?>
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
