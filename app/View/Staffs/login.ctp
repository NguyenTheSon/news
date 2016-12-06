<div class="login-container animated fadeInUp">		
	<div class="row">
        <div class="col-sm-6 col-md-4 col-xs-12 col-md-offset-4 col-sm-offset-3">
			<h1 class="page-heading text-center" style="color:#fff;">Đăng Nhập</h1>	
			<?php echo $this->Form->create('User', array('action' => 'login', 'class' => 'body bg-gray', 'escape' => false)); ?>
			<div class="form-group has-feedback lg left-feedback no-label">
			  <?php echo $this->Form->input('phonenumber', array('class' => 'form-control no-border input-lg rounded', 'placeholder' => 'Phone Number', 'autofocus' => 'autofocus', 'label' => false)); ?>
			  <span class="fa fa-user form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback lg left-feedback no-label">
			 <?php echo $this->Form->input('password', array('class' => 'form-control no-border input-lg rounded form-group', 'placeholder' => 'Mật khẩu', 'label' => false)); ?>
			  <span class="fa fa-unlock-alt form-control-feedback"></span>
			</div>

			<div class="form-group">
				<input type="hidden" name="data[User][remember]" id="UserActive_" value="0">
				<input type="checkbox" name="data[User][remember]" class="i-blue-flat" value="1" id="UserActive">
				<label for="UserActive" style="color:#fff;">Ghi nhớ mật khẩu</label>
			</div>
			<?php echo $this->Form->button('Đăng nhập', array('class' => 'btn btn-info btn-lg btn-perspective btn-block')); ?>
			<?php echo $this->Form->end(); ?>
				
		</div>
	</div>
</div>