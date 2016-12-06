<div class="sections">
    <h2 class="heading">Hair awards</h2>
    <div class="clearfix"></div>
    <div class="media-carousal">
        <div id="nav-01" class="crsl-nav">
            <a href="#" class="previous"><i class="fa fa-arrow-circle-o-left"></i></a>
            <a href="#" class="next"><i class="fa fa-arrow-circle-o-right"></i></a>
        </div>
        <div class="crsl-items1" data-navigation="nav-01">
            <div class="crsl-wrap">
                <?php foreach($awards as $item):?>
                    <div class="crsl-item">
                        <div class="blogposttwoawards">
                            <figure>
                                <a href="<?php echo Router::url(array('controller' => 'Awards', 'action' => 'detail', $item['Awards']['id']));?>">
                                    <img src="<?php echo $item['Awards']['imgavatar'];?>" class="img-responsive hovereffect" alt="" />
                                </a>
                            </figure>
                            <div class="text">
                                <h4 style="text-align: center;">
                                    <a href="<?php echo Router::url(array('controller' => 'Awards', 'action' => 'detail', $item['Awards']['id']));?>">
                                        <?php echo $item['Awards']['name'];?>- MS: <?php echo $item['Awards']['ide_number'];?>
                                    </a>
                                </h4>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>