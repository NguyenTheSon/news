<?php

$articlePaginator = $this->Paginator;

$articlePaginator->options(array(
		'update'=>'#articlePaging',
		'evalScripts' => true,
	    'before' => $this->Js->get('#loader')->effect(
	        'fadeIn',
	        array('buffer' => false)
	    ),
	    'complete' => $this->Js->get('loader')->effect(
	        'fadeOut',
	        array('buffer' => false)
	    ),
	   	'url' => array(
	        'controller' => 'Rss',
	        'action' => 'article'
	    ),
	    'model' => 'Article'
	    ));
?>
<div class="col col-lg-3">

<?php echo $this->Html->image('loading.gif', array('class' => 'hide', 'id' => 'loader')); ?>
<table class="table-striped table-bordered table-condensed table-hover">
	<tr>
		<th><?php echo $this->Paginator->sort('id'); ?></th>
		<th><?php echo $this->Paginator->sort('title'); ?></th>
		<th><?php echo $this->Paginator->sort('permalink'); ?></th>
		<th><?php echo $this->Paginator->sort('description'); ?></th>
		<th><?php echo $this->Paginator->sort('date'); ?></th>
		<th><?php echo $this->Paginator->sort('created'); ?></th>
		<th><?php echo $this->Paginator->sort('modified'); ?></th>
		<th class="actions">Actions</th>
	</tr>
	<?php foreach ($articles as $article): ?>
	<tr>
		<td><?php echo h($article['Article']['id']); ?></td>
		<td><?php echo h($article['Article']['title']); ?></td>
		<td><?php echo h($article['Article']['permalink']); ?></td>
		<td><?php echo h($article['Article']['description']); ?></td>
		<td><?php echo h($article['Article']['date']); ?></td>
		<td><?php echo h($article['Article']['created']); ?></td>
		<td><?php echo h($article['Article']['modified']); ?></td>
		<td class="actions">
			<?php echo $this->Html->link('View', array('action' => 'news_view', $article['Article']['id']), array('class' => 'btn btn-default btn-xs')); ?>
			<?php echo $this->Html->link('Edit', array('action' => 'news_edit', $article['Article']['id']), array('class' => 'btn btn-default btn-xs')); ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>

<br />

<?php echo $this->Paginator->counter(array(
    'model' => 'Article',
    'format' => 'range',
    'separator' => ' / '
)); ?>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo $this->Paginator->prev(
  '« 戻る',
  $options = array('model'=>'Article'),
  null,
  array('class' => 'disabled')
);
echo " | ".$this->Paginator->numbers(array('model' => 'Article'))." | ";
echo $this->Paginator->next(
  '次へ »',
  $options = array('model'=>'Article'),
  null,
  array('class' => 'disabled')
); ?>
<?php echo $this->Js->writeBuffer();?>

</div>