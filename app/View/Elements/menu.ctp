<script>
  $(document).ready(function(){

  });
  $(document).click(function(event) {

    if ($(event.target).hasClass('showbar')) {
     $("#SearchBar").show();
   }
   else
   {
    $("#SearchBar").hide();
  }
});
</script>
<nav>
  <div class="container">
    <div class="row hidden-xs">
      <div class="col-lg-12">
        <div class="logo page-scroll hidden-xs"><a href="<?=Router::url("/",true);?>"><img src="<?=Router::url("/",true);?>/img/logo-TH2.png" alt="logo" style="max-height:40px;"></a></div>
        <div class="mm-toggle-wrap">
          <div class="mm-toggle"> <i class="icon-menu"><img src="<?=Router::url("/",true);?>/news/images/menu-icon.png" alt="Menu"></i></div>
        </div>
        <ul class="menu">
          <li class="page-scroll"><a href="<?php echo Router::url("/");?>">Trang chủ</a></li>
          <?php foreach ($Categories as $key => $category) :?>
            <li class="page-scroll">
              <a href="<?php echo Router::url(array('controller' => 'News','action' => $category['Category']['layout'],'id' => $category['Category']['id'],'slug' => Inflector::slug($this->Convert->vn_str_filter($category['Category']['name']),'-')));?>"><?php echo $category['Category']['name'];?></a>
              <ul class="sub-menu">
                <?php $cate = $this->requestAction('Homes/getSubcategory/'.$category['Category']['id']);?>
                <?php if(isset($cate)):?>
                  <?php foreach ($cate as $key => $value) :?>
                    <li>
                      <a href="#"><?php echo $value['Category']['name'];?></a>
                    </li>
                  <?php endforeach; ?>
                <?php endif; ?>
              </ul>
            </li>
          <?php endforeach; ?>
          <li class="page-scroll"><a href="<?php echo Router::url(array('controller' => 'Galleries', 'action' => 'index'));?>">Thư Viện</a></li>
          <li class="page-scroll showbar" style="line-height: 48px;">
            <img class="showbar" src = "https://cdn2.iconfinder.com/data/icons/windows-8-metro-style/512/search.png" style="width:30px;">
          </li>
        </ul>
      </div>
      <div class="showbar" style="text-align:right;display:none;" id="SearchBar">
        <div class="" style="text-align:right;" class="showbar">
          <form action="<?php echo Router::url(array("action" => "Search")); ?>" method="GET">
            <table style="width:100%">
              <tr style="width:100%">
                <td>
                 <input id="birds" name="Keyword" class="typeahead showbar search-inp" style="" type="text" placeholder="Tìm kiếm">
               </td>
               <td nowrap><button type="submit" style="border: 0px;background-color: transparent;color: #000;"><i class="fa fa-search" style="padding: 7px; font-size: 18px;"></i></button>
               </tr>
             </table>
           </form>

         </div>
       </div>
     </div>
     <div class="clearfix"></div>
   </div>
 </nav>
 <div class="menu-mobile visible-xs">
  <div class="mm-toggle-wrap">
    <div class="mm-toggle"> <i class="icon-menu"><img src="<?=Router::url("/",true);?>/news/images/menu-icon.png" alt="Menu"></i></div>
  </div>
  <div class="logo page-scroll">
    <div class="overlay-logo"></div>
    <a href="<?=Router::url("/",true);?>"><img src="<?=Router::url("/",true);?>/img/logo-TH2.png" alt="logo" style="max-height:70px;"></a>
  </div>
</div>
