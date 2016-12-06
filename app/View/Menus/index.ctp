<?php //pr($current_cat); ?>
<section id="products_main">
    <div class="container" style="max-width: 960px;">
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->webroot;?>">Muba</a></li>
            <li><a href="<?php echo Router::url(['controller' => 'Categories', 'action' => 'index', $current_cat['Category']['id']]); ?>"><?php echo $current_cat['Category']['name']; ?></a></li>
        </ol>
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
                        url: '<?php echo Router::url(array("action" => "index", $current_cat["Category"]["id"])); ?>',
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
                    "height": "160px",
                    "max-width" : "none"
                });
                
                console.log(i++);
             }
   //          
        });
    }
    
</script>