<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $title_for_layout; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,800italic,400,700,800' rel='stylesheet' type='text/css'>
<?php echo $this->Html->css(array('bootstrap.min.css', 'style.css', 'style-responsive.css', 'animate.min.css', 
		'../plugins/weather-icon/css/weather-icons.min.css',
		'../plugins/prettify/prettify.min.css',
		'../plugins/magnific-popup/magnific-popup.min.css',
		'../plugins/owl-carousel/owl.carousel.min.css',
		'../plugins/owl-carousel/owl.theme.min.css',
		'../plugins/owl-carousel/owl.transitions.min.css',
		'../plugins/chosen/chosen.min.css',
		'../plugins/icheck/skins/all.css',
		'../plugins/datepicker/datepicker.min.css',
		'../plugins/timepicker/bootstrap-timepicker.min.css',
		'../plugins/validator/bootstrapValidator.min.css',
		'../plugins/summernote/summernote.min.css',
		'../plugins/markdown/bootstrap-markdown.min.css',
		'../plugins/datatable/css/bootstrap.datatable.min.css',
		'../plugins/morris-chart/morris.min.css',
		'../plugins/c3-chart/c3.min.css',
		'../plugins/slider/slider.min.css',
		'../plugins/toastr/toastr.css',
		'../plugins/font-awesome/css/font-awesome.min.css',		

		)); ?>

<lin1k rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

<!--[if lt IE 9]><?php echo $this->Html->script(array('html5shiv.js', 'respond.min.js')); ?><![endif]-->
<?php echo $this->Html->script(array('bootstrap.min.js', 'apps.js',
		'../plugins/retina/retina.min.js',
		'../plugins/nicescroll/jquery.nicescroll.js',
		'../plugins/slimscroll/jquery.slimscroll.min.js',
		'../plugins/backstretch/jquery.backstretch.min.js',
		'../plugins/skycons/skycons.js',
		'../plugins/prettify/prettify.js',
		'../plugins/magnific-popup/jquery.magnific-popup.min.js',
		'../plugins/owl-carousel/owl.carousel.min.js',
		'../plugins/chosen/chosen.jquery.min.js',
		'../plugins/icheck/icheck.min.js',
		'../plugins/datepicker/bootstrap-datepicker.js',
		'../plugins/timepicker/bootstrap-timepicker.js',
		'../plugins/mask/jquery.mask.min.js',
		'../plugins/validator/bootstrapValidator.min.js',
		'../plugins/datatable/js/jquery.dataTables.min.js',
		'../plugins/datatable/js/bootstrap.datatable.js',
		'../plugins/summernote/summernote.min.js',
		'../plugins/markdown/markdown.js',
		'../plugins/markdown/to-markdown.js',
		'../plugins/markdown/bootstrap-markdown.js',
		'../plugins/slider/bootstrap-slider.js',
		'../plugins/toastr/toastr.js',
		'../plugins/easypie-chart/easypiechart.min.js',
		'../plugins/easypie-chart/jquery.easypiechart.min.js',
		'../plugins/jquery-knob/jquery.knob.js',
		'../plugins/jquery-knob/knob.js',
		'../plugins/flot-chart/jquery.flot.js',
		'../plugins/flot-chart/jquery.flot.tooltip.js',
		'../plugins/flot-chart/jquery.flot.resize.js',
		'../plugins/flot-chart/jquery.flot.selection.js',
		'../plugins/flot-chart/jquery.flot.stack.js',
		'../plugins/flot-chart/jquery.flot.time.js',
		'../plugins/morris-chart/raphael.min.js',
		'../plugins/morris-chart/morris.min.js',
		'../plugins/c3-chart/d3.v3.min.js',
		'../plugins/c3-chart/c3.min.js',
		)); ?>

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
	<?php echo $this->element('top_navbar');?>
	<?php echo $this->element('sideleft');?>

	<div class="content page-content">
		<div class="container-fluid">
		<?php
        	$flashMessage = $this->Session->flash();
	        if ($flashMessage !== false) {
	            echo $this->element('custom_flash', array(
	                'message' => $flashMessage
	            ));
	        }
		?>

		<!-- <ol class="breadcrumb default square rsaquo sm">
			<li><?php echo $this->Html->link('<i class="fa fa-home"></i>', array('controller' => 'admin', 'action' => 'index', 'admin' => true), array('escape' => false)); ?> / <?php echo $this->Html->getCrumbs(' / '); ?></li>
		</ol> -->

		<?php echo $this->fetch('content'); ?>
		</div>
	</div>

</body>
</html>

