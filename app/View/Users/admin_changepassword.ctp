<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title">Đổi mật khẩu</h3>
  </div>
  <div class="panel-body">
	    <div class="row">
	    	<div class="col-md-6 col-sm-6 ">
				<?php echo $this->Form->create('User');?>
				<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
				<?php echo $this->Form->input('email', array('class' => 'form-control form-group', 'placeholder' => $this->Form->value('User.email'), 'label' => false, 'disabled' => 'disabled')); ?>
				<?php echo $this->Form->input('password', array('class' => 'form-control form-group', 'placeholder' => 'Mật khẩu', 'label' => false)); ?>
				<?php echo $this->Form->button('Đổi mật khẩu', array('class' => 'btn btn-primary btn-flat btn-block'));?>
				<?php echo $this->Form->end();?>
            </div>
        </div>
	</div>
</div>