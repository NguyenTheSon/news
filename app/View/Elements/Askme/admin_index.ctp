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
	        'controller' => 'Askme',
	        'action' => 'index',
	    ),
	    'model' => 'Question'
	    ));
?>
<?php echo $this->Html->image('loading.gif', array('class' => 'hide', 'id' => 'loader')); ?>
<div id = 'resultField'>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-fixed">
			<tr>
				<th style="width: 40%;">Câu hỏi</th>
				<th style="width: 20%;">Thành viên</th>
				<th style="width: 20%;">Thời gian</th>
				<th style="width: 20%;">Trạng thái</th>
				<th style="width: 20%;" class="actions">Action</th>
				
			</tr>
			<?php foreach ($Questions as $Question): ?>
			<tr>
				<td><?php echo h($Question['Question']['question']); ?></td>
				<td><?php echo h($Question['User']['name']); ?></td>
				<td><?php echo $Question['Question']['created'];?></td>
				<td><?php echo ($Question['Question']['answer']==""?"Chưa trả lời":"Đã trả lời");?></td>
				<td class="actions">
					<?php echo $this->Html->link(($Question['Question']['approved']==1?"Ẩn":"Hiện"), array('action' => 'admin_approved', $Question['Question']['id']), array('class' => 'btn btn-default btn-xs')); ?>
					<?php echo $this->Html->link('Trả lời', array('action' => 'admin_answer', $Question['Question']['id']), array('class' => 'btn btn-default btn-xs')); ?>
					<?php echo $this->Html->link('Xoá', array('action' => 'admin_del', $Question['Question']['id']), array('class' => 'btn btn-default btn-xs')); ?>
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