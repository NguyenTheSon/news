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
<script src="<?=Router::url("/",true);?>ckeditor/ckeditor.js"></script>
<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Cập nhật thông tin</h3>
  </div>
  <div class="panel-body category">
    <div class="row">
      <div class="col-sm-12 col-md-6">
        <?php echo $this->Form->create('Category',array('action' => 'edit'));?>
        <?php echo $this->Form->input('id'); ?>
        <?php echo $this->Form->input('name', array('class' => 'form-control form-group', 'label' => 'Tên chuyên mục')); ?>
        <div class="bg-success" style="padding: 20px;">
          Lưu ý tỷ lệ ảnh PC: 64x27. Kích thước thường là: 1280x540px
        </div>
        <?php 

        echo $this->Form->input('images[]', array('id' => 'ismallPicture0', 'name' => 'data[Category][images][]', 'type' => 'text','class' => 'form-control form-group', 'label' => 'Hình ảnh PC 1 <div id="smallPicture0"><img src="'.$this->request->data['Category']['images'][0].'" width="150px"></div>', 'value' => $this->request->data['Category']['images'][0]));
        ?>
        <input type="button" value="Chọn ảnh" onclick="choose('smallPicture0');" />
        <input type="button" value="Xóa ảnh" onclick="deletePicture('smallPicture0');" />
        <?php 

        echo $this->Form->input('images[]', array('id' => 'ismallPicture1', 'name' => 'data[Category][images][]', 'type' => 'text','class' => 'form-control form-group', 'label' => 'Hình ảnh PC 2 <div id="smallPicture1"><img src="'.$this->request->data['Category']['images'][1].'" width="150px"></div>', 'value' => $this->request->data['Category']['images'][1]));
        ?>
        <input type="button" value="Chọn ảnh" onclick="choose('smallPicture1');" />
        <input type="button" value="Xóa ảnh" onclick="deletePicture('smallPicture1');" />
        <?php 

        echo $this->Form->input('images[]', array('id' => 'ismallPicture2', 'name' => 'data[Category][images][]', 'type' => 'text','class' => 'form-control form-group', 'label' => 'Hình ảnh PC 3 <div id="smallPicture2"><img src="'.$this->request->data['Category']['images'][2].'" width="150px"></div>', 'value' => $this->request->data['Category']['images'][2]));
        ?>
        <input type="button" value="Chọn ảnh" onclick="choose('smallPicture2');" />
        <input type="button" value="Xóa ảnh" onclick="deletePicture('smallPicture2');" />

        <div class="bg-success" style="padding: 20px;">
          Lưu ý tỷ lệ ảnh Mobile: 4x5. Kích thước thường là: 800x1000px
        </div>
        <?php 

        echo $this->Form->input('images_mobile[]', array('id' => 'ismallPicture3', 'name' => 'data[Category][images_mobile][]', 'type' => 'text','class' => 'form-control form-group', 'label' => 'Hình ảnh Mobile 1 <div id="smallPicture3"><img src="'.$this->request->data['Category']['images_mobile'][0].'" width="150px"></div>', 'value' => $this->request->data['Category']['images_mobile'][0]));
        ?>
        <input type="button" value="Chọn ảnh" onclick="choose('smallPicture3');" />
        <input type="button" value="Xóa ảnh" onclick="deletePicture('smallPicture3');" />
        <?php 

        echo $this->Form->input('images_mobile[]', array('id' => 'ismallPicture4', 'name' => 'data[Category][images_mobile][]', 'type' => 'text','class' => 'form-control form-group', 'label' => 'Hình ảnh Mobile 2 <div id="smallPicture4"><img src="'.$this->request->data['Category']['images_mobile'][1].'" width="150px"></div>', 'value' => $this->request->data['Category']['images_mobile'][1]));
        ?>
        <input type="button" value="Chọn ảnh" onclick="choose('smallPicture4');" />
        <input type="button" value="Xóa ảnh" onclick="deletePicture('smallPicture4');" />
        <?php 

        echo $this->Form->input('images_mobile[]', array('id' => 'ismallPicture5', 'name' => 'data[Category][images_mobile][]', 'type' => 'text','class' => 'form-control form-group', 'label' => 'Hình ảnh Mobile 3 <div id="smallPicture5"><img src="'.$this->request->data['Category']['images_mobile'][2].'" width="150px"></div>', 'value' => $this->request->data['Category']['images_mobile'][2]));
        ?>
        <input type="button" value="Chọn ảnh" onclick="choose('smallPicture5');" />
        <input type="button" value="Xóa ảnh" onclick="deletePicture('smallPicture5');" />
        <?php echo $this->Form->input('title_left', array('type' => 'textarea', 'class' => 'form-control form-group', 'label' => 'Tiêu đề left')); ?>
        <?php echo $this->Form->input('text_left', array('type' => 'textarea', 'class' => 'form-control form-group', 'label' => 'Text left')); ?>
        <?php echo $this->Form->input('sort', array('class' => 'form-control form-group', 'label' => 'Thứ tự')); ?>

        <?php echo $this->Form->input('images_popup', array('id' => 'ismallPicture6', 'name' => 'data[Category][images_popup]', 'type' => 'text','class' => 'form-control form-group', 'label' => 'Hình ảnh Popup <div id="smallPicture6"><img src="'.$this->request->data['Category']['images_popup'].'" width="150px"></div>', 'value' => $this->request->data['Category']['images_popup']));
        ?>
        <input type="button" value="Chọn ảnh" onclick="choose('smallPicture6');" />
        <input type="button" value="Xóa ảnh" onclick="deletePicture('smallPicture6');" />

        <?php echo $this->Form->input('link_images', array('class' => 'form-control form-group', 'label' => 'Link Popup')); ?>
        <?php echo $this->Form->input('parent_id', array('type' => 'text', 'class' => 'form-control form-group', 'label' => 'Thư mục cha')); ?>
        <?php echo $this->Form->button('Lưu Lại', array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Html->link('Xóa chuyên mục', array('action' => 'delete', $this->data['Category']['id']), array('class' => 'btn btn-danger','style' => 'float: right;'), __('Bạn chắc chắn muốn xóa chuyên mục #%s?', $this->data['Category']['name'])); ?>

        <?php echo $this->Form->end(); ?>
        <input type=hidden id='url_add_size' value='<?php echo $this->Html->url(array("controller" => "ProductSizes", "action" => "add")); ?>'>   
        <input type=hidden id='url_edit_size' value='<?php echo $this->Html->url(array("controller" => "ProductSizes","action" => "edit")); ?>'>
        <input type=hidden id='url_del_size' value='<?php echo $this->Html->url(array("controller" => "ProductSizes","action" => "del")); ?>'>

        <input type=hidden id='url_add_brand' value='<?php echo $this->Html->url(array("controller" => "Brands","action" => "add")); ?>'>      
        <input type=hidden id='url_edit_brand' value='<?php echo $this->Html->url(array("controller" => "Brands","action" => "edit")); ?>'>
        <input type=hidden id='url_del_brand' value='<?php echo $this->Html->url(array("controller" => "Brands","action" => "del")); ?>'>
      </div>
    </div>
  </div>
</div>
