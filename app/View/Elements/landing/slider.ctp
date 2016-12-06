<?php if(isset($news)):?>
    <?php foreach($news as $key => $item): if($key >3) break;?>
        <div class="col-lg-3 col-md-3 col-sm-6 .col-xs-6">
           <div class="videobox1">
               <figure>
                   <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>">
                    <img src="<?php echo $item['News']['images'];?>" alt="" class="img-responsive hovereffect" />
                </a>
                <figcaption>
                    <h2><a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>"><?php echo $item['News']['title'];?></a></h2>
                    <ul>
                       <li><i class="fa fa-heart"></i>1056</li>
                       <li><i class="fa fa-comments"></i>58</li>
                       <li><i class="fa fa-clock-o"></i>12:23</li>
                   </ul>
                   <div class="clearfix"></div>
               </figcaption>
           </figure>
       </div>
   </div>
<?php endforeach; ?>
<?php endif; ?>