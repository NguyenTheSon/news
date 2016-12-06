<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title">Cập nhật thông tin</h3>
  </div>
  <div class="panel-body">
	    <div class="row">
	    	<div class="col-md-6 col-sm-6 ">
	    	<fieldset class="list-category-border">
              <legend class="list-category-border">Thông tin cơ bản</legend>
		    	<?php echo $this->Form->create('User',array('enctype' => "multipart/form-data"));?>
				<?php echo $this->Form->input('id'); ?>
				<?php echo $this->Form->input('phonenumber', array('class' => 'form-control form-group', 'label' => 'Số Điện Thoại')); ?>
				
				<!--div class="form-group">
					<?php echo $this->Form->label('Avatar'); ?>
					<br>
					<img src='<?php if(isset($this->data["User"]["avatar"])) echo $this->Html->url('/').$this->data["User"]["avatar"];?>' style='max-height:100px;' id='User-avartar'>
					<div>
						<span class="btn btn-default btn-file">Đổi Ảnh <input type="file" id='fileAvatar1' name='data[file]'></span>
						<span class='btn btn btn-danger' id='removeAvatar'>Xóa Ảnh</span>
					</div>
					<input type='hidden' name='data[delavatar]' id='delavatar' value='0'>
				</div!-->
				<?php echo $this->Form->input('prefix', array('class' => 'form-control form-group', 'label' => 'Danh', 'options' => array('' => '','chị' => 'chị', 'cô' => 'cô','cháu' => 'cháu', 'anh' => 'anh','em' => 'em'))); ?>
				<?php echo $this->Form->input('name', array('class' => 'form-control form-group', 'label' => 'Tên Hiển Thị')); ?>
			
				<?php echo $this->Form->input('email', array('class' => 'form-control form-group', 'label' => 'Email')); ?>
				<?php echo $this->Form->input('birthday', array('class' => 'form-control form-group', 'label' => 'Ngày Sinh')); ?>
				<?php echo $this->Form->input('address', array('class' => 'form-control form-group', 'label' => 'Địa chỉ')); ?>
				<?php echo $this->Form->input('balance', array('class' => 'form-control form-group', 'label' => 'Điểm tích lũy')); ?>
				<?php echo $this->Form->input('percent_discount', array('class' => 'form-control form-group', 'label' => 'Phần trăm khuyến mại')); ?>
				
				<?php echo $this->Form->input('password', array('required' => false,'class' => 'form-control form-group', 'label' => 'password','value' => '')); ?>
				
				<?php echo $this->Form->input('role', array('class' => 'form-control form-group', 'label' => 'Nhóm người dùng', 'options' => array('2' => 'admin', '3' => 'user'))); ?>
				<div class="form-group">
					<input type="hidden" name="data[User][active]" id="UserActive_" value="0">
					<input type="checkbox" name="data[User][active]" class="i-grey-square" value="1" id="UserActive" <?php if ($this->data['User']['active'] == 1) echo 'checked';?> >
					<label for="UserActive">Active</label>
				</div>
			</fieldset>
			
            </div>

       
        </div>
        <div class="row">
        	<div class="col-xs-12">
        		<?php echo $this->Html->link('Quay Lại', array('action' => 'index'), array('class' => 'btn btn-warning')); ?>
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
				$("#delavatar").val(0);
	});
	$('#removeAvatar').click(function(){
		if(confirm('Bạn có muốn xóa Avatar này?')){
			$("#User-avartar").attr('src','');
				$("#UserAvatar").val('');
				$("#delavatar").val(1);
		}
	});
	$(".edit-address").click(function(){
		var id = $(this).attr("data-addr-id");
		window.location = "<?php echo Router::url(array("action" => "edit_addr"));?>/"+id;
	});
	$(function() {
	var icons = { 
      header: "ui-accordion-header-icon ui-icon ui-icon-triangle-1-e",
      activeHeader: "ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"
    };
    $( ".accordion" ).accordion({
    	collapsible: true,
    	icons: icons,
    });
  });
</script>