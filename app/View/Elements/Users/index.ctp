<table class="table table-striped table-bordered table-hover">
	<thead>
	<tr>
		<th width="5%" class="text-center">ID</th>
		<th width="10%" class="text-center">Danh</th>
		<th width="15%" class="text-center">Họ Tên</th>
		<th width="15%" class="text-center">Số ĐT</th>
		<th width="10%" class="text-center">Địa chỉ</th>		
		<th width="10%" class="text-center">Số Tiền</th>
		<th width="10%" class="text-center">Phần trăm</th>
		<th width="10%" class="text-center">Details</th>
	</tr>
	</thead>
	<tbody>
	<?php
		foreach($users as $user) {
			echo '<tr>';
			echo '<td>' . $user['User']['id'] . '</td>';
			echo '<td>' . $user['User']['prefix'] . '</td>';
			echo '<td>' . $user['User']['name'] . '</td>';
			echo '<td>' . $user['User']['phonenumber'] . '</td>';
			echo '<td>' . $user['User']['address'] . '</td>';
			echo '<td>' . $user['User']['balance'] . '</td>';
			echo '<td>' . $user['User']['percent_discount'] . '</td>';
			echo '<td>' . $this->Html->link('SMS',
					array('controller' => 'users', 'action' => 'sms', $user['User']['id'], 'admin' => true),
					array('class' => 'btn btn-default btn-xs')).
					$this->Html->link('Details',
					array('controller' => 'users', 'action' => 'view', $user['User']['id'], 'admin' => true),
					array('class' => 'btn btn-default btn-xs')) .
				'</td>';
			echo '</tr>';
		}
	?>
	</tbody>
</table>
<div class="row">
	<div class="col-sm-12 col-md-12">
		<?php echo $this->element('pagination'); ?>
</div>
</div>
<?php //pr($users) ?>