<?php
          foreach ($Feedbacks as $feedback):
        ?>
          <a href="<?php echo Router::url(array("action" => "detail",$feedback['Feedback']['id'])); ?>">
            <div class="col-xs-6 col-md-5c item">
                <div class="box">
                    <img src="<?php echo $feedback['Feedback']['images'];?>">
                    <div class="info" style="color:#333;">
                      <p class="detail">
                          <?php echo $feedback['Feedback']['detail'];?>
                      </p>
                      <div class="account">
                        <b><?php echo $feedback['Feedback']['username'];?></b>
                        <p style="color: #aaa;margin:0px;"><?php echo $feedback['Feedback']['created'];?></p>
                        <div class="fb-like" data-href="<?php echo Router::url(array("action" => "detail",$feedback['Feedback']['id']),true); ?>" data-layout="button" data-action="like" data-show-faces="true" data-share="true"  style="width:100%;"></div>
                      </div>
                    </div>
                </div>
            </div>
          </a>      
        <?php
          endforeach;
        ?>