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
<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' xmlns:b='http://www.google.com/2005/gml/b' xmlns:data='http://www.google.com/2005/gml/data' xmlns:expr='http://www.google.com/2005/gml/expr'>
<head>
  <meta content='text/html; charset=UTF-8' http-equiv='Content-Type'/>
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
  <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&subset=latin,vietnamese' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Bitter:400,700,400italic' rel='stylesheet' type='text/css'/>
  <link href='//fonts.googleapis.com/css?family=Lato:400,400italic|Open+Sans:400italic,600italic,400,600|Coda:800)' media='screen' rel='stylesheet' type='text/css'/>
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400' rel='stylesheet' type='text/css'/>
  
  <link href='//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' rel='stylesheet'/>
  <?php
  echo $this->Html->css(array(
    '../news/css/master.css',
    'bootstrap.css',
    '../news/blogs/reset.css',
    '../news/css/input.css',
    'animate.min.css',
    '../plugins/toastr/toastr.css',
    'style.css',
    ));
    ?>
    <style type='text/css'>
      .sidebar-wrapper {   display: none;  }
      .main-wrapper {width:auto;margin:0;}
    </style>
    <?php echo $this->Html->script(array(
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
      ));
      ?>
      <div id="fb-root"></div>
      <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.4&appId=1602684293325237";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>
    </head>
    <body style="background: url(/img/cover.jpg); background-position: center center; background-attachment:fixed; background-size: cover; ">
     
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
        <div class='header-wrapper'>
          <div id='logo'>
            <div class='ct-wrapper'>
              <div class='header-inner-wrap'>
                <div class='header section' id='header'>
                  <div class='widget Header' id='Header1'>
                    <div id='header-inner' style="margin-top:95px;">
                      <h2 style="color: #fff;">Dòng Thời Gian</h2>
                    </div>
                  </div>
                </div>
              </div><!-- /header-inner-wrap -->
              <div class='clr'></div>
            </div>
          </div>
        </div>
        <div class='clr'></div>
        <div id='capo'></div>
        <?php echo $this->fetch('content'); ?>
        <!--FOOTER--!-->
        <?php echo $this->element('footer'); ?>
      </div>
    </body>
    <!-- Mirrored from lithemes.com/blackair/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 01 Sep 2015 03:21:05 GMT -->
    </html>


    
