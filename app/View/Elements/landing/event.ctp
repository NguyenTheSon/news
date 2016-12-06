<div class="sections">
    <h2 class="heading">Sự kiện</h2>
    <div class="clearfix"></div>
    <div class="row">
        <?php foreach($events as $event):?>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <!-- Video Box Start -->
                <div class="videobox2">
                    <figure>
                        <!-- Video Thumbnail Start --> 
                        <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $event['News']['id']));?>">
                            <img src="<?php echo $event['News']['images'];?>" class="img-responsive hovereffect" alt="<?php echo $event['News']['title'];?>" />
                        </a>
                        <!-- Video Thumbnail End -->
                        <!-- Video Info Start -->
                        
                        <!-- Video Info End -->
                    </figure>
                    <!-- Video Title Start -->
                    <h4><a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $event['News']['id']));?>"><?php echo $event['News']['title'];?></a></h4>
                    <!-- Video Title End -->
                </div>
                <!-- Video Box End -->
            </div>
        <?php endforeach;?>
    </div>
</div>