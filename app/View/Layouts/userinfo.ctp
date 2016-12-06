<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

?>
<!doctype html>
<html>

<!-- Mirrored from lithemes.com/blackair/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 01 Sep 2015 03:19:03 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,200,300' rel='stylesheet' type='text/css'>
<? echo $this->Html->css(array(
      '../news/css/master.css',
              'bootstrap.css',
    
      'style.css',
      'animate.min.css',
      '../plugins/toastr/toastr.css',
  ));
?>
<? echo $this->Html->script(array(
      '../news/js/jquery.1.11.2.js',
      'bootstrap.js',
      '../news/js/function.js',
      '../news/js/bootstrap-datepicker.js',
      '../news/js/parallax.js',
      '../news/js/scorll.js',
      '../news/js/jquery.easing.min.js',
      '../news/js/slick.js',
      '../news/js/menu.js',
      '../news/js/ios-timer.js',
      '../news/js/jquery.fencybox.js',
      '../news/js/jquery.mousewheel-3.0.6.pack.js',
      '../news/js/jquery.validate.js',
      '../plugins/toastr/toastr.js',
    ));
?>
<!-- Latest compiled and minified CSS -->

<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>
<body>
<div id="overlay"></div>
<div id="page">
  <header id="pagetop">
    <?php echo $this->element('menu'); ?>
  </header>
  <?php
            $flashMessage = $this->Session->flash();
            if ($flashMessage !== false) {
                echo $this->element('custom_flash', array(
                    'message' => $flashMessage
                ));
            }
      ?>
    <section id="userinfo">
    <div class="container">
      <div class="row">
        <div class="col-sm-13 col-md-3 col-lg-3 box left-menu">
            <ul class="nav navmenu-nav">
              <li class="active"><a href="#">Thay đổi thông tin</a></li>
              <li><a href="#">Lịch sử đặt lịch</a></li>

            </ul>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-9">
            <?php echo $this->fetch('content'); ?>
          
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </section>
  <!--FOOTER--!-->
  <?php echo $this->element('footer'); ?>
</div>
</body>
<!-- Mirrored from lithemes.com/blackair/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 01 Sep 2015 03:21:05 GMT -->
</html>


        
