<section id="news-detail">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-8 col-lg-8 box">
        <h1 class="title">Thư viện ảnh <?php echo $item['Gallery']['caption']; ?></h1>
        <div class="facebook-like">
          <div class="fb-like" data-href="<?php echo Router::url( $this->here, true ); ?>" data-width="300" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
        
        </div>
        <div class="content">
          <?php
            if($item['Gallery']['video'] ==""):
          ?>
              <img src="<?php echo $item['Gallery']['image']; ?>" >
          <?php else: ?>
              <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $item['Gallery']['video']; ?>" frameborder="0" style="max-width: 100%;" allowfullscreen></iframe>
          <?php
            endif;
          ?> 
          <?php echo $item['Gallery']['caption']; ?>
        </div>
        <div class="fb-comments" data-href="<?php echo Router::url( $this->here, true ); ?> " data-width="100%" data-numposts="1"></div>
      </div>
      <div class="col-sm-12 col-md-4 col-lg-4">
        <?php echo $this->element('rightframe'); ?>
      </div>
    </div>
    <div class="clearfix"></div>
  </div>
</section>