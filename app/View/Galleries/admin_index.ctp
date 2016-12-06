<div id="reload"> 
<div class="form-group">
<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title">Quản lý Thư viện</h3>
  </div>
  <div class="panel-body">
	    <div class="row">
            <div class="col-sm-3 col-md-2 col-xs-2 search-form pull-left">
                <?php echo $this->Html->link('Thêm ảnh/video', array('action' => 'admin_add', 'admin' => true), array('class' => 'btn btn-primary')); ?>
            </div>
        </div>
        <br />
        <div class="row">
        	<div class="col-sm-12 col-md-12" id="ListProducts">
            	<?php echo $this->element('Galleries/admin_index'); ?>
            </div>
		</div>
		
	</div>
</div>
</div>
</div>