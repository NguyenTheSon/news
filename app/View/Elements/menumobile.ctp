<div id="mobile-menu">
  <ul>
    <li class="page-scroll"><a href="<?php echo Router::url("/");?>">Trang chủ</a></li>
    <?php
      foreach ($Categories as $key => $category) {
        ?>
        <li class="page-scroll">
                <?php echo $this->Html->link(
                  $category['Category']['name'], 
                  array( 
                    'controller' => 'News', 
                    'action' => $category['Category']['layout'], 
                    'id' => $category['Category']['id'], 
                    'slug' => Inflector::slug($this->Convert->vn_str_filter($category['Category']['name']),'-'))
                );
                ?></li>
        <?php
      }
    ?>
    <li class="page-scroll"><a href="<?php echo Router::url(array('controller' => 'Products', 'action' => 'index'));?>">Sản phẩm</a></li>
    <li class="page-scroll"><a href="<?php echo Router::url(array('controller' => 'Galleries', 'action' => 'index'));?>">Thư Viện</a></li>
    <li class="page-scroll" style="text-align:center;">
    <form action="<?php echo Router::url(array("action" => "Search")); ?>" method="GET">
               <input id="birds" name="Keyword" class="typeahead form-control email" style="border: 1px solid #000;width:245px;height:40px;" type="text" placeholder="input a country name">
    </li>
    <li class="page-scroll">
               <input type="submit" class="btn btn-default" style="color: #000;border: 1px solid #000;font-size: 16px;width:100px" value="Tìm kiếm" name="submit">
             </form>
             </li>
  </ul>
</div>
