<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 equalcol blacksidebar">
  <!-- Search Widget start -->
  <div class="widget">
    <h2 class="heading">Tìm kiếm</h2>
    <div class="search">
      <form action="http://www.softcircles.net/demos/html/videomagazine/search.php">
        <input type="text" placeholder="Search Keyword" />
        <button class="btn btn-primary btn-xs backcolor"><i class="fa fa-arrow-right"></i></button>
      </form>
    </div>
  </div>
  <div class="clearfix"></div>
  <!-- Search Widget End -->
  <!-- Hot Videos Widget start -->
  <?php if(!empty($cliphot)):?>
    <div class="widget">
      <h2 class="heading">Clip hot</h2>
      <div class="carousals">
        <div id="carouselvideo" class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner">
            <div class="item active">
              <?php foreach($cliphot as $key => $item): if($key >2) break;?>
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
                       <li><i class="fa fa-clock-o"></i><?php echo $item['News']['created'];?></li>
                     </ul>
                     <div class="clearfix"></div>
                   </div>
                   <!-- Video Info End -->
                 </figure>
                 <!-- Video Title Start -->
                 <h4>
                   <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>"><?php echo $item['News']['title'];?></a>
                 </h4>
                 <!-- Video Title End -->
               </div>
             <?php endforeach; ?>
           </div>
           <div class="item">
             <?php foreach($cliphot as $key => $item): if($key <3) continue; if($key > 5) break;?>
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
                     <li><i class="fa fa-clock-o"></i><?php echo $item['News']['created'];?></li>
                   </ul>
                   <div class="clearfix"></div>
                 </div>
                 <!-- Video Info End -->
               </figure>
               <!-- Video Title Start -->
               <h4>
                 <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>"><?php echo $item['News']['title'];?></a>
               </h4>
               <!-- Video Title End -->
             </div>
           <?php endforeach; ?>
         </div>
         <div class="item">
           <?php foreach($cliphot as $key => $item): if($key <6) continue;?>
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
                   <li><i class="fa fa-clock-o"></i><?php echo $item['News']['created'];?></li>
                 </ul>
                 <div class="clearfix"></div>
               </div>
               <!-- Video Info End -->
             </figure>
             <!-- Video Title Start -->
             <h4>
               <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>"><?php echo $item['News']['title'];?></a>
             </h4>
             <!-- Video Title End -->
           </div>
         <?php endforeach; ?>
       </div>
     </div>
     <div class="carouselpagination">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#carouselvideo" data-slide-to="0" class="active"></li>
        <li data-target="#carouselvideo" data-slide-to="1"></li>
        <li data-target="#carouselvideo" data-slide-to="2"></li>
      </ol>
    </div>
  </div>
</div>
</div>
<?php endif; ?>
<div class="clearfix"></div>
<!-- Hot Videos Widget End -->
<!-- Categories Widget start -->
<div class="clearfix"></div>
<!-- Categories Widget End -->
<?php if(!empty($showhot)):?>
  <div class="widget">
    <h2 class="heading">Show hot</h2>
    <div class="carousals">
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel"> 
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
          <div class="item active">
            <ul class="bloglist">
              <?php foreach($showhot as $key => $item) : if($key >2) break;?>
                <li>
                  <figure>
                   <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>">
                    <img src="<?php echo $item['News']['images'];?>" class="img-responsive hovereffect" alt="<?php echo $item['News']['title'];?>" />
                  </a>
                </figure>
                <div class="text">
                  <h4>
                    <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>"><?php echo $item['News']['title'];?>
                    </a>
                  </h4>
                  <ul>
                    <li><i class="fa fa-calendar"></i><?php echo $item['News']['created'];?></li>
                    <li> <i class="fa fa-align-justify"></i> <a href="#">Videos, </a> <a href="#">Music</a> </li>
                  </ul>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="item">
          <ul class="bloglist">
            <?php foreach($showhot as $key => $item) : if($key <3) continue; if($key > 5) break;?>
              <li>
                <figure>
                 <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>">
                  <img src="<?php echo $item['News']['images'];?>" class="img-responsive hovereffect" alt="<?php echo $item['News']['title'];?>" />
                </a>
              </figure>
              <div class="text">
                <h4>
                  <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>"><?php echo $item['News']['title'];?></a>
                </h4>
                <ul>
                  <li><i class="fa fa-calendar"></i><?php echo $item['News']['created'];?></li>
                  <li> <i class="fa fa-align-justify"></i> <a href="#">Videos, </a> <a href="#">Music</a> </li>
                </ul>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="item">
        <ul class="bloglist">
          <?php foreach($showhot as $key => $item) : if($key <6) continue;?>
            <li>
              <figure>
               <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>">
                <img src="<?php echo $item['News']['images'];?>" class="img-responsive hovereffect" alt="<?php echo $item['News']['title'];?>" />
              </a>
            </figure>
            <div class="text">
              <h4>
                <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>"><?php echo $item['News']['title'];?></a>
              </h4>
              <ul>
                <li><i class="fa fa-calendar"></i><?php echo $item['News']['created'];?></li>
                <li> <i class="fa fa-align-justify"></i> <a href="#">Videos, </a> <a href="#">Music</a> </li>
              </ul>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
  <div class="carouselpagination"> 
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
      <li data-target="#carousel-example-generic" data-slide-to="1"></li>
      <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    </ol>
  </div>
</div>
</div>
</div>
<?php endif; ?>
<div class="clearfix"></div>
<!-- Blog Post Widget End -->
<!-- Tags Widget start -->
<div class="widget">
  <h2 class="heading">Tags</h2>
  <div class="tagswidget">
    <a href="#" class="btn btn-primary btn-xs backcolor">Music</a>
    <a href="#" class="btn btn-primary btn-xs backcolor">Funny</a>
    <a href="#" class="btn btn-primary btn-xs backcolor">Movies</a>
    <a href="#" class="btn btn-primary btn-xs backcolor">Sport</a>
    <a href="#" class="btn btn-primary btn-xs backcolor">News</a>
    <a href="#" class="btn btn-primary btn-xs backcolor">Arts</a>
    <a href="#" class="btn btn-primary btn-xs backcolor">Gaming</a>
    <a href="#" class="btn btn-primary btn-xs backcolor">Tech</a>
    <a href="#" class="btn btn-primary btn-xs backcolor">Animals</a>
    <a href="#" class="btn btn-primary btn-xs backcolor">Auto</a>
    <a href="#" class="btn btn-primary btn-xs backcolor">Moto</a>
    <a href="#" class="btn btn-primary btn-xs backcolor">Celeb</a>
    <a href="#" class="btn btn-primary btn-xs backcolor">College</a>
    <a href="#" class="btn btn-primary btn-xs backcolor">Lifestyle</a>
    <a href="#" class="btn btn-primary btn-xs backcolor">Sexy</a>
    <a href="#" class="btn btn-primary btn-xs backcolor">Sport</a>
  </div>
</div>
<div class="clearfix"></div>
<!-- Tags Widget End -->
<!-- Advertisement start -->
<div class="widget">
  <?php if(!empty($midadvert)):?>
    <?php foreach($midadvert as $item):?>
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
</div>
<div class="clearfix"></div>
<!-- Advertisement End -->
</div>