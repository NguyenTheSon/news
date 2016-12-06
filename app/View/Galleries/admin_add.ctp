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
    document.getElementById('GalleryImage').value=fileUrl;
}
function SetFileField1(fileUrl )
{
        document.getElementById('smallPicture').innerHTML = "<img src='"+fileUrl+"' width='150px'>";
}
function deletePicture(id)
{
    document.getElementById('smallPicture').innerHTML = "";
    document.getElementById('GalleryImage').value="";
}

</script>
<script src="<?=Router::url("/",true);?>ckeditor/ckeditor.js"></script>
<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Thêm ảnh/video</h3>
  </div>
  <div class="panel-body">
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
            <?php echo $this->Form->create('Gallery',array());?>
            <?php echo $this->Form->input('caption', array('type' => 'textarea','class' => 'form-control form-group', 'label' => 'Caption')); ?>
            <?php echo $this->Form->input('video', array('type' => 'text','class' => 'form-control form-group', 'label' => 'URL Video')); ?>
             <?php 
               
                    echo $this->Form->input('image', array('type' => 'text','class' => 'form-control form-group', 'label' => 'Hình ảnh <div id="smallPicture"><img src="" width="150px"></div>'));
            ?>
            <input type="button" value="Chọn ảnh" onclick="choose('smallPicture');" />
            <input type="button" value="Xóa ảnh" onclick="deletePicture('smallPicture');" />
            <br>
            <?php echo $this->Form->button('Quay Lại', array('class' => 'btn btn-warning', 'onclick' => "window.location ='".$this->request->referer()."'", 'type' => 'button')); ?>
            <?php echo $this->Form->button("Thêm", array('class' => 'btn btn-primary')); ?>
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