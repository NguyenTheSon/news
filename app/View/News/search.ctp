<?php echo $this->element('News/header'); ?>
  <section id="ourteam">
    <div class="container">
      <div class="row">
        <div class="hidden-xs hidden-sm col-md-4 col-lg-4">
          <div  data-spy="affix" data-offset-top="570" data-offset-bottom="670">
            <?php
              foreach ($Captions as $key => $caption) {
                ?>
                <div class="caption-content">
                  <h2><?php echo $caption['CategoryCaption']['title'];?></h2>
                  <div class="ourteamd">
                    <p><?php echo $caption['CategoryCaption']['content'];?></p>
                  </div>
                </div>
                <?php
              }
            ?>
          </div>
        </div>
        <div class="col-sm-12 col-md-8 col-lg-8" id="blog-content">          
          <?php echo $this->element('News/index_page'); ?>
      </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </section>
<div class="animation_image" style="display:none" align="center">
                    <img src="/img/ajax-loader1.gif" height="100">
</div>
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
  </style>
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
                        $("#blog-content").append(data);
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