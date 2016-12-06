<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"> <i class="glyphicon glyphicon-tasks"></i> Thêm quảng cáo</h3>
	</div>
	<div class="panel-body">
		<?php echo $this->Form->create('Advertise', array('class' => 'form-horizontal', 'url' => array('action' => 'add'), 'id' => 'FormAdvertise'));?>
		<div class="form-group">
			<label class="col-sm-2 control-label">Tên quảng cáo</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" 
				name="name" id="nameAdvertise" 
				placeholder="Nhập Tên quảng cáo"
				data-rule-required="true"
				data-msg-required="Bạn chưa nhập tên quảng cáo">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Chiều rộng</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" 
				name="width" id="widthAdvertise" 
				placeholder="Nhập chiều rộng"
				data-rule-required="true"
				data-msg-required="Bạn chưa nhập chiều rộng">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Chiều cao</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" 
				name="height" id="heightAdvertise" 
				placeholder="Nhập chiều cao"
				data-rule-required="true"
				data-msg-required="Bạn chưa nhập chiều cao">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Vị trí</label>
			<div class="col-sm-9">
				<select class="form-control" name="location_id">
					<?php foreach($Locations as $location):?>
						<option value="<?php echo $location['Location']['id'];?>">
							<?php echo $location['Location']['name'];?>
						</option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Thứ tự</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" name="order" id="orderAdvertise" placeholder="Nhập thứ tự"
				data-rule-required="true"
				data-msg-required="Bạn chưa nhập thứ tự">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">Thêm nhóm quảng cáo</button>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>