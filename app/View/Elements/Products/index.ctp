<?php
    foreach($Products as $Product){
     
?>
            <div class="col-xs-6 col-sm-4 col-md-5c product-item">
              <a href="<?php echo Router::url(array('action' => 'detail',$Product['Product']['id']));?>">
                    <div style="background: transparent url('<?php echo $Product['Product']['image'];?>') repeat scroll 0% 0% / cover ; width: 100%; height: 600px;" class="img-thumb">
                    </div>
              </a>
              <div class="product-info">
                <h4><?php echo $Product['Product']['name'];?></h4>
                <p class="price"><?php echo number_format($Product['Product']['price']);?></p>
              </div>
              <div class="row">
                  <div class="col-xs-4 cart"><img src="/img/cart.png"></div>
                  <div class="col-xs-8 col-md-7 col-md-offset-1 rating"><img src="/img/star-rating.png"></div>
              </div>
            </div>
<?php
     }
?>