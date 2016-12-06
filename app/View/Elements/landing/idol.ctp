<div class="sections">
    <h2 class="heading">Hair idol</h2>
    <div class="clearfix"></div>
    <div class="row">
        <?php foreach($idol as $item):?>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <figure class="gallery">
                    <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>">
                        <img src="<?php echo $item['News']['images'];?>" alt="<?php echo $item['News']['title'];?>" class="img-responsive hovereffect">
                    </a>
                    <figcaption class="backcolor">
                        <h4>
                            <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>"><?php echo $item['News']['title'];?></a>
                        </h4>
                    </figcaption>
                </figure>
            </div>
        <?php endforeach; ?>
    </div>
</div>