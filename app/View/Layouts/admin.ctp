<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $title_for_layout; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php echo $this->Html->css(array('bootstrap.min.css', 'style.css','admin.css', 'style-responsive.css', 'animate.min.css', 
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
//		'../plugins/c3-chart/c3.min.css',
		'../plugins/slider/slider.min.css',
		'../plugins/toastr/toastr.css',
		'../plugins/font-awesome/css/font-awesome.min.css',
		'jquery.tagsinput.min.css',
		'jquery-ui.css'
		)); ?>


<!--[if lt IE 9]><?php echo $this->Html->script(array('html5shiv.js', 'respond.min.js')); ?><![endif]-->
<?php echo $this->Html->script(array(
		'jquery-1.11.1.min.js',
		'jquery-ui.js',
		'admin.js',
		'bootstrap.min.js', 'apps.js',
		'../plugins/retina/retina.min.js',
		'date.format.js',
		'../plugins/toastr/toastr.js',
		'socket.io.js',
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
		'jquery.validate.min.js',
		'jquery.tagsinput.min.js'
		)); ?>

<?php echo $this->App->js(); ?>
<?php echo $this->fetch('meta'); ?>
<?php echo $this->fetch('css'); ?>
<?php echo $this->fetch('script'); ?>


</head>
<body>
	<?php echo $this->element('admin_top_navbar');?>
	<?php echo $this->element('admin_sideleft');?>

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

		<?php echo $this->fetch('content'); ?>
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>

