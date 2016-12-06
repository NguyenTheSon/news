<?php //pr($current_cat); ?>
<section id="products_main">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->webroot;?>">Muba</a></li>
            <li><a href="<?php echo Router::url(array($User['User']['url'])); ?>"><?php echo $User['User']['username']; ?></a></li>
        </ol>
        <div class="col-xs-12 col-sm-3">
            <div class="user-info product-info" style="padding: 15px;">
                <table class="table">
                    <tr>
                        <td style="border: none;" colspan="2">
                            <img src="<?php echo $User['User']['avatar'];?>" style="width: 100%;">
                            <div class="username"><?php echo $User['User']['username'];?></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="userinfo" style="border: none;" colspan="2">
                           <p style="color:#000; margin-bottom: 15px;"><?php echo $User['User']['status'];?></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="userinfo">
                           Đã đăng
                        </td>
                        <td class="userinfo">
                            14 sản phẩm
                        </td>
                    </tr>
                    <tr>
                        <td class="userinfo">
                           Đánh giá
                        </td>
                        <td class="userinfo">
                            45 điểm
                        </td>
                    </tr>
                    <tr>
                        <td class="userinfo">
                           Tham gia
                        </td>
                        <td class="userinfo">
                            31/12/2015
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-xs-12 col-sm-9">
            <?php
            if(!$products) {
                echo '<h2 style="text-align: center;">Không có dữ liệu hoặc dữ liệu đang được cập nhật !!!</h2>';
            } else {
            ?>
            <div class="list_products">
                <div class="row">
                    <?php echo $this->element('Categories/list-products-index'); ?>
                </div>
            </div>
            <div class="animation_image" style="display:none" align="center">
                        <img src="<?php echo $this->webroot;?>img/ajax-loader1.gif" height="100">
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<script type="text/javascript">
var isEnd = false;
var loading = false;
var page = 1;
    $(document).ready(function(){
   //     $('.list_products .item img').heightLine();
        resizeImage();
        $(window).scroll(function() {
            console.log($(window).scrollTop() + $(window).height()+1 , $(document).height());
            if($(window).scrollTop() + $(window).height()+5 >= $(document).height()){
                if(isEnd == false && loading==false)
                {
                    loading = true;
                    $('.animation_image').show();
                    $.ajax({
                        url: '<?php echo Router::url(array($User["User"]["url"])); ?>',
                        type: 'POST',
                    //    dataType: 'JSON',
                        data: {page: ++page},
                    })
                    .done(function(data) {
                        if(data.trim() ==""){
                            isEnd = true;
                        }
                        $(".list_products .row").append(data);
                        resizeImage();
                        loading = false;
                        $('.animation_image').hide();
                    })
                    .fail(function() {
                        console.log("error");
                        loading = false;
                        $('.animation_image').hide();
                    });
                }
            }
        });
    });

    function resizeImage(){
        var i = 0;
        $(".list_products img[data-resized != 'true']").each(function(){
            $(this).error(function() { $(this).attr("src", "<?php echo $this->webroot;?>img/noimage.jpg"); });
            $(this).attr("data-resized", true);
            if($(this).height() < $(this).parent().height()){
                $(this).css({
                    "height": "200px",
                    "max-width" : "none"
                });
                
                console.log(i++);
             }
   //          
        });
    }
    
</script>