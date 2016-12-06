<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title"> <i class="glyphicon glyphicon-tasks"></i> Quản lý quảng cáo</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<th>ID</th>
					<th>Tên quảng cáo</th>
					<th>Vị trí</th>
					<th>Thứ tự</th>
					<th>Hiển thị</th>
				</thead>
				<tbody>
					<?php foreach($Advertise as $item):?>
						<tr class="odd gradeX">
							<td><?php echo $item['Advertise']['id'];?></td>
							<td>
								<a href="<?php echo Router::url(array('controller' => 'Advertises', 'action' => 'admin_edit', $item['Advertise']['id']));?>">
									<?php echo $item['Advertise']['name'];?> (<?php echo 'w: '.$item['Advertise']['width'].'px';?> && <?php echo 'h: '.$item['Advertise']['height'].'px';?>)
								</a>
							</td>
							<td><?php echo $item['Location']['name'];?></td>
							<td><?php echo $item['Advertise']['order'];?></td>
							<td>
								<?php echo $this->Html->link(($item['Advertise']['approved']==1?"Hiện":"Ẩn"), array('action' => 'admin_approved', $item['Advertise']['id']), array('class' => 'btn btn-default btn-xs')); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>