<?php

$articlePaginator = $this->Paginator;

$articlePaginator->options(array(
		'update'=>'#resultField',
		'evalScripts' => true,
	    'before' => $this->Js->get('#loader')->effect(
	        'fadeIn',
	        array('buffer' => false)
	    ),
	    'complete' => $this->Js->get('#loader')->effect(
	        'fadeOut',
	        array('buffer' => false)
	    ),
	   	'url' => array(
	        'controller' => 'ProductReports',
	        'action' => 'index',
	        (isset($this->request->params['pass'][0])? $this->request->params['pass'][0]:'0')
	    ),
	    'model' => 'ProductReports'
	    ));
?>
<?php echo $this->Html->image('loading.gif', array('class' => 'hide', 'id' => 'loader')); ?>
<div id = 'resultField'>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-condensed table-hover table-th-block table-primary table-fixed">
			<tr>
				<th style="width: 15%;"><?php echo $this->Paginator->sort('ProductReport.subject','Chủ đề');?></th>
				<th style="width: 15%;"><?php echo $this->Paginator->sort('ProductReport.details','Nội dung');?></th>
				<th style="width: 10%;"><?php echo $this->Paginator->sort('Product.name','Tên Sản Phẩm');?></th>
				<th style="width: 10%;"><?php echo $this->Paginator->sort('Product.category_id','Chuyên mục');?></th>	
				<th style="width: 10%;"><?php echo $this->Paginator->sort('ProductReport.reporter_id','Người Report');?></th>
				
				<th style="width: 7%;">Số Report</th>
				<th style="width: 10%;"><?php echo $this->Paginator->sort('Product.created','Ngày Đăng');?></th>
				<th style="width: 10%;"><?php echo $this->Paginator->sort('ProductReport.created','Ngày Report');?></th>
				<th style="width: 10%;" class="actions">Action</th>
				
			</tr>
			<?php foreach ($Products as $Product):?>
			<tr class="report-row" <?php if(!$Product['ProductReport']['is_viewed']){ echo "style='font-weight:bold;'";} ?>  id="report-id-<?php echo h($Product['ProductReport']['id']); ?>">
				<td><?php echo h($Product['ProductReport']['subject']); ?></td>
				<td><?php echo h($Product['ProductReport']['details']); ?></td>
				<td><?php echo h($Product['Product']['name']); ?></td>
				<td><?php echo h($Product['Product']['category_name']); ?></td>
				<td><?php echo h($Product['Product']['reporter_name']); ?></td>
				
				<td><?php echo h($Product['Product']['report']); ?></td>
				<td><?php echo h($Product['Product']['created']); ?></td>
				<td><?php echo h($Product['ProductReport']['created']); ?></td>
				<td class="actions">
				<button type="button" class="btn btn-default btn-xs details" pid='<?php echo h($Product['Product']['id']); ?>' rid="<?php echo h($Product['ProductReport']['id']); ?>" data-toggle="modal" data-target=".bs-example-modal-lg">Chi Tiết</button>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php echo $this->element('pagination-counter'); ?>
		<?php echo $this->element('pagination'); ?>
	</div>
</div>

