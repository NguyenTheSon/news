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
<title><?php echo $header['title'];?></title>
<meta name="title" content='<?php echo $header['title'];?>'/>
<meta name="site_name" content='<?php echo $header['site_name'];?>'/>
<meta name="description" content='<?php echo $header['description'];?>' />
<meta name="keywords" content='<?php echo $header['keywords'];?>'/>
<meta property="og:type" content="<?php echo $header['type'];?>" />
<meta property="og:title" content='<?php echo $header['title'];?>' />
<meta property="og:description" content='<?php echo $header['description'];?>' />
<meta property="og:site_name" content='<?php echo $header['site_name'];?>' />
<meta property="og:image" content='<?php echo $header['image'];?>' />
 <meta property="fb:app_id" content="1602684293325237" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&subset=latin,vietnamese' rel='stylesheet' type='text/css'>
<? echo $this->Html->css(array(
      '../news/css/master.css',
              'bootstrap.css',
    
      'style.css',
      'animate.min.css',
      '../plugins/toastr/toastr.css',
      'font-awesome.min.css'
  ));
?>
<? echo $this->Html->script(array(
      '../news/js/jquery.1.11.2.js',
      'bootstrap.js','script.js',
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
      'imagesloaded.pkgd.js',
      'masonry.pkgd.min.js'

    ));
?>
<!-- Latest compiled and minified CSS -->

<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php echo $this->element('preloader');?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.4&appId=1602684293325237";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</head>
<body>
<div id="overlay"></div>
<?php echo $this->element('menumobile'); ?>
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
  <?php echo $this->fetch('content'); ?>
  <!--FOOTER--!-->
</div>
</body>
<!-- Mirrored from lithemes.com/blackair/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 01 Sep 2015 03:21:05 GMT -->
</html>


        
