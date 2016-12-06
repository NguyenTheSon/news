<?php

$articlePaginator = $this->Paginator;

$articlePaginator->options(array(
		'update'=>'#resultField',
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
	        'controller' => 'Products',
	        'action' => 'index',
	        (isset($this->request->params['pass'][0])? $this->request->params['pass'][0]:'0')
	    ),
	    'model' => 'Products'
	    ));
?>
<?php echo $this->Html->image('loading.gif', array('class' => 'hide', 'id' => 'loader')); ?>
<div id = 'resultField'>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-fixed">
			<tr>
				<th style="width: 15%;"><?php echo $this->Paginator->sort('name','Tên Sản Phẩm');?></th>
				<th style="width: 20%;"><?php echo $this->Paginator->sort('described','Miêu Tả');?></th>
				<th style="width: 10%;"><?php echo $this->Paginator->sort('price','Giá Bán');?></th>
				<th style="width: 10%;"><?php echo $this->Paginator->sort('created','Ngày Đăng');?></th>
				<th style="width: 10%;"><?php echo $this->Paginator->sort('seller','Người bán');?></th>
				<th style="width: 10%;"><?php echo $this->Paginator->sort('category','Chuyên mục');?></th>
				<th style="width: 10%;"><?php echo $this->Paginator->sort('is_deleted','Hiển Thị');?></th>
				<th style="width: 10%;"><?php echo $this->Paginator->sort('report','Report');?></th>
				<th style="width: 10%;" class="actions">Action</th>
				
			</tr>
			<?php foreach ($Products as $Product): ?>
			<tr>
				<td><?php echo h($Product['Product']['name']); ?></td>
				<td><?php echo h($Product['Product']['described']); ?></td>
				<td><?php echo h($Product['Product']['price']); ?></td>
				<td><?php echo h($Product['Product']['created']); ?></td>
				<td><?php echo h($Product['Product']['seller']); ?></td>
				<td><?php echo h($Product['Product']['category']); ?></td>
				<td><?php echo $this->Html->image('icon_' . abs($Product['Product']['is_deleted']-1) . '.png') ?></td>
				<td><?php echo h($Product['Product']['report']); ?></td>
				<td class="actions">
					<?php echo $this->Html->link('Chi Tiết', array('action' => 'view', $Product['Product']['id']), array('class' => 'btn btn-default btn-xs')); ?>
					<?php echo $this->Html->link('Sửa', array('action' => 'edit', $Product['Product']['id']), array('class' => 'btn btn-default btn-xs')); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php echo $this->element('pagination-counter'); ?>
		<?php echo $this->element('pagination'); ?>
	</div>
</div>
