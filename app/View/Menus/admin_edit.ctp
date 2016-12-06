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
        SetFileField(url);
  
}
function choose(id)
{
    /*if(id=='smallPicture')
    {
        type='smallPicture';
    }*/
    type = id;
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
    document.getElementById(type).innerHTML = "<img src='"+fileUrl+"' width='150px'>";
    document.getElementById('i'+type).value=fileUrl;
}
function SetFileField1(fileUrl )
{
        document.getElementById(type).innerHTML = "<img src='"+fileUrl+"' width='150px'>";
}
function deletePicture(id)
{
    document.getElementById(id).innerHTML = "";
    document.getElementById('i'+id).value="";
}

</script>
<div class="panel panel-info">
  <div class="panel-heading">
  <h3 class="panel-title">Cập nhật thông tin</h3>
  </div>
  <div class="panel-body category">
      <div class="row">
      <div class="col-sm-12 col-md-6">
    	   <?php echo $this->Form->create('Menu',array('action' => 'edit'));?>
          <?php echo $this->Form->input('id'); ?>
      		<?php echo $this->Form->input('name', array('class' => 'form-control form-group', 'label' => 'Tên chuyên mục')); ?>
          <div class="bg-success" style="padding: 20px;">
            Lưu ý tỷ lệ ảnh Menu là: 100x100;
            Ảnh background là: 1600px x 900px;
          </div>
          <?php 
          
                    echo $this->Form->input('image', array('id' => 'ismallPicture', 'name' => 'data[Menu][image]', 'type' => 'text','class' => 'form-control form-group', 'label' => 'Hình ảnh <div id="smallPicture"><img src="'.$this->request->data['Menu']['image'].'" width="150px"></div>', 'value' => $this->request->data['Menu']['image']));
            ?>
            <input type="button" value="Chọn ảnh" onclick="choose('smallPicture');" />
            <input type="button" value="Xóa ảnh" onclick="deletePicture('smallPicture');" />
          <?php echo $this->Form->input('url', array('type' => 'text', 'class' => 'form-control form-group', 'label' => 'url')); ?>
          <?php echo $this->Form->input('sort', array('class' => 'form-control form-group', 'label' => 'Thứ tự')); ?>
          
    			<?php echo $this->Form->button('Lưu Lại', array('class' => 'btn btn-primary')); ?>
          
    			<?php echo $this->Form->end(); ?>
      </div>
    </div>
  </div>
</div>
