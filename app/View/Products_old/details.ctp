<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
<section id="products_main">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->webroot; ?>">Muba</a></li>
            <li><a href="<?php echo Router::url(['controller' => 'Categories', 'action' => 'index', $current_cat['Category']['id']]); ?>"><?php echo $current_cat['Category']['name']; ?></a></li>
            <li><a href="<?php echo Router::url(['controller' => 'Products', 'action' => 'details', $product['Product']['id']]); ?>"><?php echo $product['Product']['name']; ?></a></li>
        </ol>
        <div class="list_products" ng-app="listProduct">
            <div class="row" ng-controller="product">
                <div class="col-xs-12 col-sm-4 col-sm-offset-1">
                    <div class="product-info">
                        <p class="name"><?php echo $product['Product']['name'] ?></p>
                        <div style="display: inline-block; position: relative; width: 100%;">
                            <div class="col-xs-12 col-lg-6" style="padding: 0px;">
                           <?php
                                if($product['Product']['price_new'] >0){
                                    ?>
                                    <h4 class="price"><?php echo number_format($product['Product']['price']); ?> VNĐ<br><s style="color:#515151; text-align: right; font-size: 12px; font-weight: bold;display: inline-block; width: 100%;"><?php echo number_format($product['Product']['price_new']); ?> VNĐ</s></h4>
                                    <?php
                                }
                                else{
                                    echo '<h4 class="price">'.number_format($product['Product']['price']).' VNĐ</h4>';
                                }
                                ?>
                            </div>
                            <div class="col-xs-12 col-lg-6">
                                <a class="btn btn-primary btn-buy" data-toggle="modal" data-target="#download">Mua sản phẩm</a>
                            </div>
                        </div>
                        
                    </div>

                    <div class="product-info">
                        <p class="title-details">Chi tiết sản phẩm</p>
                        
                        <table style="width: 100%; color: #383838;" class="details">
                             <tr style="border-bottom: 1px solid #FFF1E7;">
                                <th colspan="2">
                                    <table>
                                        <tr>
                            
                                        <td colspan="2">
                                            <p style="font-weight: normal;margin: 0px; padding: 5px 0px; color: #000;font-size: 13px; text-align: justify;line-height: 16px;"><?php echo $product['Product']['described'] ?></p>
                                        </td>
                                        </tr>
                                    </table>
                                
                                </th>
            
                            </tr>
                            <tr>
                                <th style="padding-top: 5px; width: 50%;">
                                    <span class="icon"></span><p class="text">Chuyên mục</p>
                                </th>
                                <th style="float: right;"><p class="text text-right"><?php echo $product['Category']['name'] ?></p></th>
                            </tr>
                            <tr>
                                <th><span class="icon" style="background-position-y:-26px;"></span><p class="text"> Nhãn hiệu</p></th>
                                <th style="float: right;"><p class="text text-right"><?php echo $product['Brand']['brand_name'] ?></p></th>
                            </tr>
                            <tr>
                                <th><span class="icon" style="background-position-y:-52px;"></span><p class="text"> Kích cỡ</p></th>
                                <th style="float: right;"><p class="text text-right"><?php echo $product['ProductSize']['size_name'] ?></p></th>
                            </tr>
                            <tr>
                                <th><span class="icon" style="background-position-y:-78px;"></span><p class="text"> Trạng thái</p></th>
                                <th style="float: right;"><p class="text text-right"><?php echo $product['Product']['condition'] ?></p></th>
                            </tr>
                            <tr>
                                <th><span class="icon" style="background-position-y:-104px;"></span><p class="text"> Nơi bán</p></th>
                                <th style="float: right;"><p class="text text-right"><?php echo $product['Product']['ships_from'] ?></p></th>
                            </tr>
                           
                        </table>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                        <div class="product-info" style="display: flex;">
                        <?php
                            if($product['Product']['video']) { ?>
                                        <div class="col-xs-12 ">
                                            <embed style="width:100%; height:300px;" src="<?php echo $product['Product']['video'] ?>">
                                        </div>
                                    <?php } else {
                         ?>               
                            <div class="slider slider-for col-xs-12 col-md-9" style=" padding:0px;">
                                
                                    <?php
                                        foreach ($product['ProductOtherImage'] as $key => $image) {
                                            echo '<div>
                                                <img style=" width: 100%; " src="'.$this->webroot.str_replace("/thumbnail","/images",$image['image']).'">
                                            </div>';
                                        }
                                    ?>   
                                   
                            </div>
                            <div class="slider slider-nav product-thumbnail hidden-xs col-md-3">
                                <?php 
                                foreach ($product['ProductOtherImage'] as $key => $image) {
                                            echo '<div class="slick-slide" style="max-height:120px; overflow: hidden;">
                                                <img style=" width: 120px;" src="'.$this->webroot.$image['image'].'">
                                            </div>';
                                        }
                                ?>
                            </div>
                            <?php } ?>
                        </div>
                </div>
                

        </div>
    </div>
</section>
<div id="download" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content" style="border: 2px solid #E86B7A;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">DOWNLOAD MUBA</h4>
      </div>
      <div class="modal-body" style="display: inline-block; text-align: center;">
        <p class="txt-Download">Bạn chỉ có thể mua hàng tại MUBA khi sử dụng ứng dụng trên di động. Vui lòng tải ứng dụng tại link dưới.</p>
        <a href="#please-edit-this-link" class="btn btn-app-download btn-ios">
            <i class="fa fa-apple"></i>
            <strong class="hidden-xs">Tải ứng dụng</strong> <span class="hidden-xs">từ App Store</span>
        </a>

        <a href="#please-edit-this-link" class="btn btn-app-download btn-primary">
            <i class="fa fa-android"></i>
            <strong class="hidden-xs">Tải ứng dụng</strong> <span class="hidden-xs">từ Play Store</span>
        </a>
      </div>
      

  </div>
</div>
<script type="text/javascript">

$(document).ready(function() {
  
    $('.slider-nav').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        arrows: false,
        focusOnSelect: true,
        vertical: true,
    });
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        asNavFor: '.slider-nav'
    });
  
   $('.slider-nav .slick-slide:not(.slick-cloned)').eq(0).addClass('slick-current');
   $('.slider-nav').on('click', function(){
             //remove all active class
             $('.slider-nav .slick-slide').removeClass('slick-current');
             //set active class for current slide
             $('.slider-nav .slick-active').addClass('slick-current');  
    });
    $(".slick-slide img")
    .error(function() { $(this).attr("src", "<?php echo $this->webroot;?>img/noimage.jpg"); });
  

});
</script>