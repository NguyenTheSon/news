<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">Chi tiết Tài Khoản</h3>
	</div>
	<div class="panel-body">
		<div class="row table-responsive">
			<div class="col-md-6 col-sm-6 ">
				<table class="table table-striped table-bordered table-condensed table-hover table-th-block table-primary">
					<tr>
						<td>ID</td>
						<td><?php echo $staff['Staff']['id']; ?></td>
					</tr>
					<tr>
						<td>Tên hiển thị</td>
						<td><?php echo $staff['Staff']['name']; ?></td>
					</tr>
					<tr>
						<td>Nhóm nhân viên</td>
						<td><?php echo $groups['StaffGroup']['name']; ?></td>
					</tr>
					<tr>
						<td>Content</td>
						<td><?php echo $staff['Staff']['content']; ?></td>
					</tr>
					<tr>
						<td>Ngày tham gia</td>
						<td><?php echo $staff['Staff']['created']; ?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<?php echo $this->Html->link('Quay Lại', array('action' => 'index'), array('class' => 'btn btn-warning')); ?>

			<?php echo $this->Html->link('Sửa Tài Khoản', array('action' => 'edit', $staff['Staff']['id']), array('class' => 'btn btn-info')); ?>

			<?php echo $this->Html->link('Xóa Tài Khoản', array('action' => 'delete', $staff['Staff']['id']), array('class' => 'btn btn-danger'), __('Bạn chắc chắn muốn xóa nhân viên?')); ?>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	$(function() {
		var icons = { 
			header: "ui-accordion-header-icon ui-icon ui-icon-triangle-1-e",
			activeHeader: "ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"
		};
		$( ".accordion" ).accordion({
			collapsible: true,
			icons: icons,
		});
	});
</script>