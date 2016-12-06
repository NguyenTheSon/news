<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title">Chi tiết tin tức</h3>
  </div>
  <div class="panel-body">
	    <div class="row">
	    	<div class="col-md-6 col-sm-6 ">
	    	<?php echo $this->Form->create('News');?>
			<?php echo $this->Form->input('id'); ?>
			<?php echo $this->Form->input('title', array('class' => 'form-control form-group', 'label' => 'Tiêu Đề')); ?>
		

			<?php echo $this->Form->input('content', array('class' => 'form-control form-group', 'label' => 'Nội Dung', 'type' => 'textarea')); ?>
		
			<?php echo $this->Html->link('Quay Lại', array('action' => 'index'), array('class' => 'btn btn-warning')); ?>
			<?php echo $this->Form->button('Lưu Lại', array('class' => 'btn btn-primary')); ?>
			<?php echo $this->Html->link('Xóa', array('action' => 'delete',$this->data['News']['id']), array('class' => 'btn btn-danger pull-right')); ?>

			<?php echo $this->Form->end(); ?>
            </div>
        </div>
	</div>
</div>