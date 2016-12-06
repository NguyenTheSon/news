<?php
$logger = $this->Session->read('Auth.User');
?>

<div class="sidebar-left sidebar-nicescroller ">
	<ul class="sidebar-menu">
		<li>
			<?php echo $this->Html->link('<i class="fa fa-rss icon-sidebar"></i>Home<span class="label label-success span-sidebar">UPDATED</span>', array('controller' => 'Homes', 'action' => 'dashboard', 'admin' => true), array('escape' => false)); ?>
		</li>

		<?php if($this->Permission->checkView($logger['id'], 'Categories', 'admin_index')) :?>
			<li>
				<?php echo $this->Html->link('<i class="fa fa-puzzle-piece icon-sidebar"></i>Quản lý chuyên mục', array('controller' => 'categories', 'action' => 'index', 'admin' => true), array('escape' => false));?>
			</li>
		<?php endif;?>


		<?php if($this->Permission->checkView($logger['id'], 'News', 'admin_index')) :?>
			<li>
				<?php echo $this->Html->link('<i class="fa fa-newspaper-o icon-sidebar"></i>Quản lý tin tức', array('controller' => 'news', 'action' => 'index', 'admin' => true), array('escape' => false));?>
			</li>
		<?php endif;?>

		<?php if($this->Permission->checkView($logger['id'], 'Advertises', 'admin_index')) :?>
			<li>
				<?php echo $this->Html->link('<i class="fa fa-puzzle-piece icon-sidebar"></i>Quản lý quảng cáo', array('controller' => 'Advertises', 'action' => 'admin_index', 'admin' => true), array('escape' => false));?>
			</li>
		<?php endif;?>

		<?php if($this->Permission->checkView($logger['id'], 'Awards', 'admin_index')) :?>
			<li>
				<?php echo $this->Html->link('<i class="fa fa-puzzle-piece icon-sidebar"></i>Quản lý bài thi Hair awards', array('controller' => 'awards', 'action' => 'admin_index', 'admin' => true), array('escape' => false));?>
			</li>
		<?php endif;?>

		
		<?php if($this->Permission->checkView($logger['id'], 'Permissions', 'admin_index')) :?>
			<li>
				<?php echo $this->Html->link('<i class="fa fa-stack-overflow icon-sidebar"></i>Phân quyền', array('controller' => 'permissions', 'action' => 'index', 'admin' => true), array('escape' => false));?>
				<ul class="sub-menu" style="display:none;">
					<li>
						<?php echo $this->Html->link('Theo nhóm', array('controller' => 'permissions', 'action' => 'index', 'admin' => true)) ;?>
					</li>
					<?php if($this->Permission->checkView($logger['id'], 'Permissions', 'admin_user_lists')) :?>
						<li>
							<?php echo $this->Html->link('Theo người dùng', array('controller' => 'permissions', 'action' => 'user_lists', 'admin' => true));?>
						</li>
					<?php endif;?>
					<?php if($this->Permission->checkView($logger['id'], 'Actions', 'admin_index')) :?>
						<li>
							<?php echo $this->Html->link('Cập nhật Actions', array('controller' => 'actions', 'action' => 'index', 'admin' => true));?>
						</li>
					<?php endif;?>
				</ul>
			</li>
		<?php endif;?>

	</ul>
</div>