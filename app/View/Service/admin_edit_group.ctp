<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo ($ServiceGroup['ServiceGroup']['id']!=""?"Sửa nhóm dịch vụ":"Thêm nhóm dịch vụ");?></h3>
  </div>
  <div class="panel-body">
        <div class="row">
            <div class="col-md-6 col-sm-6 ">
            <?php echo $this->Form->create('ServiceGroup',array());?>
            <?php echo $this->Form->input('group_name', array('class' => 'form-control form-group', 'label' => 'Tên nhóm dịch vụ', 'value' => $ServiceGroup['ServiceGroup']['group_name'])); ?>
            <?php echo $this->Form->select('group_type',
                            array(
                                "1" => "Cắt gội",
                                "2" => "SPA",),
                            array(
                                'empty' => false,
                                "class" => "changestate", 
                                "data-id" =>  $ServiceGroup['ServiceGroup']['id'],
                                "default" => $ServiceGroup['ServiceGroup']['group_type'],
                            )
                            );
                     ?>
            <?php echo $this->Form->button('Quay Lại', array('class' => 'btn btn-warning', 'onclick' => "window.location ='".$this->request->referer()."'", 'type' => 'button')); ?>
            <?php echo $this->Form->button(($ServiceGroup['ServiceGroup']['id']!=""?"Lưu lại":"Thêm mới"), array('class' => 'btn btn-primary')); ?>

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