<section class="content-qc">
	<h2>Sửa quảng cáo</h2>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"> <i class="glyphicon glyphicon-tasks"></i> Sửa quảng cáo</h3>
				</div>
				<div class="panel-body">
					<?php echo $this->Form->create('Advertise', array('class' => 'form-horizontal', 'id' => 'FormAdvertise'));?>
					<div class="form-group">
						<label class="col-sm-2 control-label">Tên quảng cáo</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" 
							name="name" 
							id="nameAdvertise" 
							placeholder="Nhập Tên quảng cáo"
							data-rule-required="true"
							data-msg-required="Bạn chưa nhập tên quảng cáo"
							value="<?php echo $Advertise['Advertise']['name'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Chiều rộng</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="width" id="widthAdvertise" placeholder="Nhập chiều rộng" value="<?php echo $Advertise['Advertise']['width'];?>"
							data-rule-required="true"
							data-msg-required="Bạn chưa nhập chiều rộng">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Chiều cao</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="height" id="heightAdvertise" placeholder="Nhập chiều cao" value="<?php echo $Advertise['Advertise']['height'];?>"
							data-rule-required="true"
							data-msg-required="Bạn chưa nhập chiều cao">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Vị trí</label>
						<div class="col-sm-9">
							<select class="form-control" name="location_id">
								<?php foreach($Locations as $location):?>
									<option value="<?php echo $location['Location']['id'];?>"
										<?php echo ($location['Location']['id'] == $Advertise['Advertise']['location_id']) ? "selected" : "";?>
										>
										<?php echo $location['Location']['name'];?>
									</option>
								<?php endforeach;?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Thứ tự</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="order" id="orderAdvertise" placeholder="Nhập thứ tự" value="<?php echo $Advertise['Advertise']['order'];?>"
							data-rule-required="true"
							data-msg-required="Bạn chưa nhập thứ tự">
						</div>
					</div>
					<div class="control-group">
						<label class="col-sm-2 control-label">Quảng cáo</label>
						<div class="col-sm-9">
							<div class="controls" style="padding:15px 0;">
								<input type="button" value="Thêm quảng cáo" id="newqc">
								<div id="imgs" style="padding-top: 15px;">
									<?php for($i=0; $i < count($Advertise['Advertise']['image']); $i++) :?>
										Link ảnh: <input type="text" id="image[<?php echo $i;?>]" name="image[<?php echo $i;?>]" 
										value="<?php echo $Advertise['Advertise']['image'][$i];?>">
										Link website: <input type="text" name="url[<?php echo $i;?>]" value="<?php echo $Advertise['Advertise']['url'][$i];?>">

										<input type="button" value="Chọn ảnh" onclick="choose('image[<?php echo $i;?>]');" />
										<br/>
									<?php endfor;?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<hr/>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Lưu</button>
							<a href="<?php echo Router::url(array('action' => 'admin_delete', $Advertise['Advertise']['id']));?>" class="btn btn-primary" onclick="if (confirm('Bạn có muốn xóa quảng cáo này?')) { return true; } return false;"><i class="fa fa-times" aria-hidden="true"></i> Xoá</a>
							<button type="button" onclick="window.history.back();" class="btn btn-primary"><i class="fa fa-reply" aria-hidden="true"></i> Trở về</button>
						</div>
					</div>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>	
		</div>
	</div>
</section>
<script>
	$("#newqc").click(function(){
		var inputs=document.getElementsByTagName("input");
		var count=0;
		for(var i=0;i<inputs.length;i++){
			if(inputs[i].id.indexOf("image[")==0)count++;
		}
		$("#imgs").append('Link ảnh: <input type="text" id="image['+count+']"  name="image['+count+']" value=""> Link website: <input type="text" name="url['+count+']" value=""> <input type="button" class="choosebtn" value="Chọn ảnh" onclick="choose(\'image['+count+']\');" /><br>');
	});
</script>
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
		type = id;
		window.open("<?php  Configure::load('ckfinder');echo Configure::read('CKFINDER_POPUP');?>","popup",'height=700,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');
	}
	function SetUrl(fileUrl)
	{
		var dialog = CKEDITOR.dialog.getCurrent();
		dialog.selectPage('info');
		var tUrl = dialog.getContentElement('info', 'txtUrl');
		tUrl.setValue(fileUrl);
	}

	function SetFileField(fileUrl)
	{
		document.getElementById(type).value=fileUrl;
	}

</script>