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
	        'controller' => 'Bills',
	        'action' => 'index',
	    ),
	    'model' => 'Bill'
	    ));
?>
<?php echo $this->Html->image('loading.gif', array('class' => 'hide', 'id' => 'loader')); ?>
<div id = 'resultField'>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-fixed">
			<tr>
				<th style="width: 15%;"><?php echo $this->Paginator->sort('User.fullname','Khách Hàng');?></th>
				<th style="width: 15%;"><?php echo $this->Paginator->sort('User.phone','Điện Thoại');?></th>
				<th style="width: 15%;">Thời Gian</th>
				<th style="width: 30%;">Dịch Vụ</th>
				<th style="width: 15%;">Tổng Tiền</th>
				<th style="width: 15%;">Khuyến mại</th>
				<th style="width: 15%;">Thành Tiền</th>
				<th style="width: 15%;" class="actions">Action</th>
				
			</tr>
			<?php foreach ($Bills as $Bill): ?>
			<tr>
				<td><?php echo h($Bill['User']['name']); ?></td>
				<td><?php echo h($Bill['User']['phonenumber']); ?></td>
				<td><?php echo $Bill['Bill']['created']; ?></td>
				<td><?php foreach ($Bill['Service'] as $key => $Service) {
						echo $Service['Service']['name']." (".$Service['StaffGroup']['name'].")<br>";
				} ?></td>
				<td><?php echo number_format($Bill['Bill']['total_money']); ?></td>
				<td><?php echo number_format($Bill['Bill']['discount']); ?></td>
				<td><?php echo number_format($Bill['Bill']['total_money'] - $Bill['Bill']['discount']); ?></td>
				<td class="actions">
					<?php //echo $this->Html->link('Chi Tiết', array('action' => 'view', $Bill['Bill']['id']), array('class' => 'btn btn-default btn-xs')); ?>
					<?php echo $this->Html->link('SMS', array('controller' => 'Users', 'action' => 'sms', $Bill['User']['id']), array('class' => 'btn btn-default btn-xs')); ?>
					<?php echo $this->Html->link('Sửa', array('action' => 'edit', $Bill['Bill']['id']), array('class' => 'btn btn-default btn-xs')); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php echo $this->element('pagination-counter'); ?>
		<?php echo $this->element('pagination'); ?>
	</div>
</div>