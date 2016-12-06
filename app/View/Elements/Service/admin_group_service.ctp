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
	        'controller' => 'Service',
	        'action' => 'admin_group_service',
	    ),
	    'model' => 'Service'
	    ));
?>
<?php echo $this->Html->image('loading.gif', array('class' => 'hide', 'id' => 'loader')); ?>
<div id = 'resultField'>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-fixed">
			<tr>
				<th style="width: 85%;"><?php echo $this->Paginator->sort('name','Nhóm dịch vụ');?></th>
				<th style="width: 85%;"><?php echo $this->Paginator->sort('name','Loại dịch vụ');?></th>
				<th style="width: 15%;" class="actions">Action</th>
				
			</tr>
			<?php foreach ($ServiceGroups as $ServiceGroup): ?>
			<tr>
				<td><?php echo h($ServiceGroup['ServiceGroup']['group_name']); ?></td>
				<td><?php echo ($ServiceGroup['ServiceGroup']['group_type']=="1")?"Cắt gội":"SPA"; ?></td>
				<td class="actions">
					<?php echo $this->Html->link('Sửa', array('action' => 'admin_edit_group', $ServiceGroup['ServiceGroup']['id']), array('class' => 'btn btn-default btn-xs')); ?>
					<?php echo $this->Html->link('Xoá', array('action' => 'admin_del_group', $ServiceGroup['ServiceGroup']['id']), array('class' => 'btn btn-default btn-xs'),__("Bạn có chắc muốn xóa nhóm này?")); ?>
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