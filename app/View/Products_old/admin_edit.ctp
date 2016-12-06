<?php
function show_category($categories,$level=1){
	if($categories)
	foreach ($categories as $category) {
?>
	<li id='<?php echo $category['Category']['id'];?>' style='padding-left: <?php echo (15*$level);?>px;'>
		<?php echo $category['Category']['name'];?>
	</li>
     <?php show_category($category['children'],$level+1); ?>
<?php }} ?>	
<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title">Cập nhật thông tin</h3>
  </div>
  <div class="panel-body">
	    <div class="row">
	    	<div class="col-md-6 col-sm-6 ">
	    	<?php echo $this->Form->create('Product',array('enctype' => "multipart/form-data"));?>
			<?php echo $this->Form->input('id'); ?>
			<?php echo $this->Form->input('seller_id',array('type' => 'hidden')); ?>
			<?php echo $this->Form->input('name', array('class' => 'form-control form-group', 'label' => 'Tên Sản Phẩm')); ?>
			<div class="form-group">
				<?php echo $this->Form->label('Ảnh'); ?>
				<br>
				<div class="list-image-product">
					<?php
						if(isset($other_images)){
							foreach ($other_images as $oimg) {
								echo "<span>
										<p></p>
										<img src='".$this->webroot.$oimg['ProductOtherImage']['image']."' style='max-height:100px;'>
										<i class='fa fa-close del-img' id='".$oimg['ProductOtherImage']['id']."'></i>
										<input type='hidden' name='data[delimg][".$oimg['ProductOtherImage']['id']."]' id='del-img-".$oimg['ProductOtherImage']['id']."' value='0'>
									</span>";
							}
						}
					?>						
				</div>
				<input type='hidden' name='data[delimg][0]' id='del-img-0' value='0'>
			</div>
			<?php echo $this->Form->input('price', array('class' => 'form-control form-group', 'label' => 'Giá bán')); ?>
			<?php echo $this->Form->input('price_new', array('class' => 'form-control form-group', 'label' => 'Giá mới')); ?>
			
			<?php echo $this->Form->input('described', array('class' => 'form-control form-group', 'label' => 'Miêu tả','type' => 'textarea')); ?>
			<div class="btn-group btn-input clearfix">
			 <button type="button" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown">
	    			    <span data-bind="label"><?php echo $this->data['Product']['category_name']; ?></span> <span class="caret"></span>
	    		  </button>
	    			<ul class="dropdown-menu product-category" role="menu">
	           		  <?php show_category($categories); ?>
	    			</ul>	 
	    	<input type=hidden name='data[Product][category_id]' id='category_id' value='<?php echo $this->data['Product']['category_id'];?>'>
	    	</div>
			<?php echo $this->Form->input('product_size_id', array('class' => 'form-control form-group', 'label' => 'Cỡ', 'options' => (isset($this->data['ProductSize']) ? $this->data['ProductSize'] :""), 'default' =>$this->data['Product']['product_size_id'])); ?>
			<?php echo $this->Form->input('brand_id', array('class' => 'form-control form-group', 'label' => 'Hãng', 'options' => (isset($this->data['Brand']) ? $this->data['Brand'] : ""), 'default' =>$this->data['Product']['brand_id'])); ?>
			
			
			<?php echo $this->Form->input('ships_from', array('class' => 'form-control form-group', 'label' => 'Ship từ')); ?>
			<?php echo $this->Form->input('condition', array('class' => 'form-control form-group', 'label' => 'Loại Hàng')); ?>
			<div class="form-group">
				<input type="hidden" name="data[Product][is_deleted]" id="ProductIs_Deleted_" value="1">
				<input type="checkbox" name="data[Product][is_deleted]" class="i-grey-square" value="0" id="ProductIs_Deleted" <?php if ($this->data['Product']['is_deleted'] == 0) echo 'checked';?> >
				<label for="UserActive">Hiển Thị</label>
			</div>
			<?php echo $this->Form->button('Quay Lại', array('class' => 'btn btn-warning', 'onclick' => "window.location ='".$this->request->referer()."'", 'type' => 'button')); ?>
			<?php echo $this->Form->button('Lưu Lại', array('class' => 'btn btn-primary')); ?>

			<?php echo $this->Form->end(); ?>
            </div>
        </div>
	</div>
</div>
<script type="text/javascript">
	
	$('.del-img').click(function(){
		if(confirm('Bạn có muốn xóa Ảnh này?')){
			var parent = $(this).parent();
			var id = $(this).attr('id');
			parent.css('display','none');
			$('#del-img-'+id).val(1);
		}
	});
$( document.body ).on( 'click', '.product-category li', function( event ) {
  var $target = $( event.currentTarget );
 	var id= $(this).attr('id');
 	var c_sizeid = <?php echo $this->data['Product']['product_size_id'];?>;
 	console.log(c_sizeid);
 	var c_brandid = <?php echo $this->data['Product']['brand_id'];?>;

 	$('#category_id').val(id);
 	var url = '<?php echo $this->Html->url(array("action" => "edit")); ?>';
 	$.ajax({
		  type: "POST",
		  url: url,
		  dataType: "JSON",
		  data: { category_id: id}
		})
		  .done(function( data ) {
		  	console.log(data);
		  	$('#ProductProductSizeId option').remove();
		  	$.each(data.ProductSize,function(id,name){
		  		$('#ProductProductSizeId').append('<option value="'+ id +'" '+(c_sizeid==id? 'selected=""':'')+' >' +name+ '</option>');
		  	});
		  	$('#ProductBrandId option').remove();
		  	$.each(data.Brand,function(id,name){
		  		$('#ProductBrandId').append('<option value="'+ id +'" '+(c_brandid==id? 'selected=""':'')+'>' +name+ '</option>');
		  	});
		  	
	});
   $target.closest( '.btn-group' )
      .find( '[data-bind="label"]' ).text( $target.text() )
         .end()
      .children( '.dropdown-toggle' ).dropdown( 'toggle' );
   return false;
 
});
</script>