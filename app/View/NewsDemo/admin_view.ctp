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
						<td>Tên hiển thị</td>
						<td><?php echo $user['User']['username']; ?></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><?php echo $user['User']['email']; ?></td>
					</tr>
					
					<tr>
						<td>Avatar</td>
						<td><img src='<?php echo $this->Html->url('/').$user['User']['avatar']; ?>' style='max-height:100px;'></td>
					</tr>
					<tr>
						<td>Active</td>
						<td><?php echo $this->Html->image('icon_' . $user['User']['active'] . '.png') ?></td>
					</tr>
					<tr>
						<td>Ngày tham gia</td>
						<td><?php echo $user['User']['created']; ?></td>
					</tr>
					<tr>
						<td>Sửa đổi lần cuối</td>
						<td><?php echo $user['User']['modified']; ?></td>
					</tr>
					<tr>
						<td>Số sản phẩm đã đăng</td>
						<td><?php echo $user['User']['numProduct']; ?></td>
					</tr>
					<tr>
						<td>Số giao dịch đã thực hiện</td>
						<td><?php echo $user['User']['numPurchase']; ?></td>
					</tr>
					<tr>
						<td>Số người theo dõi thành viên</td>
						<td><?php echo $user['User']['followed']; ?></td>
					</tr>
					<tr>
						<td>Số người thành viên đang theo dõi</td>
						<td><?php echo $user['User']['follow']; ?></td>
					</tr>
				</table>
				<?php echo $this->Html->link('Quay Lại', array('action' => 'index'), array('class' => 'btn btn-warning')); ?>

				<?php echo $this->Form->postLink('Xóa Tài Khoản', array('action' => 'delete', $user['User']['id']), array('class' => 'btn btn-danger'), __('Bạn chắc chắn muốn xóa người dùng #%s?', $user['User']['id'])); ?>

			</div>
        </div>
	</div>
</div>
	