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
	        'controller' => 'News',
	        'action' => 'admin_index',
	    ),
	    'model' => 'News'
	    ));
?>
<?php echo $this->Html->image('loading.gif', array('class' => 'hide', 'id' => 'loader')); ?>
<div id = 'resultField'>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-fixed">
			<tr>
				<th style="width: 40%;">Tiêu đề bài viết</th>
				<th style="width: 20%;">Chuyên mục</th>
				<th style="width: 20%;">Mô tả</th>
				<th style="width: 20%;">Thời gian</th>
				<th style="width: 20%;" class="actions">Action</th>
				
			</tr>
			<?php foreach ($News as $New): ?>
			<tr>
				<td><?php echo h($New['News']['title']); ?></td>
				<td><?php echo h($New['Category']['name']); ?></td>
				<td><?php echo $New['News']['description'];?></td>
				<td><?php echo $New['News']['created'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(($New['News']['approved']==1?"Ẩn":"Hiện"), array('action' => 'admin_approved', $New['News']['id']), array('class' => 'btn btn-default btn-xs')); ?>
					<?php echo $this->Html->link('Sửa', array('action' => 'admin_edit', $New['News']['id']), array('class' => 'btn btn-default btn-xs')); ?>
					<?php echo $this->Html->link('Xoá', array('action' => 'admin_del', $New['News']['id']), array('class' => 'btn btn-default btn-xs'),__("Bạn có chắc muốn xóa tin này?")); ?>
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