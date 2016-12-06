 <link rel="stylesheet" type="text/css" href="<?=Router::url("/",true);?>/news/css/input.css">

<style>
@media (min-width: 992px) {
  .col-md-5c{
    width: 20%;
  }
}
</style>
<script src="<?=Router::url("/",true);?>/news/js/plugins.js" type="text/javascript"></script>
 <link rel="stylesheet" type="text/css" href="<?=Router::url("/",true);?>/news/css/input.css">
 <link rel="stylesheet" type="text/css" href="<?=Router::url("/",true);?>/news/css/products.css">
 <link  href="http://fonts.googleapis.com/css?family=Reenie+Beanie:regular" rel="stylesheet" type="text/css"> 

 <section id="products" class="col-padtop">
    <div class="container">
      <div class="row">
<div style="margin-top: 20px;">
  <nav class="navbar navbar-default" role="navigation" style="z-index:0; min-height: 0px;">
    <div class="container-fluid">
    <div class="list-category">
      <ul class="">
        <li data-category-id="0">Tất cả</li>
         <?php
              foreach ($ProdCategories as $key => $ProdCategory) {
                ?>
                <li style="" data-category-id="<?php echo $ProdCategory["ProdCategory"]['id'];?>"><?php echo $ProdCategory["ProdCategory"]['name'];?></li>
                <?php
              }
            ?>
      </ul>
   </div>
 </div>
</nav>
</div>
       
        <div class="list-products">
          <?php echo $this->element("Products/index"); ?>
      </div>
    </div>
 </section>
<section  class="col-padtop">
  <div class="container">
      <div class="row">

</div>
</div>
</section>
  <script type="text/javascript">
  function Render(){
    $(".img-thumb").height($(".img-thumb").width()/4*5);
    if($(window).width() < 768){
          $(".product-item").each(function(index, el) {
            if((index+1) % 4 == 0 || index %4 == 0){
              $(el).addClass('odd');
            }
          });
      }
      else{
          $(".product-item").each(function(index, el) {
            if(index % 2 == 0){
              $(el).addClass('odd');
            }
          });
      }
  }
  $(document).ready(function() {
      
      Render();
      $('.list-category ul').slick({
          slide: 'li',
          centerMode: true,
          arrow: false,
          responsive: [
            {
              breakpoint: 2024,
              settings: {
                slidesToShow: 5,
                slidesToScroll: 5,
              }
            },
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              }
            }
          ]
        });

        $('.list-category ul').on('click', 'li', function(e) {
          e.stopPropagation();
          var currentActive = $('.slick-center').attr("data-slick-index");
          var slideIndex = $(this).attr("data-slick-index");
          var numSlides = $('.slick-slider li.slick-slide').size() - $('.slick-slider li.slick-cloned').size();
          if(slideIndex < -1){
              console.log(slideIndex);
              $('.slick-slider').slick("slickPrev");
              setTimeout(function(){
                $('.slick-slider').slick("slickGoTo",parseInt(numSlides) + parseInt(slideIndex));
              },500);
              
          }
          else{
            $('.slick-slider').slick("slickGoTo",slideIndex);
          }
         
        });

        $('.slick-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
            var catid = $('.slick-slider li.slick-slide[data-slick-index="'+nextSlide+'"]').attr("data-category-id");
            console.log(catid);
            $.ajax({
              url: '<?php echo Router::url(array("action" => "index")); ?>',
              type: 'POST',
              data: {catid: catid},
            })
            .done(function(data) {
              $(".list-products").fadeOut('slow', function() {
                $(".list-products").html(data);
                $(".list-products").show();
                Render();
                
              });
            })
            .fail(function() {
              console.log("error");
            })
            .always(function() {
              console.log("complete");
            });
            
        }); 
  });
</script>
