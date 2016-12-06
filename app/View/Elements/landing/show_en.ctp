<div class="sections">
  <h2 class="heading">Show quốc tế</h2>
  <div class="clearfix"></div>
  <div class="media-carousal">
    <div id="nav-00" class="crsl-nav">
      <a href="#" class="previous"><i class="fa fa-arrow-circle-o-left"></i></a>
      <a href="#" class="next"><i class="fa fa-arrow-circle-o-right"></i></a>
    </div>
    <div class="crsl-items" data-navigation="nav-00">
      <div class="crsl-wrap">
      <?php foreach($showEn as $item):?>
          <div class="crsl-item">
            <!-- Video Box Start -->
            <div class="videobox2">
              <figure>
                <!-- Video Thumbnail Start --> 
                <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>">
                  <img src="<?php echo $item['News']['images'];?>" class="img-responsive hovereffect" alt="<?php echo $item['News']['title'];?>" />
                </a>
                <!-- Video Thumbnail End -->
                <!-- Video Info Start -->
                <div class="vidopts">
                  <ul>
                   <li><i class="fa fa-heart"></i>1056</li>
                   <li><i class="fa fa-clock-o"></i>12:23</li>
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
 </div>
</div>