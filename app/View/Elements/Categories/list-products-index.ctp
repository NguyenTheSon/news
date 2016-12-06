<?php foreach($products as $product) { ?>
<div class="item_product col-lg-15 col-sm-4 col-xs-12">
    <div class="animated fadeIn item">
    <?php
    if(isset($product['ProductOtherImage'][0]['image'])){
        echo $this->Html->link(
            "<img src='".$this->webroot.str_replace("/thumbnail","/images",$product['ProductOtherImage'][0]['image'])."'>",
            array('controller' => 'products', 'action' => 'details', $product['Product']['id']),
            array('escape' => false,'class' => 'image-crop')
        );
    }
    else{
        echo $this->Html->link(
            "<img src='".$this->webroot."img/noimage.jpg'>",
            array('controller' => 'products', 'action' => 'details', $product['Product']['id']),
            array('escape' => false,'class' => 'image-crop')
        );
    }
    ?>
    <div class="info">
        <h4><?php echo $product['Product']['name']; ?></h4>
        <h5><?php echo number_format($product['Product']['price']); ?> VNĐ</h5>
    </div>
    </div>
</div>
<?php } ?>