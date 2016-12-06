<ul class="nav main">
	<li ><?php echo $this->Html->link('RSS', array('controller' => 'Rss', 'action' => 'index', 'admin' => true)); ?></li>
	<li><?php echo $this->Html->link('キャラクター', array('controller' => 'Character', 'action' => 'index', 'admin' => true)); ?></li>
	<li><?php echo $this->Html->link('ユーラー', array('controller' => 'users', 'action' => 'index', 'admin' => true)); ?></li>
	<li><?php echo $this->Html->link('お知らせ', array('controller' => 'Notification', 'action' => 'index', 'admin' => true)); ?></li>
	<li><?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout', 'admin' => false)); ?></li>
</ul>
