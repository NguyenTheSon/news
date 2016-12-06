<script src="<?=Router::url("/",true);?>ckeditor/ckeditor.js"></script>
<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Trả lời tư vấn</h3>
  </div>
  <div class="panel-body">
        <div class="row">
            <div class="col-md-6 col-sm-6 ">
            <?php echo $this->Form->create('Question',array());?>
            <?php echo $this->Form->input('question', array('class' => 'form-control form-group', 'label' => 'Câu hỏi:', 'value' => $Question['Question']['question'], "disabled" => "disabled")); ?>
            <?php 
                $images = explode("|",$Question['Question']['image']);
                foreach( $images as $key => $image)
                { 
                    if($image=="")
                        continue;
                    echo $this->Form->input('image_'.$key, array('class' => 'form-control form-group', 'label' => 'Hình ảnh <img src="'.$image.'" style="width:150px;height:150px;">', 'value' => $image, "disabled" => "disabled"));
                }
            ?>
             <?php echo $this->Form->input('content', array('type' => 'textarea','class' => 'form-control form-group ckeditor', 'label' => 'Nội dung', 'value' => $Question['Question']['content'],"disabled" => "disabled")); ?>
               <?php echo $this->Form->input('answer', array('type' => 'textarea','class' => 'form-control form-group ckeditor', 'label' => '<br>Câu trả lời', 'value' => $Question['Question']['answer'])); ?>
            <?php echo $this->Form->button('Quay Lại', array('class' => 'btn btn-warning', 'onclick' => "window.location ='".$this->request->referer()."'", 'type' => 'button')); ?>
            <?php echo $this->Form->button("Lưu lại", array('class' => 'btn btn-primary')); ?>
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