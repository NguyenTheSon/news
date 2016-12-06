 <div class="contents">
   <div class="custom-container color-background">
       <div class="row">
           <?php echo $this->element('landing/slider');?>
       </div>
       <div class="row">
        <!-- Content Column Start -->
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 equalcol conentsection">
           <!-- Video Slider Start -->
           <div class="videoslider backcolor">
               <div class='tabbed_content'>
                <div class='tabs'>
                    <div class='moving_bg'>
                        <span class="pointer"></span>
                    </div>
                    <?php foreach($news as $key => $item): if($key <4) continue;?>
                        <div class='tab_item'>
                            <h5 title="<?php echo $item['News']['title'];?>"><?php echo substr($item['News']['title'], 0 , strrpos(substr($item['News']['title'], 0, 30), ' '));?></h5>
                            <span class="hidden-xs"><?php echo date("F j, Y", strtotime($item['News']['created'])) ;?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class='slide_content'>
                    <div class='tabslider'>
                        <?php foreach($news as $key => $item): if($key <4) continue;?>
                            <div class="video">
                                <!-- Video Box Start -->
                                <div class="videobox">
                                    <figure>
                                        <!-- Video Thumbnail Start --> 
                                        <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>">
                                            <img src="<?php echo $item['News']['images'];?>" alt="<?php echo $item['News']['title'];?>" class="img-responsive hovereffect" />
                                        </a>
                                        <!-- Video Thumbnail End -->
                                        <a href="#" class="playicon"><i class="fa fa-play-circle-o"></i></a>
                                        <!-- Video Title + Info Start -->
                                        <figcaption>
                                            <h2><a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>"><?php echo $item['News']['title'];?></a></h2>
                                            <ul>
                                                <li><i class="fa fa-heart"></i>1056</li>
                                                <li><i class="fa fa-comments"></i>58</li>
                                                <li><i class="fa fa-clock-o"></i><?php echo $item['News']['created'];?></li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </figcaption>
                                        <!-- Video Title + Info End -->
                                    </figure>
                                </div>
                                <!-- Video Box End -->
                            </div>
                        <?php endforeach; ?>
                        <!-- content goes here -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Video Slider End -->
        <!-- Contents Section Started -->
        <?php echo $this->element('landing/event');?>
        <!-- Contents Section End -->
        <div class="clearfix"></div>
        <!-- Contents Section Started -->
        <?php echo $this->element('landing/show_en');?>
        <!-- Contents Section End -->
        <div class="clearfix"></div>
        <!-- Contents Section Start -->
        <?php echo $this->element('landing/show_vi');?>
        <!-- Contents Section End -->
        <!-- Contents Section Started -->
        <?php echo $this->element('landing/awards');?>
        <!-- Contents Section End -->
        <div class="clearfix"></div>
        <!-- Contents Section Started -->
        <?php echo $this->element('landing/oscar');?>
        <!-- Contents Section End -->
        <div class="clearfix"></div>
        <!-- Contents Section Started -->
        <?php echo $this->element('landing/idol');?>
        <!-- Contents Section End -->
        <div class="clearfix"></div>
    </div>
    <!-- Content Column End -->
    <!-- Dark Sidebar Start -->
    <?php echo $this->element('landing/mid_home');?>
    <!-- Dark Sidebar End -->
    <!-- Gray Sidebar Start -->
    <?php echo $this->element('landing/right_home');?>
    <!-- Gray Sidebar End -->
</div>
</div>
</div>