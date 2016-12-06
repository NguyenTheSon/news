<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $title_for_layout; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,800italic,400,700,800' rel='stylesheet' type='text/css'>
<?php echo $this->Html->css(array('bootstrap.min.css', 'css.css', 'style.css')); ?>
<lin1k rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<!--[if lt IE 9]><?php echo $this->Html->script(array('html5shiv.js', 'respond.min.js')); ?><![endif]-->
<?php echo $this->Html->script(array('bootstrap.min.js', 'js.js', 'jquery.min.js', 'jquery.easing.min.js', 'jquery.nivo.slider.pack.js')); ?>
<?php echo $this->App->js(); ?>
<?php echo $this->fetch('meta'); ?>
<?php echo $this->fetch('css'); ?>
<?php echo $this->fetch('script'); ?>

  <script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });
  </script> 
</head>


<body>
  <div id="main">

	<div id="menubar">
	  <div id="welcome">
	    <h1><a href="#">Welcome To Akiba</a></h1>
	  </div><!--close welcome-->
    </div><!--close menubar-->	
    
	<div class="content">
		<div class="container">

			<?php echo $this->Session->flash(); ?>
			<br />
			<div id="content">
				<?php echo $this->fetch('content'); ?>
			</div>
			<br />
			<div id="msg"></div>
			<br />

		</div>
	</div>
  
  <div id="footer">
	  <a href="http://mqsolution.vn"><p class="copyright">Copyright&copy; MQSolutions 2014 All Rights Reserved</p></a>
  </div><!--close footer-->  
  
</body>
</html>
