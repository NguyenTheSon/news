<script src="<?=Router::url("/",true);?>ckeditor/ckeditor.js"></script>
<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">Thêm nhân viên</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-6 col-sm-6 ">
				<?php echo $this->Form->create('Staff',array('enctype' => "multipart/form-data"));?>
				<?php echo $this->Form->input('name', array('class' => 'form-control form-group', 'label' => 'Tên Hiển Thị')); ?>
				<?php echo $this->Form->input('Group', array('class' => 'form-control form-group', 'label' => 'Nhóm nhân viên','options' => $groups));?>
				<?php echo $this->Form->input('content', array('type' => 'textarea','class' => 'form-control form-group ckeditor', 'label' => 'Mô tả')); ?>

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
		$("#Staff-avartar").attr('src',filePath);
		$("#StaffAvatar").val(filePath);

	});
	$('#removeAvatar').click(function(){
		if(confirm('Bạn có muốn xóa Avatar này?')){
			$("#Staff-avartar").attr('src','');
			$("#StaffAvatar").val('');
		}
	});
</script>