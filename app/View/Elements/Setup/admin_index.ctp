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
	        'controller' => 'Setup',
	        'action' => 'index',
	    ),
	    'model' => 'Setup'
	    ));
?>
<?php echo $this->Html->image('loading.gif', array('class' => 'hide', 'id' => 'loader')); ?>
<div id = 'resultField'>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-fixed">
			<tr>
				<th style="width: 15%;"><?php echo $this->Paginator->sort('fullname','Khách Hàng');?></th>
				<th style="width: 20%;"><?php echo $this->Paginator->sort('phone','Điện Thoại');?></th>
				<th style="width: 20%;">Thời Gian</th>
				<th style="width: 40%;">Dịch Vụ</th>
				<th style="width: 20%;">Khách Đến</th>
				<!--th style="width: 15%;" class="actions">Action</th!-->
				
			</tr>
			<?php foreach ($Setups as $Setup): ?>
			<tr>
				<td><?php echo h($Setup['Setup']['fullname']); ?></td>
				<td><?php echo h($Setup['Setup']['phone']); ?></td>
				<td><?php echo $Setup['Setup']['time']."<br>".$Setup['Setup']['date']; ?></td>
				<td><?php foreach ($Setup['Service'] as $key => $Service) {
						echo $Service['Service']['name']." (".$Service['StaffGroup']['name'].")<br>";
				} ?></td>
				<td><?php echo $this->Form->select('data[Setup][state]',
                    		array(
                    			"0" => "Khách Chưa đến",
                    			"1" => "Khách đã đến", 
                    			"2" => "Khách không đến"),
                    		 array(
                    		 	'empty' => false,
                    		 	"class" => "changestate", 
                    		 	"data-id" => $Setup['Setup']['id'],
                    		 	"default" => $Setup['Setup']['state'],
                    		)
                    	);
                     ?>
				</td>
				<!--td class="actions">
					<?php echo $this->Html->link('Chi Tiết', array('action' => 'view', $Setup['Setup']['id']), array('class' => 'btn btn-default btn-xs')); ?>
					<?php echo $this->Html->link('Sửa', array('action' => 'edit', $Setup['Setup']['id']), array('class' => 'btn btn-default btn-xs')); ?>
				</td!-->
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
				window.location = '<?php echo Router::url(array("controller" => "Bills", "action" =>"add"));?>/'+id;
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