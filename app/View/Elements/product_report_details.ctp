 <div class="row table-responsive">
			<div class="col-md-8 col-sm-8 ">
		    	<table class="table table-striped table-bordered table-condensed table-hover table-th-block table-primary">
					<tr>
						<td colspan="12" style="background:#3BAFDA;color:white;">Report</td>
					</tr>
					<tr>
						<th width="20%">Chủ đề</th>
						<th width="40%">Nội dung</th>
						<th width="20%">Reporter</th>
						<th>Thời Gian</th>
					</tr>
					<? if(isset($data['Report'])) foreach ($data['Report'] as $value) {
						echo "<tr>
							<td>$value[subject]</td>
							<td>$value[details]</td>
							<td>$value[reporter]</td>
							<td>$value[created]</td>
							</tr>";
					}?>
					
				
				</table>
			</div>
			<div class="col-md-4 col-sm-4 ">
				<input type="hidden" id="ProductId" value="<?php echo h($data['Product']['id']); ?>">
				<table class="table table-striped table-bordered table-condensed table-hover table-th-block table-primary">
				<tr>
				<td colspan="12" style="background:#3BAFDA;color:white;">Chi Tiết Sản Phẩm</td>
				</tr>
					<tr>
						<td>Hình Ảnh</td>
						<td>
						<?php
							foreach ($data['Product']['other_images'] as $img) {
								echo '<img src='.$this->webroot.$img.' style="max-height:100px;">';
							}
						?>
						</td>
					</tr>
					<tr>
						<td>Miêu tả</td>
						<td><?php echo h($data['Product']['described']); ?></td>
					</tr>
					<tr>
						<td>Giá Bán</td>
						<td><?php echo h($data['Product']['price']); ?></td>
					</tr>
					<tr>
						<td>Gía mới</td>
						<td><?php echo h($data['Product']['price_new']); ?></td>
					</tr>
					
					<tr>
						<td>Ship từ</td>
						<td><?php echo h($data['Product']['ships_from']); ?></td>
					</tr>
					<tr>
						<td>Cỡ Sản Phẩm</td>
						<td><?php echo h($data['Product']['size']); ?></td>
					</tr>
					<tr>
						<td>Hãng Sản Phẩm</td>
						<td><?php echo h($data['Product']['brand']); ?></td>
					</tr>
					<tr>
						<td>Hiển thị</td>
						<td><?php echo $this->Html->image('icon_' . abs($data['Product']['is_deleted']-1) . '.png') ?></td>
					</tr>
					
						<td>Ngày đăng</td>
						<td><?php echo h($data['Product']['created']); ?></td>
					</tr>
					<tr>
						<td>Sửa đổi lần cuối</td>
						<td><?php echo h($data['Product']['modified']); ?></td>
					</tr>
					<tr>
						<td>Số Like</td>
						<td><?php echo h($data['Product']['like']); ?></td>
					</tr>
					<tr>
						<td>Số Comment</td>
						<td><?php echo h($data['Product']['comment']); ?></td>
					</tr>
					<tr>
						<td>Số Report</td>
						<td><?php echo h($data['Product']['report']); ?></td>
					</tr>
				</table>
			</div>
			
        </div>