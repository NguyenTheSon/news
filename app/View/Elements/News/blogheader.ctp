<link rel="stylesheet" type="text/css" href="<?php echo Router::url("/",true);?>/news/css/bootstrap1.css">
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
      <?php
      foreach (json_decode($headinfo['Category']['images']) as $key => $image) {
        echo '<div class="item '.($key == 0 ? 'active': '').'"> <img src="'.$image.'" style="width:100%"> </div>';
      }
      ?>
    </div>
    <div class="slider-titile">
      <div class="col-sm-4 col-md-3 col-lg-3  titile-bg">
        <h1><?php echo $headinfo['Category']['title_banner'];?></h1>
      </div>
      <div class="carousel-control"> <a class="left" href="#myCarousel" role="button" data-slide="prev"></a> <a class="right" href="#myCarousel" role="button" data-slide="next"></a> </div>
      <div class="col-sm-8 col-md-9 col-lg-9 white-bg">
        <div class="slidercaption"><?php echo $headinfo['Category']['text_banner'];?></div>
      </div>
    </div>
</div>