<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12"> 
  <!-- Video Detail Started -->
  <div class="blogdetail videodetail sections">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="blogtext">
          <h2 class="heading"><?php echo $detail['News']['title'];?></h2>
          <div class="clearfix"></div>
          <div class="blogmetas">
            <ul>
              <li> <i class="fa fa-align-justify"></i> <a href="#">News, </a> <a href="#">Videos, </a> <a href="#">Music</a> </li>
              <li> <i class="fa fa-tags"></i> <a href="#">Funny, </a> <a href="#">Videos, </a> <a href="#">Sports</a> </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <p style="font-weight: bold;text-align: justify;">
            <?php echo $detail['News']['description'];?>
          </p>
          <p><?php echo $detail['News']['content'];?></p>
        </div>
      </div>
    </div>
  </div>
  <!-- Video Detail End -->
  <div class="clearfix"></div>
  <!-- Contents Section Started -->
  <?php echo $this->element('News/relate-video');?>
  <!-- Contents Section End -->
  <div class="clearfix"></div>
  <!-- Contents Section Started -->
  <?php echo $this->element('News/comment-detail');?>
  <!-- Contents Section End -->
  <div class="clearfix"></div>
  <!-- Contents Section Started -->
  <!-- <?php echo $this->element('News/sent-address');?> -->
  <!-- Contents Section End -->
  <div class="clearfix"></div>
</div>