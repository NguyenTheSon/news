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
						<td><?php echo $user['User']['id']; ?></td>
					</tr>
					<tr>
						<td>Nhóm người dùng</td>
						<td><?php echo $user['User']['role']; ?></td>
					</tr>
					<tr>
						<td>Số Điện Thoại</td>
						<td><?php echo $user['User']['phonenumber']; ?></td>
					</tr>
					<tr>
						<td>Danh</td>
						<td><?php echo $user['User']['prefix']; ?></td>
					</tr>
					<tr>
						<td>Tên hiển thị</td>
						<td><?php echo $user['User']['name']; ?></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><?php echo $user['User']['email']; ?></td>
					</tr>
					<tr>
						<td>Ngày Sinh</td>
						<td><?php echo $user['User']['birthday']; ?></td>
					</tr>
					<tr>
						<td>Số tiền</td>
						<td><?php echo $user['User']['balance']; ?></td>
					</tr>
					<tr>
						<td>Phần trăm giảm giá</td>
						<td><?php echo $user['User']['percent_discount']; ?></td>
					</tr>

					<tr>
						<td>Active</td>
						<td><?php echo $this->Html->image('icon_' . $user['User']['active'] . '.png') ?></td>
					</tr>
					<tr>
						<td>Ngày tham gia</td>
						<td><?php echo $user['User']['created']; ?></td>
					</tr>
				</table>
				

			</div>
        </div>
        </div>
        <div class="row">
        	<div class="col-xs-12">
        		<?php echo $this->Html->link('Quay Lại', array('action' => 'index'), array('class' => 'btn btn-warning')); ?>

				<?php echo $this->Html->link('Sửa Tài Khoản', array('action' => 'edit', $user['User']['id']), array('class' => 'btn btn-info')); ?>

				<?php echo $this->Html->link('Xóa Tài Khoản', array('action' => 'delete', $user['User']['id']), array('class' => 'btn btn-danger'), __('Bạn chắc chắn muốn xóa người dùng #%s?', $user['User']['id'])); ?>
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