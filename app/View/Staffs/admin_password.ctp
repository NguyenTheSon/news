<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title">パスワード変更</h3>
  </div>
  <div class="panel-body">
	    <div class="row">
	    	<div class="col-md-12 col-sm-12 form-group">
	    		ID: <?php echo $this->Form->value('User.email'); ?>
	    	</div>
	    	<div class="col-md-6 col-sm-6 ">
				<?php echo $this->Form->create('User');?>
				<?php echo $this->Form->input('id', array('class' => 'form-control form-group')); ?>
				<?php echo $this->Form->input('password', array('class' => 'form-control form-group', 'label' => false, 'placeholder' => 'パスワード', 'value' => '')); ?>
				<?php echo $this->Form->button('保存', array('class' => 'btn btn-primary'));?>
				<?php echo $this->Form->end();?>
            </div>
        </div>
	</div>
</div>