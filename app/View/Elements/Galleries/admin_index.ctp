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
	        'controller' => 'Galleries',
	        'action' => 'index',
	    ),
	    'model' => 'Gallery'
	    ));
?>
<?php echo $this->Html->image('loading.gif', array('class' => 'hide', 'id' => 'loader')); ?>
<div id = 'resultField'>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-fixed">
			<tr>
				<th style="width: 40%;">Images/Video</th>
				<th style="width: 40%;">Caption</th>
				<th style="width: 20%;" class="actions">Action</th>
				
			</tr>
			<?php foreach ($Galleries as $Gallery): ?>
			<tr>
				<td><img src="<?php 
					if($Gallery['Gallery']['video']!="")
					{
						preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $Gallery['Gallery']['video'], $img);
						echo h("http://img.youtube.com/vi/".$img[1]."/0.jpg");

					}
					else
						echo h($Gallery['Gallery']['image']); 
				?>" style="max-height: 200px;"></td>
				<td><?php echo h($Gallery['Gallery']['caption']); ?></td>
				<td class="actions">
					<?php echo $this->Html->link('Sửa', array('action' => 'admin_edit', $Gallery['Gallery']['id']), array('class' => 'btn btn-default btn-xs')); ?>
					<?php echo $this->Html->link('Xoá', array('action' => 'admin_delete', $Gallery['Gallery']['id']), array('class' => 'btn btn-default btn-xs'),__('Bạn có muốn xóa ảnh này?')); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php echo $this->element('pagination-counter'); ?>
		<?php echo $this->element('pagination'); ?>
	</div>
</div>