<div class="sections">
    <h2 class="heading">Show việt nam</h2>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="blogpost">
                <figure>
                    <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $showVn[0]['News']['id']));?>">
                        <img class="img-responsive hovereffect" src="<?php echo $showVn[0]['News']['images'];?>" alt="<?php echo $showVn[0]['News']['title'];?>" />
                    </a>
                    <figcaption>
                        <ul>
                            <li><i class="fa fa-calendar"></i><?php echo $showVn[0]['News']['created'];?></li>
                            <li>
                                <i class="fa fa-align-justify"></i>
                                <a href="#">News</a>
                            </li>
                        </ul>
                    </figcaption>
                </figure>
                <div class="text">
                    <h4 class="heading">
                    <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $showVn[0]['News']['id']));?>"><?php echo $showVn[0]['News']['title'];?></a>
                    </h4>
                    <p>
                        <?php echo $showVn[0]['News']['description'];?>
                    </p>
                    <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $showVn[0]['News']['id']));?>" class="btn btn-primary btn-xs backcolor">Read More</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <ul class="bloglist">
                <?php foreach($showVn as $key => $item): if($key <1) continue;?>
                    <li>
                        <div class="media">
                            <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>" class="pull-left">
                                <img src="<?php echo $item['News']['images'];?>" class="media-object img-responsive hovereffect" alt="<?php echo $item['News']['title'];?>" />
                            </a>
                            <div class="media-body">
                                <h4><a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>" title="<?php echo $item['News']['title'];?>"><p style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><?php echo $item['News']['title'];?></p></a></h4>
                                <ul>
                                    <li><i class="fa fa-calendar"></i><?php echo $item['News']['created'];?></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>