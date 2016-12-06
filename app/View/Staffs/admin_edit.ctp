<script src="<?=Router::url("/",true);?>ckeditor/ckeditor.js"></script>
<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">Cập nhật thông tin</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-6 col-sm-6 ">
				<fieldset class="list-category-border">
					<legend class="list-category-border">Thông tin cơ bản</legend>
					<?php echo $this->Form->create('Staff',array('enctype' => "multipart/form-data"));?>
					<?php echo $this->Form->input('id'); ?>
					<?php echo $this->Form->input('name', array('class' => 'form-control form-group', 'label' => 'Tên Hiển Thị', 'value' => $staff['Staff']['name'])); ?>
					<?php echo $this->Form->input('Group', array('class' => 'form-control form-group', 'label' => 'Nhóm nhân viên','options' => $groups));?>
					<?php echo $this->Form->input('content', array('type' => 'textarea','class' => 'form-control form-group ckeditor', 'label' => 'Mô tả', 'value' => $staff['Staff']['content'])); ?>
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
		$("#Staff-avartar").attr('src',filePath);
		$("#StaffAvatar").val(filePath);
		$("#delavatar").val(0);
	});
	$('#removeAvatar').click(function(){
		if(confirm('Bạn có muốn xóa Avatar này?')){
			$("#Staff-avartar").attr('src','');
			$("#StaffAvatar").val('');
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