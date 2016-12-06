<link rel="stylesheet" type="text/css" href="<?php echo Router::url("/",true);?>news/css/bootstrap1.css">
<div id="myCarousel" class="carousel carousel-fade slide" data-ride="carousel" style="border-bottom: 3px solid #EC6F6F;">
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" role="listbox">
    <?php
    foreach (json_decode($headinfo['Category']['images']) as $key => $image) {
      echo '<div class="item '.($key == 0 ? 'active': '').'" style="width: 100%;"> <img src="'.$image.'" style="width: 100%;"> </div>';
    }
    ?>
  </div>
  <div class="carousel-control" style="">
    <a class="left" style="left: 0px;" href="#myCarousel" role="button" data-slide="prev"></a> 
    <a class="right" style="left: initial; right: 0px;" href="#myCarousel" role="button" data-slide="next"></a> 
  </div>
  <div class="slider-titile" style="bottom: 50px; opacity: 0.8; display:none;">
    <div class="white-bg" style="width: 100%; padding: 0px;">
      <div class="slidercaption"><?php echo $headinfo['Category']['text_banner'];?></div>
    </div>
  </div>
</div>