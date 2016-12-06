<?php if  ($showForm == true) { ?>
<h2> Reset Password</h2>

<div class="row">
	<div class="col-sm-4">	
		<?php echo $this->Form->create('Users');?>
		<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
		<?php echo $this->Form->input('username', array('label' => 'Email', 'class' => 'form-control', 'value' => $this->Form->value('Users.username'), 'readonly' => 'readonly')); ?>
		<br />
		<?php echo $this->Form->input('password', array('label' => 'New Password', 'class' => 'form-control', 'value' => '')); ?>
		<br />
		<?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary'));?>
		<?php echo $this->Form->end();?>
	</div>
</div>
<?php } ?>