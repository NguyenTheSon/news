<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $title_for_layout; ?></title>
<?php echo $this->Html->css(array('bootstrap.min.css', '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css', 'admin.css', 'reset', 'text', 'grid', 'layout', 'nav')); ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<?php 
	echo '<!--[if IE 6]>'.$this->Html->css('ie6').'<![endif]-->';
	echo '<!--[if IE 7]>'.$this->Html->css('ie').'<![endif]-->';
?>
<?php echo $this->Html->script(array('bootstrap.min.js', 'admin.js', 'jquery-1.3.2.min.js', 'jquery-ui.js', 'jquery-fluid16.js')); ?>

<?php echo $this->App->js(); ?>

<?php echo $this->fetch('css'); ?>
<?php echo $this->fetch('script'); ?>
</head>
<body>
	<div class="navbar navbar-inverse navbar-static-top" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">アキハバラ　マネジメントツール</a></h1>
		</div>
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li ><?php echo $this->Html->link('RSS', array('controller' => 'Rss', 'action' => 'index', 'admin' => true)); ?></li>
				<li><?php echo $this->Html->link('キャラクター', array('controller' => 'Character', 'action' => 'index', 'admin' => true)); ?></li>
				<li><?php echo $this->Html->link('ユーラー', array('controller' => 'users', 'action' => 'index', 'admin' => true)); ?></li>
				<li><?php echo $this->Html->link('お知らせ', array('controller' => 'Notification', 'action' => 'index', 'admin' => true)); ?></li>
				<li><?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout', 'admin' => false)); ?></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>

	<div class="content">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
		<div class="clear"></div>
	</div>

	<div class="footer">
		<p>&copy; <?php echo date('Y'); ?> <?php echo env('HTTP_HOST'); ?></p>
	</div>

	<div class="sqldump">
		<?php echo $this->element('sql_dump'); ?>
	</div>

</body>
</html>

