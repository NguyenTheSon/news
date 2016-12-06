<div id = 'resultField'>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-fixed">
			<tr>
				<th style="width: 15%;">Khách Hàng</th>
				<th style="width: 15%;">Điện thoại</th>
				<th style="width: 30%;">Dịch Vụ</th>
				<th style="width: 10%;">Thời gian</th>
				<th style="width: 5%;">Đã gọi</th>
				<th style="width: 5%;">Đã SMS</th>		
			</tr>
			<?php foreach ($Services as $Service): ?>
			<tr>
				<td><?php echo $Service['User']['name']; ?></td>
				<td><?php echo h($Service['User']['phonenumber']); ?></td>
				<td><?php echo $Service['Service']['name'];?></td>
				<td><?php echo $Service['Bill']['created'];?></td>
				<td><?php echo $this->Html->image('icon_' . abs($Service['BillService']['called']) . '.png') ?></td>
				<td><?php echo $this->Html->image('icon_' . abs($Service['BillService']['sms']) . '.png') ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(".changestate").change(function(event) {
		var id = $(this).attr("data-id");
		var val = $(this).val();
		$.ajax({
			url: '<?php echo Router::url(array("action" => "update_state"));?>',
			type: 'POST',
			dataType: 'JSON',
			data: {id: id, state: val},
		})
		.done(function(data) {
			if(data.code == 1000){
				toastr.success("Đổi trạng thái thành công!");
			}
			else{
				toastr.error("Có lỗi, vui lòng thử lại.");
			}
		})
		.fail(function(){
			toastr.error("Bạn không có quyền thực hiện hành động này.");
		});
	});
</script>