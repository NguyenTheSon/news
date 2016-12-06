<div class='ct-wrapper'>
      <div class='outer-wrapper'>
        <div class='main-wrapper'>
          <div class='content section' id='content'>
            <div class='widget Blog' id='Blog1'>
              <div class='blog-posts hfeed clearfix' id='grid' data-page='0'>
                <?php
                  foreach ($News as $key => $new) {
                ?>
                <div class='animated'>
                  <div class='post hentry clearfix'>
                    <div class='post-body entry-content' id='post-body-1'>
                      <div id="2">
                        <?php echo $this->Html->link(
                            '<img class="thumb" src="'.(strpos($new['News']['images'],"http") === false ? Router::url("/",true):'').$new['News']['images'].'" style="width: 100%;">'
                            ,array(
                                'controller' => 'News',
                                'action' => 'detail', 
                                'id' => $new['News']['id'], 
                                'slug' => Inflector::slug($new['News']['title_url'],'-')
                            ),
                            array('escape' => FALSE)
                          );
                        ?>
                        <div class="entry-wrap">
                          <h2 class="entry-header">
                            <?php echo $this->Html->link($new['News']['title'],
                              array( 
                                  'controller' => 'News', 
                                  'action' => 'detail', 
                                  'id' => $new['News']['id'], 
                                  'slug' => Inflector::slug($new['News']['title_url'],'-'))
                              );
                            ?>
                          </h2>
                          <div class="post_meta">
                            <span class="user">
                            </span>
                            <span class="sep">•</span>
                            <span class="time"><?php echo $new['News']['created'];?></span>
                          </div>
                          <p class="entry-summary clearfix"><?php echo $new['News']['description'];?></p>
                          <?php echo $this->Html->link("Đọc thêm →",
                              array( 
                                  'controller' => 'News', 
                                  'action' => 'detail', 
                                  'id' => $new['News']['id'], 
                                  'slug' => Inflector::slug($new['News']['title_url'],'-')),
                              array('class' => 'button normal',)
                              );

                          ?>
                        </div>
                      </div>
                      <div style='clear: both;'></div>
                    </div>
                    <div class='post-footer'>
                      <div class='post-footer-line post-footer-line-1'></div>
                      <div class='post-footer-line post-footer-line-2'></div>
                      <div class='post-footer-line post-footer-line-3'>
                        <span class='post-location'></span>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                }
                ?>
              </div>
              <div class='clear'></div>
            </div>
          </div>
        </div>
        <div class='clr'></div>
      </div>
    </div>
<div class="animation_image" style="display:none" align="center">
                    <img src="<?php echo Router::url("/",true); ?>img/ajax-loader1.gif" height="100">
</div>
 <script type="text/javascript">


    var isEnd = false;
    var loading = false;
    var page = 1;
    $(window).scroll(function() {

      if($(window).scrollTop() + $(window).height()+400 >= $(document).height()){
                    if(isEnd == false && loading==false)
                    {
                        loading = true;
                        $('.animation_image').show();
                        $.ajax({
                            url: '<?php echo Router::url(array("action" => "blog",$this->request->params['pass'][0])); ?>',
                            type: 'POST',
                        //    dataType: 'JSON',
                            data: {page: ++page},
                        })
                        .done(function(data) {
                            if(data.trim() ==""){
                                isEnd = true;
                            }
                            $("#grid").append(data);
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
    </script>