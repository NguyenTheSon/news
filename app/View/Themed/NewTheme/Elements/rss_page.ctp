
<?php

$rssPaginator = $this->Paginator; 


$rssPaginator->options(array(
		'update'=>'#rssPaging',
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
	        'action' => 'index'
	    ),

	    'model' => 'Rss'
	    ));
?>
<div class="col col-lg-3">

<?php echo $this->Html->image('loading.gif', array('class' => 'hide', 'id' => 'loader')); ?>
<table class="table-striped table-bordered table-condensed table-hover">
	<tr>
		<th><?php echo $this->Paginator->sort('id'); ?></th>
		<th><?php echo $this->Paginator->sort('name'); ?></th>
		<th><?php echo $this->Paginator->sort('url'); ?></th>
		<th><?php echo $this->Paginator->sort('active'); ?></th>
		<th><?php echo $this->Paginator->sort('created'); ?></th>
		<th><?php echo $this->Paginator->sort('modified'); ?></th>
		<th class="actions">Actions</th>
	</tr>
	<?php foreach ($rsses as $rss): ?>
	<tr>
		<td><?php echo h($rss['Rss']['id']); ?></td>
		<td><?php echo h($rss['Rss']['name']); ?></td>
		<td><?php echo h($rss['Rss']['url']); ?></td>
		<td><?php echo $this->Html->link($this->Html->image('icon_' . $rss['Rss']['active'] . '.png'), array('controller' => 'rss', 'action' => 'switch', 'active', $rss['Rss']['id']), array('class' => 'status', 'escape' => false)); ?></td>
		<td><?php echo h($rss['Rss']['created']); ?></td>
		<td><?php echo h($rss['Rss']['modified']); ?></td>
		<td class="actions">
			<?php echo $this->Html->link('View', array('action' => 'view', $rss['Rss']['id']), array('class' => 'btn btn-default btn-xs')); ?>
			<?php echo $this->Html->link('Edit', array('action' => 'edit', $rss['Rss']['id']), array('class' => 'btn btn-default btn-xs')); ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
</br>

<?php echo $this->Paginator->counter(array(
    'model' => 'Rss',
    'format' => 'range',
    'separator' => ' / '
)); ?>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo $this->Paginator->prev(
  '« 戻る',
  null,
  null,
  array('class' => 'disabled'),
  array('model'=>'Rss')
);
echo " | ".$this->Paginator->numbers()." | ";
echo $this->Paginator->next(
  '次へ »',
  null,
  null,
  array('class' => 'disabled'),
  array('model'=>'Rss')
); ?>
<?php echo $this->Js->writeBuffer();?>

</div>
