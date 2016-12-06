<?php
  foreach ($galleries as $gallery):
?>
  <a href="<?php echo Router::url(array("action" => "detail",$gallery['Gallery']['id'])); ?>">
    <div class="col-xs-6 col-md-5c item">
        <div class="box">
            <img src="<?php echo $gallery['Gallery']['image'];?>">
            <div class="info" style="color:#333;">
              <p class="detail">
                  <?php echo $gallery['Gallery']['caption'];?>
              </p>
              <div class="account">
                <div class="fb-share-button" data-href="<?php echo Router::url(array("action" => "detail",$gallery['Gallery']['id']),true); ?>" data-layout="button" ></div>
              </div>
            </div>
        </div>
    </div>
  </a>      
<?php
  endforeach;
?>