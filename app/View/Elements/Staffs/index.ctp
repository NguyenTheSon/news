<table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th width="5%" class="text-center">ID</th>
			<th width="20%" class="text-center">Họ Tên</th>
			<th width="15%" class="text-center">Nhóm nhân viên</th>
			<th width="50%" class="text-center">Content</th>
			<th width="10%" class="text-center">Details</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($staffs as $Staff) :?>
			<tr>
				<td><?php echo $Staff['Staff']['id'];?></td>
				<td><?php echo $Staff['Staff']['name'];?></td>
				<td>
					<?php  if($Staff['Staff']['staff_group_id'] ==1) :?>
						<?php echo "Nhân viên thường";?>
					<?php else:?>
						<?php echo "Nhà tạo mẫu";?>
					<?php endif; ?>
				</td>
				<td><?php echo $Staff['Staff']['content'];?></td>
				<td>
					<?php echo $this->Html->link('Details',array('controller' => 'Staffs', 'action' => 'view', $Staff['Staff']['id'], 'admin' => true),
					array('class' => 'btn btn-default btn-xs'));?>
				</td>
			</tr>
		<?php endforeach;?>
	</tbody>
</table>
<div class="row">
	<div class="col-sm-12 col-md-12">
		<?php echo $this->element('pagination'); ?>
	</div>
</div>