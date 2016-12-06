<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $title_for_layout; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,800italic,400,700,800' rel='stylesheet' type='text/css'>
<?php echo $this->Html->meta('icon'); ?>
<?php echo $this->Html->css(array('bootstrap.min.css', 'css.css', 'reset', 'text', 'grid', 'layout', 'nav')); ?>
<lin1k rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<!--[if lt IE 9]><?php echo $this->Html->script(array('html5shiv.js', 'respond.min.js')); ?><![endif]-->
<?php 
	echo '<!--[if IE 6]>'.$this->Html->css('ie6').'<![endif]-->';
	echo '<!--[if IE 7]>'.$this->Html->css('ie').'<![endif]-->';
?>
<?php echo $this->Html->script(array('bootstrap.min.js', 'js.js', 'jquery-1.3.2.min.js', 'jquery-ui.js', 'jquery-fluid16.js')); ?>
<?php echo $this->App->js(); ?>
<?php echo $this->fetch('meta'); ?>
<?php echo $this->fetch('css'); ?>
<?php echo $this->fetch('script'); ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo Configure::read('Settings.ANALYTICS'); ?>', '<?php echo Configure::read('Settings.DOMAIN'); ?>');
  ga('send', 'pageview');

</script>
</head>

<body>
	<div class="container_16">			
		<div class="grid_16">
			<h1 id="branding">
				<a href="/">Wellcome to Akiba</a>
			</h1>
		</div>
		<div class="clear"></div>
		<div class="grid_16">
			 <?php // Possible menu here ?>
		</div>
		
		<div class="clear" style="height: 10px; width: 100%;"></div>
		
			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>
		
		<div class="clear"></div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
