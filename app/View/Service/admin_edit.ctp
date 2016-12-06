<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo ($Service['Service']['id']!=""?"Sửa nhóm dịch vụ":"Thêm nhóm dịch vụ");?></h3>
  </div>
  <div class="panel-body">
        <div class="row">
            <div class="col-md-6 col-sm-6 ">
            <?php echo $this->Form->create('Service',array());?>
            <?php echo $this->Form->input('name', array('class' => 'form-control form-group', 'label' => 'Tên dịch vụ', 'value' => $Service['Service']['name'])); ?>
            <?php echo $this->Form->input('detail', array('class' => 'form-control form-group', 'label' => 'Mô tả dịch vụ', 'value' => $Service['Service']['detail'])); ?>
            <?php echo $this->Form->input('service_group_id', array('class' => 'form-control form-group', 'label' => 'Nhóm dịch vụ', 'options' => $ListGroup,'selected' => $Service['Service']['service_group_id'])); ?>
<?php echo $this->Form->input('message', array('class' => 'form-control form-group', 'label' => 'Nội dung SMS', 'value' => $Service['Service']['message'])); ?>
<?php echo $this->Form->input('duration', array('class' => 'form-control form-group', 'label' => 'Thời gian nhắn SMS', 'value' => $Service['Service']['duration'])); ?>

<?php echo $this->Form->hidden('staff_group_service_id_0', array('class' => 'form-control form-group', 'value' => $Service['StaffGroupService'][0]['id'],'hiddenField'=>1)); ?>
<?php echo $this->Form->hidden('staff_group_service_id_1', array('class' => 'form-control form-group', 'value' => $Service['StaffGroupService'][1]['id'],'hiddenField'=>1)); ?>
<?php echo $this->Form->input('Price_0', array('class' => 'form-control form-group', 'label' => 'Giá thường', 'value' => $Service['StaffGroupService'][0]['price'])); ?>
<?php echo $this->Form->input('time_0', array('class' => 'form-control form-group', 'label' => 'Thời gian thường', 'value' => $Service['StaffGroupService'][0]['time'])); ?>
<?php echo $this->Form->input('Price_1', array('class' => 'form-control form-group', 'label' => 'Giá Nhà tạo mẫu', 'value' => $Service['StaffGroupService'][1]['price'])); ?>
<?php echo $this->Form->input('time_1', array('class' => 'form-control form-group', 'label' => 'Thời gian Nhà tạo mẫu', 'value' => $Service['StaffGroupService'][1]['time'])); ?>


            <?php echo $this->Form->button('Quay Lại', array('class' => 'btn btn-warning', 'onclick' => "window.location ='".$this->request->referer()."'", 'type' => 'button')); ?>
            <?php echo $this->Form->button(($Service['Service']['id']!=""?"Lưu lại":"Thêm mới"), array('class' => 'btn btn-primary')); ?>

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