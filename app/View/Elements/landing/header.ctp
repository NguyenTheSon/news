<header>
  <!-- Logo + Search + Advertisment Start -->
  <div class="logobar">
   <div class="custom-container">
     <div class="row">
      <!-- Logo Start -->
      <div class="col-lg-4 col-lg-offset-1 col-md-4 col-sm-6 col-xs-12">
        <div class="logo">
          <a href="/">
           <img src="../../../images/logo3.png" alt="Video Magazine" width="100%" />
         </a>
       </div>
     </div>
     <!-- Logo End -->
     <!-- Search Start -->
     <!-- Search End -->
     <!-- Advertisment Start -->
     <div class="col-lg-6  col-lg-offset-1 col-md-6 col-md-offset-2 col-sm-12 col-xs-12">
      <figure class="header-adv">
       <?php if(!empty($topadvert)):?>
        <?php foreach($topadvert as $item):?>
          <div class="rightslide slider">
            <?php for($i=0; $i < count($item['Advertise']['image']); $i++):?>
              <div>
                <a href="<?php echo $item['Advertise']['url'][$i];?>">
                  <img class="img-responsive" src="<?php echo $item['Advertise']['image'][$i];?>"  alt="">
                </a>
              </div>
            <?php endfor;?>
          </div>
        <?php endforeach;?>
      <?php endif;?>
    </figure>
  </div>
  <!-- Advertisment End -->
</div>
</div>
</div>
<!-- Logo + Search + Advertisment End -->
<!-- Navigation Strip Start -->
<div class="navigationstrip bordercolor-top">
 <div class="custom-container">
   <div class="row">
    <!-- Navigation Start -->
    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-4">
     <div class="navigation">
      <!-- navbar Start -->
      <div class="navbar yamm navbar-default">
        <div class="row">
          <div class="navbar-header">
            <button type="button" data-toggle="collapse" data-target="#navbar-collapse-1" class="navbar-toggle">
              <i class="fa fa-bars"></i> Menu
            </button>
          </div>
          <div id="navbar-collapse-1" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li>
                <a href="/">Hair fashion tv</a>
              </li>
              <?php foreach($Categories as $key => $item):?>
                <li>
                  <?php if($key % 2 ==0):?>
                    <a href="<?php echo Router::url(array('controller' => 'Categories', 'action' =>'index',$item['Category']['id'].'-'.Inflector::slug($item['Category']['name'], '-')));?>"><?php echo $item['Category']['name'];?></a>
                  <?php else: ?>
                    <a href="<?php echo Router::url(array('controller' => 'Categories', 'action' =>'view',$item['Category']['id'].'-'.Inflector::slug($item['Category']['name'], '-')));?>"><?php echo $item['Category']['name'];?></a>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <!-- navbar End -->
    </div>
  </div>
</div>
</div>
</div>
<!-- Navigation Strip End -->
</header>