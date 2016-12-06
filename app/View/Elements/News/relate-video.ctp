<?php if(!empty($NewsRand)):?>
  <div class="sections">
    <h2 class="heading">Video liên quan</h2>
    <div class="clearfix"></div>
    <div class="row">
      <?php foreach($NewsRand as $item):?>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
          <!-- Video Box Start -->
          <div class="videobox2">
            <figure> 
              <!-- Video Thumbnail Start --> 
              <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>">
                <img alt="<?php echo $item['News']['title'];?>" class="img-responsive hovereffect" src="<?php echo $item['News']['images'];?>" />
              </a> 
              <!-- Video Thumbnail End --> 
              <!-- Video Info Start -->
              <div class="vidopts">
                <ul>
                  <li><i class="fa fa-heart"></i>1056</li>
                  <li><i class="fa fa-clock-o"></i><?php echo $item['News']['created'];?></li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <!-- Video Info End --> 
            </figure>
            <!-- Video Title Start -->
            <h4><a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>"><?php echo $item['News']['title'];?></a></h4>
            <!-- Video Title End --> 
          </div>
          <!-- Video Box End --> 
        </div>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>