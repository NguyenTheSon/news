  <section id="news-detail">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-8 box">
          <h1 class="title"><?php echo $detail['Product']['name']; ?>
                <br><p class="price"> Giá sản phẩm: <?php echo number_format($detail['Product']['price']); ?> VNĐ</p></h1>

          <p class="desc"><?php echo $detail['Product']['described']; ?></p>
          <div class="content">
            <img src="<?php echo $detail['Product']['image']; ?>">
            <br><br>
            <?php echo $detail['Product']['detail']; ?>
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
