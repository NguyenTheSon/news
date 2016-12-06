<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title">Chi tiết Sản Phẩm</h3>
  </div>
  <div class="panel-body">
	    <div class="row table-responsive">
	    	<div class="col-md-6 col-sm-6 ">
		    	<table class="table table-striped table-bordered table-condensed table-hover table-th-block table-primary">
					<tr>
						<td>ID</td>
						<td><?php echo h($Product['Product']['id']); ?></td>
					</tr>
					<tr>
						<td>Tên Sản Phẩm</td>
						<td><?php echo h($Product['Product']['name']); ?></td>
					</tr>
					<tr>
						<td>Loại Hàng</td>
						<td><?php echo h($Product['Product']['condition']); ?></td>
					</tr>
					<tr>
						<td>Hình Ảnh</td>
						<td>
						<?php
							foreach ($Product['Product']['other_images'] as $img) {
								echo '<img src='.$this->webroot.$img.' style="max-height:100px;">';
							}
						?>
						</td>
					</tr>
					<tr>
						<td>Miêu tả</td>
						<td><?php echo h($Product['Product']['described']); ?></td>
					</tr>
					<tr>
						<td>Giá Bán</td>
						<td><?php echo h($Product['Product']['price']); ?></td>
					</tr>
					<tr>
						<td>Giá mua mới</td>
						<td><?php echo h($Product['Product']['price_new']); ?></td>
					</tr>
					<tr>
						<td>Ship từ</td>
						<td><?php echo h($Product['Product']['ships_from']); ?></td>
					</tr>
					<tr>
						<td>Cỡ Sản Phẩm</td>
						<td><?php echo h($Product['Product']['size']); ?></td>
					</tr>
					<tr>
						<td>Hãng Sản Phẩm</td>
						<td><?php echo h($Product['Product']['brand']); ?></td>
					</tr>
					<tr>
						<td>Hiển thị</td>
						<td><?php echo $this->Html->image('icon_' . abs($Product['Product']['is_deleted']-1) . '.png') ?></td>
					</tr>
					
						<td>Ngày đăng</td>
						<td><?php echo h($Product['Product']['created']); ?></td>
					</tr>
					<tr>
						<td>Sửa đổi lần cuối</td>
						<td><?php echo h($Product['Product']['modified']); ?></td>
					</tr>
					<tr>
						<td>Số Like</td>
						<td><?php echo h($Product['Product']['like']); ?></td>
					</tr>
					<tr>
						<td>Số Comment</td>
						<td><?php echo h($Product['Product']['comment']); ?></td>
					</tr>
					<tr>
						<td>Số Report</td>
						<td><?php echo h($Product['Product']['report']); ?></td>
					</tr>
				</table>
					<?php echo $this->Form->button('Quay Lại', array('class' => 'btn btn-warning','onclick' => "window.location ='".$this->request->referer()."'", 'type' => 'button')); ?>
					<?php echo $this->Form->postLink('Xóa Vĩnh Viễn', array('action' => 'delete', $Product['Product']['id']), array('class' => 'btn btn-danger'), __('Bạn chắc chắn muốn xóa Sản phẩm %s?', $Product['Product']['name'])); ?>

			</div>
        </div>
	</div>
</div>
	