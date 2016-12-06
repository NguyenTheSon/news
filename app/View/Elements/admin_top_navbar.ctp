<div class="top-navbar">
	<div class="top-navbar-inner">
		<div class="logo-brand">
			<div class="navbar-brand" href="#">Trang tin tức</div>
		</div>
		
		<div class="top-nav-content">
			
			<div class="btn-collapse-sidebar-left">
				<i class="fa fa-bars"></i>
			</div>

			<div class="btn-collapse-nav" data-toggle="collapse" data-target="#main-fixed-nav">
				<i class="fa fa-plus icon-plus"></i>
			</div>
			<ul class="nav-user navbar-right">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-user icon-sidebar"></i>
						Hi, <?php echo $loggedin['name'];?>
					</a>
					<ul class="dropdown-menu square primary margin-list-rounded with-triangle">
						<li><?php echo $this->Html->link('Đổi mật khẩu', array('controller' => 'users', 'action' => 'changepassword')); ?></li>
						<li><?php echo $this->Html->link('Thoát', array('controller' => 'users', 'action' => 'logout', 'admin' => false)); ?></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>