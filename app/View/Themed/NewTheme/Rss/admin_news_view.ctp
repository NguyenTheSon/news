<h2>ニュース</h2>

<table class="table-striped table-bordered table-condensed table-hover">
	<tr>
		<td>Id</td>
		<td><?php echo h($artile['Article']['id']); ?></td>
	</tr>
	<tr>
		<td>Title</td>
		<td><?php echo h($artile['Article']['title']); ?></td>
	</tr>
	<tr>
		<td>Url</td>
		<td><?php echo h($artile['Article']['permalink']); ?></td>
	</tr>
	<tr>
		<td>説明</td>
		<td><?php echo h($artile['Article']['description']); ?></td>
	</tr>
	<tr>
		<td>日付</td>
		<td><?php echo h($artile['Article']['date']); ?></td>
	</tr>
	<tr>
		<td>Created</td>
		<td><?php echo h($artile['Article']['created']); ?></td>
	</tr>
	<tr>
		<td>Modified</td>
		<td><?php echo h($artile['Article']['modified']); ?></td>
	</tr>
</table>

<br />
<br />

<h3>Actions</h3>

<?php echo $this->Html->link('ニュースを編集', array('action' => 'news_edit', $artile['Article']['id']), array('class' => 'btn btn-default')); ?> </li>

<br />
<br />

<?php echo $this->Form->postLink('ニュースを削除', array('action' => 'news_delete', $artile['Article']['id']), array('class' => 'btn btn-danger'), __('Are you sure you want to delete # %s?', $artile['Article']['id'])); ?>

<br />
<br />
