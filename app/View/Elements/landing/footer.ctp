<footer class="style1">
    <div class="custom-container">
    <h2 style="color: #fff;">Clip hài tóc</h2>
        <!-- Footer Videos Start -->
        <div class="row">
            <?php foreach($cliphai as $item):?>
            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6"> 
                <!-- Video Box Start -->
                <div class="videobox1">
                    <figure>
                        <!-- Video Thumbnail Start --> 
                        <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'details', $item['News']['id']));?>">
                            <img src="<?php echo $item['News']['images'];?>" alt="" class="img-responsive hovereffect" />
                        </a> 
                        <!-- Video Thumbnail End -->
                        <!-- Video Title + Info Start -->
                        <figcaption>
                            <h2>
                                <a href="<?php echo Router::url(array('controller' => 'News', 'action' => 'detail', $item['News']['id']));?>"><?php echo $item['News']['title'];?></a>
                            </h2>
                            <div class="clearfix"></div>
                        </figcaption>
                        <!-- Video Title + Info End --> 
                    </figure>
                </div>
                <!-- Video Box End --> 
            </div>
        <?php endforeach; ?>
        </div>
        <!-- Footer Videos End -->
        <hr />
        <div class="row footerwidgets">
            <div class="col-lg-3 col-md-6 col-sm-6 .col-xs-12">
                <!-- Text Widget start -->
                <div class="widget">
                    <div class="text-widget">
                        <div class="textsec">
                            <a href="index.html"><img src="../../../images/logo1.png" alt=""></a>
                            <br /><br />
                            <p>
                                Ut volutpat consectetur aliquam. Curabitur auctor in nis ulum ornare. Sed consequat, augue condimentum fermentum gravida, metus elit vehicula dui.
                            </p>
                            <ul class="contactdetail">
                                <li><i class="fa fa-mobile"></i> +1800 1234 56789</li>
                                <li><i class="fa fa-envelope"></i><a href="mailto:support@videoMagazine.com">support@videoMagazine.com</a></li>
                            </ul>                            
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <!-- Text Widget start -->
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 .col-xs-12">
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 .col-xs-12">
                <div class="widget">
                    <h2 class="heading">Send us a message</h2>
                    <div class="contact-forms">
                        <form>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 .col-xs-12">
                                    <input type="text" placeholder="Your Name" />
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 .col-xs-12">
                                    <input type="text" placeholder="Email Address" />
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 .col-xs-12">
                                    <input type="text" placeholder="Subject" />
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-12 .col-xs-12">
                                    <textarea placeholder="Message"></textarea>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 .col-xs-12">
                                    <button type="button" class="btn btn-primary backcolor"><span>Submit message</span><i class="fa fa-angle-right"></i></button>
                                    <p>Make sure you put a valid email.</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-9 .col-xs-9">
                <p class="copyrights">© 2014. All rights reserved. Designed by <a href="#"><strong>SoftCircles</strong></a></p>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3 .col-xs-3">
                <div class="socialnetworks">
                    <ul class="pull-right">
                        <li><a href="#" data-toggle="tooltip" title="Facebook" class="facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" data-toggle="tooltip" title="Youtube" class="youtube"><i class="fa fa-youtube"></i></a></li>
                        <li><a href="#" data-toggle="tooltip" title="Twitter" class="twitter"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" data-toggle="tooltip" title="Vimeo" class="vimeo"><i class="fa fa-vimeo-square"></i></a></li>
                        <li><a href="#" data-toggle="tooltip" title="Pinterest" class="pinterest"><i class="fa fa-pinterest"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</footer>