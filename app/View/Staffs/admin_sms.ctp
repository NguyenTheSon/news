<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title">Nhắn tin cho khách hàng</h3>
  </div>
  <div class="panel-body">
	    <div class="row">
	    	<div class="col-md-6 col-sm-6 ">
	    	<?php echo $this->Form->create('User');?>
	    	<div class="form-control">
	    		<label>Tên Khách Hàng: <?php echo $this->request->data['User']['name'];?></label>
	    	</div>
	    	<?php echo $this->Form->input('phonenumber', array('class' => 'form-control form-group', 'label' => 'Số Điện Thoại')); ?>
			
			
			<?php echo $this->Form->input('content', array('class' => 'form-control form-group', 'label' => 'Nội dung', 'type' => 'textarea')); ?>

			<?php echo $this->Form->button('Quay Lại', array('class' => 'btn btn-warning', 'onclick' => "window.location ='".$this->request->referer()."'", 'type' => 'button')); ?>
			<?php echo $this->Form->button('Gửi', array('class' => 'btn btn-primary')); ?>

			<?php echo $this->Form->end(); ?>
            </div>
        </div>
	</div>
</div>
