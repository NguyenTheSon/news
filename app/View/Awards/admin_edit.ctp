<section class="content-award">
	<h2>Quản lý Award</h2>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"> <i class="glyphicon glyphicon-tasks"></i> Sưả Award</h3>
				</div>
				<div class="panel-body">
					<?php echo $this->Form->create('Award', array('class' => 'form-horizontal', 'id' => 'FormAward'));?>
					<div class="form-group">
						<label class="col-sm-2 control-label">Họ và tên</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" 
							name="name" 
							id="nameAward" 
							placeholder="Nhập họ tên"
							data-rule-required="true"
							data-msg-required="Bạn chưa nhập họ tên"
							value="<?php echo $Award['Award']['name'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Số báo danh</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="ide_number" id="ide_numberAward" placeholder="Nhập số báo danh"
							data-rule-required="true"
							data-msg-required="Bạn chưa nhập số báo danh"
							value="<?php echo $Award['Award']['ide_number'];?>">
						</div>
					</div>
					<div class="control-group">
						<label class="col-sm-2 control-label">Hình ảnh</label>
						<div class="col-sm-9">
							<div style="padding-bottom: 15px;">
								<?php echo $this->Form->input('ImgAvatar', array('type' => 'text','class' => 'form-control form-group', 'label' => '<div id="smallPicture"><img src="'.$Award['Award']['imgavatar'].'" width="150px"></div>', 'value' => $Award['Award']['imgavatar'],  'required' => 'required'));
								?>
								<input type="button" value="Chọn ảnh" onclick="chooseimage('smallPicture');" />
								<input type="button" value="Xóa ảnh" onclick="deletePicture('smallPicture');" />
							</div>
						</div>
						
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Địa chỉ</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="address" id="addressAward" placeholder="Nhập địa chỉ"
							data-rule-required="true"
							data-msg-required="Bạn chưa nhập địa chỉ"
							value="<?php echo $Award['Award']['address'];?>"
							>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Số điện thoại</label>
						<div class="col-sm-9">
							<input type="number" class="form-control" name="phonenumber" id="phoneAdvertise" placeholder="Nhập số điện thoại"
							autofocus="autofocus"
							data-rule-required="true"
							data-msg-required="Vui lòng nhập số điện thoại của bạn"
							maxlength="11"
							data-rule-number="true"
							data-msg-number="Vui lòng chỉ nhập số"
							data-rule-minlength="10" 
							data-msg-minlength="Số điện thoại từ 10 - 11 ký tự" data-rule-maxlength="11" 
							data-msg-maxlength="Số điện thoại từ 10 - 11 ký tự"
							required="required"
							value="<?php echo $Award['Award']['phonenumber'];?>"
							>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Thông tin thêm</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="note" id="noteAward" placeholder="Nhập thông tin"
							data-rule-required="true"
							data-msg-required="Bạn chưa nhập thông tin"
							value="<?php echo $Award['Award']['note'];?>"
							>
						</div>
					</div>
					<div class="control-group">
						<label class="col-sm-2 control-label">Ảnh Award</label>
						<div class="col-sm-9">
							<div class="controls" style="padding:15px 0;">
								<input type="button" value="Thêm ảnh Award" id="newqc">
								<div id="imgs" style="padding-top: 15px;">
									<?php for($i=0; $i < count($Award['Award']['images']); $i++) :?>
										Link ảnh: <input type="text" id="images[<?php echo $i;?>]" name="images[<?php echo $i;?>]" value="<?php echo $Award['Award']['images'][$i];?>", required>
										<input type="button" value="Chọn ảnh" onclick="choose('images[<?php echo $i;?>]');" />
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
			if(inputs[i].id.indexOf("images[")==0)count++;
		}
		$("#imgs").append('Link ảnh: <input type="text" id="images['+count+']"  name="images['+count+']" value="", required> <input type="button" class="choosebtn" value="Chọn ảnh" onclick="choose(\'images['+count+']\');" /><br>');
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
		if(type == "smallPicture"){
			SetFileField1(url);
		}
		else{
			SetFileField(url);
		}
		

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
<script type="text/javascript">
	function chooseimage(id)
	{
		if(id=='smallPicture')
		{
			type='smallPicture';
		}
		window.open("<?php  Configure::load('ckfinder');echo Configure::read('CKFINDER_POPUP');?>","popup",'height=700,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');
	}
	function SetFileField1(fileUrl){
		document.getElementById('smallPicture').innerHTML = "<img src='"+fileUrl+"' width='150px'>";
		document.getElementById('AwardImgAvatar').value=fileUrl;
	}
	function deletePicture(id)
	{
		document.getElementById('smallPicture').innerHTML = "";
		document.getElementById('AwardImgAvatar').value="";
	}

</script>