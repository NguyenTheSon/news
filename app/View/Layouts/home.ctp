<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $header['title'];?></title>
  <!--meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" /!-->
  <meta name="viewport" content="width=1366px" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="HandheldFriendly" content="True" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black" />
  <link href="../../../spavideo/css/style.css" rel="stylesheet" media="screen" />
  <link href="../../../spavideo/css/bootstrap.css" rel="stylesheet" media="screen" />
  <link href="../../../spavideo/css/slick-theme.css" rel="stylesheet" media="screen" />
  <link href="../../../spavideo/css/slick.css" rel="stylesheet" media="screen" />
  <link href="../../../spavideo/images/favicon.ico" rel="icon" type="image/x-icon" />
  <meta name="title" content='<?php echo $header['title'];?>'/>
  <meta name="site_name" content='<?php echo $header['site_name'];?>'/>
  <meta name="description" content='<?php echo $header['description'];?>' />
  <meta name="keywords" content='<?php echo $header['keywords'];?>'/>
  <meta property="og:type" content="<?php echo $header['type'];?>" />
  <meta property="og:title" content='<?php echo $header['title'];?>' />
  <meta property="og:description" content='<?php echo $header['description'];?>' />
  <meta property="og:site_name" content='<?php echo $header['site_name'];?>' />
  <meta property="og:image" content='<?php echo $header['image'];?>' />
<!--[if lt IE 9]>
    <script src="spavideo/js/html5shiv.js"></script>
    <script type="text/javascript" src="spavideo/js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <!-- Wrapper Start -->
    <div class="wrapper">
     <!-- Header Start -->
     <?php echo $this->element('landing/header');?>
     <!-- Header End -->
     <!-- Contents Start -->
     <?php echo $this->fetch('content'); ?>
     <!-- Contents End -->
     <!-- Footer Start -->
     <?php echo $this->element('landing/footer');?>
     <!-- Footer End --> 
     <a href="#" class="pull-right gotop btn btn-primary backcolor"> <i class="fa fa-arrow-up"></i> </a>
   </div>
   <!-- Wrapper End -->
   <!--// Javascript //-->
   <script type="text/javascript" src="../../../spavideo/js/jquery-1.11.1.min.js"></script>
   <script type="text/javascript" src="../../../spavideo/js/jquery-ui.min.js"></script>
   <script type="text/javascript" src="../../../spavideo/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="../../../spavideo/js/functions.js"></script>
   <script type="text/javascript" src="../../../spavideo/js/slick.min.js"></script>
   <script type="text/javascript" src="../../../spavideo/js/responsiveCarousel.js"></script>
   <script type="text/javascript" src="../../../spavideo/js/slimbox2.js"></script>
   <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','../../../spavideo/js/analytics.js','ga');

    ga('create', 'UA-50738310-1', 'softcircles.net');
    ga('send', 'pageview');

  </script>
  <div id="fb-root"></div>
  <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '1602684293325237',
        xfbml      : true,
        version    : 'v2.1'
      });
    };
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.4&appId=1602684293325237";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
  </body>

  <!-- Mirrored from www.softcircles.net/demos/html/videomagazine/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 03 Nov 2016 16:47:00 GMT -->
  </html>
