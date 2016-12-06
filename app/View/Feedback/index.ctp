<section id="feedback" class="col-padtop" style="padding:0px;">
	<div id="uploadbtn">
		<img id="btn_upload" src="<?php echo Router::url("/",true);?>feedback_data/upload_icon.png" style="width:150px;height:145px;">
	</div>
    <div class="grid">
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
                        <div class="fb-like" data-href="<?php echo Router::url(array("action" => "detail",$feedback['Feedback']['id']),true); ?>" data-layout="button" data-action="like" data-show-faces="true" data-share="true" data-width="100%" style="width:100%;"></div>
                      </div>
                    </div>
                </div>
            </div>
          </a>      
        <?php
          endforeach;
        ?>
          
    </div>    
</section>

<style type="text/css">
#uploadbtn {
    position: fixed;
    bottom: 0;
    width: 100%;
	text-align:right;
	z-index:10;
}
  @media (min-width: 992px) {
      .col-md-5c {
          width: 20%;
          float: left;
      }
      .item{
    padding: 20px 5px !important;
  }
  }
  #feedback{
    padding-top: 90px !important;
    background: #eee;
  }
  .item{
    padding: 15px 3px !important;
  }
  #feedback .item .box{
    background: #fff;
    -webkit-box-shadow: 0 1px 2px 0 rgba(0,0,0,0.08);
    box-shadow: 0 1px 2px 0 rgba(0,0,0,0.08);
    border-radius: 6px;
  }
  .item img{
    width: 100%;
  }
  .info .detail{
    padding: 10px;
    line-height: 16px;
    font-family: sans-serif;
  }
  .info .account{
    border-top: 1px solid #eee;
    padding: 5px 10px;
    min-height: 50px;
  }
</style>
<script type="text/javascript">
  $(document).imagesLoaded( function() {
  
    $('#feedback .grid').masonry({
  // options...
  itemSelector: '.item',
});
    
  });

</script>
 <div class="modal fade" id="Modal-gallery">
      <div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Lưu lại khoảnh khắc của bạn</h4>
			</div>
			<div class="modal-body">
			<form method="POST" enctype="multipart/form-data">
			<?php
				if($Data_User['id']==3)
				{
			?>
				<div class="form-group">
				  <label for="usr">Tên của bạn</label>
				  <input type="text" class="form-control" name="username">
				</div>
			<?php
				}
				else
				{
			?>
				<div class="form-group">
					<label for="comment">Chào <?php echo $Data_User['Name'];?>, hãy lưu lại khoảnh khắc của mình với Thanh Huyền Salon nhé</label>
					<input type="hidden" class="form-control" name="username" value="<?php echo $Data_User['Name'];?>">
				</div>
				
			<?php
				}
			?>
				<div class="form-group">
					<label for="comment">Hình ảnh</label>
					<input type="file" name="img">
				</div>
				<div class="form-group">
				  <label for="comment">Câu chuyện của bạn?</label>
				  <textarea class="form-control" rows="5" name="comment"></textarea>
				</div>
				<button type="submit" class="btn btn-default">Đăng ảnh</button>
				</form>
			</div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script type="text/javascript"> 
     
      $("#btn_upload").on("click",function() {
        
          $('#Modal-gallery .caption').html("");
          $('#Modal-gallery').modal('show');
        
      });
	  
	  $("#btn_upload").on("click",function() {
        
          $('#Modal-gallery .caption').html("");
          $('#Modal-gallery').modal('show');
        
      });
    var page = 1;
    var loading = 0;
	  $(window).scroll(function(event) {
      if($(window).scrollTop() + $(window).height() >= $("body").height() - 500 && loading == 0){
        loading = 1;
        page++;
        $.ajax({
          url: '<?php echo Router::url(array('action' => 'loadmore'));?>/'+page,
        })
        .done(function(data) {
          var $data = $(data);
                $("#feedback .grid").append($data).imagesLoaded(function(){
                    FB.XFBML.parse();
                    $("#feedback .grid").masonry( 'appended', $data, true );
                }); 
          
        })
        .always(function() {
          loading = 0;
        });
        
      }
    });
    </script>