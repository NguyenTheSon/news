    <section id="news-detail">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-8 box">
          <h1 class="title"><?php echo $detail['Question']['question']; ?></h1>
          <div class="content">
            <?php echo $detail['Question']['content']; ?>
          </div>
          <div class="fb-comments" data-href="<?php echo $detail['Question']['url'];?>" data-width="100%" data-numposts="1"></div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
          <?php echo $this->element('rightframe'); ?>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </section>
