  <section id="news-detail">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-8 box">
          <h1 class="title">Feedback của <?php echo $detail['Feedback']['username']; ?> sau khi làm tóc tại Salon</h1>
          <div class="facebook-like">
            <div class="fb-like" data-href="<?php echo Router::url( $this->here, true ); ?>" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
          
          </div>
          <div class="content">
            <img src="<?php echo $detail['Feedback']['images']; ?>" ><br>
            <?php echo $detail['Feedback']['detail']; ?>
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
