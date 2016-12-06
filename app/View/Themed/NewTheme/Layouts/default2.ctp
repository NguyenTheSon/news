<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $title_for_layout; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,800italic,400,700,800' rel='stylesheet' type='text/css'>
<?php echo $this->Html->css(array('bootstrap.min.css', 'css.css', 'default.css')); ?>
<lin1k rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<!--[if lt IE 9]><?php echo $this->Html->script(array('html5shiv.js', 'respond.min.js')); ?><![endif]-->
<?php echo $this->Html->script(array('bootstrap.min.js', 'js.js')); ?>
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
<!--Header Background Part Starts -->

<div id="header-bg">
	<!--Header Contant Part Starts -->
	<div id="header">  
		<!-- <a href="index.html"><img src="images/logo.gif" alt="Package" width="205" height="62" border="0" class="logo" title="Package" /></a> -->
		<!--Login Background Starts -->
		<div id="login-bg">
			<!--Login Area Starts -->
			<div id="login-area">
				<form action="" method="post" name="Login" id="Login">
					<label>Members Login:</label>
					<input type="text" name="username" id="username" />
					<input type="password" name="pass" id="pass" />
					<input type="image" src="images/login-btn.gif" class="login-btn" alt="Login" title="Login" />
					<br class="spacer" />
				</form>
			</div>
			<!--Login Area Ends -->
		</div>
		<!--Login Background Ends -->
		<br class="spacer" />
	</div>
	<!--Header Contant Part Ends -->
</div>
<!--Header Background Part Ends -->
<?php echo $this->element('menu', array('cache' => true)); ?>
<!--Our Company Bacground Part Starts -->
<div id="ourCompany-bg">
	<!--Our Company Part Starts -->
	<div id="ourCompany-part">
		<h2 class="ourCompany-hdr"><?php echo $title_for_layout; ?></h2>
		<?php echo $content_for_layout; ?>
		<br class="spacer" />
	</div>
	<!--Our Company Part Ends -->
</div>


<!--Our Company Bacground Part Ends -->
<!--Future Plans Part Starts -->
<div id="futurePlan-bg">
	<!--Future Plans Contant Part Starts -->
	<div id="futurePlanContant">
		<!--Projects 2007 Part Starts -->
		<div id="projPart">
			<h2 class="proj-hdr">Projects <span>2007</span></h2>
			<ul class="pic">
				<li><a href="#"><img src="images/future-pic-1.jpg" alt="Pic 1" title="Pic 1" width="82" height="74" /></a></li>
				<li><a href="#"><img src="images/future-pic-2.jpg" alt="Pic 2" title="Pic 2" width="82" height="74" /></a></li>
				<li class="noRightMargin"><a href="#"><img src="images/future-pic-3.jpg" alt="Pic 3" title="Pic 3" width="82" height="74" /></a></li>
			</ul>
			<br class="spacer" />
			<h3 class="sub-hdr">We Have For This year:</h3>
			<p>Quisque laoreet, elit at tincidunt porta, massa torr Porttitor magna, at vehicula pede dui id enim. Pellentesque</p>
			<a href="#" class="more-btn" title="READ MORE"></a>
		</div>
		<!--Projects 2007 Part Ends -->
		<!--Future Part Starts -->
		<div id="futurePart">
			<h2 class="future-hdr">Future Plans</h2>
			<h3 class="future-subHdr">Sed semper, enim id fringilla posuere</h3>
			<p>mauris diam dignissim magna, id ornare libero quam innvallis erat eu lectus. Aenean bibendum facilisis ante.</p>
			<p>Pellentesque id nunc at leo vestibulum lobortis. Integer luctus leo non felis. Proin in justo. Donec sapien enim, porta quis, aliquam sit amet, condimentum nonummy, lorem. Nullam mi metus, cursus in, porta vel, fringilla et, orci. Integer sit amet quam id turpis ultrices</p>
			<img src="images/future-img.gif" alt="Image" title="Image" width="127" height="141" />
			<br class="spacer" />
		</div>
		<!--Future Part Ends -->
		<br class="spacer" />
	</div>
	<!--Future Plans Contant Part Ends -->
</div>
<!--Footer Part Starts -->
<div id="footer-bg">
	<!--Footer Menu Part Starts -->
	<div id="footer-menu">
		<ul class="footMenu">
			<li class="noDivider"><a href="#" title="Home">Home</a></li>
			<li><a href="#" title="About">About</a></li>
			<li><a href="#" title="Services">Services</a></li>
			<li><a href="#" title="Support">Support</a></li>
			<li><a href="#" title="Chat">Chat</a></li>
			<li><a href="#" title="History">History</a></li>
			<li><a href="#" title="Contact">Contact</a></li>
		</ul>
		<br class="spacer" />
		<p class="copyright">Copyright?&copy; Package 2007 All Rights Reserved</p>
		<p class="copyright topPad">Powered by <a href="http://www.templatekingdom.com/Web-Templates/Web-Design/" target="_blank" title="TemplateKingdom.com">TemplateKingdom.com</a></p>
	</div>
	<!--Footer Menu Part Ends -->
</div>
<!--Footer Part Ends -->
</body>
</html>