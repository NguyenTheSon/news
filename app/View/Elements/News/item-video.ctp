<?php
function extract_id_video($url){
    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
        return $matches[1];
}
?>
<div class="videoplayersec">
    <div class="vidcontainer">
        <div class="row">
            <div class="col-xs-12">
                <h4><?php echo $detail['News']['title'];?></h4>
                    <br>
            </div>
        </div>
        <div class="row"> 
            <!-- Video Player Start -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 playershadow">
                <div class="playeriframe">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo extract_id_video($detail['News']['url']);?>?autoplay=1" autoplay="true" frameborder="0" allowfullscreen target="_parent"></iframe>
                </div>
            </div>
            <!-- Video Player End --> 
            <!-- Video Stats and Sharing Start -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 videoinfo">
                <div class="row"> 
                    <!-- Uploader Start -->
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 uploader">
                        <figure> <a href="video-list.html"><img src="../../images/avatar2.jpg" alt="" /></a> </figure>
                        <div class="aboutuploader">
                            <h5><a href="video-list.html">By Hairfashontv</a></h5>
                            <time datetime="25-12-2014">Uploaded : <?php echo date("d-m-Y",strtotime($detail['News']['created']));?></time>
                            <br />
                            <!-- <a class="btn btn-primary btn-xs backcolor" href="#">Watch All Videos</a>  -->
                        </div>
                    </div>
                    <!-- Uploader End --> 
                    <!-- Video Stats Start -->
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 stats">
                        <hr class="visible-xs" />
                        
                    </div>
                    <!-- Video Stats End --> 
                    <!-- Video Share Start -->
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 videoshare">
                        <div class="fb-like" data-href="<?php echo $this->here; ?>" data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>
                    </div>
                    <!-- Video Share End --> 
                </div>
            </div>
            <!-- Video Stats and Sharing End --> 
            <!-- Like This Video Start -->
                <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 likeit">
                    <hr />
                    <a class="btn btn-primary backcolor" href="#">Like This Video</a>
                </div> -->
                <!-- Like This Video Enb --> 
            </div>
        </div>
    </div>
<!-- Video Player Section End