    	<link rel="stylesheet" type="text/css" href="<?php echo Router::url("/", true);?>/galleryjquery/css/style.css" />
		<script type="text/javascript" src="<?php echo Router::url("/", true);?>/galleryjquery/js/modernizr.custom.26633.js"></script>
 		<div class="container-fluid hidden-xs">
			
			
			<section class="main" style="padding-top:60px;">

				<div id="ri-grid" class="ri-grid ri-grid-size-3">
					<img class="ri-loading-image" src="<?php echo Router::url("/", true);?>/galleryjquery/images/loading.gif"/>
					<ul class="galleries">
					<?php
							foreach ($galleries as $key => $item) {
								?>
								<li class="item"><a href="#<?php echo $item['Gallery']['id'];?>" data-id='<?php echo $item['Gallery']['id'];?>'><img src="<?php echo $item['Gallery']['image'];?>"/></a></li>
								<?php
							}
						?>
					</ul>
				</div>

			</section>
			
        </div>
        <div class="container-fluid visible-xs">
        	<div class="row">
        		<section id="feedback" class="col-padtop" style="padding:0px;">
				    <div class="grid">
				        <?php
				          foreach ($galleries_m as $gallery):
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
				                        <div class="fb-like" data-href="<?php echo Router::url(array("action" => "detail",$gallery['Gallery']['id']),true); ?>" data-layout="button" data-action="like" data-share="true"></div>
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
        	</div>
        </div>

        <div class="modal fade" id="Modal-gallery">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-body">
		      	<p id="image"><img src="" class="image"></p>
		      	<p id="video"></p>
		      	<p class="caption"></p>
		        <div class="fb-like" data-share="true"></div>
		        <div class="fb-comments" data-width="100%" data-numposts="1"></div>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
     	<script type="text/javascript" src="<?php echo Router::url("/", true);?>/galleryjquery/js/jquery.gridrotator.js"></script>
		<script type="text/javascript">	
			$(function() {
				if($(window).width() >= 768){
					$( '#ri-grid' ).gridrotator( {
						rows : 4,
						columns : 6,
						maxStep : 5,
						interval : 2000,
						w1024 : {
							rows : 5,
							columns : 4
						},
						w768 : {
							rows : 5,
							columns : 4
						},
						preventClick: false,
					} );
				}
				else{
					  $(document).imagesLoaded( function() {
					    $('#feedback .grid').masonry({
						  itemSelector: '.item',
						});
					  });
					  	var page = 1;
					    var loading = 0;
						$(window).scroll(function(event) {
						  if($(window).scrollTop() + $(window).height() >= $("body").height() - 1300 && loading == 0){
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
				}
				
				var hash = "<?php echo isset($this->request->params['pass'][0])? $this->request->params['pass'][0] : ''; ?>";
				if(hash != ""){
					//$(".item a[data-id='"+hash+"']").parent().click();
					loadItem(hash);
				}
			
			});
			$(".galleries").on("click",".item",function() {
				var id = $(this).find("a").attr("data-id");
				loadItem(id);
				
			});
			function loadItem(id){
				$.ajax({
					url: '<?php echo Router::url(array("action" => "index"));?>',
					type: 'POST',
					dataType: 'JSON',
					data: {id: id},
				})
				.done(function(data) {
					$('#Modal-gallery .caption').html(data.Gallery.caption);
					if(data.Gallery.video =="")
					{
						$('#Modal-gallery .image').attr("src",data.Gallery.image);
						$('#Modal-gallery .image').attr('style', 'display:;');
						$('#Modal-gallery #video').attr('style', 'display:none;');
					}
					else
					{
						$('#Modal-gallery #video').html('<iframe width="560" height="315" src="https://www.youtube.com/embed/'+data.Gallery.video+'" frameborder="0" allowfullscreen></iframe>');
						$('#Modal-gallery #video').attr('style', 'display:;');
						$('#Modal-gallery .image').attr('style', 'display:none;');
					}
					window.history.pushState({}, "", "<?php echo Router::url(array('action' => 'index'),true);?>/index/"+id);
					FB.XFBML.parse();
					$('#Modal-gallery').modal('show');
				})
				.fail(function() {
					console.log("error");
				});
			}
		</script>