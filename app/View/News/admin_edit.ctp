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
    document.getElementById('NewsImages').value=fileUrl;
}
function SetFileField1(fileUrl )
{
        document.getElementById('smallPicture').innerHTML = "<img src='"+fileUrl+"' width='150px'>";
}
function deletePicture(id)
{
    document.getElementById('smallPicture').innerHTML = "";
    document.getElementById('NewsImages').value="";
}

</script>
<script src="<?=Router::url("/",true);?>ckeditor/ckeditor.js"></script>
<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo ($New['News']['id']!=""?"Sửa bài viêt":"Thêm bài viết");?></h3>
  </div>
  <div class="panel-body">
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
            <?php echo $this->Form->create('News',array());?>
            <?php echo $this->Form->input('title', array('type' => 'text','class' => 'form-control form-group', 'label' => 'Tiêu đề bài viết', 'value' => $New['News']['title'])); ?>
             <?php echo $this->Form->input('description', array('type' => 'textarea','class' => 'form-control form-group ckeditor', 'label' => 'Mô tả', 'value' => $New['News']['description'])); ?>
             <?php 
               
                    echo $this->Form->input('images', array('type' => 'text','class' => 'form-control form-group', 'label' => 'Hình ảnh <div id="smallPicture"><img src="'.$New['News']['images'].'" width="150px"></div>', 'value' => $New['News']['images']));
            ?>
            <input type="button" value="Chọn ảnh" onclick="choose('smallPicture');" />
            <input type="button" value="Xóa ảnh" onclick="deletePicture('smallPicture');" />
            <div class="bg-success" class="padding: 10px; margin: 10px 0px;"> Lưu ý chọn ảnh tỷ lệ: 240x300</div>
            <?php echo $this->Form->input('url', array('type' => 'text','class' => 'form-control form-group', 'label' => 'Link video', 'value' => $New['News']['url'])); ?>
             <?php echo $this->Form->input('category_id', array('class' => 'form-control form-group', 'label' => 'Danh mục', 'options' => $ListGroup,'selected' => $New['News']['category_id'])); ?>
              <?php echo $this->Form->input('content', array('type' => 'textarea','class' => 'form-control form-group ckeditor', 'label' => '<br>Nội dung', 'value' => $New['News']['content'])); ?>

            <?php echo $this->Form->input('tags', array('type' => 'text','class' => 'form-control form-group tags', 'label' => 'Tags', 'value' => (isset($New['News']['tags'])) ? $New['News']['tags'] : "")); ?>

            <?php echo $this->Form->button('Quay Lại', array('class' => 'btn btn-warning', 'onclick' => "window.location ='".$this->request->referer()."'", 'type' => 'button')); ?>
            <?php echo $this->Form->button(($New['News']['id']!=""?"Lưu lại":"Thêm mới"), array('class' => 'btn btn-primary')); ?>
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
    $(".tags").tagsInput({
    width: "100%",
      autocomplete_url:'<?php echo Router::url(array("action" => "getTags"),true);?>'
    });
</script>