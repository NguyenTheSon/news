<?php if($detail['News']['url'] !="") echo $this->element('News/item-video');?>
<!-- Contents Start -->
<div class="contents">
  <div class="custom-container color-background">
    <div class="row"> 
      <!-- Bread Crumb Start -->
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <ol class="breadcrumb">
          <li><a href="/">Home</a></li>
          <li class="active"><?php echo $detail['News']['title'];?></li>
        </ol>
      </div>
      <!-- Bread Crumb End -->
      <!-- Content Column Start -->
      <?php echo $this->element('News/index_page');?>
      <!-- Content Column End --> 
      <!-- Gray Sidebar Start -->
      <?php echo $this->element('landing/right_home');?>
      <!-- Gray Sidebar End --> 
    </div>
  </div>
</div>
<!-- Contents End -->
<!-- Footer Start -->