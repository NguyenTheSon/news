<section class="container">
	<section class="login-form">
		<?php echo $this->Form->create('User', array('action' => 'login', 'class' => 'body bg-gray', 'role' => 'login', 'escape' => false)); ?>
		<div>
			<img src="../img/logo_medium.png" alt="" />
			<h4>Đăng nhập</h4>
		</div>			
		<?php echo $this->Form->input('phonenumber', array('class' => 'form-control no-border input-lg rounded', 'placeholder' => 'Phone Number', 'autofocus' => 'autofocus', 'label' => false)); ?>
		<?php echo $this->Form->input('password', array('class' => 'form-control no-border input-lg rounded form-group', 'placeholder' => 'Mật khẩu', 'label' => false)); ?>
		<?php echo $this->Form->button('Đăng nhập', array('class' => 'btn btn-lg btn-block btn-info')); ?>
		<?php echo $this->Form->end(); ?>
	</section>
</section>