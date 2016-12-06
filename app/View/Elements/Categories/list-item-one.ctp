 <?php if(!empty($News)) :?>
   <div class="sections">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
            <!-- Video Box Start -->
            <div class="videoboxevent">
                <figure> 
                    <!-- Video Thumbnail Start --> 
                    <a href="video-detail-double-sidebar.html">
                        <img src="images/img1-big.jpg" class="img-responsive hovereffect" alt="" />
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
                <h4><a href="video-detail-double-sidebar.html">Darkness bearings</a></h4>
                <!-- Video Title End --> 
            </div>
            <!-- Video Box End --> 
        </div>
    </div>
</div>
<div class="clearfix"></div>
<?php else :?>
    <h2>Chưa cập nhật dữ liệu!</h2>
<?php endif; ?>