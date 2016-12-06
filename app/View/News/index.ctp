<?php echo $this->element('News/header'); ?>
<section id="ourteam">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-8 col-lg-8" id="blog-content">
        <div class="row" style="display:none;">
          <div class="col-sm-12 col-md-7 col-lg-7 pull-right eblog animated fadeIn"> 
            <form action="<?php echo Router::url(array("action" => "Search")); ?>" method="GET">
             <input id="birds" name="Keyword" class="typeahead form-control email" style="border: 1px solid #000;width: 70%;float:left;margin-right: 10px;" type="text" placeholder="input a country name">
             <input type="submit" class="btn btn-default" style="color: #000;width: 100px;border: 1px solid #000; padding: 4px; font-size: 16px;" value="Tìm kiếm" name="submit">
           </form>
         </div>
       </div>
       <?php echo $this->element('News/index_page'); ?>
     </div>
     <div class="hidden-xs hidden-sm col-md-4 col-lg-4">
      <?php echo $this->element('rightframe'); ?>
    </div>
  </div>
  <div class="clearfix"></div>
</div>
</section>
<div class="animation_image" style="display:none" align="center">
  <img src="/img/ajax-loader1.gif" height="100" />
</div>
<?php echo $this->element('Homes/popup');?>
<script src="<?php echo Router::url("/",true);?>news/js/jquery-ui.js"></script>
<script>
  $(function() {
    function log( message ) {
      $( "<div>" ).text( message ).prependTo( "#log" );
      $( "#log" ).scrollTop( 0 );
    }

    $( "#birds" ).autocomplete({
      source: "<?php echo Router::url(array('action' => 'search'));?>",
      minLength: 2,
      select: function( event, ui ) {
        log( ui.item ?
          "Selected: " + ui.item.value + " aka " + ui.item.id :
          "Nothing selected, input was " + this.value );
      }
    });
  });
</script>
<style>
  .ui-autocomplete{
    color:#000;
    font-size: 15px;
    padding: 5px;
    font-weight: bold;
    width:300px;
    background: #e0e0e0;
  }
  @media (max-width: 1000px)
  {
    .team{
      height: auto !important;
    }
    .eblog{
      border-bottom: 1px solid #ECECEC;
    }
  }
</style>

