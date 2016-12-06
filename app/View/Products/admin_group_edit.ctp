<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo ($ProdCategory['ProdCategory']['id']!=""?"Sửa nhóm sản phẩm":"Thêm nhóm sản phẩm");?></h3>
  </div>
  <div class="panel-body">
        <div class="row">
            <div class="col-md-6 col-sm-6 ">
            <?php echo $this->Form->create('ProdCategory',array());?>
            <?php echo $this->Form->input('name', array('type' => 'text','class' => 'form-control form-group', 'label' => 'Tên nhóm sản phẩm', 'value' => $ProdCategory['ProdCategory']['name'])); ?>
            <?php echo $this->Form->input('code', array('type' => 'text','class' => 'form-control form-group', 'label' => 'Mã nhóm', 'value' => $ProdCategory['ProdCategory']['code'])); ?>
            <?php echo $this->Form->input('order', array('type' => 'text','class' => 'form-control form-group', 'label' => 'Thứ tự', 'value' => $ProdCategory['ProdCategory']['order'])); ?>
            <?php echo $this->Form->button('Quay Lại', array('class' => 'btn btn-warning', 'onclick' => "window.location ='".$this->request->referer()."'", 'type' => 'button')); ?>
            <?php echo $this->Form->button(($ProdCategory['ProdCategory']['id']!=""?"Lưu lại":"Thêm mới"), array('class' => 'btn btn-primary')); ?>
            <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>