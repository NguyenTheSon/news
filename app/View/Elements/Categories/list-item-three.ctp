<?php if(!empty($News)) :?>
    <div class="sections">
        <div class="clearfix"></div>
        <div class="row">
            <?php foreach($News as $item):?>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
                    <!-- Video Box Start -->
                    <div class="videoboxevent">
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
                        <h4><a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>"><?php echo $item['News']['title'];?></a></h4>
                        <!-- Video Title End --> 
                    </div>
                    <!-- Video Box End --> 
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="clearfix"></div>
<?php else :?>
    <h2>Chưa cập nhật dữ liệu!</h2>
<?php endif; ?>