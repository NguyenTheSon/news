<div class="sections">
    <h2 class="heading">Oscar </h2>
    <div class="clearfix"></div>
    <div class="row">
        <?php foreach($oscars as $item):?>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="blogposttwo">
                    <figure>
                        <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>">
                            <img src="<?php echo $item['News']['images'];?>" class="img-responsive hovereffect" alt="<?php echo $item['News']['title'];?>" />
                        </a>
                    </figure>
                    <div class="text">
                        <h4><a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>"><?php echo $item['News']['title'];?></a></h4>
                        <ul>
                            <li><i class="fa fa-calendar"></i><?php echo $item['News']['created'];?></li>
                            <li>
                                <i class="fa fa-align-justify"></i>
                                <a href="#">News</a>
                            </li>
                        </ul>
                        <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>" class="btn btn-primary btn-xs backcolor">Read More</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>