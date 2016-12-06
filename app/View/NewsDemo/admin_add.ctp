<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title">Đăng tin mới</h3>
  </div>
  <div class="panel-body">
	    <div class="row">
	    	<div class="col-md-6 col-sm-6 ">
	    	<?php echo $this->Form->create('News');?>
			<?php echo $this->Form->input('id'); ?>
			<?php echo $this->Form->input('title', array('class' => 'form-control form-group', 'label' => 'Tiêu Đề')); ?>
		

			<?php echo $this->Form->input('content', array('class' => 'form-control form-group', 'label' => 'Nội Dung', 'type' => 'textarea')); ?>
		
			<?php echo $this->Html->link('Quay Lại', array('action' => 'index'), array('class' => 'btn btn-warning')); ?>
			<?php echo $this->Form->button('Đăng Tin', array('class' => 'btn btn-primary')); ?>

			<?php echo $this->Form->end(); ?>
            </div>
        </div>
	</div>
</div>