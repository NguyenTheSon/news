<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title">Thêm người dùng</h3>
  </div>
  <div class="panel-body">
	    <div class="row">
	    	<div class="col-md-6 col-sm-6 ">
	    	<?php echo $this->Form->create('User',array('enctype' => "multipart/form-data"));?>
	    	<?php echo $this->Form->input('phonenumber', array('class' => 'form-control form-group', 'label' => 'Số Điện Thoại')); ?>
			
			<!--div class="form-group">
				<?php echo $this->Form->label('Avatar'); ?>
				<br>
				<img src='' style='max-height:100px;' id='User-avartar'>
				<div>
					<span class="btn btn-default btn-file">Đổi Ảnh <input type="file" id='fileAvatar1' name='data[file]'></span>
					<span class='btn btn btn-danger' id='removeAvatar'>Xóa Ảnh</span>
				</div>
			</div!-->
			<?php echo $this->Form->input('prefix', array('class' => 'form-control form-group', 'label' => 'Danh', 'options' => array('' => '','chị' => 'chị', 'cô' => 'cô','cháu' => 'cháu', 'anh' => 'anh','em' => 'em'))); ?>
			<?php echo $this->Form->input('name', array('class' => 'form-control form-group', 'label' => 'Tên hiển thị')); ?>
			<?php echo $this->Form->input('email', array('class' => 'form-control form-group', 'label' => 'Email')); ?>
			<?php echo $this->Form->input('birthday', array('class' => 'form-control form-group', 'label' => 'Ngày Sinh')); ?>
			<?php echo $this->Form->input('address', array('class' => 'form-control form-group', 'label' => 'Địa chỉ')); ?>
			<?php echo $this->Form->input('balance', array('class' => 'form-control form-group', 'label' => 'Điểm tích lũy')); ?>
			<?php echo $this->Form->input('percent_discount', array('class' => 'form-control form-group', 'label' => 'Phần trăm khuyến mại')); ?>
			
			
			<?php echo $this->Form->input('password', array('required' => false,'class' => 'form-control form-group', 'label' => 'password','value' => '')); ?>
			
			<?php echo $this->Form->input('role', array('class' => 'form-control form-group', 'label' => 'Nhóm người dùng', 'options' => array('2' => 'admin', '3' => 'user'), 'default' => '3')); ?>

			<div class="form-group">
				<input type="hidden" name="data[User][active]" id="UserActive_" value="0">
				<input type="checkbox" name="data[User][active]" class="i-grey-square" value="1" id="UserActive" checked >
				<label for="UserActive">Active</label>
			</div>
			<?php echo $this->Form->button('Quay Lại', array('class' => 'btn btn-warning', 'onclick' => "window.location ='".$this->request->referer()."'", 'type' => 'button')); ?>
			<?php echo $this->Form->button('Lưu Lại', array('class' => 'btn btn-primary')); ?>

			<?php echo $this->Form->end(); ?>
            </div>
        </div>
	</div>
</div>
<script type="text/javascript">
	$("#fileAvatar1").change(function(event){
		var filePath = URL.createObjectURL(event.target.files[0]);
				$("#User-avartar").attr('src',filePath);
				$("#UserAvatar").val(filePath);
			
	});
	$('#removeAvatar').click(function(){
		if(confirm('Bạn có muốn xóa Avatar này?')){
			$("#User-avartar").attr('src','');
				$("#UserAvatar").val('');
		}
	});
</script>