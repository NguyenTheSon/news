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
	        'controller' => 'Products',
	        'action' => 'index',
	    ),
	    'model' => 'Product'
	    ));
?>
<?php echo $this->Html->image('loading.gif', array('class' => 'hide', 'id' => 'loader')); ?>
<div id = 'resultField'>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-fixed">
			<tr>
				<th style="width: 15%;">Tên sản phẩm</th>
				<th style="width: 20%;">Hình ảnh</th>
				<th style="width: 20%;">Giá</th>
				<th style="width: 20%;">Danh mục</th>
				<th style="width: 30%;">Mô tả</th>
				<th style="width: 15%;" class="actions">Action</th>
				
			</tr>
			<?php foreach ($Products as $Product): ?>
			<tr>
				<td><?php echo h($Product['Product']['name']); ?></td>
				<td><img src="<?php echo h($Product['Product']['image']); ?>" style="width:100px;height:100px"></td>
				<td><?php echo h(number_format($Product['Product']['price'])); ?></td>
				<td><?php echo $Product['ProdCategory']['name'];?></td>
				<td><?php echo h(strip_tags($Product['Product']['described'])); ?></td>
				<td class="actions">
					<?php echo $this->Html->link("Sửa", array('action' => 'admin_edit', $Product['Product']['id']), array('class' => 'btn btn-default btn-xs')); ?>
					<?php echo $this->Html->link('Xoá', array('action' => 'admin_del', $Product['Product']['id']), array('class' => 'btn btn-default btn-xs')); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php echo $this->element('pagination-counter'); ?>
		<?php echo $this->element('pagination'); ?>
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