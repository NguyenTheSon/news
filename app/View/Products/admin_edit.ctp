<script type="text/javascript">
var type="";
function listenMessage(msg) {
  show(msg.data,type);
  type="";
}

if (window.addEventListener) {
    window.addEventListener("message", listenMessage, false);
} else {
    window.attachEvent("onmessage", listenMessage);
}
function show(url,type)
{
    if(type=='smallPicture')
    {
        SetFileField(url);
    }
    else
    {
        SetUrl(url);
    }

}
function choose(id)
{
    if(id=='smallPicture')
    {
        type='smallPicture';
    }
    window.open("<?php  Configure::load('ckfinder');echo Configure::read('CKFINDER_POPUP');?>","popup",'height=700,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');
}
function SetUrl(fileUrl)
{
    //document.getElementById( 'cke_114_textInput' ).value = fileUrl;
    var dialog = CKEDITOR.dialog.getCurrent();
        dialog.selectPage('info');
    var tUrl = dialog.getContentElement('info', 'txtUrl');
    tUrl.setValue(fileUrl);
}

// This is a sample function which is called when a file is selected in CKFinder.
function SetFileField(fileUrl)
{
    document.getElementById('smallPicture').innerHTML = "<img src='"+fileUrl+"' width='150px'>";
    document.getElementById('ProductImage').value=fileUrl;
}
function SetFileField1(fileUrl )
{
        document.getElementById('smallPicture').innerHTML = "<img src='"+fileUrl+"' width='150px'>";
}
function deletePicture(id)
{
    document.getElementById('smallPicture').innerHTML = "";
    document.getElementById('ProductImage').value="";
}

</script>
<script src="<?=Router::url("/",true);?>ckeditor/ckeditor.js"></script>
<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo ($Product['Product']['id']!=""?"Sửa sản phẩm":"Thêm sản phẩm");?></h3>
  </div>
  <div class="panel-body">
        <div class="row">
            <div class="col-md-6 col-sm-6 ">
            <?php echo $this->Form->create('Product',array());?>
            <?php echo $this->Form->input('name', array('type' => 'text','class' => 'form-control form-group', 'label' => 'Tên sản phẩm', 'value' => $Product['Product']['name'])); ?>
            <div class="bg-danger" style="padding: 20px;"> Lưu ý: Chọn ảnh tỷ lệ: 4x5.<br> đề nghị xử lý hình ảnh trước khi upload.</div>
            <?php 
               
                    echo $this->Form->input('image', array('type' => 'text','class' => 'form-control form-group', 'label' => 'Hình ảnh <div id="smallPicture"><img src="'.$Product['Product']['image'].'" width="150px"></div>', 'value' => $Product['Product']['image']));
            ?>
            <input type="button" value="Chọn ảnh" onclick="choose('smallPicture');" />
            <input type="button" value="Xóa ảnh" onclick="deletePicture('smallPicture');" />
            <?php echo $this->Form->input('price', array('type' => 'text','class' => 'form-control form-group', 'label' => 'Giá sản phẩm', 'value' => $Product['Product']['price'])); ?>
            
             <?php echo $this->Form->input('cat_id', array('class' => 'form-control form-group', 'label' => 'Danh mục', 'options' => $ListGroup,'selected' => $Product['Product']['cat_id'])); ?>
             <?php echo $this->Form->input('described', array('type' => 'textarea','class' => 'form-control form-group ckeditor', 'label' => 'Mô tả', 'value' => $Product['Product']['described'])); ?>
               <?php echo $this->Form->input('detail', array('type' => 'textarea','class' => 'form-control form-group ckeditor', 'label' => '<br>Nội dung', 'value' => $Product['Product']['detail'])); ?>
            <?php echo $this->Form->button('Quay Lại', array('class' => 'btn btn-warning', 'onclick' => "window.location ='".$this->request->referer()."'", 'type' => 'button')); ?>
            <?php echo $this->Form->button(($Product['Product']['id']!=""?"Lưu lại":"Thêm mới"), array('class' => 'btn btn-primary')); ?>
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