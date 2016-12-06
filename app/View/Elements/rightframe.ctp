<div class="box box-right">
  <h1>Chúng tôi trên facebook</h1>
  <div style="text-align:center;">
    <div class="fb-like-box" style="width: 90% !important; margin: 10px;" data-href="https://www.facebook.com/Luxuryhairsalonthanhhuyen" data-width="800" data-show-faces="true" data-colorscheme="dark" data-stream="false" data-border-color="#aaaaaa" data-header="true"></div>
  </div>
</div>
<div class="box box-right">
  <h1>Bài viết liên quan</h1>
  <div>
    <ul>
      <?php foreach($NewsRand as $newrand):?>
        <li>
          <a href="<?php echo Router::url(array('controller' => 'News','action' => 'detail', 'id' => $newrand['News']['id'],'slug' => Inflector::slug($newrand['News']['title_url'],'-')));?>"><?php echo $newrand['News']['title'];?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>